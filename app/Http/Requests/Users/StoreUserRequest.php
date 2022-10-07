<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          =>  'required',
            'type'          =>  'required|in:1,2',
            'mobile'        =>  'required|regex:/^(5)[0-9]{8}$/|unique:users,mobile',
            'city_id'       =>  'required|exists:cities,id',
            'email'         =>  'nullable|email',
            'password'      =>  'required|confirmed|min:6',
            'device_name'   =>  'required',
        ];
    }
}
