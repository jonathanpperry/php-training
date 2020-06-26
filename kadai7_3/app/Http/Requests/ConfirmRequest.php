<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConfirmRequest extends BaseRequest
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
            'id' => 'required|integer',
            'token' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'IDを入力して下さい。',
            'id.integer' => 'IDを入力して下さい。',
            'token.required' => 'tokenを入力して下さい。',
            'token.string' => 'tokenを入力して下さい。',
        ];
    }
}
