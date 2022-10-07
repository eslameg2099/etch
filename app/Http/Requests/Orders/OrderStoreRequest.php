<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStoreRequest extends FormRequest
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
            'is_schedule'           =>  'required|in:0,1',
            'schedule_date'         =>  'required_if:is_schedule,1',
            'order_description'     =>  'required',
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
            'shop_name'             =>  Rule::requiredIf(function (){
                return request('type') == 2 && is_null(request('shop_id'));
            }),
            'lat'             =>  ['nullable', Rule::requiredIf(function (){
                return request('type') == 2 && is_null(request('shop_id'));
            })],
            'long'             =>  ['nullable', Rule::requiredIf(function (){
                return request('type') == 2 && is_null(request('shop_id'));
            })]

        ];
    }

    public function messages()
    {
        return [
            'shop_id.required_id'   =>  trans('errors.shop_id_required_if')
        ];
    }
}
