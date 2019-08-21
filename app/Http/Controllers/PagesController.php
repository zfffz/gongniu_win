<?php

namespace App\Http\Controllers;

class PagesController extends CommonsController
{
    public function root()
    {
        return view('pages.root');
    }
}
