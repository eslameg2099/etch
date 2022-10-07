<?php

namespace App\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            return $this->createRules();
        } else {
            return $this->updateRules();
        }
    }
    private function createRules()
    {
        return RuleFactory::make([
            '%name%' => ['required', 'string', 'max:255'],
            '%description%' => ['required', 'string', 'max:255'],
            'shop_id' => ['required', 'exists:shops,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'lng' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'address' => ['required', 'string', 'max:255'],
        ]);
    }
    private function updateRules()
    {
        return [
            'name' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
            'shop_id' => ['exists:shops,id'],
            'city_id' => ['exists:cities,id'],
            'lat' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'lng' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'address' => ['string', 'max:255'],
        ];
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
