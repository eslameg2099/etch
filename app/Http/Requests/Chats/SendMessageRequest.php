<?php

namespace App\Http\Requests\Chats;

use App\Rules\Orders\CanSendMessageOverOrder;
use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id'  =>  ['required', new CanSendMessageOverOrder()],
            'message'   =>  'required_without:image',
            'image'     =>  'nullable|image'
        ];
    }
}
