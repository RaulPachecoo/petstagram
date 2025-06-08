<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * Controlador encargado de gestionar el proceso de restablecimiento
 * de contraseñas mediante el token recibido por correo electrónico.
 */
class ResetPasswordController extends Controller
{
    /**
     * Muestra el formulario para restablecer la contraseña.
     * Este formulario es accedido a través del enlace enviado por correo.
     *
     * @param \Illuminate\Http\Request $request Solicitud entrante (con el email).
     * @param string $token Token único generado por Laravel para validar la petición.
     * @return \Illuminate\View\View Vista del formulario de reseteo.
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Procesa la solicitud de restablecimiento de contraseña.
     * Valida el token, email y nueva contraseña. Si es correcto,
     * actualiza la contraseña del usuario en la base de datos.
     *
     * @param \Illuminate\Http\Request $request Contiene los datos del formulario.
     * @return \Illuminate\Http\RedirectResponse Redirige según éxito o error.
     */
    public function reset(Request $request)
    {
        // Validación de campos
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Intenta restablecer la contraseña usando el sistema de Laravel
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                // Si la validación tiene éxito, se actualiza la contraseña y el token de sesión
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        // Redirige al login con mensaje de éxito o muestra error
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
