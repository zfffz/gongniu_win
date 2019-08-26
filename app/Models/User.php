<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;         //是否有created_at和updated_at字段

    protected $fillable = [
        'no', //U8用户id
        'name', //u8用户name
        'password',//u8密码
    ];

    protected $hidden = [
        'password',
    ];
}
