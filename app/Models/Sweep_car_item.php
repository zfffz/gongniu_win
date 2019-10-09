<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sweep_car_item extends Model
{
    public $table='zzz_sweep_car_items';
    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'entry_id',
        'dispatch_no',
    ];

    public function sweep_out()
    {
        return $this->belongsTo(SweepCar::class,'id','parent_id');
    }
}
