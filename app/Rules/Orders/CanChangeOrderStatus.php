<?php

namespace App\Rules\Orders;

use App\Models\Orders\Order;
use Illuminate\Contracts\Validation\Rule;

class CanChangeOrderStatus implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $order = Order::query()
            ->DeliveryChangeStatus()
            ->find($value);

        if (! $order) {
            $this->message = trans('errors.cannot_find_this_order');

            return false;
        }

        if (! in_array($order->status, [Order::UnderReview, Order::UnderDelivery, Order::PaymentDone])) {
            $this->message = trans('errors.cannot_change_order_status', ['status' => $order->readable_status]);

            return false;
        }

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
