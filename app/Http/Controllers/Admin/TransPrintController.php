<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
//use App\Models\WayPrint;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use App\Jobs\updateSweepOut;

class TransPrintController extends CommonsController
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
        return view('admins.transPrint.index',compact('drivers'));
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
			a.ccode,convert(varchar(10),a.billdate,120) as billdate,w.cWhName,a.cdriver,b.cSCName 
            "))
			->Join('ShippingChoice as b','a.csccode','b.cSCCode')
            ->leftJoin('warehouse as w','w.cWhCode','a.cOWhCode')
			->where('a.id','=',$id)->get();
			;




 $body=DB::select("select 
            ROW_NUMBER() OVER(ORDER BY t2.csocode) ROWNU,t2.csocode,CONVERT(varchar(100), t3.dTVDate, 23) as dTVDate  ,t3.cDefine2,t3.cDefine3,P.cPersonName, sum(t2.cdefine27) as amount,''as bz
             from [hy_eo_transport] as [t1] inner join 
             [hy_eo_transports] as [t2] on [t1].[id] = [t2].[id] inner join
              TransVouch as [t3] on [t3].[ctvcode] = [t2].[csocode] inner join
              Person as P ON P.cPersonCode=T3.cPersonCode  where [t1].[id] = ?
 group by t2.csocode,t3.dTVDate,t3.cDefine2,t3.cDefine3,P.cPersonName",[$id]);


   //      $body = \DB::table('hy_eo_transport as t1')
   //          ->select(
   //              \DB::raw("
			// ROW_NUMBER() OVER(ORDER BY t2.csocode) ROWNU,t2.csocode,t3.ddate,t3.csocode as csdcode,t3.cshipaddress,t3.ccuscode,t3.ccusabbname,t5.cSSName, sum(t2.cdefine27) as amount,''as bz
   //          "))
			// ->Join('hy_eo_transports as t2', 't1.id','t2.id')
			// ->Join('Sales_FHD_H as t3' ,'t3.cdlcode' , 't2.csocode')
			// ->Join('Sales_FHD_T as t4' , 't4.dlid' , 't3.dlid')
			// ->leftJoin('SettleStyle as t5' , 't5.cSSCode' , 't4.csscode')
			// ->where('t1.id','=',$id)
			// ->groupBy('t2.csocode','t3.ddate','t3.csocode','t3.ccuscode','t3.ccusabbname','t5.cSSName','t3.cshipaddress')
			// ->get();

        $data[0] = $head[0];
        $count = count($body);
        if ($count>0) { 
            for($i=0;$i<$count;$i++){
            	$data[1][$i] = $body[$i];
            }
        }
// dd($data);
        return view('admins.transPrint.print',compact('data'));
    }






  //更新发货单打印次数和打印状态
    public function updPrintstatus(Request $request)
    {
      // dd(1);
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
                        'FCreateTime'=>date('Y-m-d H:i:s', time()),
                        'FCreateUserID'=>$request->user()->id
                    ]
                );
                 // $cprintier= Auth::user()->name;
                  $jg18=DB::table('zzz_print_tj')->insert(
                    [
                        'FBillNo'=>$data['cdlcode'],
                        'FCreateTime'=>date('Y-m-d H:i:s', time()),
                        'FCreateUserID'=>$request->user()->id,
                        'FCreateUserName'=>$request->user()->name

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
                        'lastPrintTime'=>date('Y-m-d H:i:s', time()),
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
        $eddate = date("Y-m-d",strtotime("+1day",strtotime($bedate[1])));
        $table->where('t1.cvouchtype','=','调拨运输清单');
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
