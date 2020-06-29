<?php

namespace App\Http\Controllers;

use App\Models\Sweep_out_item;
use App\Models\SweepOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SweepOutsController extends CommonsController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sweepOuts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //打包员
        $packagers = DB::table('bs_gn_wl')
            ->select('cpersoncode as no','cpersonname as name')
            ->where('wlcode','=','03')
            ->get();
        return view('sweepOuts.create',compact('packagers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sweep_out=\DB::transaction(function() use ($request){
            //创建一张新的打包出库单
            $sweep_out = new SweepOut([
                'packager_no'=>$request->input('packager'),
                'location_no'=>$request->input('location_no'),
                'user_no'=>Auth::id()
            ]);
            $sweep_out->save();

            //创建一张新的项目清单
            $sweep_out_items = $request->input('items');
            $i=1;

            foreach($sweep_out_items as $data){
                // 先检查发货单号是否重复
                $jg = Sweep_out_item::where('dispatch_no','=',$data['dispatch_no'])->get();

                if(count($jg)>0){
                    echo json_encode(array('status'=>0,'text'=>'发货单号'.$jg[0]->dispatch_no.'，系统已经存在，不允许重复创建！'));
                    exit();
                }

                $sweep_out_item = $sweep_out->sweep_out_items()->make([
                    'entry_id'=>$i,
                    'dispatch_no'=> $data['dispatch_no'],
                    'default_location_no'=> $data['default_location_no']
                ]);

                $sweep_out_item->save();







                 
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

                //更新发货单审核信息
                $cVerifier= Auth::user()->name;
                $date= date("Y-m-d H:i:s");
                DB::update("update dispatchlist set cVerifier= ?,cChanger=NULL,dverifydate=case when ddate>? then ddate else ? end ,dverifysystime=getdate() where cDLCode =?",[$cVerifier,$date,$date,$data['dispatch_no']]);
                //生成销售出库单和更改库存
                DB::Update("exec zzz_CCGC32 ?",[$data['dispatch_no']]);
        //
                $i++;
            }

            // 更新
            $sweep_out->update(['count' => ($i-1)]);

            return $sweep_out;
        });

        return $sweep_out;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sweepOut = SweepOut::find($id);

        $packager_name = DB::table('bs_gn_wl')
            ->select('cpersoncode as no','cpersonname as name')
            ->where('cpersoncode','=',$sweepOut->packager_no)
            ->get()[0]->name;

        return view('sweepOuts.show',compact('sweepOut','packager_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    public function destroy(SweepOut $sweepOut)
    {
        // 删除前先判断一下有没有生成发货装车单
        if($sweepOut->status ==1){
            echo json_encode(array('status'=>0,'text'=>'已经部分发货装车，不允许删除！'));
            exit();
        }
        if($sweepOut->status ==2){
            echo json_encode(array('status'=>0,'text'=>'已经全部发货装车，不允许删除！'));
            exit();
        }

        $sweepOut->delete();
        // 把之前的 redirect 改成返回空数组
        return [];
    }

    public function dispatch_data(Request $request){
        $dispatch_no = $request->dispatch_no;
        // 1.判断发货单号是否合法
        $data = DB:: table('dispatchlist as t1')
            ->select('t1.cDLCode')
            ->where('t1.cDLCode','=',$dispatch_no)->get();

        if(count($data) == 0){
            echo json_encode(array("status"=>"0","text"=>"发货单号系统不存在！"));
            exit();
        }else{
            // 判断发货单号是否已经打包，避免重复打包
            $jg = Sweep_out_item::where('dispatch_no','=',$dispatch_no)->get();

            if(count($jg)>0){
                echo json_encode(array('status'=>0,'text'=>'发货单号'.$jg[0]->dispatch_no.'，已经打包，不允许重复录入！'));
                exit();
            }
        }

        // 获取默认库位编码
        $data = DB:: table('dispatchlist as t1')
            ->select('t1.cDLCode','t1.cCusCode','t3.no')
            ->leftJoin('zzz_customer_locations as t2','t1.cCusCode','=','t2.customer_no')
            ->leftJoin('zzz_storage_locations as t3','t2.location_id','=','t3.id')
            ->where('t1.cDLCode','=',$dispatch_no)->get();

       if($data[0]->no ==''){
           echo json_encode(array('status'=>0,'text'=>'默认库位未维护，请联系管理员！'));
           exit();
       }else{
           echo json_encode(array('status'=>1,'no'=>$data[0]->no));
       }

    }

    public function getData(Request $request)
    {
        $builder = \DB::table('zzz_sweep_outs as t1')
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
            ->leftJoin('bs_gn_wl as t2','t1.packager_no','t2.cpersoncode')
            ->leftJoin('zzz_storage_locations as t3','t1.location_no','t3.no');

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

    public function location_data(Request $request){
        // 获取默认库位编码
        $location_no = $request->location_no;
        $data = DB:: table('zzz_storage_locations as t1')
            ->select('t1.no')
            ->where('t1.no','=',$location_no)->get();

        echo json_encode($data);

    }
}
