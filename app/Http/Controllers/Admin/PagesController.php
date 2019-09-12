<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;

class PagesController extends CommonsController
{
    public function root()
    {
        return view('admins.pages.root');
    }
}
