<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public $table='zzz_drivers';
    protected $fillable = [
        'name','mobile','create_id','note','status','edit_id'
    ];
}
