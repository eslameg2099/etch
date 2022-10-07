<?php

namespace App\Observers;

use App\Models\Orders\Order;

class OrdersObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param \App\Models\Orders\Order $order
     * @return void
     */
    public function created(Order $order)
    {
        //
    }

    /**
     * Handle the Order "saved" event.
     *
     * @param \App\Models\Orders\Order $order
     * @return void
     */
    public function saved(Order $order)
    {
        Order::withoutEvents(function () use ($order) {
            if ($order->isClosed()) {
                $order->update(['closed_at' => now()]);
                if ($delegate = $order->Delegate) {
                    $delegate->delegate->forceFill(['is_available' => 1])->save();
                }
            }
        });
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param \App\Models\Orders\Order $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param \App\Models\Orders\Order $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param \App\Models\Orders\Order $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
