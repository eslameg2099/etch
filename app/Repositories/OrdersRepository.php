<?php

namespace App\Repositories;

use App\Broadcasting\PusherChannel;
use App\Events\NewOrderEvent;
use App\Factories\DeliveryOrderFactory;
use App\Factories\PurchaseOrderFactory;
use App\Interfaces\OrdersRepositoryInterface;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use App\Models\Shop;
use App\Models\Users\Address;
use App\Models\Users\Delegate;
use App\Notifications\CustomNotification;
use App\Notifications\Orders\NewOrderNotification;
use App\Traits\RepositoryResponseTrait;
use Illuminate\Support\Facades\Http;
use App\Models\Notification as NotificationModel;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;
use Pusher\Pusher;

class OrdersRepository implements OrdersRepositoryInterface
{
    use RepositoryResponseTrait;

    public function getAllOrders()
    {
        $orders = Order::query()->where('user_id', auth()->id())->get();

        return $orders ?: null;
    }

    public function getOrderById($id)
    {
        $order = Order::query()->with('offers')->find($id);

        return $order ?: null;
    }
    public function getDeliveryCost($request)
    {
        switch ($request->type) {
            case Order::Delivery:
                $origin = Address::findOrFail($request->receiving_address_id);
                $destination = Address::findOrFail($request->delivery_address_id);
                $cost = delivery_distance($origin,$destination) * Settings::get('delivery_cost_per_km');
                return $cost < Settings::get('min_delivery_cost') ? Settings::get('min_delivery_cost') : $cost;

            case Order::Purchase:
                if(isset($request->shop_id)){
                    $origin = $this->getNearestBranch($request->shop_id);
                    $request->branch = $origin;
                }else
                    $origin = (object) array('lat' => $request->lat, 'lng' => $request->long);
                $destination = Address::findOrFail($request->delivery_address_id);
                $cost = delivery_distance($origin,$destination) * Settings::get('buy_cost_per_km');
                return $cost < Settings::get('min_buy_cost') ? Settings::get('min_buy_cost') : $cost;
            default:
                return $this->validationError(['message' => trans('errors.this_type_not_supported')]);
        }
    }
    private function getNearestBranch($shop_id)
    {
        $shop = Shop::findOrFail($shop_id);
        //dd(($shop->branches()->withDistance()->first()));
        if($shop->has('branches')) return $shop->branches()->withDistance()->first();
        return $shop;

    }

    public function createOrder($request)
    {
        $order = new Order();
        $delivery_cost = $this->getDeliveryCost($request);
        try {
            switch ($request->type) {
                case Order::Delivery:
                    $orderFactory = new DeliveryOrderFactory($order,$delivery_cost);
                    break;
                case Order::Purchase:
                    $orderFactory = new PurchaseOrderFactory($order,$delivery_cost);
                    break;
                default:
                    return $this->validationError(['message' => trans('errors.this_type_not_supported')]);
            }

            $order = $orderFactory->createOrder($request);

            if (! request('is_schedule')) {
                $this->ProcessOrderNow($orderFactory, $order);
            }

            return $order;
        } catch (\Exception $e) {
            return $this->serverError(['message' => $e->getMessage()]);
        }
    }

    public function updateOrder($request, $id)
    {
        // TODO: Implement updateOrder() method.
    }

    public function deleteOrder($id)
    {
        // TODO: Implement deleteOrder() method.
    }

    public function changeDelegate($order)
    {
        /** @var Order $order */
        $orderFactory = $order->getFactory();
        if ($order->Delegate) {
            $order->Delegate->delegate->forceFill(['is_available' => 1])->save();
        }
        $order->update(['start_at' => null, 'status' => Order::WaitingForOffers, 'delegate_id' => null]);
        $order->withdrawals()->attach($order->Delegate); // not to send the order again
        $this->ProcessOrderNow($orderFactory, $order);
    }

    private function ProcessOrderNow($orderFactory = null, $order, $exceptUsers = null)
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );
        $response = $pusher->get('/channels/presence-socket-status/users');
        $users = [];

        if ($response && $response['status'] == 200) {
            $users = array_map(function ($user) {
                return $user->id;
            }, json_decode($response['body'])->users);
        }

        $closest = $orderFactory->SendOrderToClosestDelegates($exceptUsers);

        $withdrawals = $order->withdrawals()->pluck('delegate_id');

        $closest->whereNotIn('id', $withdrawals)->each(function ($user) use ($order) {
            OrderOffer::query()->create([
                'delegate_id' => $user->id,
                'order_id' => $order->id,
                'lat' => $user->lat,
                'lng' => $user->lng,
                'status' => OrderOffer::WaitingDelegateAction,
                'distance' => $user->distance,
            ]);
        });

        $closest->whereNotIn('id', $withdrawals)->whereIn('id', $users)->map(function ($delegate) use ($order) {
            broadcast(new NewOrderEvent($order, $delegate, $delegate->distance));
        });

        // $closest->whereNotIn('id', $users)
        Notification::send($closest, new CustomNotification([
            'via' => ['database', PusherChannel::class],
            'database' => [
                'trans' => 'notifications.user.new_order',
                'order_id' => $order->id,
                'type' => $order->type == Order::Delivery
                    ? NotificationModel::DELIVERED_ORDER_TYPE
                    : NotificationModel::PURCHASE_ORDER_TYPE,
                'id' => $order->id,
            ],
            'fcm' => [
                'title' => Settings::get('name', 'Fetch App'),
                'body' => trans('notifications.user.new_order', [
                    'order' => '#' . $order->id,
                ]),
                'type' => $order->type == Order::Delivery
                    ? NotificationModel::DELIVERED_ORDER_TYPE
                    : NotificationModel::PURCHASE_ORDER_TYPE,
                'data' => [
                    'id' => $order->id,
                ],
            ],
        ]));
    }

    public function startOrder(Order $order)
    {
        if ($order->status == Order::Schedule) {
            $order->forceFill(['status' => Order::WaitingForOffers])->save();
            $this->ProcessOrderNow($order->getFactory(), $order);
        }

        return $this;
    }

    public function cancelOrder(Order $order)
    {
        $status = auth()->user()->isDelegate() ? Order::CanceledByDelegate : Order::CanceledByUser;

        $order->forceFill(['status' => $status, 'closed_at' => now()])->save();

        return $order->refresh();
    }
}
