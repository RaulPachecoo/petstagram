<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * Controlador encargado de gestionar el proceso de autenticación de usuarios,
 * tanto mediante correo/contraseña como con autenticación de Google mediante Socialite.
 */
class LoginController extends Controller
{
    /**
     * Muestra el formulario de login.
     * Redirige al usuario si ya ha iniciado sesión.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión con correo electrónico y contraseña.
     *
     * @param Request $request Datos de entrada del formulario de login.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validar campos requeridos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Intentar autenticación
        if (!Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        // Redirigir si la autenticación es exitosa
        return redirect()->route('home');
    }

    /**
     * Redirige al usuario a Google para el proceso de autenticación OAuth.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Maneja la respuesta de Google tras la autenticación OAuth.
     * Si el usuario no existe, lo crea automáticamente.
     * También envía un mensaje de bienvenida si es un nuevo usuario.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            // Obtener datos del usuario autenticado desde Google
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('mensaje', 'Error al autenticar con Google.');
        }

        // Buscar usuario por correo
        $user = User::where('email', $googleUser->getEmail())->first();

        // Crear el usuario si no existe
        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Usuario Google',
                'email' => $googleUser->getEmail(),
                'username' => Str::slug(explode('@', $googleUser->getEmail())[0]),
                'password' => Hash::make(Str::random(16)), // Contraseña aleatoria
            ]);
        }

        // Iniciar sesión automáticamente
        Auth::login($user, true);

        // Enviar mensaje de bienvenida desde el administrador si es un nuevo usuario
        $admin = User::where('email', 'raulpachecoropero555@gmail.com')->first();
        if ($admin && $user->wasRecentlyCreated) {
            \App\Models\Message::create([
                'sender_id' => $admin->id,
                'receiver_id' => $user->id,
                'body' => 'Bienvenido a Petstagram. Si tiene alguna duda sobre este Sitio Web no dude en enviarnos un mensaje',
            ]);
        }

        // Redirigir al perfil del usuario
        return redirect()->route('posts.index', $user->username);
    }
}
