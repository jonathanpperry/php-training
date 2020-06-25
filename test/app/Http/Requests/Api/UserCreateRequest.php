<?php
/**
 * ユーザー登録
 */

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\Request;

class UserCreateRequest extends Request
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
            'nickname'  => 'required',
            'uuid'      => 'required|uuid',
        ];
    }
}
