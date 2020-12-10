<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Sweep_car_item;
use App\Models\Sweep_out_item;
use App\Models\SweepCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\updateSweepOut;
// use App\Exports\UsersExport;
// use Maatwebsite\Excel\Facades\Excel;

// class UsersController extends Controller 
// {

// }




class SweepCarsController extends CommonsController
{

    // public function export() 
    // {
    //     return Excel::download(new UsersExport, 'users.xlsx');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if (! Auth::user()->can('sweepcars_users')) {
     return view('admins.pages.permission_denied');
  
        }

        return view('sweepCars.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if (! Auth::user()->can('sweepcars_users')) {
     return view('admins.pages.permission_denied');
  
        }
        $cars = Car::all('id','no');
        $drivers = DB::table('bs_gn_wl')
            ->select('cpersoncode as id','cpersonname as name')
            ->where('wlcode','=','04')
            ->get();
              
        // $drivers = Driver::all('id','name');
        return view('sweepCars.create',compact('cars','drivers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         if (! Auth::user()->can('sweepcars_users')) {
     return view('admins.pages.permission_denied');
  
        }
        $sweep_car=\DB::transaction(function() use ($request){
            //创建一张新的扫码上车单
            $sweep_car = new SweepCar([
                'car_id'=>$request->input('car_id'),
                'driver_id'=>$request->input('driver_id'),
                'user_no'=>Auth::id()
            ]);
            $sweep_car->save();

            //创建一张新的项目清单
            $sweep_car_items = $request->input('items');
            $i=1;

            foreach($sweep_car_items as $data){
                // 生成装车明细
                $sweep_car_item = $sweep_car->sweep_car_items()->make([
                    'entry_id'=>$i,
                    'dispatch_no'=> $data['dispatch_no']
                ]);
                $sweep_car_item->save();

                // 更新发货单状态（是否装车）
                Sweep_out_item::where('dispatch_no','=',$data['dispatch_no'])->update(['status' => 1]);

                // 更新发货单装车次数
                Sweep_out_item::where('dispatch_no','=',$data['dispatch_no'])->increment('car_count');

               //插库存记录
                 // $res1 = DB::select('select location_no from [dbo].[zzz_sweep_car_items] a left join  [zzz_sweep_out_items] b  on a.dispatch_no=b.dispatch_no  LEFT JOIN [zzz_sweep_outs] C ON B.parent_id=C.id WHERE   a.dispatch_no= :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);
 $ddate = date("Y-m-d H:i:s");
                
                $res = DB::select('select cinvcode,cinvname,iquantity,s.location_no from DispatchLists P left join DispatchList Z on P.DLID=Z.DLID left join  zzz_sweep_out_items t on t.dispatch_no=z.cdlcode left join zzz_sweep_outs s on t.parent_id=s.id where Z.cDLCode = :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);
            foreach ($res as $ress) {
         DB::INSERT('insert into zzz_kwkc( source,cdlcode,location_no,cinvcode,cinvname,iquantity,time)VALUES(?,?,?,?,?,?,?)',["扫码上车", $data['dispatch_no'],$ress->location_no,$ress->cinvcode,$ress->cinvname,$ress->iquantity, $ddate]);
        }

                //记录装车人和装车时间

  // $dated=date('Y-m-d H:i:s',time());
   DB::insert('insert into  BS_GN_wlstate (cpersoncode,cdlcode,zc,ddate) values (?,?,?,?)', [$request->input('driver_id'),$data['dispatch_no'],'装车',$ddate]);


                // $result1 = DB::select('select cpersonname as name from BS_GN_WL  where cpersoncode = ?', [$request->input('driver_id')]);  //抓取司机名字
                // DB::update('update DispatchList set cDefine14=? where cdlcode=?', [$result1[0]->name, $data['dispatch_no']]);

               
                // $result2 = DB::select('select DLID from Dispatchlist  where cdlcode = ?', [$data['dispatch_no']]);  //获取发货单对应的DLID
                // DB::update('update dispatchlist_extradefine set chdefine6=convert(varchar(100),?,120) where DLID=?', [$ddate, $result2[0]->DLID]);

                //查看发货单对应的打包单是否全部装车，更新打包单状态
                $result3 = DB::SELECT('SELECT parent_id from zzz_sweep_out_items where dispatch_no = ?', [$data['dispatch_no']]);  //获取打包单的id
                $result4 = DB::select('select count(*) as wzcnum from zzz_sweep_out_items where status=0 and parent_id = ?', [$result3[0]->parent_id]); //查询该打包单未生成装车单的发货单数
                if ($result4[0]->wzcnum > 0) {
                    //部分装车
                    DB::update('update zzz_sweep_outs set status=1 where id=?', [$result3[0]->parent_id]);
                } else {
                    //全部装车
                    DB::update('update zzz_sweep_outs set status=2 where id=?', [$result3[0]->parent_id]);
                }

                $i++;
            }

            // 更新
            $sweep_car->update(['count' => ($i-1)]);

            return $sweep_car;
        });

        // $this->dispatch(new updateSweepOut($sweep_car->id, config('app.sweepOut_ttl')));

        return $sweep_car;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         if (! Auth::user()->can('sweepcars_users')) {
     return view('admins.pages.permission_denied');
  
        }
        $sweepCar = SweepCar::find($id);

        return view('sweepCars.show',compact('sweepCar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (! Auth::user()->can('sweepcars_users')) {
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
         if (! Auth::user()->can('sweepcars_users')) {
     return view('admins.pages.permission_denied');
  
        }
        //
    }

    public function delete(Request $request, $id)
    {

         if (! Auth::user()->can('sweepcars_users')) {
     return view('admins.pages.permission_denied');
        };
     $searchKey = $request->input('searchKey');

$result6= DB::select("select t1.status as status from zzz_sweep_car_items as t2 inner join zzz_sweep_cars as t1  ON t1.id = t2.parent_id where t2.dispatch_no=?",[$searchKey]);
// dd($result6[0]->status);
if($result6[0]->status ==1){
                echo json_encode(array('status'=>0,'text'=>'已经生成发运单，不允许删除！'));
                exit();
            };
//明细最后一张不让删
         $result7 = DB::select(" select parent_id FROM zzz_sweep_car_items where dispatch_no=?",[$searchKey]);

 $result8 = DB::select(" select count(id) as count from zzz_sweep_car_items where parent_id=?",[$result7[0]->parent_id]);
 if($result8[0]->count ==1){
 echo json_encode(array('status'=>0,'text'=>'明细只有一行，请整单删除！'));
                exit();

 }
// $data= DB::select("select flag,dispatch_no from zzz_sweep_checks where id=?",[$id])

        // 更新打包发货单装车次数
            $delete3 = DB::table('zzz_sweep_out_items as t1')
                ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
                ->where('t2.dispatch_no','=',$searchKey)
                ->decrement('t1.car_count');
            // 更新打包发货单状态
           $delete4 = DB::table('zzz_sweep_out_items as t1')
                ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
                ->where('t2.dispatch_no','=',$searchKey)
                ->where('t1.car_count','=',0)
                ->update(['t1.status'=>0]);

         
// dd($searchKey);

      

          
    // dd($searchKey);
                 //更新打包出库单表头状态
            $result3 = DB::select('select t1.parent_id as parent_id from zzz_sweep_out_items as t1 left join zzz_sweep_car_items as t2 on t1.dispatch_no = t2.dispatch_no where t2.dispatch_no = ?', [$searchKey]); 
            // dd($result3[0]->parent_id);
            // // //获取打包单主表的id
            $result4 = DB::select('select count(*) as zcnum from zzz_sweep_out_items where status<>0 and parent_id = ?', [$result3[0]->parent_id]); 
             
           // 查询该打包单生成装车单的发货单数

           
            if ($result4[0]->zcnum > 0) {
                //部分装车
               $delete5 = DB::update('update zzz_sweep_outs set status=1 where id=?', [$result3[0]->parent_id]);
            } else {
                //全部未装车
              $delete6 = DB::update('update zzz_sweep_outs set status=0 where id=?', [$result3[0]->parent_id]);
            };
               
   

            //清空U8装车人和装车时间
$delete1 = DB::update("update dispatchlist set cDefine14='' where cdlcode=?", [$searchKey]);
            // DB::table('dispatchlist as t1')
            //     // ->join('zzz_sweep_car_items as t2','t1.cDLCode','=','t2.dispatch_no')
            //     ->where('t1.cDLCode','=',$searchKey)
            //     ->update(['t1.cDefine14'=>'']);

        $delete2 = DB::table('dispatchlist_extradefine as t1')
                ->join('dispatchlist as t2','t1.DLID','=','t2.DLID')
                // ->join('zzz_sweep_car_items as t3','t2.cDLCode','=','t3.dispatch_no')
                ->where('t2.cDLCode','=',$searchKey)
                ->update(['t1.chdefine10'=>'']);
                 //删除记录
                    $deleteds1 = DB::delete("delete from BS_GN_wlstate where zc='装车'  and cdlcode=?",[$searchKey]);
                    //删除装车记录
  $delete = DB::delete("delete from zzz_sweep_car_items where dispatch_no=?",[$searchKey]);
           return [];
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SweepCar $sweepCar,Sweep_car_item $Sweep_car_item)
    {
         if (! Auth::user()->can('sweepcars_users')) {
     return view('admins.pages.permission_denied');
  
        }
        $sweep_out_items=\DB::transaction(function() use ($sweepCar){

            // 删除之前判断是否已经在U8生成发货运输单
            if($sweepCar->status ==1){
                echo json_encode(array('status'=>0,'text'=>'已经生成发运单，不允许删除！'));
                exit();
            }
            // dd($sweepCar->status);
            // 更新打包发货单装车次数
            DB::table('zzz_sweep_out_items as t1')
                ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
                ->where('t2.parent_id','=',$sweepCar->id)
                ->decrement('t1.car_count');
            // 更新打包发货单状态
            DB::table('zzz_sweep_out_items as t1')
                ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
                ->where('t2.parent_id','=',$sweepCar->id)
                ->where('t1.car_count','=',0)
                ->update(['t1.status'=>0]);
                 // 更新打包出库单表头状态
            $result3 = DB::SELECT('SELECT t1.parent_id as parent_id from zzz_sweep_out_items as t1 LEFT join zzz_sweep_car_items as t2 ON t1.dispatch_no = t2.dispatch_no where t2.parent_id = ?', [$sweepCar->id]);  //获取打包单主表的id
            $result4 = DB::select('select count(*) as zcnum from zzz_sweep_out_items where status<>0 and parent_id = ?', [$result3[0]->parent_id]); //查询该打包单生成装车单的发货单数
            if ($result4[0]->zcnum > 0) {
                //部分装车
                DB::update('update zzz_sweep_outs set status=1 where id=?', [$result3[0]->parent_id]);
            } else {
                //全部未装车
                DB::update('update zzz_sweep_outs set status=0 where id=?', [$result3[0]->parent_id]);
            }


            //清空U8装车人和装车时间
            DB::table('dispatchlist as t1')
                ->join('zzz_sweep_car_items as t2','t1.cDLCode','=','t2.dispatch_no')
                ->where('t2.parent_id','=',$sweepCar->id)
                ->update(['t1.cDefine14'=>'']);

            DB::table('dispatchlist_extradefine as t1')
                ->join('dispatchlist as t2','t1.DLID','=','t2.DLID')
                ->join('zzz_sweep_car_items as t3','t2.cDLCode','=','t3.dispatch_no')
                ->where('t3.parent_id','=',$sweepCar->id)
                ->update(['t1.chdefine10'=>'']);
                //删除记录
      $jg2 =  DB::SELECT("select dispatch_no from zzz_sweep_car_items where parent_id=?",[$sweepCar->id]);
                foreach ( $jg2 as $Sweep_car_items) {


                    $deleteds1 = DB::delete("delete from BS_GN_wlstate where zc='装车'  and cdlcode=?",[$Sweep_car_items->dispatch_no]);
};
                // $deleteds1 = DB::delete("delete from BS_GN_wlstate where cdlcode=(select dispatch_no from zzz_sweep_car_items where  zc='装车' and parent_id=?)",[$sweepCar->id]);

                // $deleteds1 = DB::delete("delete from BS_GN_wlstate where cdlcode=? and zc='装车'",[$data[0]->dispatch_no]);

            // 关联的打包发货单明细更新状态为0
            // if(env('APP_ENV') == 'local'){
            //     DB::select("call zzz_proc_sweepOut_update($sweepCar->id)");
            // }else{
            //     DB::select("exec zzz_proc_sweepOut_update($sweepCar->id)");
            // }

            $sweepCar->delete();
        });

        // 把之前的 redirect 改成返回空数组
        return [];
    }

    public function dispatch_data(Request $request){
        $dispatch_no = $request->dispatch_no;
        $data = DB:: table('zzz_sweep_out_items as t1')
            ->select('t1.dispatch_no')
            ->where('t1.dispatch_no','=',$dispatch_no)->get();

        echo json_encode($data);

    }

    //检查口令是否正确
    public function checkPass(Request $request){
        $password = $request->password;
        if($password == '123456'){
            echo json_encode(array('status'=>'success'));
        }else{
            echo json_encode(array('status'=>'error'));
        }

    }



    //判断发货单是否已经生成过装车单,不允许重复生单
    public function checkCdlcode(Request $request){
        $cdlcode = $request->dispatch_no;
        $query = DB:: table('zzz_sweep_car_items as t1')
            ->where('t1.dispatch_no','=',$cdlcode)
            ->count();
        if($query !== 0 ){
            //这张发货单已经生成过装车单
            echo json_encode(array('status'=>0,'text'=>'已经生成装车单了，不允许重复生单！'));
        }else{
            echo json_encode(array('status'=>1,'text'=>'success！'));
        }
    }


    public function getData(Request $request)
    {
        $builder = \DB::table('zzz_sweep_cars as t1')
            ->select(
                \DB::raw("
            t1.id,
            t1.no,
            t2.no as car_no,
            t3.cpersonname as driver_name,
            t1.count,
            t1.created_at
            "))
            ->leftJoin('zzz_cars as t2','t1.car_id','t2.id')
            ->leftJoin('person as t3','t1.driver_id','t3.cpersoncode');


            // $drivers = DB::table('bs_gn_wl')
            // ->select('cpersoncode as id','cpersonname as name')
            // ->where('wlcode','=','04')
            // ->get();

        $data=parent::dataPage($request,$this->condition($builder,$request->searchKey),'asc');

        return $data;
    }

    private function condition($table,$searchKey){
        if($searchKey!=''){
            $table->where('t2.no','like','%'.$searchKey.'%');
            $table->where('t3.name','like','%'.$searchKey.'%');
            $table->orWhere('t1.created_at','like','%'.$searchKey.'%');
        }
        return $table;
    }

}
