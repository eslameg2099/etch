<?php

namespace App\Http\Requests;

use App\Rules\CanChangeDelegateRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangeDelegateRequest extends FormRequest
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
            'order_id'  =>  ['required' , new CanChangeDelegateRule()]
        ];
    }
}
