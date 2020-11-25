<?php

namespace App\Http\Requests\Api\V1\User;

use App\Http\Requests\Api\V1\BaseRequest;

class UserIdRequest extends BaseRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'userId' => 'required',
		];
	}

	public function messages()
    {
        return [
            'userId.required' => '用户ID不能为空',  
        ];
    }

}