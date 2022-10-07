<?php

namespace App\Http\Requests\Users;

use App\Rules\Orders\CanAcceptThisOffer;
use Illuminate\Foundation\Http\FormRequest;

class AcceptOfferRequest extends FormRequest
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
            'offer_id'  =>  ['required', new CanAcceptThisOffer()]
        ];
    }
}
