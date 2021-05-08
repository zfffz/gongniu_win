<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StockReportsController extends CommonsController
{
  
    public function index()
    {
      
 if (! Auth::user()->can('dispatchreports_users')) {
            return view('admins.pages.permission_denied');
        }
      
        return view('admins.stockReports.index');
    }

 public function getData(Request $request)
    {
        $builder = \DB::table('zzz_kwkc as t1')
            ->select(
                \DB::raw("
            t1.source,
            t1.cdlcode,
            t1.location_no,
            t1.cinvcode,
            t1.cinvname,
             rtrim(Convert(decimal(30,2),t1.iquantity)) as iquantity,
            t1.time
            "));
            // ->leftJoin('zzz_sweep_out_items as t2','t1.id','t2.parent_id')
            // ->leftJoin('zzz_sweep_car_items as t3','t2.dispatch_no','t3.dispatch_no')
            // ->leftJoin('zzz_sweep_cars as t4','t3.parent_id','t4.id')
            // ->leftJoin('bs_gn_wl as t5','t1.packager_no','t5.cpersoncode')
            // ->leftJoin('zzz_cars as t6','t4.car_id','t6.id')
            // ->leftJoin('zzz_drivers as t7','t4.driver_id','t7.id');

        $data=parent::dataPage6($request,$this->condition($builder,$request->searchKey),'asc');

        return $data;
    }


     private function condition($table,$searchKey){
        if($searchKey!=''){
            $table->where('t1.cdlcode','like','%'.$searchKey.'%');
            $table->orWhere('t1.location_no','like','%'.$searchKey.'%');
        }
        return $table;
    }
}
