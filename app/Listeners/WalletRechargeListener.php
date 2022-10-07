<?php

namespace App\Listeners;

use App\Broadcasting\PusherChannel;
use App\Events\WalletRechargeEvent;
use App\Models\Notification as NotificationModel;
use App\Models\Orders\Order;
use App\Notifications\CustomNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;

class WalletRechargeListener
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
     * @param WalletRechargeEvent $event
     * @return void
     */
    public function handle(WalletRechargeEvent $event)
    {
        $key = $event->transaction->amount > 0
            ? 'notifications.user.wallet-recharge'
            : 'notifications.user.wallet-discount';

        $amount = abs($event->transaction->amount) . ' '. Settings::locale()->get('currency');

        Notification::send($event->transaction->user, new CustomNotification([
            'via' => ['database', PusherChannel::class],
            'database' => [
                'trans' => $key,
                'user_id' => $event->transaction->user_id,
                'transaction_id' => $event->transaction->id,
                'type' => NotificationModel::WALLET_TYPE,
                'id' => $event->transaction->user_id,
            ],
            'fcm' => [
                'title' => Settings::get('name', 'Fetch App'),
                'body' => trans($key, [
                    'amount' => abs($event->transaction->amount) . ' '. Settings::locale()->get('currency'),
                ]),
                'type' => NotificationModel::WALLET_TYPE,
                'data' => [
                    'id' => $event->transaction->user_id,
                ],
            ],
        ]));
    }
}
