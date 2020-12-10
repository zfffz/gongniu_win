<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

// class UsersController extends Controller 
// {
   
// }



class UsersController extends CommonsController
{
	 public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

	 public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
