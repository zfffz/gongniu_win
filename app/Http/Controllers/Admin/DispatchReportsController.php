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


        return view('admins.dispatchReports.index');
    }
   

    public function getData(Request $request)
    {
        $builder = \DB::table('zzz_sweep_outs as t1')
            ->select(
                \DB::raw("
            t1.id,
            t2.dispatch_no,
            t8.ccusname,
            t2.default_location_no as location_no,
            t5.cpersonname as packager_name,
            t6.no as car_no,
            t7.cpersonname as driver_name,
            t1.created_at as out_created_at,
            t4.created_at as car_created_at
            "))
            ->leftJoin('zzz_sweep_out_items as t2','t1.id','t2.parent_id')
            ->leftJoin('dispatchlist as t8','t8.cdlcode','t2.dispatch_no')
            ->leftJoin('zzz_sweep_car_items as t3','t2.dispatch_no','t3.dispatch_no')
            ->leftJoin('zzz_sweep_cars as t4','t3.parent_id','t4.id')
            ->leftJoin('person as t5','t1.packager_no','t5.cpersoncode')
            ->leftJoin('zzz_cars as t6','t4.car_id','t6.id')
            ->leftJoin('person as t7','t4.driver_id','t7.cpersoncode')
            ->Where('t2.status','=','0');
            

        $data=parent::dataPage($request,$this->condition($builder,$request->searchKey),'asc');

        return $data;
    }

    private function condition($table,$searchKey){
        if($searchKey!=''){
            $table->where('t2.dispatch_no','like','%'.$searchKey.'%');
            $table->orWhere('t2.default_location_no','like','%'.$searchKey.'%');
            // $table->andWhere('t7.wlcode','=','04');
            // $table->andWhere('t2.status','=','0');
        }
        return $table;
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






        $data = \DB::table('zzz_sweep_outs as t1')
            ->select(
                \DB::raw("
           
            t2.dispatch_no,
            t8.ccusname,
            t2.default_location_no as location_no,
            t5.cpersonname as packager_name,
            t6.no as car_no,
            t7.cpersonname as driver_name,
            t1.created_at as out_created_at,
            t4.created_at as car_created_at
            "))
            ->leftJoin('zzz_sweep_out_items as t2','t1.id','t2.parent_id')
            ->leftJoin('dispatchlist as t8','t8.cdlcode','t2.dispatch_no')
            ->leftJoin('zzz_sweep_car_items as t3','t2.dispatch_no','t3.dispatch_no')
            ->leftJoin('zzz_sweep_cars as t4','t3.parent_id','t4.id')
            ->leftJoin('person as t5','t1.packager_no','t5.cpersoncode')
            ->leftJoin('zzz_cars as t6','t4.car_id','t6.id')
            ->leftJoin('person as t7','t4.driver_id','t7.cpersoncode')
            ->Where('t2.status','=','0')
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
      



         // $data = [[1,2,3],[1,2,3]];
      
         $download_file_name = '已打包未装车'.date('Ymd').'.xlsx';
            
         return Excel::download(new ReportExport($data), $download_file_name);


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

}
