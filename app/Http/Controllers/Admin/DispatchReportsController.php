<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class DispatchReportsController extends CommonsController
{
    public function index()
    {
         if (! Auth::user()->can('dispatchreports_users')) {
            return view('admins.pages.permission_denied');
        }
 
      //库位
    // $packagers = DB::table('bs_gn_wl')
    //         ->select('cpersoncode as no','cpersonname as name')
    //         ->where('wlcode','=','03')
    //         ->get();
    //         dd(1);

        // return view('dispatchReports.index',compact('location_no','$data'));
        return view('admins.dispatchReports.index');
    }
   

    public function getData(Request $request)
    {
        // dd(1);
        $builder = \DB::table('zzz_sweep_outs as t1')
            ->select(
                \DB::raw("
            ROW_NUMBER() OVER(ORDER BY t1.id ) ROWNU,
            t2.dispatch_no,
            convert(char(10),t8.dDate,120) as dDate,
            t1.location_no,
            t5.cCusAbbName,
            t8.cShipAddress,
            t2.default_location_no,
            case t2.status when 0 then '未装车' else '已装车' end  as status    
            "))
            ->leftJoin('zzz_sweep_out_items as t2','t1.id','t2.parent_id')
            ->leftJoin('dispatchlist as t8','t8.cdlcode','t2.dispatch_no') 
            ->leftJoin('customer as t5','t5.ccuscode','t8.ccuscode');
            // ->leftJoin('zzz_storage_locations as t6','t6.no','t1.location_no');
            // ->leftJoin('zzz_sweep_car_items as t3','t2.dispatch_no','t3.dispatch_no')
            // ->leftJoin('zzz_sweep_cars as t4','t3.parent_id','t4.id')
            // ->leftJoin('person as t5','t1.packager_no','t5.cpersoncode')
            // ->leftJoin('zzz_cars as t6','t4.car_id','t6.id')
            // ->leftJoin('person as t7','t4.driver_id','t7.cpersoncode')
            // ->Where('t2.status','=','0');
       
            

        $data=parent::dataPage($request,$this->condition($builder,$request),'asc');
    

    

        return $data;
    }

    private function condition($table,$searchKey){



       $bedate = explode(" - ",$searchKey->dateKey);
        $bgdate = $bedate[0];
        $eddate = $bedate[1];
        // dd($searchKey);
        if($searchKey!=''){

               $table->where('t8.dDate','>=',$bgdate);
               $table->where('t8.dDate','<=',$eddate);

            if($searchKey->dispatch_no!='' || $searchKey->dispatch_no!=null ){
                $table->where('t2.dispatch_no','=',$searchKey->dispatch_no);
            }

            if($searchKey->location_no!='' || $searchKey->location_no!=null ){
                $table->where('t1.location_no','=',$searchKey->location_no);
            }

            if($searchKey->status!='' || $searchKey->status!=null ){
                $table->where('t2.status','=',$searchKey->status);
            }

            // if($searchKey->cWhCodeKey!='' || $searchKey->cWhCodeKey!=null ){
            //     $table->where('t1.cWhCode','=',$searchKey->cWhCodeKey);
            // }

            // if($searchKey->status =='1' ){
            //     $table->where('t1.iPrintCount ','>=','1');
            // }

            // if($searchKey->status =='0' ){
            //     $table->where(function($query){
            //         $query->whereNull('t1.iPrintCount ')
            //               ->orwhere('t1.iPrintCount','=','0');
            //     });

            // }

        }

        return $table;







        // if($searchKey!=''){
        //     $table->where('t2.dispatch_no','like','%'.$searchKey.'%');
        //     $table->orWhere('t2.default_location_no','like','%'.$searchKey.'%');
        //     // $table->andWhere('t7.wlcode','=','04');
        //     // $table->andWhere('t2.status','=','0');
        // }
        // return $table;
    }

     private function condition1($table,$searchKey){
        if($searchKey!=''){
            $table->where('t1.cdlcode','like','%'.$searchKey.'%');
            $table->orWhere('t1.location_no','like','%'.$searchKey.'%');
        }
        return $table;
    }

     public function export(Request $request) 
    {

        //return Excel::download(new CunliangExport, 'invoices.xlsx');



  // $dispatch_no = $request->dispatch_no;
  // dd($dispatch_no);
    // if($request!=''){
 $bedate = explode(" - ",$request->dateKey);
        $bgdate = $bedate[0];
        $eddate = $bedate[1];
    //            $data->where('t8.dDate','>=',$bgdate);
    //            $data->where('t8.dDate','<=',$eddate);

            // if($request->dispatch_no!='' || $request->dispatch_no!=null ){
                $dispatch_no= $request->dispatch_no;
            // }

            // if($request->location_no!='' || $request->location_no!=null ){
                $location_no= $request->location_no;
            // }

            // if($request->status!='' || $request->status!=null ){
                 $status= $request->status;
            // }

        // }

        $data = \DB::table('zzz_sweep_outs as t1')
            ->select(
                \DB::raw("
            ROW_NUMBER() OVER(ORDER BY t1.id ) ROWNU,
            t2.dispatch_no,
            convert(char(10),t8.dDate,120) as dDate,
            t1.location_no,
            t5.cCusAbbName,
            t8.cShipAddress,
            t2.default_location_no,
            case t2.status when 0 then '未装车' else '已装车' end  as status    
            "))
            ->leftJoin('zzz_sweep_out_items as t2','t1.id','t2.parent_id')
            ->leftJoin('dispatchlist as t8','t8.cdlcode','t2.dispatch_no') 
            ->leftJoin('customer as t5','t5.ccuscode','t8.ccuscode')
                 ->where(function($query)use($dispatch_no){
    # 进行判断
    if ($dispatch_no!='' || $dispatch_no!=null) {
        $query->where('t2.dispatch_no','Like',"%$dispatch_no%");
    }
})
                 ->where(function($query)use($location_no){
    # 进行判断
    if ($location_no!='' || $location_no!=null ) {
        $query->where('t1.location_no','=',"$location_no");
    }
})
                 ->where(function($query)use($status){
    # 进行判断
    if ($status!='' || $status!=null ) {
        $query->where('t2.status','=',"$status");
    }
})
                          ->where(function($query)use($bgdate){
    # 进行判断
    if ($bgdate!='' || $bgdate!=null ) {
        $query->where('t8.dDate','>=',$bgdate);
    }
})
                            ->where(function($query)use($eddate){
    # 进行判断
    if ($eddate!='' || $eddate!=null ) {
        $query->where('t8.dDate','<=',$eddate);
    }
})

                          
// ->where(function($query)use($username){
//     # 进行判断
//     if (!empty($username)) {
//         $query->where('t1.username','Like',"%$username%");
//     }
// })
// ->where(function($query)use($hospital_id){
//     # 进行判断
//     if (!empty($hospital_id)) {
//         $query->where('t1.hospital_id','=',$hospital_id);
//     }
// })








            ->get()->toArray();        
            // dd($data);
        //     $data = array_merge([[
        //     '发货单号',
        //     '库位',
        //     '打包员',
        //     '车牌号',
        //     '司机',
        //     '打包时间',
        //     '装车时间'
        // ]], $result);
        //     // dd($result);

        // return Excel::download(new ReportExport($result), '调查数据.xlsx');
      
// $bedate = explode(" - ",$request->dateKey);
//         $bgdate = $bedate[0];
//         $eddate = $bedate[1];
    
 

// $data->get()->toArray();  

 // dd($data);
         // $data = [[1,2,3],[1,2,3]];
      
         $new_file_name = '打包装车记录'.date('Ymd').'.xlsx';
            
        Excel::store(new ReportExport($data), $new_file_name);

        // $res['data'] = route('download', ['file' => $download_file_name]);
        // return $res;

        $res['data'] = route('download', ['file' => $new_file_name]);
return $res;
//         $response =array(
// 'success' => true,
// 'url'=> route('download_file')
//         );
//         header('Content-type: application/json');
//         echo json_encode($response);


        // return Excel::create('数据更新', function($excel) use ($data) {
        //     $excel->sheet('数据更新', function($sheet) use ($data)
        //     {
        //         $sheet->cell('A1', function($cell) {$cell->setValue('dispatch_no');   }); 
        //         dd($sheet);              
        //         $sheet->cell('B1', function($cell) {$cell->setValue('location_no');   });                
        //         $sheet->cell('C1', function($cell) {$cell->setValue('packager_name');   });                
        //         $sheet->cell('D1', function($cell) {$cell->setValue('car_no');   });                
        //         $sheet->cell('E1', function($cell) {$cell->setValue('driver_name');   });                
        //         $sheet->cell('F1', function($cell) {$cell->setValue('out_created_at');   });  
        //          $sheet->cell('G1', function($cell) {$cell->setValue('car_created_at');   });               
        //         if (!empty($data)) {                    
        //         foreach ($data as $key => $value) {                        
        //         $i= $key+2;                        
        //         $sheet->cell('A'.$i, $value['dispatch_no']);                        
        //         $sheet->cell('B'.$i, $value['location_no']);                        
        //         $sheet->cell('C'.$i, $value['packager_name']);                        
        //         $sheet->cell('D'.$i, $value['car_no']);                        
        //         $sheet->cell('E'.$i, $value['driver_name']);                        
        //         $sheet->cell('F'.$i, $value['out_created_at']);
        //         $sheet->cell('G'.$i, $value['car_created_at']);
        //             }
        //         }
        //     });
        // })->download('xlsx');
    }


public function DownloadFile ($file_name) {
    // dd(1);
    // $file =null;
    $file = storage_path('app/'.$file_name);
    // dd($file);
    return response()->download($file);
}


// public function DownloadFile ($file_name) {

//     $download_file_name = '打包装车记录test'.date('Ymd').'.xlsx';
//     // dd(1);
//     $file = public_path('storage\app\\'.$file_name.'.xls');
//     return response()->download($file);
// }


}
