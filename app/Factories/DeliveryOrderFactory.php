<?php

namespace App\Factories;

use App\Events\DelegateAddInvoiceEvent;
use App\Interfaces\OrdersFactoryInterface;
use App\Models\Orders\Order;
use App\Models\Orders\OrderPaymentDetails;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Laraeast\LaravelSettings\Facades\Settings;

class DeliveryOrderFactory implements OrdersFactoryInterface
{
    public $order;
    public $delivery_cost;

    public function __construct(Order $order , $delivery_cost = null)
    {
        $this->order = $order;
        $this->delivery_cost = $delivery_cost;
    }

    public function createOrder($request)
    {
        $this->order->user_id = request()->user()->id;
        $this->order->receiving_address_id = request('receiving_address_id');
        $this->order->delivery_address_id = request('delivery_address_id');
        $this->order->type = Order::Delivery;
        $this->order->is_schedule = request('is_schedule');
        $this->order->schedule_date = request('schedule_date');
        $this->order->reference_number = request()->user()->id.'-'.Carbon::now()->timestamp;
        $this->order->order_description = request('order_description');
        $this->order->status = request('is_schedule') ? Order::Schedule : Order::WaitingForOffers;
        $this->order->delivery_cost = $this->delivery_cost;
        $this->order->payment_type = request('payment_type', 1);

        $this->order->save();

        $this->order->forceFill(['reference_number' => $this->order->id.'-'.time()])->save();

        $this->createInvoice();

        return $this->order;
    }

    public function updateOrder()
    {
        // TODO: Implement updateOrder() method.
    }

    public function createInvoice()
    {
        //$amount = $this->order->user->city->delivery_cost;
        $amount = $this->delivery_cost;
        //$amount = $this->delivery_cost;
        $tax = Settings::get('tax', 0);
        $total = $amount + (($amount / 100) * $tax);
        $payment = $this->order->payment()->create(['amount' => $total]);
        $payment->details()->insert([
            [
                'order_payment_id' => $payment->id,
                'item_type' => OrderPaymentDetails::DeliveryCost,
                'item_name' => 'تكلفة التوصيل',
                'cost' => $amount,
            ],
            [
                'order_payment_id' => $payment->id,
                'item_type' => OrderPaymentDetails::TaxCost,
                'item_name' => 'ضرائب',
                'cost' => $total - $amount,
            ],
        ]);
    }

    public function getInvoice()
    {
        // TODO: Implement getInvoice() method.
    }

    public function SendOrderToClosestDelegates($exceptUsers = null)
    {
        $receivingAddress = $this->order->receivingAddress;

        $query = User::query()
            ->whereDoesntHave('withdrawals', function (Builder $builder) {
                $builder->where('order_id', $this->order->id);
            })
            ->has('delegateTodayCompletedOrders', '<=', (int) Settings::get('orders_per_day'))
            ->when($this->order->payment_type == Order::PAYMENT_ON_DELIVERY, function (Builder $query) {
                return $query->whereHas('delegate', function (Builder $delegate) {
                    $delegate->where('can_receive_cash_orders', true);
                });
            });


        $delegates = (clone $query)
            ->with('city')
            ->ClosestDelegates($receivingAddress->lat, $receivingAddress->lng, $receivingAddress->city_id, 1)
            ->when($exceptUsers, function ($q) use ($exceptUsers) {
                return $q->whereNotIn('id', $exceptUsers);
            })
            ->limit(25)
            ->get();
        return $delegates->count() > 0
            ? $delegates
            : (clone $query)
                ->with('city')
                ->ClosestDelegates($receivingAddress->lat, $receivingAddress->lng, $receivingAddress->city_id, 24)
                ->when($exceptUsers, function ($q) use ($exceptUsers) {
                    return $q->whereNotIn('id', $exceptUsers);
                })
                ->limit(25)
                ->get();
    }
}
