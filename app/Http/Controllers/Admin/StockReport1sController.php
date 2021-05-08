<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
use Illuminate\Http\Request;
// use App\Models\CustomerLocation;
// use App\Models\Storage_location;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockReport1sController extends CommonsController
{

    public function index()
    {

 if (! Auth::user()->can('dispatchreports_users')) {
            return view('admins.pages.permission_denied');
        }

// $drivers = DB::table('bs_gn_wl')
//             ->select('cpersoncode as id','cpersonname as name')
//             ->where('wlcode','=','04')
//             ->get();
//             dd($drivers);
//              $inventory = DB::table('inventory')
//            ->select('cinvcode as cinvcode','cinvname as cinvname')
//
//            ->get();
//
// dd($inventory);
        // $storage_locations = Storage_location::all();

        return view('admins.stockReport1s.index');
    }

      public function getInventoryData(Request $request){

        $builder = \DB::table('inventory as t1')
            ->select(
                \DB::raw("
            t1.cinvcode as id,
            t1.cinvname as text
            "));

        $code = $request->code;
        if($code!=''){
            $builder->where('t1.cinvcode','like','%'.$code.'%');
            $builder->orWhere('t1.cinvname','like','%'.$code.'%');
        }

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');

        $total = $builder->count();
        $list = $builder->orderBy('cinvcode', 'asc')->offset($start)->take($length)->get()->toArray();
        $data = [];
        $data["draw"] = $draw;
        $data["recordsTotal"] = $total;
        $data["recordsFiltered"] = $total;
        $data["data"] = $list;
        return response()->json($data);

    }

 public function getData(Request $request)
    {
        $builder = \DB::table('zzz_CurrentStock as t1')
            ->select(
                \DB::raw("
            t1.cinvcode,
            t1.cinvname,
            t1.location_no,
            t1.location_name,
             rtrim(Convert(decimal(30,2),t1.iquantity)) as iquantity
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
        $table->where('t1.iquantity','>','0');
        if($searchKey!=''){
            $table->where('t1.cinvcode','like','%'.$searchKey.'%');
            $table->orWhere('t1.location_no','like','%'.$searchKey.'%');
        }
        return $table;
    }
}
