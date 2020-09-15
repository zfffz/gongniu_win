<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DispatchReportsController extends CommonsController
{
    public function index()
    {
        return view('admins.dispatchReports.index');
    }
   

    public function getData(Request $request)
    {
        $builder = \DB::table('zzz_sweep_outs as t1')
            ->select(
                \DB::raw("
            t1.id,
            t2.dispatch_no,
            t2.default_location_no as location_no,
            t5.cpersonname as packager_name,
            t6.no as car_no,
            t7.name as driver_name,
            t1.created_at as out_created_at,
            t4.created_at as car_created_at
            "))
            ->leftJoin('zzz_sweep_out_items as t2','t1.id','t2.parent_id')
            ->leftJoin('zzz_sweep_car_items as t3','t2.dispatch_no','t3.dispatch_no')
            ->leftJoin('zzz_sweep_cars as t4','t3.parent_id','t4.id')
            ->leftJoin('bs_gn_wl as t5','t1.packager_no','t5.cpersoncode')
            ->leftJoin('zzz_cars as t6','t4.car_id','t6.id')
            ->leftJoin('zzz_drivers as t7','t4.driver_id','t7.id');

        $data=parent::dataPage($request,$this->condition($builder,$request->searchKey),'asc');

        return $data;
    }

    private function condition($table,$searchKey){
        if($searchKey!=''){
            $table->where('t2.cpersonname','like','%'.$searchKey.'%');
            $table->orWhere('t1.created_at','like','%'.$searchKey.'%');
        }
        return $table;
    }

     private function condition1($table,$searchKey){
        if($searchKey!=''){
            $table->where('t1.cdlcode','like','%'.$searchKey.'%');
            $table->orWhere('t1.location_no','like','%'.$searchKey.'%');
        }
        return $table;
    }
}
