<?php

namespace App\Observers;

use App\Broadcasting\PusherChannel;
use App\Models\Notification as NotificationModel;
use App\Models\Orders\Order;
use App\Models\Users\User;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;

class CancellationAttemptsObserver
{
    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Models\Users\User  $user
     * @return void
     */
    public function saving(User $user)
    {
        if ($user->isDirty('cancellation_attempts') && $user->cancellation_attempts == 0) {
            Notification::send($user, new CustomNotification([
                'via' => ['database', PusherChannel::class],
                'database' => [
                    'trans' => 'notifications.user.cancellation-attempts-0',
                    'user_id' => $user->id,
                    'type' => NotificationModel::CANCELLATION_ATTEMPTS_TYPE,
                    'id' => $user->id,
                ],
                'fcm' => [
                    'title' => Settings::get('name', 'Fetch App'),
                    'body' => trans('notifications.user.cancellation-attempts-0', [
                        'attempts' => $user->cancellation_attempts,
                    ]),
                    'type' => NotificationModel::CANCELLATION_ATTEMPTS_TYPE,
                    'data' => [
                        'id' => $user->id,
                    ],
                ],
            ]));
        }

        if ($user->getOriginal('cancellation_attempts') == 0 && $user->isDirty('cancellation_attempts') && $user->cancellation_attempts > 0) {
            Notification::send($user, new CustomNotification([
                'via' => ['database', PusherChannel::class],
                'database' => [
                    'trans' => 'notifications.user.cancellation-attempts-add',
                    'user_id' => $user->id,
                    'type' => NotificationModel::CANCELLATION_ATTEMPTS_TYPE,
                    'id' => $user->id,
                ],
                'fcm' => [
                    'title' => Settings::get('name', 'Fetch App'),
                    'body' => trans('notifications.user.cancellation-attempts-add', [
                        'attempts' => $user->cancellation_attempts,
                    ]),
                    'type' => NotificationModel::CANCELLATION_ATTEMPTS_TYPE,
                    'data' => [
                        'id' => $user->id,
                    ],
                ],
            ]));
        }
    }
}
