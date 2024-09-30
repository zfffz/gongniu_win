<?php

namespace App\Http\Requests;

class VehicleCodeRequest extends Request
{
    public function rules()
    {
        $vehicleCode =$this->route ('vehicleCode');
        $id=isset($vehicleCode->id)?$vehicleCode->id:$vehicleCode;
        return [
            'cxno' => 'unique:zzz_DMS_FC_code,cxno,' . $id,
        ];
    }

    public function messages()
    {
        return [
            'cxno.unique' => '该客户已维护，不允许重复',
        ];
    }
}
