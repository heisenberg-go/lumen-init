<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'users';

    public $timestamps = false;
    
    protected $hidden = [
        'password'
    ];

    protected $fillable = [
        'name', 
        'password', 
        'updated_at',
        'created_at'
    ];

    /**
     * 获取所有用户列表
     *
     * @return object
     */ 
    public function getUserAll()
    {
        return self::all();
    }

}
