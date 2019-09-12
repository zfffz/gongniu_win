<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public $table='zzz_cars';
    protected $fillable = [
        'no','model','create_id','note','status'
    ];
}
