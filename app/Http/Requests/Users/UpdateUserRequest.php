<?php

namespace App\Http\Requests\Users;

use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $segments   =   request()->segments();
        return [
            'same_user'     =>  Rule::requiredIf(function ()use($segments){
                return end($segments) != auth()->user()->id;
            }),
            'name'          =>  'required',
            'city_id'       =>  'required|exists:cities,id',
            'email'         =>  'nullable|email',
        ];
    }

    public function messages()
    {
        return [
            'same_user.required'    =>  trans('errors.not_allowed_change_this_id')
        ];
    }
}
