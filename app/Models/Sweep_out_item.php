<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sweep_out_item extends Model
{
    public $table='zzz_sweep_out_items';
    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'entry_id',
        'dispatch_no',
        'location_no',
    ];

    public function sweep_out()
    {
        return $this->belongsTo(SweepOut::class,'id','parent_id');
    }
}
