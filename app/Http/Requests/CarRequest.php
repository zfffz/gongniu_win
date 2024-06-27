<?php

namespace App\Http\Requests;

class CarRequest extends Request
{
    public function rules()
    {
        $car =$this->route ('car');
        $id=isset($car->id)?$car->id:$car;
        return [
            'no' => 'max:10|unique:zzz_cars,no,' . $id,
        ];
    }

    //self define message
    public function messages()
    {
        return [
            'no.max' => '车牌号不允许超过10个字符。',
            'no.unique' => '车牌号已存在，不允许重复',
        ];
    }
}
