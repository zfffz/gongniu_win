<?php

namespace App\Http\Controllers;

use App\Models\Return_house_item;
use App\Models\ReturnHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ReturnHousesController extends CommonsController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (! Auth::user()->can('returnhouse_users')) {
     return view('admins.pages.permission_denied');
  
        }

        return view('returnhouse.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if (! Auth::user()->can('returnhouse_users')) {
     return view('admins.pages.permission_denied');
  
        }
        //打包员
        $packagers = DB::table('bs_gn_wl')
            ->select('cpersoncode as no','cpersonname as name')
            ->where('wlcode','=','04')
            ->get();
        return view('returnhouse.create',compact('packagers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         if (! Auth::user()->can('returnhouse_users')) {
     return view('admins.pages.permission_denied');
  
        }
        
        $return_house=\DB::transaction(function() use ($request){
            //创建一张新的打包出库单
            $return_house = new ReturnHouse([
                'packager_no'=>$request->input('packager'),
                'location_no'=>$request->input('location_no'),
                'user_no'=>Auth::id()
            ]);
            $return_house->save();
            // $revalue =[];

            //创建一张新的项目清单
            $return_house_items = $request->input('items');
            $i=1;

            foreach($return_house_items as $data){
                // 先检查发货单号是否重复
                // $jg = Sweep_out_item::where('dispatch_no','=',$data['dispatch_no'])->get();

                // if(count($jg)>0){
                //     echo json_encode(array('status'=>0,'text'=>'发货单号'.$jg[0]->dispatch_no.'，系统已经存在，不允许重复创建！'));
                //     exit();
                // }
    

      $return_house_item = $return_house->return_house_items()->make([
                    'entry_id'=>$i,
                    'dispatch_no'=> $data['dispatch_no'],
                    'default_location_no'=> $data['default_location_no'],
                ]);

              

                $return_house_item->save();

        // 1.验证是否已经审核
        // $data = DB:: table('DispatchList as t1')
        // ->select('t1.cvereifier')
        // ->where('t1.dispatch_no','=',$dispatch_no)->get();

        // if(count($data) > 0){
        //     echo json_encode(array("status"=>"1","text"=>"发货单'$dispatch_no'已对货，不允许再次扫描！"));
        //     exit();
        // }
        // else{
        //  echo json_encode(array("status"=>"0"));
        //     }
                //取打包单号
         $results = DB::select('select no from zzz_sweep_outs P left join zzz_sweep_out_items Z on P.id=z.parent_id  where z.dispatch_no = :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);
               
         //记录打包员和打包时间
                // $ddate = date("Y-m-d H:i:s");
                // DB::INSERT('insert into BS_GN_WLstate(cpersoncode,cdlcode,db,ddate)VALUES(?,?,?,?)',[$request->input('packager'),$data['dispatch_no'],'打包',$ddate]);

 $dis=(substr($data['dispatch_no'],0,4));

// 获取发货单默认库位编码
          if ($dis=='XSFH') {
                // $cVerifier= Auth::user()->name;
         $cVerifier= 'auser';
        $ddate= date("Y-m-d H:i:s");
          $res = DB::select('select cinvcode,cinvname,iquantity from DispatchLists P left join DispatchList Z on P.DLID=Z.DLID  where Z.cDLCode = :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);

      }
      else if ($dis=='CKDB') {

         $res = DB::select('select P.cinvcode,I.cinvname,P.iTVQuantity AS iquantity from transvouchs P left join transvouch Z on P.ID=Z.ID  left join inventory I on I.cInvCode=P.cinVCODE where Z.cTVCode = :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);

      }
foreach ($res as $ress) {




$location_no = $request->location_no;
  $iquay=DB::select("select cinvcode,cinvname,iquantity from zzz_CurrentStock where cinvcode =? and location_no=?",[$ress->cinvcode,$location_no]);
          // $iquay = DB::select('select cinvcode,cinvname,iquantity from zzz_CurrentStock where cinvcode =? and location_no=?',[$ress->cinvcode,$location_no]);

          if (count($iquay)>0) {
            $iquantity8 = ($ress->iquantity)+($iquay[0]->iquantity);   
           
              DB::update("update zzz_CurrentStock  set iquantity=? where cinvcode =? and location_no=?",[$iquantity8,$ress->cinvcode,$location_no]);
          }
          else
          {

                     $check1=DB::select("select cinvcode,cinvname from inventory where cinvcode =?",[$ress->cinvcode]);
                     // dd(1);

$check2=DB::select("select no,name from zzz_storage_locations where no =?",[$location_no]);
// dd($check2);
           

            if (count($check1)>0 & count($check2)>0) {


     DB::INSERT('insert into zzz_CurrentStock(cinvcode,cinvname,location_no,location_name,iquantity)VALUES(?,?,?,?,?)',[$check1[0]->cinvcode,$check1[0]->cinvname,$check2[0]->no,$check2[0]->name,$ress->iquantity]);
                # code...
             // dd(1);   
            }
            else{
                return false;
            }             
          }








          $ddate= date("Y-m-d H:i:s");
         DB::INSERT('insert into zzz_kwkc(source,cdlcode,location_no,cinvcode,cinvname,iquantity,time)VALUES(?,?,?,?,?,?,?)',['退回入库',$data['dispatch_no'],$request->input('location_no'),$ress->cinvcode,$ress->cinvname,$ress->iquantity,$ddate]);

        }
 //更新发货单审核信息（审核人、变更人、审核日期、审核时间）
               
                // DB::update("update dispatchlist set cVerifier= ?,cChanger=NULL,dverifydate=case when ddate>? then ddate else ? end ,dverifysystime=getdate() where cDLCode =?",[$cVerifier,$date,$date,$data['dispatch_no']]);
                //生成销售出库单和更改库存
                // DB::Update("exec zzz_CCGC32 ?",[$data['dispatch_no']]);
                //回传打包单号
         // DB::update("update dispatchlist set cdefine2= ? where cDLCode =?",[$results[0]->no,$data['dispatch_no']]);
         // DB::update("update zzz_sweep_checks  set flag=1 where dispatch_no =?",[$data['dispatch_no']]);
        //1.提示销售出库单号
        // $data1 = DB:: table('rdrecord32 as t1')
        // ->select('t1.ccode')
        // ->where('t1.cbuscode','=',$data['dispatch_no'])->get();
        
 //        if(count($data1) != 0)
 //        {
           
 //    $revalue = json_encode(array('status'=>1,'text1'=>$data1[0]->ccode));

 // // return $revalue ;

 //        }

 //        else{
 //    $revalue = json_encode(array('status'=>2,'text2'=>'未生成销售出库单，请联系管理员！'));
    
 // // return $revalue ;
 //     }



        //
                $i++;
            }
            // 更新
 //            $sweep_out->update(['count' => ($i-1)]);
 //             if(count($data1) != 0)
 //        {
           
    $revalue = json_encode(array('status'=>1));

 return $revalue ;

 //        }

 //        else{
 //    $revalue = json_encode(array('status'=>2,'text2'=>'未生成销售出库单，请联系管理员！'));
    
 // // return $revalue ;
 //     }

             // return $revalue ;
            // 更新
            $return_house->update(['count' => ($i-1)]);

            return $return_house;
            
             
        });

        return $return_house;
       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         if (! Auth::user()->can('returnhouse_users')) {
     return view('admins.pages.permission_denied');
  
        }
        $returnHouse = ReturnHouse::find($id);

        $packager_name = DB::table('bs_gn_wl')
            ->select('cpersoncode as no','cpersonname as name')
            ->where('cpersoncode','=',$returnHouse->packager_no)
            ->get()[0]->name;

        return view('returnHouse.show',compact('returnHouse','packager_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (! Auth::user()->can('returnhouse_users')) {
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
         if (! Auth::user()->can('returnhouse_users')) {
     return view('admins.pages.permission_denied');
  
        }
        // var tb = document.getElementById("dispatch_table");
        // $dispatch_no  = $request->document.getElementById("dispatch_table").rows[1].cells[0].innerHTML;
        // $dispatch_no = $request->input('items');
        // $dispatch_no = $request->dispatch_no;
        // $cVerifier= Auth::user()->name;
        // $data=DB::update("update dispatchlist set cVerifier= ?,cChanger='null',dverifydate='2020-04-13' where cDLCode in (?)",[$cVerifier,$dispatch_no]);
        // $sweep_out_items = $request->input('items');
        //     // $i=1;

        //     foreach($sweep_out_items as $data){
        //         // 先检查发货单号是否重复
        //         $jg = Sweep_out_item::where('dispatch_no','=',$data['dispatch_no'])->get();

        // var_dump($data,$data['dispatch_no'],$cVerifier);
      }  

// public function update_cverifier(Request $request)
//     {
//         dd($request->input);
//         $sweep_out=\DB::transaction(function() use ($request){
//         // var tb = document.getElementById("dispatch_table");
//         // $dispatch_no  = $request->document.getElementById("dispatch_table").rows[1].cells[0].innerHTML;
// //         $dispatch_no = $request->input('items');
// //         // $dispatch_no = $request->dispatch_no;
//         $cVerifier= Auth::user()->name;
// //         $data=DB::update("update dispatchlist set cVerifier= '张峰',cChanger='null',dverifydate='2020-04-13' where cDLCode ='XSFH00318238
// // '");
        
//           $dispatchlist = $request->input('item');
//             $i=1;

         
//                 // 先检查发货单号是否重复
//                 $data=DB::update("update dispatchlist set cVerifier= '张峰',cChanger='null',dverifydate='2020-04-13' where cDLCode =?",[$dispatchlist['dispatch_no']]);
//                 // $jg = dispatchlist::where('cDLCode','=',$data['dispatch_no'])->get();
//             // $data->update([
//             // "cVerifier"=>'张峰',
//             // "cChanger"=>null
//             // // "dverifydate"=>date("Y-m-d H:i:s"),
//             // // "dverifysystime"=>Auth::user()->name
//             //  ]);
//         //var_dump($data,$dispatchlist['dispatch_no'],$cVerifier);
      

//       });  
// }
// $driver->update([
//             "cVerifier"=>'张峰',
//             "cChanger"=>null,
//             "dverifydate"=>date("Y-m-d H:i:s"),
//             "dverifysystime"=>Auth::user()->name
//         ]);

//         return redirect()->route('driver.index')->with('success', '司机更新成功！');
        // $driver->update([
        //     "cVerifier"=>'张峰',
        //     "cChanger"=>null,
        //     "dverifydate"=>date("Y-m-d H:i:s"),
        //     "dverifysystime"=>Auth::user()->name
        // ]);

        // return redirect()->route('driver.index')->with('success', '司机更新成功！');



        // $dispatch_no = $request->dispatch_no;
        // DB::table('DispatchList as t1')
        //         // ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
        //         ->where('t1.cDLCode','=',$dispatch_no)
        //         ->update(['t1.cVerifier'=>'张峰'],['t1.cChanger'=>null],['dverifydate'=>'2020-06-08'],['t1.dverifysystime'=>getdate()]);

                 // Update DispatchList SET  cVerifier=N'张峰',cChanger=null,dverifydate=case when ddate>'2020-04-13' then ddate else '2020-04-13' end,dverifysystime=getdate()  WHERE DispatchList.DLID=1000363092
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

//      public function update_cverifier(Request $request,dispatchlist $dispatchlist){


// //         DB::table('DispatchList as t1')
// //                 // ->join('zzz_sweep_car_items as t2','t1.dispatch_no','=','t2.dispatch_no')
// //                 ->where('t1.cDLCode','=',$dispatch_no)
// //                 ->update(['t1.cVerifier'=>'张峰'],['t1.cChanger'=>null],['dverifydate'=>'2020-06-08'],['t1.dverifysystime'=>getdate()]);
// // echo json_encode(array("status"=>"3"));

//         }
    public function destroy(ReturnHouse $returnhouse,Return_house_item $Return_house_item)
    {
         if (! Auth::user()->can('returnhouse_users')) {
     return view('admins.pages.permission_denied');
  
        }

        // 删除前先判断一下有没有生成发货装车单
   
        if($returnhouse->status ==1){
            echo json_encode(array('status'=>0,'text'=>'已经部分发货装车，不允许删除！'));
            exit();
        }
        if($returnhouse->status ==2){
            echo json_encode(array('status'=>0,'text'=>'已经全部发货装车，不允许删除！'));
            exit();
        }


        //标记刷回0，对货就可以删除了
    // DB::update("update A SET A.flag=0 FROM zzz_sweep_checks A left join zzz_sweep_out_items B ON A.dispatch_no=B.dispatch_no where B.parent_id =?",[$sweepOut->id]);

     //清空U8发货单里记录的打包单号
        // DB::table('dispatchlist as t1')
        //     ->join('zzz_sweep_out_items as t2','t1.cDLCode','=','t2.dispatch_no')
        //     ->where('t2.parent_id','=',$sweepOut->id)
        //     ->update(['t1.cDefine2'=>'']);

            //删除BS_GN_wlstate上的打包记录
// $deleteds1 = DB::delete("delete from BS_GN_wlstate where cdlcode=(select dispatch_no from zzz_sweep_out_items where parent_id=?) and db='打包'",[$sweepOut->id]);
$jg2 = DB::SELECT("select dispatch_no from zzz_return_house_items where parent_id=?",[$returnhouse->id]);

   
            foreach ( $jg2 as $Sweep_out_items) {


$dis=(substr($Sweep_out_items->dispatch_no,0,4));
//计算现存量

          if ($dis=='XSFH') {
                
           $res = DB::select("select cinvcode,cinvname,iquantity from DispatchLists P left join DispatchList Z on P.DLID=Z.DLID  where Z.cDLCode =?",[$Sweep_out_items->dispatch_no]);
     }

         else if ($dis=='CKDB') {

         $res = DB::select("select P.cinvcode,I.cinvname,P.iTVQuantity AS iquantity from transvouchs P left join transvouch Z on P.ID=Z.ID  left join inventory I on I.cInvCode=P.cinVCODE where Z.cTVCode =?", [$Sweep_out_items->dispatch_no]);
         }
          
       
foreach ($res as $ress) {
$location_no = DB::select(" select b.location_no from zzz_sweep_outs b left join zzz_sweep_out_items a on a.parent_id=b.id where dispatch_no=?", [$Sweep_out_items->dispatch_no]);
//查现有库存
  $iquay=DB::select("select cinvcode,cinvname,iquantity from zzz_CurrentStock where cinvcode =? and location_no=?",[$ress->cinvcode,$location_no[0]->location_no]);
          // $iquay = DB::select('select cinvcode,cinvname,iquantity from zzz_CurrentStock where cinvcode =? and location_no=?',[$ress->cinvcode,$location_no]);

          if (count($iquay)>0) {
            $iquantity8 = ($iquay[0]->iquantity)-($ress->iquantity);   
            // dd($iquantity8);
              DB::update("update zzz_CurrentStock  set iquantity=? where cinvcode =? and location_no=?",[$iquantity8,$ress->cinvcode,$location_no[0]->location_no]);
          }
          else
          {

                    
         
                return false;
                     
          }          

        }







$deleteds2= DB::delete("delete from zzz_kwkc where  cdlcode=? and source='退回入库'",[$Sweep_out_items->dispatch_no]);

         
            
// $deleteds1 = DB::delete("delete from BS_GN_wlstate where db='打包'  and cdlcode=?",[$Sweep_out_items->dispatch_no]);
};
        //清空U8发货单记录的打包人和打包时间
        // DB::table('dispatchlist as t1')
        //     ->join('zzz_sweep_out_items as t2','t1.cDLCode','=','t2.dispatch_no')
        //     ->where('t2.parent_id','=',$sweepOut->id)
        //     ->update(['t1.cDefine13'=>'']);

        // DB::table('dispatchlist_extradefine as t1')
        //     ->join('dispatchlist as t2','t1.DLID','=','t2.DLID')
        //     ->join('zzz_sweep_out_items as t3','t2.cDLCode','=','t3.dispatch_no')
        //     ->where('t3.parent_id','=',$sweepOut->id)
        //     ->update(['t1.chdefine5'=>'']);
        
        $returnhouse->delete();
        // 把之前的 redirect 改成返回空数组
        return [];
    }

//     public function dispatchs_data(Request $request){
//         $dispatch_no = $request->dispatch_no;
// $data = DB::SELECT("select cVerifier from dispatchlist where CDLCODE= ? AND cVerifier is NULL ",[$dispatch_no]);
//         if(count($data) == 0){
//             echo json_encode(array('status1'=>0,'text1'=>"发货单号'$dispatch_no'已经审核！"));
//             exit();
//         }else{
//             echo json_encode(array('status1'=>1));
//                 exit();
//             }

// }



    public function dispatch_data(Request $request){
         if (! Auth::user()->can('returnhouse_users')) {
     return view('admins.pages.permission_denied');
  
        }
        $dispatch_no = $request->dispatch_no;
        // 1.判断发货单号是否合法
        // $data = DB:: table('dispatchlist as t1')
        //     ->select('t1.cDLCode','t1.cVerifier')
        //     ->where('t1.cDLCode','=',$dispatch_no)->get();
 $data = DB::SELECT("
select id from  zzz_kwkc where source='扫码上车' and  cdlcode= ?",[$dispatch_no]);

            $data1 = DB::SELECT("select id from hy_eo_transports
 where csocode= ?",[$dispatch_no]);

        if(count($data) == 0){
            echo json_encode(array("status"=>"0","text"=>"未作扫码上车，无需退库！"));
            exit();
        }
        else if (count($data1) > 0) {

 echo json_encode(array("status"=>"1","text1"=>"请在发运单中删除对应发货单，再做退库！"));
           // DD(1);
 exit();
        
        }
            // echo json_encode(array("status1"=>"1",'cVerifier'=>$data[0]->cVerifier));
            // if(cVerifier == NULL)
            // { echo json_encode(array('status1'=>0,'text1'=>"发货单号'$dispatch_no'已经审核！"));
            // exit();
            // }
        // else{
        //     echo json_encode(array('status1'=>1));
        //         exit();
        //     }
            // }
            // else
            // {

            // 判断发货单号是否已经打包，避免重复打包
            // $jg = Sweep_out_item::where('dispatch_no','=',$dispatch_no)->get();

            // if(count($jg)>0){
            //     echo json_encode(array('status'=>0,'text'=>'发货单号'.$jg[0]->dispatch_no.'，已经打包，不允许重复录入！'));
            //     exit();
            // }
        


// DB::SELECT("update dispatchlist set cVerifier= ?,cChanger=NULL,dverifydate=case when ddate>? then ddate else ? end ,dverifysystime=getdate() where cDLCode =?",[$cVerifier,$date,$date,$data['dispatch_no']]);




//截取前四位，可能有调拨单
           $dis=(substr($dispatch_no,0,4));
// 获取发货单默认库位编码
          if ($dis=='XSFH') {

        // 获取默认库位编码
        $data = DB:: table('dispatchlist as t1')
            ->select('t1.cDLCode','t1.cCusCode','t3.no')
            ->leftJoin('zzz_customer_locations as t2','t1.cCusCode','=','t2.customer_no')
            ->leftJoin('zzz_storage_locations as t3','t2.location_id','=','t3.id')
            ->where('t1.cDLCode','=',$dispatch_no)->get();
        }
         else if ($dis=='CKDB') {

            $data =  DB::SELECT("select t1.cTVCode,SUBSTRING(t1.cdefine3,1, CHARINDEX('销',t1.cdefine3)) as cdefine3,t3.no from transvouch as t1 left join customer as t0 on SUBSTRING(t1.cdefine3,1, CHARINDEX('销',t1.cdefine3))=t0.ccusname left join zzz_customer_locations as t2 on t0.cCusCode=t2.customer_no left join  zzz_storage_locations as t3 on t2.location_id=t3.id where t1.cTVCode=?",[$dispatch_no]);

                 }

       if($data[0]->no ==''){
           echo json_encode(array('status'=>2,'text'=>'默认库位未维护，请联系管理员！'));
           exit();
       }else{
           echo json_encode(array('status'=>3,'no'=>$data[0]->no));
       }



       

    }


  //判断发货单是否已经对货，未对货则要求先对货，再打包
 public function checkIfdh(Request $request){
        $cdlcode = $request->dispatch_no;

        //11.20修改检查发货单是否已经审核过，未审核过要求先审核，在打包,以后检查对货可以直接启用
        // $query = DB:: table('zzz_sweep_checks as t1')
        //     ->where('t1.dispatch_no','=',$cdlcode)
        //     ->count();
   $dis=(substr($cdlcode,0,4));
       if ($dis=='XSFH') {

 $query =  DB::SELECT("select DLID as DLID from dispatchlist where cDLCode=?",[$cdlcode]);
 }
  else if ($dis=='CKDB') {
 $query =  DB::SELECT("select ID as DLID from transvouch where  cTVCode=?",[$cdlcode]);

     }
        if(COUNT($query) == 0 ){
            //这张发货单未进行对货
            echo json_encode(array('status'=>0,'text'=>'单据不存在，不允许打包入库！'));
        }else{
            echo json_encode(array('status'=>1,'text'=>'success！'));
        }
    }
    //对货启用后，启用一下语句
    // public function checkIfdh(Request $request){
    //     $cdlcode = $request->dispatch_no;
    //     $query = DB:: table('zzz_sweep_checks as t1')
    //         ->where('t1.dispatch_no','=',$cdlcode)
    //         ->count();
    //     if($query == 0 ){
    //         //这张发货单未进行对货
    //         echo json_encode(array('status'=>0,'text'=>'未对货，不允许退货入库！'));
    //     }else{
    //         echo json_encode(array('status'=>1,'text'=>'success！'));
    //     }
    // }
    public function getData(Request $request)
    {
        $builder = \DB::table('zzz_return_houses as t1')
            ->select(
                \DB::raw("
            t1.id,
            t1.no,
            t1.location_no,
            t3.name as location_name,
            t2.cpersonname as packager_name,
            t1.count,
            t1.created_at
            "))
            ->leftJoin('person as t2','t1.packager_no','t2.cpersoncode')
            ->leftJoin('zzz_storage_locations as t3','t1.location_no','t3.no');

        $data=parent::dataPage7($request,$this->condition($builder,$request->searchKey),'desc');

        return $data;
    }

    private function condition($table,$searchKey){
        if($searchKey!=''){
            $table->where('t2.cpersonname','like','%'.$searchKey.'%');
            $table->orWhere('t1.created_at','like','%'.$searchKey.'%');
        }
        return $table;
    }

    public function location_data(Request $request){
        // 获取默认库位编码
        $location_no = $request->location_no;
        $data = DB:: table('zzz_storage_locations as t1')
            ->select('t1.no')
            ->where('t1.no','=',$location_no)->get();

        echo json_encode($data);

    }
}
