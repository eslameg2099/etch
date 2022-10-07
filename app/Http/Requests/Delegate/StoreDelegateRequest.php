<?php

namespace App\Http\Requests\Delegate;

use Illuminate\Foundation\Http\FormRequest;

class StoreDelegateRequest extends FormRequest
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
            'name' => 'required',
            'type' => 'required|in:1,2',
            'mobile' => 'required|unique:users,mobile|min:9|max:12',
            'city_id' => 'required|exists:cities,id',
            'email' => 'nullable|email',
            'password' => 'required|confirmed|min:6',
            'device_name' => 'required',
            'national_id' => 'required|numeric|unique:delegates,national_id',
            'vehicle_type' => 'required',
            'vehicle_model' => 'required',
            'vehicle_number' => 'required|unique:delegates,vehicle_number',
            'vehicle_number_image' => 'required|image',
            'image' => 'required|image',
            'national_id_front_image' => 'required|image',
            'national_id_back_image' => 'required|image',
        ];
    }
}
