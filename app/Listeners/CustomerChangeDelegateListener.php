<?php

namespace App\Listeners;

use App\Broadcasting\PusherChannel;
use App\Events\CustomerChangeDelegateEvent;
use App\Models\Notification as NotificationModel;
use App\Models\Orders\Order;
use App\Notifications\CustomNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;

class CustomerChangeDelegateListener
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
     * @param  CustomerChangeDelegateEvent  $event
     * @return void
     */
    public function handle(CustomerChangeDelegateEvent $event)
    {
        Notification::send($event->order->Delegate, new CustomNotification([
            'via' => ['database', PusherChannel::class],
            'database' => [
                'trans' => 'notifications.user.change_delegate',
                'user_id' => $event->order->user_id,
                'order_id' => $event->order->id,
                'type' => $event->order->type == Order::Delivery
                    ? NotificationModel::DELIVERED_ORDER_TYPE
                    : NotificationModel::PURCHASE_ORDER_TYPE,
                'id' => $event->order->id,
            ],
            'fcm' => [
                'title' => Settings::get('name', 'Fetch App'),
                'body' => trans('notifications.user.change_delegate', [
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
