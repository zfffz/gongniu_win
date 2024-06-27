<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sweep_check_item1 extends Model
{
 public $table='zzz_sweep_check_items1';
 public $timestamps = false;

 protected $fillable = [
 	 'parent_id',
    'entry_id',
    
    'cInvName',
    
    'iQuantity',
    
    'zb',

];

public function sweep_check1()
{
    return $this->belongsTo(SweepCheck1::class,'id','parent_id');
}
}
