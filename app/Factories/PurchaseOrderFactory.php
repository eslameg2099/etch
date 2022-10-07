<?php

namespace App\Factories;

use App\Events\DelegateAddInvoiceEvent;
use App\Http\Resources\Orders\OrderResource;
use App\Interfaces\OrdersFactoryInterface;
use App\Models\Orders\Order;
use App\Models\Orders\OrderPayment;
use App\Models\Orders\OrderPaymentDetails;
use App\Models\Shop;
use App\Traits\RepositoryResponseTrait;
use Carbon\Carbon;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Builder;
use Laraeast\LaravelSettings\Facades\Settings;

class PurchaseOrderFactory implements OrdersFactoryInterface
{
    use RepositoryResponseTrait;

    public $order;
    public $delivery_cost;

    public function __construct(Order $order , $delivery_cost = null)
    {
        $this->order = $order;
        $this->delivery_cost = $delivery_cost;
    }

    public function createOrder($request)
    {
        $shop_id = request('shop_id') ?: $this->createNewShop();
        $this->order->shop_id = $shop_id;
        $this->order->branch_id = isset($request->branch)? $request->branch->id: null;
        $this->order->user_id = request()->user()->id;
        $this->order->delivery_address_id = request('delivery_address_id');
        $this->order->type = Order::Purchase;
        $this->order->is_schedule = request('is_schedule');
        $this->order->schedule_date = request('schedule_date');
        $this->order->reference_number = request()->user()->id.'-'.Carbon::now()->timestamp;
        $this->order->order_description = request('order_description');
        $this->order->status = request('is_schedule') ? Order::Schedule : Order::WaitingForOffers;
        $this->order->delivery_cost = $this->delivery_cost;
        $this->order->payment_type = request('payment_type', 1);

        $this->order->save();

        $this->order->forceFill(['reference_number' => $this->order->id.'-'.time()])->save();

        return $this->order;
    }

    public function updateOrder()
    {
        // TODO: Implement updateOrder() method.
    }

    public function createInvoice()
    {
        $itemsTotalPrice = collect(request()->input('items'))->pluck('item_price')->sum();
        //$deliveryCost = $this->order->user->city->delivery_cost;
        $deliveryCost = $this->delivery_cost;
        //if($this->order->type == Order::Purchase)
        //{
        //    $deliveryCost = $this->order->user->city->purchase_delivery_cost;
        //}
        //$delivery = $this->delivery_cost;
        $delivery = $deliveryCost;
        $amount = $delivery + $itemsTotalPrice;
        $tax = Settings::get('tax', 0);
        $total = $amount + (($delivery / 100) * $tax);
        throw_if(
            ! is_null($this->order->payment) && $this->order->payment->status >= OrderPayment::Pending,
            new \Exception(trans('errors.cannot_make_payment_operation_on_this_order'))
        );

        $this->order->update(['status' => Order::WaitingForPayment]);

        $payment = $this->order->payment()->updateOrCreate(['amount' => $total]);

        $items = collect(request()->input('items'))->map(function ($item) use ($payment) {
            return [
                'order_payment_id' => $payment->id,
                'item_type' => OrderPaymentDetails::PurchasableItem,
                'item_name' => $item['item_name'],
                'cost' => $item['item_price'],
            ];
        })
            ->merge($this->taxAndDelivery($payment, $delivery))
            ->toArray();

        $payment->details()->delete();
        $payment->details()->insert($items);
        broadcast(new DelegateAddInvoiceEvent($this->order));
    }

    public function getInvoice()
    {
        // TODO: Implement getInvoice() method.
    }

    private function createNewShop()
    {
        // todo create new shop
        $shop = Shop::query()->create([
            'name' => request('shop_name'),
            'lat' => request('lat'),
            'lng' => request('long'),
            'address' => getAddress(request('long') , request('lat')) ?? null,
            'by_user' => request()->user()->id,
        ]);

        return $shop->id;
    }

    public function SendOrderToClosestDelegates($exceptUsers = null)
    {
        $deliveryAddress = $this->order->deliveryAddress;
        $delegates = User::query()
            ->has('delegateTodayCompletedOrders', '<=', (int) Settings::get('orders_per_day'))
            ->whereDoesntHave('withdrawals', function (Builder $builder) {
                $builder->where('order_id', $this->order->id);
            })
            ->with('city')
            ->ClosestDelegates($deliveryAddress->lat, $deliveryAddress->lng, $deliveryAddress->city_id, 1)
            ->when($exceptUsers, function ($q) use ($exceptUsers) {
                return $q->whereNotIn('id', $exceptUsers);
            })
            ->when($this->order->payment_type == Order::PAYMENT_ON_DELIVERY, function (Builder $query) {
                return $query->whereHas('delegate', function (Builder $delegate) {
                    $delegate->where('can_receive_cash_orders', true);
                });
            })
            ->limit(25)
            ->get();

        $delegates = $delegates->count() > 0
            ? $delegates
            : User::query()
                ->has('delegateTodayCompletedOrders', '<=', (int) Settings::get('orders_per_day'))
                ->with('city')
                ->ClosestDelegates($deliveryAddress->lat, $deliveryAddress->lng, $deliveryAddress->city_id, 24)
                ->when($exceptUsers, function ($q) use ($exceptUsers) {
                    return $q->whereNotIn('id', $exceptUsers);
                })
                ->when($this->order->payment_type == Order::PAYMENT_ON_DELIVERY, function (Builder $query) {
                    return $query->whereHas('delegate', function (Builder $delegate) {
                        $delegate->where('can_receive_cash_orders', true);
                    });
                })
                ->limit(25)->get();

        return $delegates;
    }

    private function taxAndDelivery($payment, $delivery)
    {
        $tax = ($delivery / 100) * Settings::get('tax');

        return [
            [
                'order_payment_id' => $payment->id,
                'item_type' => OrderPaymentDetails::DeliveryCost,
                'item_name' => 'تكلفة التوصيل',
                'cost' => $delivery,
            ],
            [
                'order_payment_id' => $payment->id,
                'item_type' => OrderPaymentDetails::TaxCost,
                'item_name' => 'ضرائب',
                'cost' => $tax,
            ],
        ];
    }
}
