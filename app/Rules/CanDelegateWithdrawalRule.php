<?php

namespace App\Rules;

use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CanDelegateWithdrawalRule implements Rule
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
        $order  =   Order::query()
            ->whereNotIn('status', [
                Order::PaymentDone,
                Order::UnderDelivery,
                Order::Delivered,
                Order::UnderReview,
            ])
            ->whereHas('offers', function ($q) {return $q->DelegateCanWithdrawal();})
            //->with(['offers' => function($q) {return $q->DelegateCanWithdrawal();}])
            ->find($value);

        if(!$order) return false;

        return  true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('errors.cannot_withdrawal_from_order');
    }
}
