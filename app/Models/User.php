<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
// use Spatie\Permission\Traits\HasPermissions;
class User extends Authenticatable
{
    use HasRoles;
    // use HasPermissions;
    use Notifiable;

    public $timestamps = false;         //是否有created_at和updated_at字段


//         public static function findAvailableNo()
//     {
//         dd(1);
//       if('id'<10){

//   return '0'+'id';
// }
//     }

    protected $fillable = [
        'no', //U8用户id
        'name', //u8用户name
        'password',//u8密码
    ];

    protected $hidden = [
        'password',
    ];
}
