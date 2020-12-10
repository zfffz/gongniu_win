<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
class ReportExport implements FromArray, WithHeadings, WithEvents
{
   
    // public function array(): array
    // {
    //     return [
    //         'dispatch_no',
    //         'location_no',
    //         'packager_name',
    //         'car_no',
    //         'driver_name',
    //         'out_created_at',
    //         'car_created_at',
    //     ];
    // }

      private $data;
 
    public function __construct (array $data)
    {
        $this->data = $data;
    }
 
    public function array() : array
    {
        return $this->data;
    }
    // 列名
    public function headings() : array
    {
        return [
            '发货单号',
            '客户名称',
            '库位',
            '打包员',  
            '车牌号',
            '司机',
            '打包时间',
            '装车时间'
        ];
    }
 
    public function registerEvents() : array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(38);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(22);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(22);           
            }
        ];
    }

}