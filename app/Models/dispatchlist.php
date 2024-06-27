<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dispatchlist extends Model
{
    public $table='dispatchlist';
    protected $fillable = [
        'cVerifier','cChanger','dverifydate','dverifysystime'
    ];


}
