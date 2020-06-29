<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sweep_check_item extends Model
{
 public $table='zzz_sweep_check_items';
 public $timestamps = false;

 protected $fillable = [
    'parent_id',
    'entry_id',
    'cWhName',
    'cInvCode',
    'cInvName',
    'cInvStd',
    'cComUnitName',
    'cinvDefine13',
    'iNum',
    'iQuantity',
    'yQuantity',

];

public function sweep_check()
{
    return $this->belongsTo(SweepCheck::class,'id','parent_id');
}
}
