<?php

namespace App\Http\Requests\Delegate;

use App\Models\Orders\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcceptOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->isDelegate();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id'  =>  [
                'required',
                Rule::exists('orders', 'id')->where('status', Order::WaitingForOffers)
            ]
        ];
    }
}
