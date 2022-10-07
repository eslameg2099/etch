<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryCostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->isCustomer();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'  =>  'required|in:1,2',
            'receiving_address_id'  =>  'nullable|required_if:type,1|exists:user_addresses,id',
            'delivery_address_id'   =>  'required|exists:user_addresses,id|different:receiving_address_id',
            'shop_id'               =>  ['nullable',
                Rule::requiredIf(function (){
                    return ( request('type') == 2 &&
                        (
                            is_null(request('shop_name'))  &&
                            is_null(request('lat'))        &&
                            is_null(request('long'))
                        )
                    );
                }),
                Rule::exists('shops', 'id')->whereNull('by_user')
            ],
            'lat'             =>  ['nullable', Rule::requiredIf(function (){
                return request('type') == 2 && is_null(request('shop_id'));
            })],
            'long'             =>  ['nullable', Rule::requiredIf(function (){
                return request('type') == 2 && is_null(request('shop_id'));
            })]
        ];
    }
}
