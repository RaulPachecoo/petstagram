<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('home');
        }
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

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('mensaje', 'Error al autenticar con Google.');
        }

        $user = User::where('email', $googleUser->getEmail())->first();
        if (!$user) {
            // Crear usuario automáticamente si no existe
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Usuario Google',
                'email' => $googleUser->getEmail(),
                'username' => Str::slug(explode('@', $googleUser->getEmail())[0]),
                'password' => Hash::make(Str::random(16)),
            ]);
        }
        Auth::login($user, true);
        // Enviar mensaje de bienvenida desde Petstagram Admin si es un nuevo usuario
        $admin = User::where('email', 'raulpachecoropero555@gmail.com')->first();
        if ($admin && $user->wasRecentlyCreated) {
            \App\Models\Message::create([
                'sender_id' => $admin->id,
                'receiver_id' => $user->id,
                'body' => 'Bienvenido a Petstagram. Si tiene alguna duda sobre este Sitio Web no dude en enviarnos un mensaje',
            ]);
        }
        return redirect()->route('posts.index', $user->username);
    }
}
