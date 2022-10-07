<?php

namespace App\Observers;

use App\Models\Orders\Order;

class UpdateDelegateRateObserver
{
    /**
     * Handle the Order "saved" event.
     *
     * @param \App\Models\Orders\Order $order
     * @return void
     */
    public function saved(Order $order)
    {
        if ($order->Delegate) {
            Order::withoutEvents(function () use ($order) {
                $order->Delegate->forceFill([
                    'rate' => (int)$order->Delegate->delegateOrders()->average('rate'),
                ])->save();
            });
        }
    }
}
