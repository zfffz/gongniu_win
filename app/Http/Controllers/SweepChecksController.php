<?php

namespace App\Http\Controllers;

use App\Models\Sweep_check_item;
use App\Models\SweepCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SweepChecksController extends CommonsController
{
   
   public function destroy($id)
    {
        // $checker=Auth::id();
         // $id = $request->id;
         // dd($id);
        // 删除前先判断一下有没有生成发货装车单
        // if($sweepOut->status ==1){
        //     echo json_encode(array('status'=>0,'text'=>'已经部分发货装车，不允许删除！'));
        //     exit();
        // }
        // if($sweepOut->status ==2){
        //     echo json_encode(array('status'=>0,'text'=>'已经全部发货装车，不允许删除！'));
        //     exit();
        // }
        $data= DB::select("select flag,dispatch_no from zzz_sweep_checks where id=?",[$id]);
        // dd($data);
         if($data[0]->flag==1){
            echo json_encode(array('status'=>0,'text'=>'已经打包，请先删除打包单据！'));
            exit();
        }


$deleteds = DB::delete("delete from zzz_sweep_check_items where parent_id =?",[$id]);
$deleted = DB::delete("delete from zzz_sweep_checks where id=?",[$id]);


//删除BS_GN_wlstate上的对货记录
$deleteds1 = DB::delete("delete from BS_GN_wlstate where cdlcode=? and hd='对货'",[$data[0]->dispatch_no]);
//更新发货单上对货记录(对货人)
DB::update("update DispatchList set cDefine11='' where cdlcode=?",[$data[0]->dispatch_no]);

$data1= DB::select("select DLID from dispatchlist where cDLCode=?",[$data[0]->dispatch_no]);
//更新发货单上对货记录(对货时间)
DB::update("update dispatchlist_extradefine set chdefine4='' where DLID=?",[$data1[0]->DLID]);

// update DispatchList set cDefine11=@cname where cdlcode=@cdlcode
//     update dispatchlist_extradefine set chdefine4=convert(varchar(100),@ddate,120) where DLID=@dlid


  

// $data= DB::delete

        // $sweepCheck->delete();
        // $Sweep_check_item->delete();
        // 把之前的 redirect 改成返回空数组
        // return [];
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sweepChecks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	
        //打包员
        // $checkers = DB::table('dhy')
        //     ->select('cpersoncode as no','cpersonname as name')
        //     ->get();
        //     $dispatch_no = $request->dispatch_no;
        // $customers = DB::table('dispatchlistm')
        //     ->select('ccusname as name')
        //     ->where('dispatchlist','=',$dispatch_no)
        //     ->get();
      // return view('sweepChecks.app',compact('checkers'));
        $checkers = DB::table('bs_gn_wl')
            ->select('cpersoncode as no','cpersonname as name')
            ->where('wlcode','=','02')
            ->get();
        return view('sweepChecks.create',compact('checkers'));
        return view('sweepChecks.index',compact('checkers'));
        // return view('sweepChecks.show',compact('checkers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response


     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$sweepOut = SweepOut::find($id);

        // $sweepCheck = SweepCheck::find($id);

        return view('sweepChecks.show');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDatas(Request $request)
    {
        $searchKey = $request->input('searchKey');
          //$searchKey = $request->searchKey;
        // $dispatch_no = $request->dispatch_no;
        $builder =  \DB:: table('zzz_sweep_check_items as t1')
        ->select(
            \DB::raw("
                t2.id,
                t2.dispatch_no,
                t2.ccusname,
                t2.checker,
                t2.lszz,
                Convert(decimal(30,3),t2.cz) as cz,

                t1.cInvCode,
                t1.cInvName,
                (ISNULL(Convert(decimal(30,3),t1.iinvweight),0))
                 as iinvweight,
                
                Convert(decimal(30,0),t1.iQuantity) as iQuantity,
                Convert(decimal(30,0),t1.yQuantity) as yQuantity,
                t1.zb,
                CONVERT(varchar(100), t2.created_at, 20) as created_at
                "))
        ->leftJoin('zzz_sweep_checks as t2','t1.parent_id','=','t2.id');
        // ->where('t2.cDLCode','=',$dispatch_no)->get();

        $data=parent::dataPage2($request,$this->conditions($builder,$request->searchKey),'asc');

        return $data;
        // echo json_encode(array('status'=>1,'ddate'=>$data[0]->ddate));
      // echo json_encode(array('status'=>1,'position'=>$data[0]->position));
    }
    private function conditions($table,$searchKey){
        if($searchKey!=''){
            $table->where('t2.dispatch_no','like','%'.$searchKey.'%');
            $table->orWhere('t2.checker','like','%'.$searchKey.'%');
        }
        return $table;
    }



     public function getData(Request $request)
    {
        $searchKey = $request->input('searchKey');
          //$searchKey = $request->searchKey;
        $data = \DB:: table('DispatchList as t1')
        ->select(
            \DB::raw("
                t1.cDLCode,
                t1.cCusName,
                CONVERT(varchar(100), t1.dDate, 23) as dDate ,
                t3.no
                "))
        ->leftJoin('zzz_customer_locations as t2','t1.cCusCode','=','t2.customer_no')
        ->leftJoin('zzz_storage_locations as t3','t2.location_id','=','t3.id')
        // ->where('t1.cDLCode','=',$searchKey)->get();
        ->where('t1.cDLCode','like','%'.$searchKey.'%')->get();

        echo json_encode(array('status'=>1,'cDLCode'=>$data[0]->cDLCode,'cCusName'=>$data[0]->cCusName,'dDate'=>$data[0]->dDate,'no'=>$data[0]->no));
        // echo json_encode(array('status'=>1,'ddate'=>$data[0]->ddate));
      // echo json_encode(array('status'=>1,'position'=>$data[0]->position));
    }

    public function dispatchs_data(Request $request)
    {

        $searchKey = $request->input('searchKey');
        $builder = \DB::table('DispatchLists as t1')
        ->select(
            \DB::raw("
                t1.AutoID,
                t2.cDLCode,
                t3.cWhName,
                t1.cInvCode,
                t4.cInvName,
                t4.cInvStd,
                t5.cComUnitName,

                (ISNULL(Convert(decimal(30,3),t4.iinvweight),0))
                 as iinvweight,
                Convert(decimal(30,0),t4.cinvDefine13) as cinvDefine13,
                 (CASE WHEN t4.cinvDefine13 != 0 THEN (CONVERT(decimal(30, 2), t1.iQuantity / t4.cinvDefine13)) ELSE 1 END) as iNum,
                '' as kz,
                Convert(decimal(30,0),t1.iQuantity) as iQuantity
                "))
        ->leftJoin('DispatchList as t2','t1.DLID','=','t2.DLID')
        ->leftJoin('Warehouse as t3','t1.cWhCode','=','t3.cWhCode')
        ->leftJoin('Inventory as t4','t1.cInvCode','=','t4.cInvCode')
        ->leftJoin('ComputationUnit as t5','t4.cComUnitCode','=','t5.cComunitCode');

          // dd($builder) ; 

        $data=parent::dataPage1($request,$this->condition($builder,$request->searchKey),'asc');

        return $data;
    }


    public function dispatchscf_data(Request $request)
    {

             $searchKey = $request->input('searchKey');
        $builder = \DB::table('V_zzz_cf as t1')
        ->select(
            \DB::raw("
                t1.AutoID,
                t1.cDLCode,
                t1.cWhName,
                t1.cInvCode,
                t1.cInvName,
                t1.cInvStd,
                t1.cComUnitName,
                t1.cinvDefine13,
               (ISNULL(Convert(decimal(30,3),t1.iinvweight),0))
                 as iinvweight,
                t1.iNum,
                '' as kz,
                t1.iQuantity
                "))
                   ;

          // dd($builder) ; 

        $data=parent::dataPage5($request,$this->condition($builder,$request->searchKey),'asc');

        return $data;
    }




    private function condition($table,$searchKey){
        if($searchKey!=''){
            // $table->where('cDLCode','=',$searchKey);
$table->where('cDLCode','like','%'.$searchKey.'%');
        }
        return $table;
    }

    public function dispatch_data(Request $request){
      $searchKey = $request->input('searchKey');
        // $dispatch_no = $request->dispatch_no;
        // 1.判断发货单号是否合法
        $data = DB:: table('dispatchlist as t1')
        ->select('t1.cDLCode')
        // ->where('t1.cDLCode','=',$dispatch_no)->get();
        // ->where('t1.cDLCode','like','%'.$dispatch_no.'%')->get();
        ->where('t1.cDLCode','like','%'.$searchKey.'%')->get();

// $results = DB::select('select no from zzz_sweep_outs P left join zzz_sweep_out_items Z on P.id=z.parent_id  where z.dispatch_no = :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);
// Model::where('field_name','like','%'.$keywords.'%')->get()
// $data = DB::select('select cDLCode from dispatchlist where cdlcode like ?', ['%'$dispatch_no'%']);


         $data1 = DB:: table('zzz_sweep_checks as t2')
        ->select('t2.dispatch_no')
        ->where('t2.dispatch_no','like','%'.$searchKey.'%')->get();

        if(count($data) == 0){
            echo json_encode(array("status"=>"0","text"=>"发货单号'$searchKey'不存在！"));
            exit();
        }
        else{
         echo json_encode(array("status"=>"1"));
     }
     
 }

     public function dispatchss_data(Request $request){
        $dispatch_no = $request->dispatch_no;
        // 1.验证是否重复扫描
        $data = DB:: table('zzz_sweep_checks as t1')
        ->select('t1.dispatch_no')
        ->where('t1.dispatch_no','like','%'.$dispatch_no.'%')->get();

        if(count($data) > 0){
            echo json_encode(array("status"=>"1","text"=>"发货单'$dispatch_no'已对货，请勿再次扫描！"));
            exit();
        }
        else{
         echo json_encode(array("status"=>"0"));
     }
 }
 public function result_data(Request $request){
      //
    $result = $request->result;
    $dispatch_no = $request->dispatch_no;
    // $searchKey = $request->input('searchKey');
        // array('t1.cinvcode' => $result, 't1.cdlcode'=>$dispatch_no); 
   //  $data = DB:: table('dispatchlists as t1')
   //  ->select('t1.cInvCode', 't2.cDLCode','t3.cinvdefine5')
   //  ->leftJoin('DispatchList as t2','t1.DLID','=','t2.DLID')
   //  ->leftJoin('inventory as t3','t3.cInvCode','=','t1.cInvCode')
   //  ->where(array('t1.cInvCode' => $result, 't2.cDLCode'=>$dispatch_no)) 
   //  ->orwhere('t3.cinvdefine5','=',$result) 
   //  ->get();
   // $data= DB::select('select no from zzz_sweep_outs P left join zzz_sweep_out_items Z on P.id=z.parent_id  where z.dispatch_no = :dispatch_no', ['dispatch_no' => $data['dispatch_no']]);

         $data= DB::select('select t1.cInvCode,t2.cDLCode,t3.cinvdefine5 from dispatchlists as t1 left Join DispatchList as t2 on t1.DLID=t2.DLID left Join inventory as t3 on t3.cInvCode=t1.cInvCode where  t2.cDLCode=? and (t1.cInvCode =? or t3.cinvdefine5= ?)', [$dispatch_no,$result,$result]);

    if(count($data) == 0){
        echo json_encode(array("status"=>"0"));
        exit();
    }
    else{
     echo json_encode(array("status"=>"1",'cInvCode'=>$data[0]->cInvCode));
 }

}


public function store(Request $request)
{
    $sweep_check=\DB::transaction(function() use ($request){
            //创建一张新的扫码对货单
     $dispatch_no = $request->dispatch_no;
     $checker=$request->checker;
     $ddate=date('Y-m-d H:i:s',time());

     // dd($checker);
        // 1.判断发货单号是否合法
     $pd = DB:: table('zzz_sweep_checks as t1')
     ->select('t1.dispatch_no')
     ->where('t1.dispatch_no','=',$dispatch_no)->get();

     if(count($pd) > 0){
        echo json_encode(array("status"=>"0","text"=>"发货单'$dispatch_no'已对货，不允许重复保存！"));
        exit();
    }
    // insert into  BS_GN_wlstate (cpersoncode,cdlcode,jh,hd,db,ck,zc,snno,wlno,ddate) values (@cpersoncode,@cdlcode,NULL,'对货',NULL,NULL,NULL,'',NULL,@ddate)

   DB::insert('insert into  BS_GN_wlstate (cpersoncode,cdlcode,hd,ddate) values (?,?,?,?)', [$checker,$dispatch_no,'对货',$ddate]);

            // $jg = SweepCheck::where('dispatch_no','=',$datas['dispatch_no'])->get();

            //     if(count($jg)>0){
            //         echo json_encode(array('status'=>0,'text'=>'发货单号'.$jg[0]->dispatch_no.'，系统已经存在，不允许重复创建！'));
            //         exit();
            //     }
    $sweep_check = new SweepCheck([
        'dispatch_no'=>$request->input('dispatch_no'),
        'ccusname'=>$request->input('ccusname'),
        'ddate'=>$request->input('ddate'),
        'position'=>$request->input('position'),
        'zdzz'=>$request->input('zdzz'),
        'lszz'=>$request->input('lszz'),
        'cz'=>$request->input('cz'),
        'cy'=>$request->input('cy'),
        'CTNS'=>$request->input('CTNS'),
        'checker'=>$request->input('checker'),
        'user_no'=>Auth::id(),
                // 'entry_id'=>'1'
    ]);

    $sweep_check->save();

            //创建一张新的项目清单
    $sweep_check_items = $request->input('items');
    $i=1;

    foreach($sweep_check_items as $data){
                //先检查发货单号是否重复


        $sweep_check_item = $sweep_check->sweep_check_items()->make([
            'entry_id'=>$i,
            'cWhName'=> $data['cWhName'],
            'cInvCode'=> $data['cInvCode'],
            'cInvName'=> $data['cInvName'],
            'cInvStd'=> $data['cInvStd'],
            'cComUnitName'=> $data['cComUnitName'],
            'cinvDefine13'=> $data['cinvDefine13'],
            'iinvweight'=> $data['iinvweight'],
            
            'iNum'=> $data['iNum'],
            'iQuantity'=> $data['iQuantity'],
            'yQuantity'=> $data['yQuantity'],
            'zb'=> $data['zb']
        ]);

        $sweep_check_item->save();

        $i++;
    }

            // 更新
            // $sweep_check->update(['count' => ($i-1)]);

    return $sweep_check;
});

    return $sweep_check;
}
}
