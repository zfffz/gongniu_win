<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Return_house_item extends Model
{
    public $table='zzz_return_house_items';
    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'entry_id',
        'dispatch_no',
        'default_location_no',
        'location_no',
    ];

    public function return_house()
    {
        return $this->belongsTo(ReturnHouse::class,'id','parent_id');
    }
}
