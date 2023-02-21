<?php

namespace App\Http\Controllers;

use App\Models\User;

class LoginController extends Controller
{
    	public function index()
    		{
        		return view('login/index');

    		}
}
