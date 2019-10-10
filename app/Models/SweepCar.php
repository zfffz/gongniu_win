<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SweepCar extends Model
{
    public $table='zzz_sweep_cars';
    protected $fillable = [
        'car_id','driver_id','user_no','count',
    ];

    public function sweep_car_items()
    {
        return $this->hasMany(Sweep_car_item::class,'parent_id','id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class,'car_id','id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id','id');
    }
}
