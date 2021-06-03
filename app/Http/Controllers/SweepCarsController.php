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
          // dd(1);

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
                       $dis=(substr($data['dispatch_no'],0,4));

          if ($dis=='CKDB') {
   
 $CHECK1 = DB::select('select cOWhCode from  transvouch Z  where Z.cTVCode = :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);

$data1[$i] = $CHECK1[0]->cOWhCode;
}

$i++;
}
 $dis=(substr($data['dispatch_no'],0,4));

          if ($dis=='CKDB') {
                if (count(array_unique($data1))>1) {  

     echo json_encode(array('status'=>0,'text'=>'不同转出仓库的调拨单不能做一张装车单！'));
exit();
}
}
     

$i=1;

            foreach($sweep_car_items as $data){



                // 生成装车明细
                $sweep_car_item = $sweep_car->sweep_car_items()->make([
                    'entry_id'=>$i,
                    'dispatch_no'=> $data['dispatch_no']
                ]);
                $sweep_car_item->save();
 $dis=(substr($data['dispatch_no'],0,4));

          if ($dis=='CKDB') {
               
                 $CHECK1 = DB::select('select cOWhCode from  transvouch Z  where Z.cTVCode = :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);
   
    DB::update("update A set A.cowhcode=? FROM zzz_sweep_cars A LEFT JOIN zzz_sweep_car_items B on A.id=B.parent_id where B.dispatch_no =? ",[$CHECK1[0]->cOWhCode,$data['dispatch_no']]);
}
                // 更新发货单状态（是否装车）
                Sweep_out_item::where('dispatch_no','=',$data['dispatch_no'])->update(['status' => 1]);

                // 更新发货单装车次数
                Sweep_out_item::where('dispatch_no','=',$data['dispatch_no'])->increment('car_count');

               //插库存记录
                 // $res1 = DB::select('select location_no from [dbo].[zzz_sweep_car_items] a left join  [zzz_sweep_out_items] b  on a.dispatch_no=b.dispatch_no  LEFT JOIN [zzz_sweep_outs] C ON B.parent_id=C.id WHERE   a.dispatch_no= :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);
 $ddate = date("Y-m-d H:i:s");
   $dis=(substr($data['dispatch_no'],0,4));

          if ($dis=='XSFH') {
 
                
                $res = DB::select('select cinvcode,cinvname,iquantity,s.location_no from DispatchLists P left join DispatchList Z on P.DLID=Z.DLID left join  zzz_sweep_out_items t on t.dispatch_no=z.cdlcode left join zzz_sweep_outs s on t.parent_id=s.id where Z.cDLCode = :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);


 //                $cVerifier= 'auser';
 // //更新发货单审核信息（审核人、变更人、审核日期、审核时间）
 //                $date= date("Y-m-d H:i:s");
 //                DB::update("update dispatchlist set cVerifier= ?,cChanger=NULL,dverifydate=case when ddate>? then ddate else ? end ,dverifysystime=getdate() where cDLCode =?",[$cVerifier,$date,$date,$data['dispatch_no']]);

 //                //生成销售出库单和更改库存
 //                DB::Update("exec zzz_CCGC32 ?",[$data['dispatch_no']]);

            }
               else if ($dis=='CKDB')
               {
  $res = DB::select('select P.cinvcode,I.cinvname,P.iTVQuantity as iquantity,s.location_no from TransVouchs P left join transvouch Z on P.ID=Z.ID left join inventory I on I.cInvCode=P.cInvCode   left join  zzz_sweep_out_items t on t.dispatch_no=z.cTVCode left join zzz_sweep_outs s on t.parent_id=s.id where Z.cTVCode = :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);


  

 

                  }
            foreach ($res as $ress) {

//没有打包单据，此处为第二处修改
// $location_no = DB::select(" select b.location_no from zzz_sweep_outs b left join zzz_sweep_out_items a on a.parent_id=b.id where dispatch_no=?",[$data['dispatch_no']]);

//   $iquay=DB::select("select cinvcode,cinvname,iquantity from zzz_CurrentStock where cinvcode =? and location_no=?",[$ress->cinvcode,$location_no[0]->location_no]);
//           // $iquay = DB::select('select cinvcode,cinvname,iquantity from zzz_CurrentStock where cinvcode =? and location_no=?',[$ress->cinvcode,$location_no]);

//           if (count($iquay)>0) {
//             $iquantity8 = ($iquay[0]->iquantity)-($ress->iquantity);     //原先的减去本次的
//             // dd($iquantity8);
//               DB::update("update zzz_CurrentStock  set iquantity=? where cinvcode =? and location_no=?",[$iquantity8,$ress->cinvcode,$location_no[0]->location_no]);
//           }
//           else
//           {

//                 return false;
          
            
             
//           }








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
   //直接修改发货单号取值为固定值，此为修改第三处
                // $result3 = DB::SELECT('SELECT parent_id from zzz_sweep_out_items where dispatch_no = ?', ['XSFH00327383']);  //获取打包单的id
                // $result4 = DB::select('select count(*) as wzcnum from zzz_sweep_out_items where status=0 and parent_id = ?', [$result3[0]->parent_id]); //查询该打包单未生成装车单的发货单数
                // if ($result4[0]->wzcnum > 0) {
                //     //部分装车
                //     DB::update('update zzz_sweep_outs set status=1 where id=?', [$result3[0]->parent_id]);
                // } else {
                //     //全部装车
                //     DB::update('update zzz_sweep_outs set status=2 where id=?', [$result3[0]->parent_id]);
                // }

                $i++;
            }
     

            // 更新
            $sweep_car->update(['count' => ($i-1)]);

          $jy1= $sweep_car->count;
 
           $result18 = DB::select('select count(parent_id) count from zzz_sweep_car_items where SUBSTRING(dispatch_no,0,5) =? and parent_id = ?',['XSFH',$sweep_car->id]);
   
       

           if ($jy1==$result18[0]->count)
            {
               
DB::update("update zzz_sweep_cars set statusd=1 where id=?",[$sweep_car->id]);

           }
          
           else
            {
                $result16 = DB::select('select count(parent_id) count from zzz_sweep_car_items where SUBSTRING(dispatch_no,0,5) =? and parent_id = ?',['CKDB',$sweep_car->id]);
                
           
 
           if ($jy1==$result16[0]->count) {
       
                DB::update('update zzz_sweep_cars set status=1 where id=?',[$sweep_car->id]);
           }
           else
            { };
};




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
// dd( $searchKey);
$result6= DB::select("select t1.status as status,t1.statusd from zzz_sweep_car_items as t2 inner join zzz_sweep_cars as t1  ON t1.id = t2.parent_id where t2.dispatch_no=?",[$searchKey]);
// dd(1);
$result16= DB::select("select isnull(transportno,0) as transportno from zzz_sweep_car_items  where dispatch_no=?",[$searchKey]);

// dd(1);
if($result16[0]->transportno <>0){
                echo json_encode(array('status'=>0,'text'=>'已经生成运单，不允许删除！'));
                exit();
            };
//明细最后一张不让删
         $result7 = DB::select(" select parent_id FROM zzz_sweep_car_items where dispatch_no=?",[$searchKey]);

 $result8 = DB::select(" select count(id) as count from zzz_sweep_car_items where parent_id=?",[$result7[0]->parent_id]);
 if($result8[0]->count ==1){
 echo json_encode(array('status'=>0,'text'=>'明细只有一行，请整单删除！'));
                exit();

 }
  $deleteds2= DB::delete("delete from zzz_kwkc where  cdlcode=? and source='扫码上车'",[$searchKey]);
// $data= DB::select("select flag,dispatch_no from zzz_sweep_checks where id=?",[$id])

        // 更新打包发货单装车次数,0508 装车不用打包 注释
           //  $delete3 = DB::table('zzz_sweep_out_items as t1')
           //      ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
           //      ->where('t2.dispatch_no','=',$searchKey)
           //      ->decrement('t1.car_count');
           //  // 更新打包发货单状态
           // $delete4 = DB::table('zzz_sweep_out_items as t1')
           //      ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
           //      ->where('t2.dispatch_no','=',$searchKey)
           //      ->where('t1.car_count','=',0)
           //      ->update(['t1.status'=>0]);

         
// dd($searchKey);

      

          

                 //更新打包出库单表头状态  0508
            // $result3 = DB::select('select t1.parent_id as parent_id from zzz_sweep_out_items as t1 left join zzz_sweep_car_items as t2 on t1.dispatch_no = t2.dispatch_no where t2.dispatch_no = ?', [$searchKey]); 
      
            // // // //获取打包单主表的id
            // $result4 = DB::select('select count(*) as zcnum from zzz_sweep_out_items where status<>0 and parent_id = ?', [$result3[0]->parent_id]); 
             
           // 查询该打包单生成装车单的发货单数

           //0508
            // if ($result4[0]->zcnum > 0) {
            //     //部分装车
            //    $delete5 = DB::update('update zzz_sweep_outs set status=1 where id=?', [$result3[0]->parent_id]);
            // } else {
            //     //全部未装车
            //   $delete6 = DB::update('update zzz_sweep_outs set status=0 where id=?', [$result3[0]->parent_id]);
            // };
               
   // dd([$searchKey]);
$dis=(substr($searchKey,0,4));
// dd($dis);
          if ($dis=='XSFH') {
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
                  }
                      else if($dis=='CKDB')
              {
                         //清空U8装车人和装车时间
$delete1 = DB::update("update transvouch set cDefine14='' where ctvcode=?", [$searchKey]);
           

        $delete2 = DB::table('transvouch_extradefine as t1')
                ->join('transvouch as t2','t1.ID','=','t2.ID')
                // ->join('zzz_sweep_car_items as t3','t2.cDLCode','=','t3.dispatch_no')
                ->where('t2.ctvCode','=',$searchKey)
                ->update(['t1.chdefine10'=>'']);


              }









$dis=(substr($searchKey,0,4));

          if ($dis=='XSFH') {
                

           $res = DB::select("select cinvcode,cinvname,iquantity from DispatchLists P left join DispatchList Z on P.DLID=Z.DLID  where Z.cDLCode =?",[$searchKey]);
     }

         else if ($dis=='CKDB') {

        

         $res = DB::select("select P.cinvcode,I.cinvname,P.iTVQuantity AS iquantity from transvouchs P left join transvouch Z on P.ID=Z.ID  left join inventory I on I.cInvCode=P.cinVCODE where Z.cTVCode =?", [$searchKey]);
         }
 
foreach ($res as $ress) {

$location_no = DB::select(" select b.location_no from zzz_sweep_outs b left join zzz_sweep_out_items a on a.parent_id=b.id where dispatch_no=?", [$searchKey]);


//查现有库存 0521 注释掉 后面要恢复
  // $iquay=DB::select("select cinvcode,cinvname,iquantity from zzz_CurrentStock where cinvcode =? and location_no=?",[$ress->cinvcode,$location_no[0]->location_no]);
         
  //  dd(count($iquay));

  //         if (count($iquay)>0) {
  //           $iquantity8 = ($iquay[0]->iquantity)+($ress->iquantity);   
       
  //             DB::update("update zzz_CurrentStock  set iquantity=? where cinvcode =? and location_no=?",[$iquantity8,$ress->cinvcode,$location_no[0]->location_no]);
  //         }
  //         else
  //         {

                    
         
  //               return false;
                     
  //         }          

        }


















                 //删除记录
                    $deleteds1 = DB::delete("delete from BS_GN_wlstate where zc='装车'  and cdlcode=?",[$searchKey]);



                       $result87 = DB::select(" select parent_id FROM zzz_sweep_car_items where dispatch_no=?",[$searchKey]);

                       $jy1=  DB::select("select count  FROM zzz_sweep_cars where id=?",[$result87[0]->parent_id]);

                       $jy2= $jy1[0]->count-1;

                    //删除装车记录
  $delete = DB::delete("delete from zzz_sweep_car_items where dispatch_no=?",[$searchKey]);

$delete11 = DB::update("update zzz_sweep_cars set count=? where id=?", [$jy2,$result87[0]->parent_id]);







          // $jy1=  DB::select("select count  FROM zzz_sweep_cars where id=?",[$result87[0]->parent_id]);

 
          // $sweep_car->count;
 
           $result88 = DB::select('select count(parent_id) count from zzz_sweep_car_items where SUBSTRING(dispatch_no,0,5) =? and parent_id = ?',['XSFH',$result87[0]->parent_id]);

           if ($jy2==$result88[0]->count)
            {
               
DB::update("update zzz_sweep_cars set statusd=1 where id=?",[$result87[0]->parent_id]);

           }
          
           else
            {
                $result86 = DB::select('select count(parent_id) count from zzz_sweep_car_items where SUBSTRING(dispatch_no,0,5) =? and parent_id = ?',['CKDB',$result87[0]->parent_id]);
                
           
   // dd($result86[0]->count);
           if ($jy2==$result86[0]->count) {
       
                DB::update('update zzz_sweep_cars set status=1 where id=?',[$result87[0]->parent_id]);
           }
           else
            { };
};















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
            // if($sweepCar->status ==1 || $sweepCar->statusd ==1){
            //     echo json_encode(array('status'=>0,'text'=>'已经生成运单，不允许删除！'));
            //     exit();
            // }


            $a = DB::select("select transportno from zzz_sweep_car_items where transportno is NOT NULL and parent_id=?", [$sweepCar->id]);
  if(count($a) >0){
                echo json_encode(array('status'=>0,'text'=>'已经生成运单，不允许删除！'));
                exit();
            }
            // dd($sweepCar->status);
            // 更新打包发货单装车次数0508
            // DB::table('zzz_sweep_out_items as t1')
            //     ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
            //     ->where('t2.parent_id','=',$sweepCar->id)
            //     ->decrement('t1.car_count');
            // // 更新打包发货单状态
            // DB::table('zzz_sweep_out_items as t1')
            //     ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
            //     ->where('t2.parent_id','=',$sweepCar->id)
            //     ->where('t1.car_count','=',0)
            //     ->update(['t1.status'=>0]);
            //      // 更新打包出库单表头状态
            // $result3 = DB::SELECT('SELECT t1.parent_id as parent_id from zzz_sweep_out_items as t1 LEFT join zzz_sweep_car_items as t2 ON t1.dispatch_no = t2.dispatch_no where t2.parent_id = ?', [$sweepCar->id]);  //获取打包单主表的id
            // $result4 = DB::select('select count(*) as zcnum from zzz_sweep_out_items where status<>0 and parent_id = ?', [$result3[0]->parent_id]); //查询该打包单生成装车单的发货单数
            // if ($result4[0]->zcnum > 0) {
            //     //部分装车
            //     DB::update('update zzz_sweep_outs set status=1 where id=?', [$result3[0]->parent_id]);
            // } else {
            //     //全部未装车
            //     DB::update('update zzz_sweep_outs set status=0 where id=?', [$result3[0]->parent_id]);
            // }

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

            //清空U8调拨单装车人和装车时间
            DB::table('transvouch as t1')
                ->join('zzz_sweep_car_items as t2','t1.ctvCode','=','t2.dispatch_no')
                ->where('t2.parent_id','=',$sweepCar->id)
                ->update(['t1.cDefine14'=>'']);

            DB::table('transvouch_extradefine as t1')
                ->join('transvouch as t2','t1.ID','=','t2.ID')
                ->join('zzz_sweep_car_items as t3','t2.ctvCode','=','t3.dispatch_no')
                ->where('t3.parent_id','=',$sweepCar->id)
                ->update(['t1.chdefine10'=>'']);
                //删除记录


      $jg2 =  DB::SELECT("select dispatch_no from zzz_sweep_car_items where parent_id=?",[$sweepCar->id]);

                foreach ( $jg2 as $Sweep_car_items) {


             
$dis=(substr($Sweep_car_items->dispatch_no,0,4)); 
//计算现存量

          if ($dis=='XSFH') {
                

           $res = DB::select("select cinvcode,cinvname,iquantity from DispatchLists P left join DispatchList Z on P.DLID=Z.DLID  where Z.cDLCode =?",[$Sweep_car_items->dispatch_no]);
     }

         else if ($dis=='CKDB') {

        

         $res = DB::select("select P.cinvcode,I.cinvname,P.iTVQuantity AS iquantity from transvouchs P left join transvouch Z on P.ID=Z.ID  left join inventory I on I.cInvCode=P.cinVCODE where Z.cTVCode =?", [$Sweep_car_items->dispatch_no]);
         }
          
       

foreach ($res as $ress) {
// $location_no = DB::select(" select b.location_no from zzz_sweep_outs b left join zzz_sweep_out_items a on a.parent_id=b.id where dispatch_no=?", [$Sweep_car_items->dispatch_no]);
// //查现有库存
//   $iquay=DB::select("select cinvcode,cinvname,iquantity from zzz_CurrentStock where cinvcode =? and location_no=?",[$ress->cinvcode,$location_no[0]->location_no]);
//           // $iquay = DB::select('select cinvcode,cinvname,iquantity from zzz_CurrentStock where cinvcode =? and location_no=?',[$ress->cinvcode,$location_no]);

//           if (count($iquay)>0) {
//             $iquantity8 = ($iquay[0]->iquantity)+($ress->iquantity);   
//             // dd($iquantity8);
//               DB::update("update zzz_CurrentStock  set iquantity=? where cinvcode =? and location_no=?",[$iquantity8,$ress->cinvcode,$location_no[0]->location_no]);
//           }
//           else
//           {

                    
         
//                 return false;
                     
//           }          

        }





  $deleteds2= DB::delete("delete from zzz_kwkc where  cdlcode=? and source='扫码上车'",[$Sweep_car_items->dispatch_no]);




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
        $query1 = DB:: table('zzz_return_house_items as t1')
            ->where('t1.dispatch_no','=',$cdlcode)
            ->count();


        $query2 = DB::select("select cdlcode from dispatchlist where ISNULL(cverifier,'') !='' and  cdlCode =?", [$cdlcode]);
         $query3 = DB::select("select ctvcode from transvouch where ISNULL(cverifyperson,'') !='' and  ctvCode =?", [$cdlcode]);

         $dis=(substr($cdlcode,0,4)); 
         if ($dis=='CKDB') 
         {
         //只能扫三个仓库的调拨单 四楼仓、四楼临时仓、发货仓
         $query6 = DB::select("select cowhcode from transvouch where ctvcode=? and (cowhcode=? or cowhcode=? or cowhcode=?)",[$cdlcode,1,6,13]);
        }
        if ($dis=='XSFH')
        {
         $query6 = DB::select("select DLID from DISPATCHLIST where cdlcode=?",[$cdlcode]);
        }


     if(count($query2)==0&&count($query3)==0)
     {
        echo json_encode(array('status'=>2));
     }
            // $query-1>=$query1
     else
     {
        if($query>$query1){
            //装车单只可以比退回单多一次,没保存的时候装车单次数是不能大于退回单次数
            echo json_encode(array('status'=>0));
        }else{

            $query5 = DB::select("select id from hy_eo_transports where csocode =?", [$cdlcode]);

if(count($query5)>0)
     {
        echo json_encode(array('status'=>5));
     }
     else
     {
      if(count($query6)==0)
      {
        echo json_encode(array('status'=>6));
      }
      else{
            echo json_encode(array('status'=>1,'text'=>'success！'));
            }
            }
        }

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

        $data=parent::dataPage($request,$this->condition($builder,$request->searchKey),'desc');

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