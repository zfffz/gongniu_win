<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleCode extends Model
{
    public $table='zzz_DMS_FC_code';
    protected $fillable = [
        'cxno','fccode','create_id','status','edit_id'
    ];


}
