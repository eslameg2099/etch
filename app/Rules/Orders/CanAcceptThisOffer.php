<?php

namespace App\Rules\Orders;

use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use Illuminate\Contracts\Validation\Rule;

class CanAcceptThisOffer implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $offer  =   OrderOffer::query()->whereHas('order', function ($q) {
            $q->where('user_id', request()->user()->id)
                ->where('status', Order::WaitingForOffers);
        })->find($value);

        return (boolean) $offer;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('errors.cannot_accept_this_offer_on_this_order');
    }
}
