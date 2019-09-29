<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerLocation extends Model
{
    public $table='zzz_customer_locations';
    protected $fillable = [
        'customer_no','location_id','create_id','note','status'
    ];


}
