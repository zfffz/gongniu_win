<?php

namespace App\Http\Requests;

class StorageLocationRequest extends Request
{
    public function rules()
    {
        $storage_location =$this->route ('storageLocation');
        $id=isset($storage_location->id)?$storage_location->id:$storage_location;
        return [
            'no' => 'max:10|unique:zzz_storage_locations,no,' . $id,
        ];
    }

    //self define message
    public function messages()
    {
        return [
            'no.max' => '仓库编码不允许超过10个字符。',
            'no.unique' => '仓库编码已存在，不允许重复',
        ];
    }
}
