<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
// use PDO;

class DispatchPrintController extends CommonsController
{
    // public function index()
  
    public function index()
    {
        
         if (! Auth::user()->can('dispatchprint_users')) {
            return view('admins.pages.permission_denied');
        }

        return view('admins.dispatchPrint.index');
    }

    public function getData(Request $request)
    {
 $builder = \DB::table('dispatchlist1 as t1')
            ->select(
                \DB::raw("
            t1.cDLCode, 
            convert(char(10),t1.dDate,120) as dDate,
            t2.cSTName,
            t6.cDepname,
            t1.cCusName,
            t3.cCusAbbName,
            t4.cPsn_Name,
            t1.cMemo,
            t1.cMaker,
            t5.cSCName,
            case isnull(t1.iPrintCount,0) when 0 then '否' else '是' end as status,
            isnull(t1.iPrintCount,0) as iprintCount
            "))
        ->leftJoin('SaleType as t2','t1.cSTCode','t2.cSTCode')
        ->leftJoin('Customer as t3','t1.cCusCode','t3.cCusCode')
        ->leftJoin('Department as t6','t1.cDepCode','t6.cDepCode')
        ->leftjoin('hr_hi_person as t4','t1.cPersonCode','t4.cPsn_Num')
        ->leftjoin('ShippingChoice as t5','t1.cSCCode','t5.cSCCode');
        // ->leftjoin('dispatchlists as t8','t1.DLID','t8.DLID')

        $data=parent::dataPage3($request,$this->condition($builder,$request),'asc');

        return $data;
    }

//打印发货单
    public function getPrint(Request $request)
    {
         if (! Auth::user()->can('dispatchprint_users')) {
            return view('admins.pages.permission_denied');
        }

        $data = explode('|',substr($request['datas'],0,-1));
        $n=0;
        $m=1;
         // dd($data);
        foreach ($data as $cdlcode){


            $head = \DB::table('Sales_FHD_H as a')
                ->select(
                    \DB::raw("
            a.cDLCode,a.cCusCode,a.ccusabbname,a.cmemo,a.cshipaddress,
            a.cpersonname,a.cscname,a.dDate,d.ccontactname,d.cmobilephone,
            d.cofficephone,d.cssname,a.csocode,c.no,
            a.cmaker,a.cverifier,CONVERT(varchar(10), a.dcreatesystime,23) as createtime, a.dverifydate,
            '' as divid, '' as tableid, '' as pageid
            "))
                ->leftJoin('zzz_customer_locations as b','a.cCusCode','b.customer_no')
                ->leftJoin('zzz_storage_locations as c','b.location_id','c.id')
                ->leftJoin('Sales_FHD_T as d','a.cdlcode','d.cdlcode')
                ->where('a.cDLCode','=',$cdlcode)->get();
            ;

            $body = \DB::table('Sales_FHD_H as t1')
                ->select(
    \DB::raw("t2.irowno as ROWNU,t4.cWhName,t2.cInvcode,t2.cInvName,t2.iQuantity, rtrim( Convert(decimal(30,2),t2.iTaxUnitPrice)) as iTaxUnitPrice,rtrim(Convert(decimal(30,2),t2.isum)) as isum,t3.cInvStd,t5.cComUnitName,t3.cInvDefine5
            "))
                ->Join('dispatchlists as t2', 't1.dlid','t2.dlid')
                ->Join('inventory as t3' ,'t3.cInvCode' , 't2.cInvCode')
                ->leftJoin('Warehouse as t4' , 't4.cWhCode' , 't2.cWhCode')
                ->Join('ComputationUnit as t5' , 't5.cComunitCode' , 't3.cComUnitCode')
                ->where('t1.cDLCode','=',$cdlcode)
                ->orderby('t2.autoid')
                ->get();
// dd($body);
            $head[0]->divid = 'div'.$m;  //拼div的id
            $head[0]->tableid ='table'.$m;  //拼table对应的div的id
            $head[0]->pageid ='page'.$m;   //拼页脚id
            $data1=[];
            $data1[0] = $head[0];
            $count = count($body);
            if ($count>0) {
                for($i=0;$i<$count;$i++){
                    $data1[1][$i] = $body[$i];
                }
            }
            $data2[$n][0]=$data1[0];
            $data2[$n][1]=$data1[1];
            $n=$n+1;
            $m=$m+1;
        }
        //echo json_encode(array('status'=>0,'returndata'=>$data2));
        // dd($data2);

        return view('admins.dispatchPrint.print',compact('data2','n'));
        //return redirect()->route('dispatchPrint.printpage');

    }



 //    public function lgetPrint(Request $request)
 //    {
 //        $data = explode('|',substr($request['datas'],0,-1));
 //        $n=0;
 //        $m=1;
 //        $s=0;
 //        // dd($data);
 //        foreach ($data as $cdlcode){

 //                $head = \DB::table('zzz_sweep_checks as a')
 //                ->select(
 //                    \DB::raw("
 //            a.dispatch_no as cDLCode,'' as divid
 //            "))
 //                ->where('a.dispatch_no','=',$cdlcode)->get();

 //                 $body = \DB::table('zzz_sweep_check_items as t1')
 //                ->select(
 //                    \DB::raw("
 //            ROW_NUMBER() OVER(ORDER BY entry_id desc) ROWNU,t1.cinvname as cInvName,t1.iquantity as iQuantity,t1.zb
 //            "))
 //                ->leftJoin('zzz_sweep_checks as t2', 't1.parent_id','t2.id')
 //                ->where('t2.dispatch_no','=',$cdlcode)
 //                ->whereNOTNULL('t1.zb')
 //                ->get();;

 //               $arrayData = \DB::table('zzz_sweep_check_items as t1')
 //               ->select(
 //                    \DB::raw("t1.zb,'' as tableid"))
 //                ->leftJoin('zzz_sweep_checks as t2' ,'t2.id' , 't1.parent_id')
 //                ->where('t2.dispatch_no','=',$cdlcode)
 //                ->whereNOTNULL('t1.zb')
 //                ->groupby('t1.zb')
 //                ->get();

 //                // $count= DB::select('select count(t1.zb) as count from zzz_sweep_check_items as t1 left Join zzz_sweep_checks as t2 on t2.id=t1.parent_id where t2.dispatch_no = ? and t1.zb is not null  group by (t1.zb)', [$cdlcode]);

 //                $count=count($arrayData);

 //            //$head[0]->divid = $m;
 //            $data3[$n] = $head[0];
 //            // $arrayData[0]->tableid 
 //            // dd($count[0]->count);
 //            // dd($head[0]);
 //        $t=1;
 //        $data1=[];  //置空
 //       // $s=$s+($count[0]->count);
 //        //$arrayData[0]->tableid ='table'.$t;
 //        // dd($arrayData[0]->tableid);

 // // dd($arrayData);
 // foreach ($arrayData as $zb){

 //            $zb1=$zb->zb;
 //           // $data3[$n]->divid='div'.$m;
 //            // $head = \DB::table('zzz_sweep_checks as a')
 //            //     ->select(
 //            //         \DB::raw("
 //            // a.dispatch_no as cDLCode,'' as divid
 //            // "))
 //            //     ->where('a.dispatch_no','=',$cdlcode)->get();


 //                $body1 = \DB::table('zzz_sweep_check_items as t1')
 //                ->select(
 //                    \DB::raw("
 //            ROW_NUMBER() OVER(ORDER BY entry_id desc) ROWNU,t1.cinvname as cInvName,t1.iquantity as iQuantity,t1.zb
 //            "))
 //                ->leftJoin('zzz_sweep_checks as t2', 't1.parent_id','t2.id')
 //                ->where('t1.zb','=',$zb1)
 //                ->where('t2.dispatch_no','=',$cdlcode)
 //                ->whereNOTNULL('t1.zb')
 //                ->get();                  

 //            $count = count($body1);

 //            $data1[0]=array('divid'=>'div'.$t);



 //            if ($count>0) {
 //                for($i=0;$i<$count;$i++){
 //                    $data1[$t][$i] = $body1[$i];    //$data1[1] 子表
 //                }

 //            }
 //            //dd($data1);
         
 //            // $head[0]->divid = $m;
 //            // $data1[0] = $head[0];    //$data1[0] 主表
 //            // $data2[$t][0]=$data1[0];  //主表
 //            // $data2[$t][1]=$data1[$t];  //子表
 //         //   $head[0]->divid = $m;
 //         //   $data1[0] = $head[0];    //$data1[0] 主表
 //           // $data2[$n][$t]=$data1[$t][$tableid];  //主表
          
 //             //i是分组下的明细循环
 //             //t是分组循环
 //             //n是发货单循环
 //           $data2[$n]=$data1[0];
 //           $data2[$n][$t+1]=$data1[$t]; 
 //           // print_r($tableid);
 //             $t=$t+1;
 //              // $data5[$t] = $arrayData[$t-1]->tableid ;
 //        }
 

 //        //  $data3[$n][0]=$data2[$n];  //主表

 //        //  $data3[$n][1]=$data2[$n];  //子表
             
 //            $data4[$n][0]=$data3[$n];    //主表
 //            // $data4[$n][1]=$data5[$t-1]; 

 //            $data4[$n][1]=$data2[$n];   //子表


          
     
 //            // $s=$s+1;
 //            $n=$n+1;
 //            $m=$m+1;
 //        }
 //        //echo json_encode(array('status'=>0,'returndata'=>$data2));
 //        dd($data4);
 //        // dd(t);
 //         // dd($s);
       
 //         // dd( $s);
 //        return view('admins.dispatchPrint.lable',compact('data4','s'));
 //        //return redirect()->route('dispatchPrint.printpage');

 //    }
 public function lgetPrint1(Request $request)
    {
         if (! Auth::user()->can('dispatchprint_users')) {
            return view('admins.pages.permission_denied');
        }

        $data = explode('|',substr($request['datas'],0,-1));
        $n=1;
        $s=0;
        $t=1;
        $m=0;
        // dd($data);
        foreach ($data as $cdlcode){

                $head = \DB::table('zzz_sweep_checks as t1')
                ->select(
                    \DB::raw("
            t1.dispatch_no ,t2.zb,'' as divid
            "))
                ->leftJoin('zzz_sweep_check_items as t2', 't2.parent_id','t1.id')
                ->where('t1.dispatch_no','=',$cdlcode)
                ->whereNOTNULL('t2.zb')
                ->groupby('t1.dispatch_no')
                ->groupby('t2.zb')
                ->get();
 if(count($head) == 0){
    // dd('发货单无组别，无法打印');
            echo json_encode(array("status"=>"0"));
             // return view('admins.dispatchPrint.index');
            exit();
        }
    }
}

//正式
        public function lgetPrint(Request $request)
    {
         if (! Auth::user()->can('dispatchprint_users')) {
            return view('admins.pages.permission_denied');
        }

        $data = explode('|',substr($request['datas'],0,-1));
        $n=1;
        $s=0;
        $t=1;
        $m=0;
        // dd($data);
        foreach ($data as $cdlcode){

                $head = \DB::table('zzz_sweep_checks as t1')
                ->select(
                    \DB::raw("
            t1.dispatch_no ,t2.zb,'' as divid
            "))
                ->leftJoin('zzz_sweep_check_items as t2', 't2.parent_id','t1.id')
                ->where('t1.dispatch_no','=',$cdlcode)
                ->whereNOTNULL('t2.zb')
                ->groupby('t1.dispatch_no')
                ->groupby('t2.zb')
                ->get();
 // if(count($head) == 0){
 //    // dd('发货单无组别，无法打印');
 //            // echo json_encode(array("status"=>"0"));
 //             // return view('admins.dispatchPrint.index');
 //            exit();
 //        }
        // if($head[0]->zb=''){
        //      exit();
        //     dd('发货单无组别，无法打印');
        //      echo json_encode(array('status'=>0,'text'=>'发货单无组别，无法打印！'));
        //         exit();

        // }
                // dd($cdlcode);

 foreach ($head as $zb){
         

                $body1 = \DB::table('zzz_sweep_check_items as t1')
                ->select(
                    \DB::raw("
            ROW_NUMBER() OVER(ORDER BY entry_id desc) ROWNU,t1.cinvname as cInvName,t1.iquantity as iQuantity,t1.zb
            "))
                ->leftJoin('zzz_sweep_checks as t2', 't1.parent_id','t2.id')
                ->where('t1.zb','=',$zb->zb)
                ->where('t2.dispatch_no','=',$zb->dispatch_no)
                ->whereNOTNULL('t1.zb')
                ->get();                  

        
            $count=count($body1);
            if ($count>0) {
                for($i=0;$i<$count;$i++){
                    $data1[$t][$i] = $body1[$i];    //$data1[1] 子表
                }

            }

            $zb->divid='div'.$t;

           $data2[$m][0]=$zb;
// if ($n>1) {
// $n=$n-1;
//      }
//             for($t=1;$t<$count;$t++){
           $data2[$m][1]=$data1[$t]; 
           $t=$t+1;
           $m=$m+1;
            
        }
           $n=$n+1;
        }
        //echo json_encode(array('status'=>0,'returndata'=>$data2));
       // dd($data2);
       if(count($head) == 0)
       {
        echo json_encode(array('status'=>0));
        exit();
          // return view('admins.dispatchPrint.index');

       }
       else
       {
        // dd(data2);
// echo json_encode(array('status'=>1));
        return view('admins.dispatchPrint.lable',compact('data2','m'));

        }
       
       
        // return view('admins.dispatchPrint.lable',compact('data2','m'));
        //return redirect()->route('dispatchPrint.printpage');

    }


//    public function printpage(request $request){
//        $data2 = $request->all();
//        return view('admins.dispatchPrint.print',compact('data2'));
//    }


     //打印外箱箱标
    public function outboxPrint(Request $request)
    {
         if (! Auth::user()->can('dispatchprint_users')) {
            return view('admins.pages.permission_denied');
        }

        $data = explode('|',substr($request['datas'],0,-1));
        $n=0;
        $m=1;
        $result = 0;
// dd($data );
foreach ($data as $cdlcode){
// echo json_encode(array('status'=>0));
            $head1 = \DB::table('zzz_sweep_checks as b')
                ->select(
                    \DB::raw("
            b.dispatch_no,
            b.CTNS
            "))
                
                ->where('b.dispatch_no','=',$cdlcode)->get();
            ;
            
        
       //  }
       // else
       //  { echo json_encode(array('status'=>1));}
  
       // {

       //  foreach ($data as $cdlcode){

            $head = \DB::table('Sales_FHD_H as a')
                ->select(
                    \DB::raw("
            a.cDLCode,a.ccusabbname,a.cshipaddress,
            b.CTNS,'' as divid
            "))
                ->Join('zzz_sweep_checks as b','a.cDLCode','b.dispatch_no')
                ->where('a.cDLCode','=',$cdlcode)->get();
            ;
 


// print_r(count($head1));
        if(count($head1) == 0)
       {

        // echo json_encode(array('status'=>0));
        echo json_encode(array('status'=>0));
        // return;
      exit();
       //    // return view('admins.dispatchPrint.index');
 $result = 0;
 // exit();
 // echo json_encode(array('status'=>0));
       }
       else
       {

           //  $zb->divid='div'.$t;
           // $data2[$m][0]=$zb;

           $head[0]->divid = 'div'.$m;

            $data1[$n] = $head[0];
            $n=$n+1;
            $m=$m+1;
             $result1 = 1;
            }
        }
          // dd($result);
       //     if(count($head1) == 0)
       // {

       //  echo json_encode(array('status'=>0));
       //  exit();
       //    // return view('admins.dispatchPrint.index');

       // }
       // else
       // {
      // print_r(count($head1));
           if ($result = 0) {
            echo json_encode(array('status'=>0));
        exit();
        }
        if ($result1 = 1) {
            return view('admins.dispatchPrint.outboxprint',compact('data1','n'));
        }
      
        
        // }

        

    }

   // public function check(Request $request)
   //  {
   //      dd(1);
   //       $check = $request->input('items');
   //        // dd($check);
   //      foreach($check as $da){
       

   //      $data= DB::select('select iPrintCount from dispatchlist where cdlcode=?', [$da['cdlcode']]);
        
   //      if($data[0]>0){
   //          echo json_encode(array("status"=>"0","text"=>"发货单'$data[0]'已打印！"));
   //          exit();
   //      }

   //      }
   //      // dd($query12);
   //     // if ($data[0]>0) {
   //     //       echo json_encode(array("status"=>"1","text"=>"发货单'$data['cdlcode']'已打印！"));
   //     //      exit();
   //     //   }


   //  }

      public function checkprint(Request $request){

         $data = explode('|',substr($request['dispatch_no'],0,-1));
      $n=0;
      // $t=0;
        // dd($data);
        foreach ($data as $cdlcode){
        // dd(1);
        // $cdlcode = $request->dispatch_no;

        //11.20修改检查发货单是否已经审核过，未审核过要求先审核，在打包,以后检查对货可以直接启用
        // $query = DB:: table('zzz_sweep_checks as t1')
        //     ->where('t1.dispatch_no','=',$cdlcode)
        //     ->count();
// dverifydate is NOT NULL and

 $query =  DB::SELECT("select total from PrintPolicy_VCH where VchID=?",[$cdlcode]);
 $n=$n+COUNT($query);
 // $t=$t+1;

}
// dd($query);
// dd($n);
        if($n == 0 ){
            //这张发货单未进行对货
            echo json_encode(array('status'=>1,'text'=>'success！'));
        }else{
            echo json_encode(array('status'=>0,'text'=>'发货单已打印！'));
            // exit();
        }
    }
    //预览打印
   public function checkprint1(Request $request){
// dd(1);
        $updcdlcode = $request->input('items');
         $n=0;
         $t=0;
        foreach($updcdlcode as $data){
     

   // DB::insert('insert into  zzz_print (cpersoncode,cdlcode,hd,ddate) values (?,?,?,?)', [$checkers[0]->no,$dispatch_no,'对货',$ddate]);
   //    // $t=0;
        // dd($data);
        // foreach ($data as $cdlcode){
        // dd(1);
        // $cdlcode = $request->dispatch_no;

        //11.20修改检查发货单是否已经审核过，未审核过要求先审核，在打包,以后检查对货可以直接启用
        // $query = DB:: table('zzz_sweep_checks as t1')
        //     ->where('t1.dispatch_no','=',$cdlcode)
        //     ->count();
// dverifydate is NOT NULL and
// DB::insert('insert into  BS_GN_wlstate (cpersoncode,cdlcode,hd,ddate) values (?,?,?,?)', [$checkers[0]->no,$dispatch_no,'对货',$ddate]);

    // $jg2=DB::table('zzz_print')->insert(
    //                 [
    //                     'cdlcode'=>$data['cdlcode'],
    //                     'CreateTime'=>date('Y-m-d h:i:s', time()),
    //                     'userid'=>$request->user()->id
    //                 ]
    //             );
 $query1 =  DB::SELECT("select cdlcode from zzz_print where cdlcode=?",[$data['cdlcode']]);

 $query =  DB::SELECT("select total from PrintPolicy_VCH where VchID=?",[$data['cdlcode']]);
 $n=$n+COUNT($query);
 $t=$t+COUNT($query1);

}
// dd($query);
// dd($n);
        if($n == 0 ){
            if ($t == 0) {
                 echo json_encode(array('status'=>1,'text'=>'success！'));
            }
            else
          {
            //这张发货单未进行对货
            echo json_encode(array('status'=>0,'text'=>'发货单正在打印中！'));
             exit();
        }
    }
        else{
            echo json_encode(array('status'=>0,'text'=>'发货单已打印！'));
            exit();
        }

    }
        //预览打印
   public function checkprint2(Request $request){
  $updcdlcode = $request->input('items');
  foreach($updcdlcode as $data){
DB::insert('insert into  zzz_print (cdlcode,userid,CreateTime) values (?,?,?)', [$data['cdlcode'],$request->user()->id,date('Y-m-d h:i:s', time())]);
}

      }

        public function checkprint3(Request $request){
  $updcdlcode = $request->input('items');
  foreach($updcdlcode as $data){
$deleted = DB::delete("delete from zzz_print where cdlcode=?",[$data['cdlcode']]);
}

      }
    //更新发货单打印次数和打印状态
    public function updPrintstatus(Request $request)
    {
        $updcdlcode = $request->input('items');
        foreach($updcdlcode as $data){
          //  $time=date('Y-m-d h:i:s', time());
            DB::beginTransaction();
            try{
                //更新发货单打印次数
                $query1 = \DB::table('dispatchlist')
                    ->select(
                        \DB::raw("isnull(iPrintCount,0) as iPrintCount
            "))
                    ->where('cDLCode','=',$data['cdlcode'])->get();

                $jg1=DB::table('DispatchList')
                    ->where('cdlcode','=',$data['cdlcode'])
                    ->update(
                        [
                            'iPrintCount'=>$query1[0]->iPrintCount + 1,
                        ]
                    );

                //插入发货单打印日志zzz_print_diary
                $jg2=DB::table('zzz_print_diary')->insert(
                    [
                        'FBillNo'=>$data['cdlcode'],
                        'FCreateTime'=>date('Y-m-d h:i:s', time()),
                        'FCreateUserID'=>$request->user()->id
                    ]
                );

        $jg4= DB::select('select ISNULL(total,0) from PrintPolicy_VCH where VchID= ?', [$data['cdlcode']]);

        $deleted = DB::delete("delete from zzz_print where cdlcode=?",[$data['cdlcode']]);
// [$dispatch_no,$result,$result]);
        // console.log($jg4);
                // if ($jg4[0]=0) {
                    # code...
               // dd($jg4);

            //     $jg4 = \DB::table('PrintPolicy_VCH')
            //         ->select(
            //             "Total
            // "))
            //         ->where('cDLCode','=',$data['cdlcode'])
                    // $retVal = ($jg4=) ? a : b ;

        if(count($jg4)==0)
        {
                //插入u8打印日志
                $jg3=DB::table('PrintPolicy_VCH')->insert(
                    [
                        'PolicyID'=>'01_131460',
                        'lastPrintTime'=>date('Y-m-d h:i:s', time()),
                        'VchID'=>$data['cdlcode'],
                        'VchUniqueID'=>$data['cdlcode'],
                        'Total'=>'1'
                    ]
                );
 }
 // else if ($jg4[0]>0) {
 //    $jg5=DB::table('PrintPolicy_VCH')
 //                    ->where('cdlcode','=',$data['cdlcode'])
 //                    ->update(
 //                        [
 //                            'iPrintCount'=>$query1[0]->iPrintCount + 1,

 //                        ]
 //                    );
 // }
                if (!$jg1) {
                    throw new \Exception("2");
                }
                if (!$jg2) {
                    throw new \Exception("3");
                }
                // if (!$jg3) {
                //     throw new \Exception("4");
                // }
                DB::commit();
                echo json_encode(array("FTranType"=>1,"FText"=>'打印更新成功！'),JSON_UNESCAPED_UNICODE);
            }catch(\Exception $e){
                DB::rollback();//事务回滚
                echo $e->getMessage();
                echo json_encode(array("FTranType"=>0,"FText"=>'数据异常！'),JSON_UNESCAPED_UNICODE);
            }
            //将打印信息写入日志

        }
    }


    private function condition($table,$searchKey){

       $bedate = explode(" - ",$searchKey->dateKey);
        $bgdate = $bedate[0];
        $eddate = $bedate[1];
        //dd($searchKey);
        $table->where('t1.bReturnFlag','=',0);
        if($searchKey!=''){

               $table->where('t1.dDate','>=',$bgdate);
               $table->where('t1.dDate','<=',$eddate);

            if($searchKey->cSTcodeKey!='' || $searchKey->cSTcodeKey!=null ){
                $table->where('t1.cSTCode','=',$searchKey->cSTcodeKey);
            }

            if($searchKey->cDLCodeKey!='' || $searchKey->cDLCodeKey!=null ){
                $table->where('t1.cDLCode','=',$searchKey->cDLCodeKey);
            }

            if($searchKey->cDepartmentKey!='' || $searchKey->cDepartmentKey!=null ){
                $table->where('t1.cDepCode','=',$searchKey->cDepartmentKey);
            }

            if($searchKey->cWhCodeKey!='' || $searchKey->cWhCodeKey!=null ){
                $table->where('t1.cWhCode','=',$searchKey->cWhCodeKey);
            }

            if($searchKey->status =='1' ){
                $table->where('t1.iPrintCount ','>=','1');
            }

            if($searchKey->status =='0' ){
                $table->where(function($query){
                    $query->whereNull('t1.iPrintCount ')
                          ->orwhere('t1.iPrintCount','=','0');
                });

            }

        }

        return $table;
    }
}

