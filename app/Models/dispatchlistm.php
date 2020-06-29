<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dispatchlistm extends Model
{
    public function Sweep_check_item()
    {
        return $this->hasOne('App\Models\Sweep_check_item');
    }
}