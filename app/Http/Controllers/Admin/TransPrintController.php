<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
//use App\Models\WayPrint;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use App\Jobs\updateSweepOut;

class WayPrintController extends CommonsController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if (! Auth::user()->can('transvouch_users')) {
     return view('admins.pages.permission_denied');
  
        }
$drivers = DB::table('bs_gn_wl')
            ->select('cpersoncode as id','cpersonname as name')
            ->where('wlcode','=','04')
            ->get();
        // $drivers= Driver::all();
        return view('admins.wayPrint.index',compact('drivers'));
    }

    public function getData(Request $request)
    {

        $builder = \DB::table('hy_eo_transport as t1')
            ->select(
                \DB::raw("
			t1.id,t1.ccode, t1.cdriver,t1.ccusadd,t1.cmaker,
            CONVERT(VARCHAR(10),t1.billdate,120) as billdate, 
            isnull(t1.iPrintCount,'') as iPrintCount 
            "));

        $data=parent::dataPage($request,$this->condition($builder,$request),'asc');

        return $data;
    }

    public function getPrint($id)
    {

         if (! Auth::user()->can('transvouch_users')) {
     return view('admins.pages.permission_denied');
  
        }

        $head = \DB::table('hy_eo_transport as a')
            ->select(
                \DB::raw("
			a.ccode,convert(varchar(10),a.billdate,120) as billdate,a.cdriver,b.cSCName 
            "))
			->Join('ShippingChoice as b','a.csccode','b.cSCCode')
			->where('a.id','=',$id)->get();
			;
        $body = \DB::table('hy_eo_transport as t1')
            ->select(
                \DB::raw("
			ROW_NUMBER() OVER(ORDER BY t2.csocode) ROWNU,t2.csocode,t3.ddate,t3.csocode as csdcode,t3.cshipaddress,t3.ccuscode,t3.ccusabbname,t5.cSSName, sum(t2.cdefine27) as amount,''as bz
            "))
			->Join('hy_eo_transports as t2', 't1.id','t2.id')
			->Join('Sales_FHD_H as t3' ,'t3.cdlcode' , 't2.csocode')
			->Join('Sales_FHD_T as t4' , 't4.dlid' , 't3.dlid')
			->leftJoin('SettleStyle as t5' , 't5.cSSCode' , 't4.csscode')
			->where('t1.id','=',$id)
			->groupBy('t2.csocode','t3.ddate','t3.csocode','t3.ccuscode','t3.ccusabbname','t5.cSSName','t3.cshipaddress')
			->get();
        $data[0] = $head[0];
        $count = count($body);
        if ($count>0) { 
            for($i=0;$i<$count;$i++){
            	$data[1][$i] = $body[$i];
            }
        }
        return view('admins.wayPrint.print',compact('data'));
    }

    private function condition($table,$searchKey){

        $bedate = explode(" - ",$searchKey->dateKey);
        $bgdate = $bedate[0];
        $eddate = date("Y-m-d",strtotime("+1day",strtotime($bedate[1])));
        //dd($searchKey);
        if($searchKey!=''){
            if ($searchKey->driverKey!=null || $searchKey->driverKey!=''){
                $table->where('t1.billdate','>=',$bgdate);
                $table->where('t1.billdate','<',$eddate);
                $table->where('t1.cdriver','=',$searchKey->driverKey); 
            }
            else{
                $table->where('t1.billdate','>=',$bgdate);
                // $table->where('t1.billdate','<',$eddate);
                $table->where('t1.billdate','<',$eddate);
            }


        }
       
        return $table;
    }
}
