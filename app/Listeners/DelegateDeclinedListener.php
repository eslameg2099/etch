<?php

namespace App\Listeners;

use App\Broadcasting\PusherChannel;
use App\Events\DelegateApprovedEvent;
use App\Events\DelegateDeclinedEvent;
use App\Models\Notification as NotificationModel;
use App\Notifications\CustomNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;

class DelegateDeclinedListener
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
     * @param \App\Events\DelegateDeclinedEvent $event
     * @return void
     */
    public function handle(DelegateDeclinedEvent $event)
    {
        Notification::send($event->delegate->user, new CustomNotification([
            'via' => ['database', PusherChannel::class],
            'database' => [
                'trans' => 'notifications.delegate.declined',
                'user_id' => $event->delegate->user_id,
                'type' => NotificationModel::DELEGATE_TYPE,
                'id' => $event->delegate->user_id,
            ],
            'fcm' => [
                'title' => Settings::get('name', 'Fetch App'),
                'body' => trans('notifications.delegate.declined', [
                    'delegate' => $event->delegate->user->name,
                ]),
                'type' => NotificationModel::DELEGATE_TYPE,
                'data' => [
                    'id' => $event->delegate->user_id,
                ],
            ],
        ]));
    }
}
