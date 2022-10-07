<?php

namespace App\Rules;

use App\Models\Orders\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CanChangeDelegateRule implements Rule
{
    private $message;
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
            ->where('user_id', auth()->id())
            ->whereIn('status', [Order::WaitingForPayment, Order::WaitingForAddPayment])
            ->find($value);

        if(!$order) { $this->message = trans('errors.cannot_find_this_order') ; return false;}
        //if($order->start_at->diffInSeconds(Carbon::now(), false) > 300) {$this->message = trans('errors.cannot_change_delegate_after_5_min'); return false;}

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
