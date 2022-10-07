<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateMobileNumber extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && (auth()->user()->isCustomer() || auth()->user()->isDelegate());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'  =>  'required',
            'mobile'    =>  'required|regex:/^(5)[0-9]{8}$/|unique:users,mobile',
            'code'      =>  'required',
        ];
    }

    public function messages()
    {
        return [
            'password.required_if'  =>  trans('errors.password_not_correct')
        ];
    }
}
