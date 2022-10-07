<?php

namespace App\Listeners;

use App\Broadcasting\PusherChannel;
use App\Events\CustomerAcceptOfferEvent;
use App\Models\Notification as NotificationModel;
use App\Models\Orders\Order;
use App\Notifications\CustomNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;

class CustomerAcceptOfferListener
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
     * @param  CustomerAcceptOfferEvent  $event
     * @return void
     */
    public function handle(CustomerAcceptOfferEvent $event)
    {
        Notification::send($event->offer->order->Delegate, new CustomNotification([
            'via' => ['database', PusherChannel::class],
            'database' => [
                'trans' => 'notifications.user.accept_offer',
                'user_id' => $event->offer->order->user_id,
                'order_id' => $event->offer->order_id,
                'offer_id' => $event->offer->id,
                'type' => $event->offer->order->type == Order::Delivery
                    ? NotificationModel::DELIVERED_ORDER_TYPE
                    : NotificationModel::PURCHASE_ORDER_TYPE,
                'id' => $event->offer->order_id,
            ],
            'fcm' => [
                'title' => Settings::get('name', 'Fetch App'),
                'body' => trans('notifications.user.accept_offer', [
                    'user' => $event->offer->order->User->name,
                    'order' => '#' . $event->offer->order_id,
                ]),
                'type' => $event->offer->order->type == Order::Delivery
                    ? NotificationModel::DELIVERED_ORDER_TYPE
                    : NotificationModel::PURCHASE_ORDER_TYPE,
                'data' => [
                    'id' => $event->offer->order_id,
                ],
            ],
        ]));
    }
}
