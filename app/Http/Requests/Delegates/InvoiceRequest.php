<?php

namespace App\Http\Requests\Delegates;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'order_id'  =>  ['required'], // todo check can create invoice
            'items'     =>  'required|array',
            'items.*.item_name' =>  'required', #distinct
            'items.*.item_price' =>  'required|numeric|min:0',
        ];
    }
}
