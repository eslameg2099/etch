<?php

namespace App\Observers;

use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;

class RejectOffersWhenCancelOrderObserver
{
    /**
     * Handle the Order "saved" event.
     *
     * @param \App\Models\Orders\Order $order
     * @return void
     */
    public function saved(Order $order)
    {
        if ($order->isCanceled()) {
            $order->offers()->each(function (OrderOffer $offer) {
                $offer->forceFill(['status' => OrderOffer::CustomerReject])->save();
            });
        }
    }
}
