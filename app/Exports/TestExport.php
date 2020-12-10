<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TestExport implements FromArray
{
    private $id;
    public function __construct($id)
    {
        $this->id = $id;
    }
  
    public function array(): array
    {
        $data = [[$this->id,$this->id,$this->id],[1,2,3],[4,5,6],[7,8,9]];//测试数据
        return $data;
    }
}
