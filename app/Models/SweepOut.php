<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SweepOut extends Model
{
    public $table='zzz_sweep_outs';
    protected $fillable = [
        'packager_no','user_no','count',
    ];

    public function sweep_out_items()
    {
        return $this->hasMany(Sweep_out_item::class,'parent_id','id');
    }
}
