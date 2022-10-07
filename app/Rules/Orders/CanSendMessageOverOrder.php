<?php

namespace App\Rules\Orders;

use App\Models\Orders\Order;
use Illuminate\Contracts\Validation\Rule;

class CanSendMessageOverOrder implements Rule
{

    private $message;
    private $checkClosed;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($checkClosed = true)
    {
        $this->checkClosed  =   $checkClosed;
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
        $order    =   Order::query()
            ->where(function ($query) {
                return $query->where('user_id', auth()->id())
                    ->orWhere('delegate_id', auth()->id());
            })
            ->whereNotNull('delegate_id')
            ->whereNotNull('start_at')
            ->find($value);

        if( !$order ) { $this->message = trans('errors.cannot_find_this_order'); return false;}

        if( $this->checkClosed && $order->isClosed() ) { $this->message = trans('errors.this_order_close'); return false;}

        return  true;
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
