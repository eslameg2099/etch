<?php

namespace App\Http\Requests\Delegates;

use App\Rules\Orders\CanChangeOrderStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
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
            'order_id'  =>  ['required' , new CanChangeOrderStatus()],
            'status'    =>  'required|in:7,8'
        ];
    }
}
