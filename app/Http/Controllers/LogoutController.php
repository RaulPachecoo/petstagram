<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this line

class LogoutController extends Controller
{
    public function store(){
        Auth::logout(); // Change this line
        return redirect()->route('login');
    }
}
