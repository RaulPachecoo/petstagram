<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        // Añadimos la validación de los campos
        $request->request->add(['username' => Str::slug($request->username)]);

        $request->validate([
            'username' => ['required', 'unique:users,username,' . Auth::user()->id, 'min:3', 'max:20', 'not_in:twitter,editar-perfil'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::user()->id],
            'password' => ['nullable', 'min:6', 'confirmed'], // Validamos que las contraseñas coincidan
        ]);

        // Si el usuario ha subido una nueva imagen
        if ($request->imagen) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Obtener el usuario autenticado
        $usuario = User::find(Auth::user()->id); 

        // Actualizar los datos
        $usuario->username = $request->username;
        $usuario->email = $request->email;

        // Si se proporcionó una nueva contraseña y está confirmada
        if ($request->password) {
            $usuario->password = Hash::make($request->password);
        }

        // Si se subió una nueva imagen, actualizarla
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? null;

        $usuario->save();

        return redirect()->route('posts.index', $usuario->username); 
    }
}


