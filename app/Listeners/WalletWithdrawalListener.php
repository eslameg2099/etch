<?php

namespace App\Listeners;

use App\Events\WalletWithdrawalEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WalletWithdrawalListener
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
     * @param  WalletWithdrawalEvent  $event
     * @return void
     */
    public function handle(WalletWithdrawalEvent $event)
    {
        //
    }
}
