<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
// use App\Models\TransVouch;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\updateSweepOut;



use Illuminate\Support\Facades\Input;

class SignBackController extends CommonsController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  dd(1);

 if (! Auth::user()->can('signback_users')) {
     return view('admins.pages.permission_denied');

        }

        return view('admins.signBack.index');
   
    }



    public function destroy(Request $request)
    {
        if (! Auth::user()->can('signback_users')) {
            return view('admins.pages.permission_denied');
       
               }
                $ccode=$request->ccodeKey;
                $csocode=$request->csocodeKey;
                // dd($ccode);
            //    $csocodeKey = $request->input('csocodeKey');
            //    $ccodeKey = $request->input('ccodeKey');

        // 删除前先判断一下有没有生成发货装车单
        // dd($sweepOut->id);
        $sqlvalue =  DB::select("exec z_zf_signbackdelete ?,?,?",
        [$ccode,$csocode,'']);
//    dd(count($sqlvalue));

    if(count($sqlvalue)>0){
         $revalue = json_encode(array('status'=>0,'text'=>$sqlvalue[0]->billno,'title'=>'删行成功！'));
    }else{
        $revalue = json_encode(array('status'=>1,'text'=>$sqlvalue[0]->billno,'title'=>'删行失败！'));
    }
    return $revalue;
    }

   
    public function store(Request $request)
    {
        if (! Auth::user()->can('signback_users')) {
            return view('admins.pages.permission_denied');
       
               }
//  dd($request[0]);
        $searchKey = $request[0];
        // $dis=(substr($searchKey,0,4));
    
     
        $uname = $request->user()->name;

        $sqlvalue =  DB::select("exec z_zf_signback ?,?,?",
            [$searchKey,$uname,'']);
//    dd(count($sqlvalue));

        if(count($sqlvalue)>0){
             $revalue = json_encode(array('status'=>0,'text'=>$sqlvalue[0]->billno,'title'=>'签回成功！'));
        }else{
            $revalue = json_encode(array('status'=>1,'text'=>$sqlvalue[0]->billno,'title'=>'签回失败！'));
        }

        //dd($revalue);
        return $revalue;
    }



    public function dispatch_data(Request $request){
        if (! Auth::user()->can('signback_users')) {
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
        if (! Auth::user()->can('signback_users')) {
            return view('admins.pages.permission_denied');
       
               }
                // dd($request);
            $searchKey = $request->ccodeKey;
            // $column = $request->input('order.0.dir'); // 获取排序的列索引
            // dd($column);
            // $dis=(substr($searchKey,0,4));
            
            // if ($dis!='FHYD') {
            //  $tou='FHYD000';
            //  $searchKey =$tou . $searchKey;
            //    };
        $dis=(substr($searchKey,0,4));
            // dd($dis);
            if ($dis=='FHYD') {
               $builder = \DB::table('hy_eo_transport as t1')
               ->select(
                   \DB::raw("
               ROW_NUMBER() OVER(ORDER BY max(t4.ccusabbname)) ROWNU,t1.ccode,max(t2.autoid) as autoid,t2.csocode,t4.ccusabbname,0 as issign"))
               ->Join('hy_eo_transports as t2', 't1.id','t2.id')
               ->Join('dispatchlist as t3' ,'t3.cdlcode' , 't2.csocode')
               ->Join('customer as t4' ,'t4.ccuscode' , 't3.ccuscode')
            //    ->Join('transvouch as t4' ,'t4.ctvcode' , 't2.csocode')
               ->where('t1.ccode','=', $searchKey)
               ->whereNull('t1.ccheckbacker')
               ->whereNull('t1.verify')              
               ->groupBy('t1.ccode','t2.csocode','t4.ccusabbname');
            }
            else if ($dis=='DBYD') {
                $builder = \DB::table('hy_eo_transport as t1')
                ->select(
                    \DB::raw("
                ROW_NUMBER() OVER(ORDER BY max(t1.cdefine3)) ROWNU,t1.ccode,max(t2.autoid) as autoid,t2.csocode,t1.cdefine3 as ccusabbname,0 as issign"))
                ->Join('hy_eo_transports as t2', 't1.id','t2.id')
               
                ->where('t1.ccode','=', $searchKey)
                ->whereNull('t1.ccheckbacker')
                ->whereNull('t1.verify')              
                ->groupBy('t1.ccode','t2.csocode','t1.cdefine3');
             }
             else{
                //以下只是为了刚进去查询报表不报错
                $builder = \DB::table('hy_eo_transport as t1')
                ->select(
                    \DB::raw("
                ROW_NUMBER() OVER(ORDER BY max(t1.cdefine3)) ROWNU,t1.ccode,max(t2.autoid) as autoid,t2.csocode,t1.cdefine3 as ccusabbname,0 as issign"))
                ->Join('hy_eo_transports as t2', 't1.id','t2.id')
                ->where('t1.ccode','=', '11')
                ->whereNull('t1.ccheckbacker')
                ->whereNull('t1.verify')              
                ->groupBy('t1.ccode','t2.csocode','t1.cdefine3');
             }
           
           
   

        $data=parent::dataPage10($request,$this->condition($builder,$request),'asc');

        return $data;
    
    }
    public function getData1(Request $request)
    {           
         $ccode = $request->ccode;
           //取司机名字
           $data= DB::select('select t1.cdriver from hy_eo_transport as t1  where  t1.cCode=?', [$ccode]);
           //  $extraField = 'value'; // 替换为你想传递的具体值或逻辑
        //    dd($data);
            // $data['cdriver'] = $data1[0]->cdriver;
           //  return view('your.view.name', $data);

           echo json_encode(array('status'=>1,'cdriver'=>$data[0]->cdriver));

  }
    public function csocode_data(Request $request){
        //
        // dd(12);
      $csocode = $request->csocode;
      
       $dis=(substr($csocode,0,4));     
    //   if ($dis!='XSFH') {
    //   $tou='XSFH0';
    //   $csocode =$tou . $csocode;
    //      }
    //   else{
   
    //   }
        //   dd($csocode);
      $ccode = $request->ccode;
    //   dd($ccode);
      $ydh=(substr($ccode,0,4));     
      if ($ydh == 'FHYD') {
        if($dis!='XSFH'){
      $to='XSFH0';
      $csocode =$to . $csocode; }
               
         }
      else if($ydh == 'DBYD'){
        if($dis!='CKDB'){
        $to='CKDB000';
        $csocode =$to . $csocode;}
   
      }
    
           $dis=(substr($csocode,0,4));     
           if ($dis=='XSFH') {
           $data= DB::select('select t1.csocode,t3.cDLCode from hy_eo_transports as t1 left Join hy_eo_transport as t2 on t1.ID=t2.ID left Join dispatchlist as t3 on t3.cdlcode=t1.csocode where  t2.ccode=? and t3.cdlcode= ?', [$ccode,$csocode]);
           }
           else if ($dis=='CKDB') {
            $data= DB::select('select t1.csocode,t3.cTVCode from hy_eo_transports as t1 left Join hy_eo_transport as t2 on t1.ID=t2.ID left Join TRANSVOUCH as t3 on t3.cTVcode=t1.csocode where  t2.ccode=? and t3.cTVcode= ?', [$ccode,$csocode]);
            }
            else{
                $data= DB::select('select t1.csocode from hy_eo_transports  as t1 where 1=0');
            }
    //    dd(count($data));
      if(count($data) == 0){
          echo json_encode(array("status"=>"0"));
          exit();
      }
      else{
       echo json_encode(array("status"=>"1",'csocode'=>$data[0]->csocode));
   }
  
  }

    private function condition($table,$searchKey){

        // $bedate = explode(" - ",$searchKey->dateKey);
        // $bgdate = $bedate[0];
        // $eddate = date("Y-m-d",strtotime("+1day",strtotime($bedate[1])));
        //dd($searchKey);
        if($searchKey!=''){
            // if ($searchKey->caridKey!=null || $searchKey->caridKey!=''){
                // $table->where('t1.cowhcode','=',$searchKey->houseoutKey);
                // $table->where('t1.created_at','>=',$bgdate);
                // $table->where('t1.created_at','<',$eddate);
                // $table->where('t4.cpersoncode','=',$searchKey->driveridKey);
                // $table->where('t1.ccode','=',$searchKey->ccodeKey);
                // $table->groupBy('t2.csocode','t3.ccuscode','t3.ccusabbname');
                // ('t1.ccode','=',$searchKey->ccodeKey);
                // $table->where('t1.status','<>','2');
            // }
            // else{
            //     $table->where('t1.created_at','>=',$bgdate);
            //     $table->where('t1.created_at','<',$eddate);
            //     $table->where('t1.status','=',$searchKey->statusKey);
            // }


        }

        return $table;
    }




}



