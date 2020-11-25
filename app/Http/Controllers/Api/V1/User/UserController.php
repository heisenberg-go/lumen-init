<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Hashing\Hasher as Hash;
use App\Http\Controllers\Api\V1\BaseController;
use App\Models\User\User;
use App\Services\User\UserService;
use App\Http\Requests\Api\V1\User\{UserStoreRequest, UserIdRequest};

class UserController extends BaseController
{
    
    private $hash;

	private $userService;

    public function __construct(UserService $userService, Hash $hash)
    {
        $this->hash = $hash;
        $this->userService = $userService;
    }

    /**
     * 获取用户列表
     *
     * @return josn
     */  
    public function show(User $user)
    {
        return $this->data($user->getUserAll());
    }

    /**
     * 注册用户
     *
     * @param  string  $name           账号
     * @param  string  $password       密码
     * @return josn
     */  
    public function store(UserStoreRequest $request)
    {
        $time = time();
        return $this->data(User::create([
            'name' => $request->name,
            'password' => $this->hash->make($request->password),
            'created_at' => $time,
            'updated_at' => $time
        ]));
    }

    /**
     * 更新用户信息
     *
     * @param  string  $userId         ID
     * @param  string  $name           账号
     * @param  string  $password       密码
     * @return josn
     */  
    public function update(UserIdRequest $request, User $user)
    {
        //$where = $request->only('id');
        $where = ['id' => $request->userId];
        $data = [];
        if ($request->password) {
            $data['password'] = $this->hash->make($request->password);
        }
        if ($request->name) {
            $data['name'] = $request->name;
        }
        $data['updated_at'] = time();
        if(empty($data)){
            return $this->error(6);
        }

        $user->where($where)->update($data);

        return $this->success();
    }

    /**
     * 删除用户
     *
     * @param  int  $userId   用户ID
     * @return josn
     */  
    public function destroy(UserIdRequest $request, User $user)
    {
        if($user->where('id', $request->userId)->delete()){
            return $this->success();
        }

        return $this->error();
    }
}