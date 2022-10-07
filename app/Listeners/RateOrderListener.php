<?php

namespace App\Listeners;

use App\Broadcasting\PusherChannel;
use App\Events\RateOrderEvent;
use App\Models\Notification as NotificationModel;
use App\Models\Orders\Order;
use App\Notifications\CustomNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;

class RateOrderListener
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
     * @param  RateOrderEvent  $event
     * @return void
     */
    public function handle(RateOrderEvent $event)
    {
        Notification::send($event->order->User, new CustomNotification([
            'via' => ['database', PusherChannel::class],
            'database' => [
                'trans' => 'notifications.user.rate_order',
                'order_id' => $event->order->id,
                'type' => NotificationModel::RATE_ORDER_TYPE,
                'id' => $event->order->id,
            ],
            'fcm' => [
                'title' => Settings::get('name', 'Fetch App'),
                'body' => trans('notifications.user.rate_order', [
                    'order' => '#' . $event->order->id,
                ]),
                'type' => NotificationModel::RATE_ORDER_TYPE,
                'data' => [
                    'id' => $event->order->id,
                    'delegate' => [
                        'name' => $event->order->Delegate->name,
                        'image' => $event->order->Delegate->image_url,
                    ],
                ],
            ],
        ]));
    }
}
