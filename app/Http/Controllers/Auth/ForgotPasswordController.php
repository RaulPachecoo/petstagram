<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * Controlador encargado de gestionar el proceso de recuperación de contraseñas.
 * Permite mostrar el formulario para solicitar un enlace de reseteo
 * y enviar dicho enlace al correo del usuario.
 */
class ForgotPasswordController extends Controller
{
    /**
     * Muestra el formulario para que el usuario introduzca su correo
     * y solicite el enlace de recuperación de contraseña.
     *
     * @return \Illuminate\View\View Vista con el formulario de recuperación.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Procesa la solicitud del formulario, valida el correo y envía el enlace
     * de restablecimiento de contraseña si el correo está registrado.
     *
     * @param  \Illuminate\Http\Request  $request Solicitud HTTP que contiene el email.
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito o error.
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validar que el campo email es obligatorio y con formato válido
        $request->validate([
            'email' => 'required|email',
        ]);

        // Intentar enviar el enlace de restablecimiento al correo indicado
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Dependiendo del estado, se redirige con mensaje de estado o con errores
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status)) // Éxito: muestra mensaje
            : back()->withErrors(['email' => __($status)]); // Error: muestra validación
    }
}
