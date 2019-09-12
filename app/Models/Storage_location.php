<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage_location extends Model
{
    public $table='zzz_storage_locations';
    protected $fillable = [
        'no','name','create_id','note','status'
    ];
}
