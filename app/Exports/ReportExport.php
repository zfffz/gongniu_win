<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
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
            '序号',
            '发货单号',
            '日期',
            '库位',
            '客户简称',  
            '发货地址',
            '默认库位',
            '状态'
        ];
    }
 
    public function registerEvents() : array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(46);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(46);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(10);           
            }
        ];
    }

}