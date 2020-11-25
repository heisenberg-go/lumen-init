<?php

namespace App\Http\Requests\Api\V1\User;

use App\Http\Requests\Api\V1\BaseRequest;

class UserStoreRequest extends BaseRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name' => 'required',
			'password' => 'required',
		];
	}

	public function messages()
    {
        return [
            'name.required' => '姓名不能为空',
            'password.required'  => '密码不能为空',    
        ];
    }

}