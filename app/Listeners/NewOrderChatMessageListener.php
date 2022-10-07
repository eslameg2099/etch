<?php

namespace App\Listeners;

use App\Broadcasting\PusherChannel;
use App\Events\NewOrderChatMessageEvent;
use App\Models\Notification as NotificationModel;
use App\Notifications\CustomNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;
use Pusher\Pusher;

class NewOrderChatMessageListener
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
     * @param NewOrderChatMessageEvent $event
     * @return void
     */
    public function handle(NewOrderChatMessageEvent $event)
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );
        $response = $pusher->get("/channels/presence-order-{$event->order->reference_number}/users");

        $users = [];

        if ($response && $response['status'] == 200) {
            $users = array_map(function ($user) {
                return $user->id;
            }, json_decode($response['body'])->users);
        }

        $user = $event->message->sender->is($event->order->Delegate)
            ? $event->order->User
            : $event->order->Delegate;

        if (! $user || in_array($user->id, $users)) {
            return;
        }

        Notification::send($user, new CustomNotification([
            'via' => ['database', PusherChannel::class],
            'database' => [
                'trans' => 'notifications.user.new_message',
                'user_id' => $event->message->sender_id,
                'order_id' => $event->order->id,
                'type' => NotificationModel::CHAT_MESSAGE_TYPE,
                'id' => $event->order->id,
            ],
            'fcm' => [
                'title' => Settings::get('name', 'Fetch App'),
                'body' => trans('notifications.user.new_message', [
                    'user' => $event->message->sender->name,
                    'order' => '#'.$event->order->id,
                ]),
                'type' => NotificationModel::CHAT_MESSAGE_TYPE,
                'data' => [
                    'id' => $event->order->id,
                ],
            ],
        ]));
    }
}
