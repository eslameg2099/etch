<?php

namespace App\Observers;

use App\Models\Users\Delegate;
use App\Events\DelegateDeclinedEvent;
use App\Events\DelegateApprovedEvent;

class ApproveDelegateObserver
{
    /**
     * Handle the Delegate "saving" event.
     *
     * @param  \App\Models\Users\Delegate  $delegate
     * @return void
     */
    public function saving(Delegate $delegate)
    {
        if ($delegate->isDirty('is_approved')) {
            if ($delegate->is_approved) {
                broadcast(new DelegateApprovedEvent($delegate));
            } else {
                broadcast(new DelegateDeclinedEvent($delegate));
            }
        }
    }
}
