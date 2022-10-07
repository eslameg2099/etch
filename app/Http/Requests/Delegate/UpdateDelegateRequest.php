<?php

namespace App\Http\Requests\Delegate;

use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDelegateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->type == User::Delegate;
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
            'city_id'       =>  'required|exists:cities,id',
            'email'         =>  'nullable|email',
        ];
    }
}
