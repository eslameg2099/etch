<?php

namespace App\Http\Requests\Dashboard;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
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
        return RuleFactory::make([
            '%name%' => ['required', 'string', 'max:255'],
            '%description%' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'city_id' => ['required', 'exists:cities,id'],
            //'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            //'lng' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            //'address' => ['required']
        ]);
    }

    /**
     * Get the update validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        return RuleFactory::make([
            '%name%' => ['required', 'string', 'max:255'],
            '%description%' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'city_id' => ['required', 'exists:cities,id'],
            //'lat' => ['required', 'numeric'],
            //'lng' => ['required', 'numeric'],
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('shops.attributes'));
    }
}
