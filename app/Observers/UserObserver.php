<?php

namespace App\Observers;

use App\Models\Users\User;
use Laraeast\LaravelSettings\Facades\Settings;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param  \App\Models\Users\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $attempts = $user->isDelegate()
            ? Settings::get('delegate_cancellation_attempts', 5)
            : Settings::get('user_cancellation_attempts', 3);

        $user->forceFill(['cancellation_attempts' => $attempts]);
    }
}
