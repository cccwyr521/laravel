<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function home()
    {
    	// dd(\App\Model\Permissions::getMeuns());
    	
    	return view('admin.home');
    }
}
