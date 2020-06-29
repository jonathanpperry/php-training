<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
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
     * [override] バリデーション失敗時ハンドリング
     *
     * @param Validator $validator
     * @throw HttpResponseException
     * @see FormRequest::failedValidation()
     */
    protected function failedValidation(Validator $validator)
    {
        if ($validator->errors()->get('id')) {
            $response['data'] = $validator->errors()->get('id');
            throw new HttpResponseException(
                response()->json($response, 500)
            );    
        }
        if ($validator->errors()->get('token')) {
            $response['data'] = $validator->errors()->get('token');
            throw new HttpResponseException(
                response()->json($response, 500)
            );    
        }
    }
}
