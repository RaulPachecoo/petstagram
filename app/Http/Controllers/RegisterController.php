<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

/**
 * Controlador encargado del registro y autenticación de usuarios.
 *
 * Proporciona métodos para mostrar el formulario de registro,
 * registrar usuarios con datos propios o mediante Google OAuth,
 * y gestionar la autenticación y bienvenida.
 */
class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro de usuario.
     *
     * @return \Illuminate\View\View Vista 'auth.register'
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Valida y registra un nuevo usuario en la aplicación.
     *
     * - Convierte el username a slug para mayor consistencia.
     * - Valida los datos obligatorios (nombre, username, email, password).
     * - Crea el usuario con contraseña encriptada.
     * - Autentica al usuario registrado automáticamente.
     * - Envía un mensaje de bienvenida desde el administrador si existe.
     * - Redirige al usuario a la página principal de posts.
     *
     * @param  \Illuminate\Http\Request  $request Datos recibidos del formulario de registro
     * @return \Illuminate\Http\RedirectResponse Redirige a la ruta 'posts.index' con el username del usuario autenticado
     */
    public function store(Request $request)
    {
        // Convertir username a slug para URL amigable
        $request->request->add(['username' => Str::slug($request->username)]);

        // Validar datos recibidos
        $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:30',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|min:8|max:30|confirmed'
        ]);

        // Crear nuevo usuario con datos validados y password cifrada
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Autenticar usuario recién creado
        Auth::attempt($request->only('email', 'password'));

        // Enviar mensaje de bienvenida desde administrador si existe
        $admin = \App\Models\User::where('email', 'raulpachecoropero555@gmail.com')->first();
        $newUser = Auth::user();
        if ($admin && $newUser) {
            \App\Models\Message::create([
                'sender_id' => $admin->id,
                'receiver_id' => $newUser->id,
                'body' => 'Bienvenido a Petstagram. Si tiene alguna duda sobre este Sitio Web no dude en enviarnos un mensaje',
            ]);
        }

        // Redirigir a posts del usuario autenticado
        return redirect()->route('posts.index', Auth::user()->username);
    }

    /**
     * Redirige al usuario al flujo de autenticación con Google.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse Redirecciona a Google para autenticación OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Maneja la respuesta del callback de Google OAuth.
     *
     * - Obtiene información del usuario desde Google.
     * - Si el usuario no existe, crea uno nuevo con datos obtenidos.
     * - Autentica al usuario y mantiene la sesión iniciada.
     * - Envía mensaje de bienvenida si es un usuario nuevo.
     * - Redirige a la página principal de posts.
     *
     * @return \Illuminate\Http\RedirectResponse Redirige a la ruta 'posts.index' con el username del usuario autenticado
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('register')->with('mensaje', 'Error al autenticar con Google.');
        }

        // Buscar usuario por email
        $user = User::where('email', $googleUser->getEmail())->first();

        // Crear usuario si no existe
        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Usuario Google',
                'email' => $googleUser->getEmail(),
                'username' => Str::slug(explode('@', $googleUser->getEmail())[0]),
                'password' => Hash::make(Str::random(16)), // contraseña aleatoria
            ]);
        }

        // Autenticar y mantener sesión
        Auth::login($user, true);

        // Enviar mensaje de bienvenida desde administrador si es usuario nuevo
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
