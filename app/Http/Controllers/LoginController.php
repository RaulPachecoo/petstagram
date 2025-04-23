<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login'); 
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'email' => 'required|email', 
            'password' => 'required'
        ]);

        // Intentar autenticación
        if (!Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('mensaje', 'Credenciales Incorrectas'); 
        }

        // Si la autenticación es exitosa, redirigir al usuario
        return redirect()->route('home'); 
    }
}
