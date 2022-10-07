<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use WithHashedPassword;

    /**
     * Determine if the supervisor is authorized to make this request.
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
        if ($this->isMethod('POST')) {
            return $this->createRules();
        } else {
            return $this->updateRules();
        }
    }

    /**
     * Get the create validation rules that apply to the request.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'unique:users,mobile'],
            'city_id' => ['required', 'exists:cities,id'],
            'password' => ['required', 'min:8', 'confirmed'],
            'delegate.national_id' => 'required|unique:delegates,national_id',
        ];
    }

    /**
     * Get the update validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'unique:users,mobile,'.optional($this->route('user') ?: $this->route('delegate'))->id],
            'city_id' => ['required', 'exists:cities,id'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('users.attributes');
    }
}
