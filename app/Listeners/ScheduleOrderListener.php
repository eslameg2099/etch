<?php

namespace App\Listeners;

use App\Events\NewScheduleOrderEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ScheduleOrderListener
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
     * @param  NewScheduleOrderEvent  $event
     * @return void
     */
    public function handle(NewScheduleOrderEvent $event)
    {
        //
    }
}
