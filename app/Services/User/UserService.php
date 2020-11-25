<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
     /**
     * 账号密码登录用户
     *
     * @param  string  $name        用户名
     * @param  string  $password    密码
     * @return bool
     */ 
    public function passwordLogin(string $name, string $password): array
    {
        $user = User::where(['name' => $name])->first();
        if (!$user) {
            return [];
        }
        if (!Hash::check($password, $user->password)) {
            return [];
        }

        return $user->toArray();
    }

   


}