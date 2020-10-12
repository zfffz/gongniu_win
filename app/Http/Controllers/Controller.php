<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public function before($user, $ability)
    // {
    //     // 如果用户拥有管理内容的权限的话，即授权通过
    //     if ($user->can('manage_users')) {
    //         return true;
    //     }
    // }
}
