<?php

namespace App\Http\Requests;

class CustomerLocationRequest extends Request
{
    public function rules()
    {
        $customerLocation =$this->route ('customerLocation');
        $id=isset($customerLocation->id)?$customerLocation->id:$customerLocation;
        return [
            'customer_no' => 'unique:zzz_customer_locations,customer_no,' . $id,
        ];
    }

    public function messages()
    {
        return [
            'customer_no.unique' => '该客户已维护，不允许重复',
        ];
    }
}
