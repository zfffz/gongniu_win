<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


use App\Http\Controllers\CommonsController;

class PagesController extends CommonsController
{
  public function root()
    {
         $CHECK= DB::select('SELECT COUNT(ID) AS count FROM zzz_sweep_checks  where created_at>=convert(varchar(10),Getdate(),120) and created_at<convert(varchar(10),dateadd(d,1,Getdate()),120)  ');
         // $OUT= DB::select('SELECT count(no) as count FROM zzz_sweep_outs  where created_at>=convert(varchar(10),Getdate(),120) and created_at<convert(varchar(10),dateadd(d,1,Getdate()),120)  ');
         $OUT= DB::select('SELECT count(parent_id) as count FROM zzz_sweep_cars b left join zzz_sweep_car_items z on b.id=z.parent_id  where created_at>=convert(varchar(10),Getdate(),120) and created_at<convert(varchar(10),dateadd(d,1,Getdate()),120)  ');
         $CAR= DB::select('SELECT COUNT(ID) AS count FROM zzz_sweep_cars  where created_at>=convert(varchar(10),Getdate(),120) and created_at<convert(varchar(10),dateadd(d,1,Getdate()),120)  ');
          $transport= DB::select('SELECT COUNT(ID) AS count FROM hy_eo_transport  where billdate>=convert(varchar(10),Getdate(),120) and billdate<convert(varchar(10),dateadd(d,1,Getdate()),120)  ');

         $CHECKM= DB::select('select COUNT(ID) AS count from zzz_sweep_checks 
             where DATEPART(mm, created_at) = DATEPART(mm, GETDATE()) and DATEPART(yy, created_at) = DATEPART(yy, GETDATE())  ');
         // $OUTM= DB::select('select COUNT(no) AS count from zzz_sweep_outs
         //   where DATEPART(mm, created_at) = DATEPART(mm, GETDATE()) and DATEPART(yy, created_at) = DATEPART(yy, GETDATE())  ');
         $OUTM= DB::select('SELECT count(parent_id) as count FROM zzz_sweep_cars b left join zzz_sweep_car_items z on b.id=z.parent_id
           where DATEPART(mm, created_at) = DATEPART(mm, GETDATE()) and DATEPART(yy, created_at) = DATEPART(yy, GETDATE())  ');
         $CARM= DB::select('select COUNT(ID) AS count from zzz_sweep_cars 
             where DATEPART(mm, created_at) = DATEPART(mm, GETDATE()) and DATEPART(yy, created_at) = DATEPART(yy, GETDATE())  ');
         $transportM= DB::select('select COUNT(ID) AS count from hy_eo_transport  where DATEPART(mm, billdate) = DATEPART(mm, GETDATE()) and DATEPART(yy, billdate) = DATEPART(yy, GETDATE())  ');


         return view('admins.pages.root',compact('OUT','CHECK','CAR','CHECKM','OUTM','CARM','transport','transportM'));
    }

    public function permissionDenied()
    {

        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
           
            return redirect(url(config('administrator.uri')), 302);
        }

        // 否则使用视图
        return view('admins.pages.permission_denied');
        // return view('sweepchecks.create');
    }
}
