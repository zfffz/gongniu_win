<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
// use App\Models\TransVouch;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\updateSweepOut;

class TransVouchsController extends CommonsController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(1);

 if (! Auth::user()->can('transvouch_users')) {
     return view('admins.pages.permission_denied');
  
        }

        $cars= Car::all();
          $drivers = DB::table('bs_gn_wl')
            ->select('cpersoncode as id','cpersonname as name')
            ->where('wlcode','=','04')
            ->get();
          $warehouses =  DB::select("select cwhcode as id,cwhname as name from warehouse where dwhenddate is NULL");
            // $warehouses =DB::table('warehouse')
            // ->select('cwhcode as id','cwhname as name')
            // ->where('dwhenddate','is','NULL')
            // ->get();
        return view('admins.transVouch.index',compact('cars','drivers','warehouses'));
         // return view('admins.transVouch.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if (! Auth::user()->can('transvouch_users')) {
     return view('admins.pages.permission_denied');
  
        }
        // $cars = Car::all('id','no');
        // $drivers = Driver::all('id','name');
        // return view('wayBills.create',compact('cars','drivers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //     if (! Auth::user()->can('waybills_users')) {
     // return view('admins.pages.permission_denied');
  
     //    }
        
        // dd($request);
        $sweepcars_id = json_decode(json_encode($request->sweep_cars), true);

        $valstr = $this->checkRepeat($request);
        $valobj = json_decode($valstr);
        //dd($valobj);
        if($valobj->status == 1){
            return $valstr;
        }

        $strcsc = $this->checkCsc($request);
        $objcsc = json_decode($strcsc);
        //dd($valobj);
        if($objcsc->status == 1){
            return $strcsc;
        }
        $str_id = "";
        $count = count($sweepcars_id);
        if (count($sweepcars_id)>0) { 
            for($i=0;$i<$count;$i++){
                if ($str_id == "") {
                    $str_id = $sweepcars_id[$i];
                }else{
                    $str_id = $str_id.'-'.$sweepcars_id[$i];
                }
            }
        }  
        
        // dd($str_id); 
        $uname = $request->user()->name;

        $sqlvalue =  DB::select("exec z_qt_fhysd ?,?,?",
            [$str_id,$uname,'']);
        //DB::select("exec z_qt_fhysd('".$str_id."','".$uname."')");
        // $v=(array) sqlvalue[0];
         // dd($sqlvalue[0]->billno);
       // $V=count($sqlvalue);
        // dd($V);
        if(count($sqlvalue)>0){
             $revalue = json_encode(array('status'=>0,'text'=>$sqlvalue[0]->billno,'title'=>'发运单创建成功！'));       
        }else{
            $revalue = json_encode(array('status'=>1,'text'=>$sqlvalue[0]->billno,'title'=>'发运单创建未成功！'));  
        }

        //dd($revalue);
        return $revalue;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         if (! Auth::user()->can('transvouch_users')) {
     return view('admins.pages.permission_denied');
  
        }
        // $sweepCar = SweepCar::find($id);

        // return view('sweepCars.show',compact('sweepCar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (! Auth::user()->can('transvouch_users')) {
     return view('admins.pages.permission_denied');
  
        }
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         if (! Auth::user()->can('transvouch_users')) {
     return view('admins.pages.permission_denied');
  
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SweepCar $sweepCar)
    {
         if (! Auth::user()->can('transvouch_users')) {
     return view('admins.pages.permission_denied');
  
        }
        // $sweep_out_items=\DB::transaction(function() use ($sweepCar){
        //     // 更新打包发货单装车次数
        //     DB::table('zzz_sweep_out_items as t1')
        //         ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
        //         ->where('t2.parent_id','=',$sweepCar->id)
        //         ->decrement('t1.car_count');
        //     // 更新打包发货单状态
        //     DB::table('zzz_sweep_out_items as t1')
        //         ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
        //         ->where('t2.parent_id','=',$sweepCar->id)
        //         ->where('t1.car_count','=',0)
        //         ->update(['t1.status'=>0]);

        //     // 关联的打包发货单明细更新状态为0
        //     if(env('APP_ENV') == 'local'){
        //         DB::select("call zzz_proc_sweepOut_update($sweepCar->id)");
        //     }else{
        //         DB::select("exec zzz_proc_sweepOut_update($sweepCar->id)");
        //     }

        //     $sweepCar->delete();
        // });

        // // 把之前的 redirect 改成返回空数组
        // return [];
    }

    public function dispatch_data(Request $request){
         if (! Auth::user()->can('transvouch_users')) {
     return view('admins.pages.permission_denied');
  
        }
        // $dispatch_no = $request->dispatch_no;
        // $data = DB:: table('zzz_sweep_out_items as t1')
        //     ->select('t1.dispatch_no')
        //     ->where('t1.dispatch_no','=',$dispatch_no)->get();

        // echo json_encode($data);

    }


    public function getData(Request $request)
    {
         if (! Auth::user()->can('transvouch_users')) {
     return view('admins.pages.permission_denied');
  
        }

        $builder = \DB::table('zzz_sweep_cars as t1')
            ->select(
                \DB::raw("
            t1.id,
            t1.no,
            t3.no as car_name,
            t4.cpersonname as drive_name,
            CONVERT(VARCHAR(10),t1.created_at,120) as c_date, 
            CONVERT(VARCHAR(10),t1.created_at,108) as c_time,
            case t1.status when 0 then '未生成' when 1 then '已生成' end as status 
            "))
            ->leftJoin('zzz_cars as t3','t1.car_id','t3.id')
            ->leftJoin('person as t4','t1.driver_id','t4.cpersoncode');

        $data=parent::dataPage($request,$this->condition($builder,$request),'asc');

        return $data;

    }

    private function condition($table,$searchKey){

        $bedate = explode(" - ",$searchKey->dateKey);
        $bgdate = $bedate[0];
        $eddate = date("Y-m-d",strtotime("+1day",strtotime($bedate[1])));
        //dd($searchKey);
        if($searchKey!=''){
            // if ($searchKey->caridKey!=null || $searchKey->caridKey!=''){
                $table->where('t1.created_at','>=',$bgdate);
                $table->where('t1.created_at','<',$eddate);
                $table->where('t4.cpersoncode','=',$searchKey->driveridKey);
                $table->where('t1.status','=',$searchKey->statusKey); 
            // }
            // else{
            //     $table->where('t1.created_at','>=',$bgdate);
            //     $table->where('t1.created_at','<',$eddate);
            //     $table->where('t1.status','=',$searchKey->statusKey); 
            // }


        }
       
        return $table;
    }

    public function getTransVouch(Request $request){
        $dispatch_no = $request->dispatch_no;    
        $builder = \DB::table('zzz_sweep_car_items as t1')->select(\DB::raw("
            dispatch_no,
            isnull(transportno,'') transportno
            "))
        ->where('t1.parent_id','=',$dispatch_no)->get();

        //return $builder;
        return json_encode($builder);
    }

    //检查是否已生成过单据
    public function checkRepeat(Request $request){

        $sweepcars_id = json_decode(json_encode($request->sweep_cars), true);
        //$sweepcars_id[] = array($request->sweep_cars);
        $sweepcars = \DB::table('zzz_sweep_cars as t1')
        ->select('no','status')
        ->wherein('t1.id',$sweepcars_id)
        ->where('t1.status','=','1')
        ->get();

        $str_no = "";
        $con = 0;
        $count = count($sweepcars);
        if (count($sweepcars)>0) { 
             $con = 1;
            for($i=0;$i<$count;$i++){
                if ($str_no == "") {
                    $str_no = $sweepcars[$i]->no;
                }else{
                    $str_no = $str_no.'--'.$sweepcars[$i]->no;
                }
            }
        }
        return json_encode(array('status'=>$con,'text'=>$str_no,'title'=>'存在已生成单据，重新选择！'));
    }

    //检查单据发运方式是否一致
    public function checkCsc(Request $request){

        $sweepcars_id = json_decode(json_encode($request->sweep_cars), true);
        //$sweepcars_id[] = array($request->sweep_cars);
        $caritems = \DB::table('zzz_sweep_car_items')
                   ->select('dispatch_no')
                   ->wherein('parent_id',$sweepcars_id);

        $dispatch_csc = DB::table('Sales_FHD_T as a')
        ->joinSub($caritems, 'b', function ($join) {
            $join->on('a.cdlcode','=','b.dispatch_no');
        })
        ->select('a.csccode','a.cscname')
        ->groupBy('a.csccode','a.cscname')
        ->get();

        // $dispatch_csc = \DB::table('Sales_FHD_T as a')
        // ->Join( \DB::table('zzz_sweep_car_items as b')
        //         ->select('b.dispatch_no')
        //         ->wherein('b.parent_id',$sweepcars_id),
        // 'a.cdlcode','=','b.dispatch_no')
        // ->select('a.csccode','a.cscname')
        // ->groupBy('a.csccode','a.cscname')
        // ->get();




        $str_csc = "";
        $count = count($dispatch_csc);
        $con = 0;
        if (count($dispatch_csc)>1) { 
            $con = 1;
            for($i=0;$i<$count;$i++){
                if ($str_csc == "") {
                    $str_csc = $dispatch_csc[$i]->cscname;
                }else{
                    $str_csc = $str_csc.'--'.$dispatch_csc[$i]->cscname;
                }
            }
        }
        return json_encode(array('status'=>$con,'text'=>$str_csc,'title'=>'单据存在不同发运类型！'));
    }

}



