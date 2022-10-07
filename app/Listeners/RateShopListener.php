<?php

namespace App\Listeners;

use App\Broadcasting\PusherChannel;
use App\Events\RateShopEvent;
use App\Models\Notification as NotificationModel;
use App\Models\Users\User;
use App\Notifications\CustomNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;

class RateShopListener
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
     * @param  RateShopEvent  $event
     * @return void
     */
    public function handle(RateShopEvent $event)
    {
        User::where('type', User::User)->each(function (User $user) use ($event) {
            Notification::send($user, new CustomNotification([
                'via' => ['database', PusherChannel::class],
                'database' => [
                    'trans' => 'notifications.user.rate_shop',
                    'shop_id' => $event->shop->id,
                    'type' => NotificationModel::RATE_SHOP_TYPE,
                    'id' => $event->shop->id,
                ],
                'fcm' => [
                    'title' => Settings::get('name', 'Fetch App'),
                    'body' => trans('notifications.user.rate_shop', [
                        'shop' => '#' . $event->shop->id,
                    ]),
                    'type' => NotificationModel::RATE_SHOP_TYPE,
                    'data' => [
                        'id' => $event->shop->id,
                        'shop' => [
                            'name' => $event->shop->ar_name,
                            'image' => $event->shop->image_url,
                        ],
                    ],
                ],
            ]));
        });
    }
}
