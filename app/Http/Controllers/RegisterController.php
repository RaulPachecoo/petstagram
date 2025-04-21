<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request){

        $request->request->add(['username' => Str::slug($request->username)]); 

        $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:30', 
            'email' => 'required|unique:users|email|max:60', 
            'password' => 'required|min:8|max:30|confirmed'
            
        ]); 

        User::create([
            'name' => $request->name, 
            'username' => $request->username, 
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]); 

        // Autenticar un usuario
        Auth::attempt($request->only('email', 'password')); 

        // Redireccionar al usuario
        return redirect()->route('posts.index', Auth::user()->username); 
    }
}
