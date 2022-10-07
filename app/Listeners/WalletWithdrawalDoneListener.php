<?php

namespace App\Listeners;

use App\Events\WalletWithdrawalDoneEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WalletWithdrawalDoneListener
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
     * @param  WalletWithdrawalDoneEvent  $event
     * @return void
     */
    public function handle(WalletWithdrawalDoneEvent $event)
    {
        //
    }
}
