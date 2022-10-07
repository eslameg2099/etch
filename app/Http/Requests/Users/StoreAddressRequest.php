<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'name'      =>  'required|min:2',
            'city_id'   =>  'required|exists:cities,id',
            'address'   =>  'required|min:10',
            'long'      =>  ['required','regex:/\A[+-]?(?:180(?:\.0{1,18})?|(?:1[0-7]\d|\d{1,2})\.\d{1,18})\z/x'],
            'lat'       =>  ['required','regex:/\A[+-]?(?:90(?:\.0{1,18})?|\d(?(?<=9)|\d?)\.\d{1,18})\z/x'],
            'is_default'    =>  'nullable|in:0,1'
        ];
    }

    public function messages()
    {
        return [
            'lat.regex' =>  trans('errors.not_correct_lat'),
            'long.regex' =>  trans('errors.not_correct_long'),
        ];
    }
}
