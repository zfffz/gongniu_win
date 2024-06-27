<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends Request
{
    public function rules()
    {
        $driver =$this->route ('driver');
        $id=isset($driver->id)?$driver->id:$driver;
        return [
            'name' => 'max:10|unique:zzz_drivers,name,' . $id,
        ];
    }

    //self define message
    public function messages()
    {
        return [
            'name.max' => '车牌号不允许超过10个字符。',
            'name.unique' => '车牌号已存在，不允许重复',
        ];
    }
}
