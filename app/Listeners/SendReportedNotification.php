<?php

namespace App\Listeners;

use App\Events\Reported;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReportedNotification
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
     * @param  Reported  $event
     * @return void
     */
    public function handle(Reported $event)
    {
        //
    }
}
