<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DelegateRequest extends FormRequest
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
            'national_id' => ['required'],
            'vehicle_type' => ['required'],
            'vehicle_model' => ['required'],
            'vehicle_number' => ['required'],
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
            'mobile' => ['required', 'unique:users,mobile,'.$this->route('delegate')->id],
            'city_id' => ['required', 'exists:cities,id'],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'national_id' => ['required'],
            'vehicle_type' => ['required'],
            'vehicle_model' => ['required'],
            'vehicle_number' => ['required'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('delegates.attributes');
    }
}
