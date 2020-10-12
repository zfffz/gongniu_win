<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends CommonsController
{
    public function root()
    {
        return view('pages.root');
    }

    public function permissionDenied()
    {

        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
        	// dd(1);
            return redirect(url(config('administrator.uri')), 302);
        }

        // 否则使用视图
        return view('pages.permission_denied');
        // return view('sweepchecks.create');
    }
}
