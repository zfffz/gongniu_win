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
         if (! Auth::user()->can('waybills_users')) {
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
            "))
            ;

        $data=parent::dataPage($request,$this->condition($builder,$request),'asc');

        return $data;
    }

    public function getPrint($id)
    {

         if (! Auth::user()->can('waybills_users')) {
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







      //更新发货单打印次数和打印状态
    public function updPrintstatusfh(Request $request)
    {
 
            $updccode = $request[0];
      
          //  $time=date('Y-m-d h:i:s', time());
            DB::beginTransaction();
            try{
                //更新发货单打印次数
                $query1 = \DB::table('hy_eo_transport')
                    ->select(
                        \DB::raw("isnull(iPrintCount,0) as iPrintCount
            "))
                    ->where('ccode','=',$updccode)->get();

                $jg1=DB::table('hy_eo_transport')
                    ->where('ccode','=',$updccode)
                    ->update(
                        [
                            'iPrintCount'=>$query1[0]->iPrintCount + 1,
                        ]
                    );

                //插入发货单打印日志zzz_print_diary
                // $jg2=DB::table('zzz_print_diary')->insert(
                //     [
                //         'FBillNo'=>$data['cdlcode'],
                //         'FCreateTime'=>date('Y-m-d H:i:s', time()),
                //         'FCreateUserID'=>$request->user()->id
                //     ]
                // );
                //  // $cprintier= Auth::user()->name;
                //   $jg18=DB::table('zzz_print_tj')->insert(
                //     [
                //         'FBillNo'=>$data['cdlcode'],
                //         'FCreateTime'=>date('Y-m-d H:i:s', time()),
                //         'FCreateUserID'=>$request->user()->id,
                //         'FCreateUserName'=>$request->user()->name

                //     ]
                // );

        $jg4= DB::select('select ISNULL(total,0) from PrintPolicy_VCH where VchID= ?', [$updccode]);
        $jg5= DB::select('select id from hy_eo_transport where ccode=?', [$updccode]);

        // $deleted = DB::delete("delete from zzz_print where cdlcode=?",[$data['cdlcode']]);
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
                        'PolicyID'=>'EO015_131458',
                        'lastPrintTime'=>date('Y-m-d H:i:s', time()),
                        'VchID'=>$updccode,
                        'VchUniqueID'=>$jg5[0]->id,
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
                if (!$jg5) {
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







    private function condition($table,$searchKey){

        $bedate = explode(" - ",$searchKey->dateKey);
        $bgdate = $bedate[0];
        $eddate = date("Y-m-d",strtotime("+1day",strtotime($bedate[1])));
        //dd($searchKey);
        $table->where('t1.cvouchtype','=','发货运输清单');
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
