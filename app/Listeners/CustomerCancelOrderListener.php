<?php

namespace App\Listeners;

use App\Broadcasting\PusherChannel;
use App\Events\CustomerCancelOrderEvent;
use App\Notifications\CustomNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification as NotificationModel;
use App\Models\Orders\Order;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;

class CustomerCancelOrderListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CustomerCancelOrderEvent $event)
    {
        if(! $event->order->Delegate) return;
        Notification::send($event->order->Delegate, new CustomNotification([
            'via' => ['database', PusherChannel::class],
            'database' => [
                'trans' => 'notifications.user.cancel_order',
                'user_id' => $event->order->user_id,
                'order_id' => $event->order->id,
                'type' => $event->order->type == Order::Delivery
                    ? NotificationModel::DELIVERED_ORDER_TYPE
                    : NotificationModel::PURCHASE_ORDER_TYPE,
                'id' => $event->order->id,
            ],
            'fcm' => [
                'title' => Settings::get('name', 'Fetch App'),
                'body' => trans('notifications.user.cancel_order', [
                    'user' => $event->order->User->name,
                    'order' => '#' . $event->order->id,
                ]),
                'type' => $event->order->type == Order::Delivery
                    ? NotificationModel::DELIVERED_ORDER_TYPE
                    : NotificationModel::PURCHASE_ORDER_TYPE,
                'data' => [
                    'id' => $event->order->id,
                ],
            ],
        ]));
    }
}
