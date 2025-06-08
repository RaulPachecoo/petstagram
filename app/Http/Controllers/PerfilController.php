<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\ValidationException;

/**
 * Controlador para gestionar el perfil del usuario.
 *
 * Esta clase permite mostrar el formulario de edición de perfil y
 * actualizar la información del usuario autenticado, incluyendo
 * username, email, contraseña e imagen de perfil.
 */
class PerfilController extends Controller
{
    /**
     * Aplicar middleware de autenticación a todos los métodos del controlador.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar la vista del perfil del usuario.
     *
     * @return \Illuminate\View\View Retorna la vista 'perfil.index'
     */
    public function index()
    {
        return view('perfil.index');
    }

    /**
     * Actualizar el perfil del usuario autenticado.
     *
     * Valida los datos recibidos, procesa la imagen si se envía,
     * actualiza el username, email, contraseña (si se proporciona),
     * y la imagen de perfil en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request Datos de la solicitud HTTP
     * @return \Illuminate\Http\RedirectResponse Redirige a la ruta 'posts.index' con el username actualizado
     *
     * @throws \Illuminate\Validation\ValidationException Si la validación falla
     */
    public function store(Request $request)
    {
        // Regenera la sesión para evitar fijación de sesión
        $request->session()->regenerate();

        // Validar los datos del formulario
        $request->validate([
            'username' => [
                'required',
                'unique:users,username,' . Auth::user()->id,
                'min:3',
                'max:20',
                'not_in:twitter,editar-perfil'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . Auth::user()->id
            ],
            'password' => [
                'nullable',
                'min:6',
                'same:password_confirmation'
            ],
            'password_confirmation' => [
                'required_with:password'
            ],
        ]);

        // Crear slug del username para URL amigable
        $username_slug = Str::slug($request->username);

        // Procesar imagen si se ha enviado
        if ($request->imagen) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            // Redimensionar y recortar la imagen a 1000x1000 píxeles
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            // Guardar la imagen en la carpeta 'public/perfiles'
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Obtener usuario autenticado
        $usuario = User::find(Auth::user()->id);

        // Actualizar campos del usuario
        $usuario->username = $username_slug;
        $usuario->email = $request->email;

        // Actualizar contraseña si se proporcionó
        if ($request->password) {
            $usuario->password = Hash::make($request->password);
        }

        // Actualizar imagen si se subió una nueva, o mantener la actual
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? null;

        // Guardar cambios en la base de datos
        $usuario->save();

        // Redirigir a la ruta principal de posts con el username actualizado
        return redirect()->route('posts.index', $usuario->username);
    }
}
