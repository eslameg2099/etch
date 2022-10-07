<?php

namespace App\Observers;

use App\Support\Payment\Models\Transaction;
use Laraeast\LaravelSettings\Facades\Settings;

class DisableReceivingCashOrdersIfBalanceNotEnough
{
    /**
     * Handle the Transaction "saved" event.
     *
     * @param \App\Support\Payment\Models\Transaction $transaction
     * @return void
     */
    public function saved(Transaction $transaction)
    {
        if (! $transaction->user || ! $transaction->user->delegate) {
            return;
        }
        $shouldDisableCashOrders = $transaction->user->isDelegate()
            && $transaction->user->delegate->can_receive_cash_orders
            && $transaction->user->getBalance() < Settings::get('delegate_hold_amount', 0);

        if ($shouldDisableCashOrders) {
            $transaction->user->delegate->forceFill([
                'can_receive_cash_orders' => 0,
            ])->save();
        }
    }
}
