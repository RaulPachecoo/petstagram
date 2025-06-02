<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {

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

        $admin = \App\Models\User::where('email', 'raulpachecoropero555@gmail.com')->first();
        $newUser = Auth::user();
        if ($admin && $newUser) {
            \App\Models\Message::create([
                'sender_id' => $admin->id,
                'receiver_id' => $newUser->id,
                'body' => 'Bienvenido a Petstagram. Si tiene alguna duda sobre este Sitio Web no dude en enviarnos un mensaje',
            ]);
        }

        // Redireccionar al usuario
        return redirect()->route('posts.index', Auth::user()->username);
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
            return redirect()->route('register')->with('mensaje', 'Error al autenticar con Google.');
        }

        $user = User::where('email', $googleUser->getEmail())->first();
        if (!$user) {
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
