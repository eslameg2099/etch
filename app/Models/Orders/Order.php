<?php

namespace App\Models\Orders;

use App\Factories\DeliveryOrderFactory;
use App\Factories\PurchaseOrderFactory;
use App\Models\Branch;
use App\Models\Chat\OrderChat;
use App\Models\Collect;
use App\Models\Concerns\Ratable;
use App\Models\Report;
use App\Models\Shop;
use App\Models\Users\Address;
use App\Models\Users\User;
use App\Support\Payment\Facades\Cashier;
use App\Support\Payment\Models\Transaction;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laraeast\LaravelSettings\Facades\Settings;
use Malhal\Geographical\Geographical;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasFilter, Ratable, Geographical;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'orders';

    protected $guarded = ['id'];

    protected $appends = ['readable_status', 'readable_type'];

    protected $casts = ['start_at' => 'datetime'];

    const LATITUDE = 'lat';

    const LONGITUDE = 'lng';

    protected static $kilometers = true;

    ### type ###
    const Delivery = 1;

    const Purchase = 2;

    ### Status ###
    const WaitingForOffers = 1;

    const WaitingForAcceptOffer = 2;

    const WaitingForPayment = 3;

    const ChangeDelegate = 4;

    const PaymentDone = 5;

    const UnderReview = 6;

    const UnderDelivery = 7;

    const Delivered = 8;

    const CanceledByDelegate = 9;

    const CanceledByUser = 10;

    const RefusedByAdmin = 11;

    const Schedule = 12;

    const CanceledSchedule = 13;

    const PaymentTimeOut = 14;

    const WaitingForAddPayment = 15;

    const CanceledBySystem = 16;
    const CanceledAutomatic = 17;

    #### Payment Methods ####

    const PAYMENT_ON_DELIVERY = 1;

    const ONLINE_PAYMENT = 2;

    const PAYMENT_FROM_WALLET = 3;

    public function Delegate()
    {
        return $this->belongsTo(User::class, 'delegate_id', 'id')->withTrashed();
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id')->withTrashed();
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')->withTrashed();
    }

    public function ReceivingAddress()
    {
        return $this->belongsTo(Address::class, 'receiving_address_id', 'id');
    }

    public function DeliveryAddress()
    {
        return $this->belongsTo(Address::class, 'delivery_address_id', 'id');
    }
    //public function offer()
    //{
    //    return $this->hasMany(OrderOffer::class);
    //}

    public function offers()
    {
        return $this->hasMany(OrderOffer::class, 'order_id', 'id')
            ->latest()
            ->when(auth()->check() && auth()->user()->isDelegate(), function ($q) {
                $q->where('delegate_id', auth()->id()); //->NewDelegateOrders();
            });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collects()
    {
        return $this->hasMany(Collect::class);
    }

    public function acceptedOffer()
    {
        return $this->offers()->where('status', OrderOffer::CustomerAccept);
    }

    public function payment()
    {
        return $this->hasOne(OrderPayment::class, 'order_id', 'id');
    }

    public function chats()
    {
        return $this->hasMany(OrderChat::class, 'order_id', 'id');
    }

    public function getReadableStatusAttribute()
    {
        /** @var User $user */
        if ($user = auth('sanctum')->user()) {
            if ($user->isDelegate()
                && $this->offers()->where('delegate_id', $user->id)->where('status', OrderOffer::CustomerReject)->exists()) {
                return trans('global.canceled_by_user');
            }
        }

        $status = [
            self::WaitingForOffers => trans('global.waiting_for_offers'),
            self::WaitingForAcceptOffer => trans('global.waiting_for_accept_offer'),
            self::WaitingForPayment => $this->payment_type == self::PAYMENT_ON_DELIVERY
                ? trans('global.waiting_for_confirm')
                : trans('global.waiting_for_payment'),
            self::WaitingForAddPayment => trans('global.waiting_for_add_payment'),
            self::ChangeDelegate => trans('global.change_delegate'),
            self::PaymentDone => $this->payment_type == self::PAYMENT_ON_DELIVERY
                ? trans('global.payment_confirmed')
                : trans('global.payment_done'),
            self::UnderReview => trans('global.under_review'),
            self::UnderDelivery => trans('global.under_delivery'),
            self::Delivered => trans('global.delivered'),
            self::CanceledByDelegate => trans('global.canceled_by_delegate'),
            self::CanceledByUser => trans('global.canceled_by_user'),
            self::RefusedByAdmin => trans('global.refused_by_admin'),
            self::Schedule => trans('global.schedule'),
            self::CanceledBySystem => trans('global.canceled_by_system'),
            self::CanceledAutomatic => trans('global.canceled_automatic'),
            null => 'Error',
        ];

        return $status[$this->status];
    }

    public function getReadableTypeAttribute()
    {
        $types = [
            self::Delivery => trans('global.delivery'),
            self::Purchase => trans('global.purchase'),
            null => 'Error',
        ];

        return $types[$this->type];
    }

    public function getFactory()
    {
        switch ($this->type) {
            case Order::Delivery:
                return new DeliveryOrderFactory($this,$this->delivery_cost);
            case Order::Purchase:
                return new PurchaseOrderFactory($this,$this->delivery_cost);
            default:
                return null;
        }
    }

    public function isClosed()
    {
        return in_array($this->status, [
            self::RefusedByAdmin,
            self::CanceledByUser,
            self::CanceledByDelegate,
            self::CanceledBySystem,
            self::CanceledAutomatic,
            self::Delivered,
        ]);
    }
    public function isCanceled()
    {
        return in_array($this->status, [
            self::RefusedByAdmin,
            self::CanceledByUser,
            self::CanceledBySystem,
            self::CanceledAutomatic,
            self::CanceledByDelegate,
        ]);
    }

    public function scopeDeliveryChangeStatus($query)
    {
        return $query->where('delegate_id', auth()->id())
            //->whereNotNull('delegate_id')
            ->whereNotNull('start_at')
            ->whereNull('closed_at');
    }

    public function scopeMyOrders($query)
    {
        // case has order or only has offers -- not accepted attached.
        if (auth()->check() && auth()->user()->isDelegate()) {
            return $query->where(function ($query) {
                $query->where('delegate_id', auth()->id());
                $query->orWhereHas('offers', function ($q) {
                    $q->where('delegate_id', auth()->id());
                });
            });
        } else {
            if (auth()->check() && auth()->user()->isCustomer()) {
                return $query->where('user_id', auth()->id());
            } else {
                throw new \Exception('cannot query on this user type');
            }
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function withdrawals()
    {
        return $this->belongsToMany(User::class, 'order_withdrawal', 'order_id', 'delegate_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function handlePayment($checkoutId = null)
    {
        switch ($this->payment_type) {
            case Order::PAYMENT_ON_DELIVERY:
                $this->handleCashPayment();
                break;
            case Order::PAYMENT_FROM_WALLET:
                $this->handleWalletPayment();
                break;
            case Order::ONLINE_PAYMENT:
                $this->handleOnlinePayment($checkoutId);
                break;
        }

        return $this->refresh();
    }

    public function handleCashPayment()
    {
        // [1] Add a transaction to deduct the delivery cost from the delegate's wallet
        // [2] Add a transaction to add the delivery cost to the app's wallet
        // [3] Add a transaction to deduct the app's profit and tax cost from the app's wallet // - defer
        // [4] Add a transaction to add the app's profit and tax cost to the delegate's wallet // - defer

        // [1]
        Transaction::forceCreate([
            'user_id' => $this->delegate_id,
            'actor_id' => $this->user_id,
            'order_id' => $this->id,
            'identifier' => Str::random(40),
            'amount' => ($this->getDeliveryCost() + $this->getTaxCost()) * -1,
            'status' => Transaction::BALANCE_STATUS,
            'type' => Transaction::APP_PROFITS_TYPE,
            'date' => now(),
        ]);

        // [2]
        Transaction::forceCreate([
            'user_id' => null,
            'actor_id' => $this->user_id,
            'order_id' => $this->id,
            'identifier' => Str::random(40),
            'amount' => ($this->getDeliveryCost() + $this->getTaxCost()),
            'status' => Transaction::BALANCE_STATUS,
            'type' => Transaction::APP_PROFITS_TYPE,
            'date' => now(),
        ]);

        // [3]
        $this->collects()->create([
            'user_id' => $this->delegate_id,
            'amount' => $this->getDeliveryCost() - $this->getAppProfit(),
        ]);
        //Transaction::forceCreate([
        //    'user_id' => null,
        //    'actor_id' => $this->user_id,
        //    'order_id' => $this->id,
        //    'identifier' => $identifier = Str::random(40),
        //    'amount' => ($this->getDeliveryCost() - $this->getAppProfit()) * -1,
        //    'status' => Transaction::BALANCE_STATUS,
        //    'type' => Transaction::APP_PROFITS_TYPE,
        //    'date' => now(),
        //]);
    }

    public function handleOnlinePayment($checkoutId = null)
    {
        // [1] Add a transaction to add the order's total cost to the app's wallet
        // [2] Add a transaction to deduct the purchase cost from the app's wallet
        // [3] Add a transaction to add the purchase cost to the delegate's wallet
        // [4] Add a transaction to deduct the app's profit and tax cost from the app's wallet // - defer
        // [5] Add a transaction to add the app's profit and tax cost to the delegate's wallet // - defer

        // [1]
        if (! $checkoutId) {
            return false;
        }

        $checkout = Cashier::setActor($this->User)
            ->setCheckout($checkoutId)
            ->updateStatus()
            ->getCheckout();

        $status = Transaction::PENDING_STATUS;

        if ($checkout->isPending()) {
            $status = Transaction::PENDING_STATUS;
        }
        if ($checkout->isSuccessfulAndPending() || $checkout->isSuccessful()) {
            $status = Transaction::BALANCE_STATUS;
        }
        if ($checkout->isRejected() || $checkout->isRejectedByExternalBank()) {
            $status = Transaction::REJECTED_STATUS;
        }

        if (! $checkout->isSuccessful() && ! $checkout->isSuccessfulAndPending()) {
            throw ValidationException::withMessages([
                'amount' => 'Error: '. trans('hyperpay.'. $checkout->status),
            ]);
        }

        Transaction::forceCreate([
            'user_id' => null,
            'actor_id' => $this->user_id,
            'order_id' => $this->id,
            'checkout_id' => $checkout->id,
            'identifier' => $identifier = Str::random(40),
            'amount' => $this->payment->getTotal(),
            'status' => $status,
            'type' => Transaction::ORDER_TOTAL_AMOUNT_TYPE,
            'date' => now(),
        ]);

        // [2]
        if ($amount = $this->payment->details()->where('item_type',
            OrderPaymentDetails::PurchasableItem)->sum('cost'))
        {
            Transaction::forceCreate([
                'user_id' => null,
                'actor_id' => $this->user_id,
                'order_id' => $this->id,
                'identifier' => $identifier = Str::random(40),
                'amount' => $amount * -1,
                'status' => Transaction::BALANCE_STATUS,
                'type' => Transaction::PURCHASE_AMOUNT_TYPE,
                'date' => now(),
            ]);

            // [3]
            Transaction::forceCreate([
                'user_id' => $this->delegate_id,
                'actor_id' => $this->user_id,
                'order_id' => $this->id,
                'identifier' => $identifier = Str::random(40),
                'amount' => $amount,
                'status' => Transaction::BALANCE_STATUS,
                'type' => Transaction::PURCHASE_AMOUNT_TYPE,
                'date' => now(),
            ]);

            // [4]
            //Transaction::forceCreate([
            //    'user_id' => null,
            //    'actor_id' => $this->user_id,
            //    'order_id' => $this->id,
            //    'identifier' => $identifier = Str::random(40),
            //    'amount' => ($this->getDeliveryCost() - $this->getAppProfit()) * -1,
            //    'status' => Transaction::BALANCE_STATUS,
            //    'type' => Transaction::APP_PROFITS_TYPE,
            //    'date' => now(),
            //]);

            // [5]
            //Transaction::forceCreate([
            //    'user_id' => $this->delegate_id,
            //    'actor_id' => $this->user_id,
            //    'order_id' => $this->id,
            //    'identifier' => $identifier = Str::random(40),
            //    'amount' => $this->getDeliveryCost() - $this->getAppProfit(),
            //    'status' => Transaction::BALANCE_STATUS,
            //    'type' => Transaction::DELEGATE_PROFITS_TYPE,
            //    'date' => now(),
            //]);
        }

        $this->collects()->create([
            'user_id' => $this->delegate_id,
            'amount' => $this->getDeliveryCost() - $this->getAppProfit(),
        ]);
    }

    public function handleWalletPayment()
    {
        // [1] Add a transaction to deduct the order's total cost to the user's wallet
        // [2] Add a transaction to add the order's total cost to the app's wallet
        // [3] Add a transaction to deduct the purchase cost from the app's wallet
        // [4] Add a transaction to add the purchase cost to the delegate's wallet
        // [5] Add a transaction to deduct the app's profit and tax cost from the app's wallet // - defer
        // [6] Add a transaction to add the app's profit and tax cost to the delegate's wallet // - defer

        // [1]
        Transaction::forceCreate([
            'user_id' => $this->user_id,
            'actor_id' => $this->user_id,
            'order_id' => $this->id,
            'identifier' => $identifier = Str::random(40),
            'amount' => $this->payment->getTotal() * -1,
            'status' => Transaction::BALANCE_STATUS,
            'type' => Transaction::ORDER_TOTAL_AMOUNT_TYPE,
            'date' => now(),
        ]);

        // [2]
        Transaction::forceCreate([
            'user_id' => null,
            'actor_id' => $this->user_id,
            'order_id' => $this->id,
            'identifier' => $identifier = Str::random(40),
            'amount' => $this->payment->getTotal(),
            'status' => Transaction::BALANCE_STATUS,
            'type' => Transaction::ORDER_TOTAL_AMOUNT_TYPE,
            'date' => now(),
        ]);

        // [3]
        if ($amount = $this->payment->details()->where('item_type',
            OrderPaymentDetails::PurchasableItem)->sum('cost')) {
            Transaction::forceCreate([
                'user_id' => null,
                'actor_id' => $this->user_id,
                'order_id' => $this->id,
                'identifier' => $identifier = Str::random(40),
                'amount' => $amount * -1,
                'status' => Transaction::BALANCE_STATUS,
                'type' => Transaction::PURCHASE_AMOUNT_TYPE,
                'date' => now(),
            ]);

            // [4]
            Transaction::forceCreate([
                'user_id' => $this->delegate_id,
                'actor_id' => $this->user_id,
                'order_id' => $this->id,
                'identifier' => $identifier = Str::random(40),
                'amount' => $amount,
                'status' => Transaction::BALANCE_STATUS,
                'type' => Transaction::PURCHASE_AMOUNT_TYPE,
                'date' => now(),
            ]);

            // [5]
            //Transaction::forceCreate([
            //    'user_id' => null,
            //    'actor_id' => $this->user_id,
            //    'order_id' => $this->id,
            //    'identifier' => $identifier = Str::random(40),
            //    'amount' => ($this->getDeliveryCost() - $this->getAppProfit()) * -1,
            //    'status' => Transaction::BALANCE_STATUS,
            //    'type' => Transaction::APP_PROFITS_TYPE,
            //    'date' => now(),
            //]);

            // [6]
            //Transaction::forceCreate([
            //    'user_id' => $this->delegate_id,
            //    'actor_id' => $this->user_id,
            //    'order_id' => $this->id,
            //    'identifier' => $identifier = Str::random(40),
            //    'amount' => $this->getDeliveryCost() - $this->getAppProfit(),
            //    'status' => Transaction::BALANCE_STATUS,
            //    'type' => Transaction::DELEGATE_PROFITS_TYPE,
            //    'date' => now(),
            //]);
        }
        $this->collects()->create([
            'user_id' => $this->delegate_id,
            'amount' => $this->getDeliveryCost() - $this->getAppProfit(),
        ]);
    }

    public function getDeliveryCost()
    {
        return $this->payment->details()
            ->where('item_type', OrderPaymentDetails::DeliveryCost)
            ->sum('cost');
    }

    public function getTaxCost()
    {
        return $this->payment->details()
            ->where('item_type', OrderPaymentDetails::TaxCost)
            ->sum('cost');
    }

    public function getAppProfit()
    {
        return ($this->getDeliveryCost() * Settings::get('app_profits_percent', 25)) / 100;
    }

    public function getAppProfitAndTax()
    {
        $amount = $this->getDeliveryCost();

        return (($amount * Settings::get('app_profits_percent', 25)) / 100) + $this->getTaxCost();
    }

    public function getAppProfitAndDelegateTax()
    {
        $amount = $this->getDeliveryCost();

        return $amount - $this->getAppProfit();
    }

    public function getTaxCostForApp()
    {
        return ($this->getTaxCost() * Settings::get('app_profits_percent', 25)) / 100;
    }

    public function getTaxCostForDelegate()
    {
        return $this->getTaxCost() - $this->getTaxCostForApp();
    }

    public function scopeNotRejected($builder)
    {
        return $builder->whereNotIn('status', [
            Order::RefusedByAdmin,
            Order::CanceledByUser,
            Order::CanceledBySystem,
            Order::CanceledAutomatic,
            Order::CanceledByDelegate,
            Order::CanceledSchedule,
        ]);
    }
}
