<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador para la gestión de comentarios en publicaciones.
 * Permite a los usuarios crear y eliminar comentarios, con restricciones de permisos.
 */
class ComentarioController extends Controller
{
    /**
     * Almacena un nuevo comentario asociado a una publicación y a un usuario.
     *
     * @param \Illuminate\Http\Request $request Datos enviados desde el formulario.
     * @param \App\Models\User $user Usuario al que pertenece la publicación (contexto).
     * @param \App\Models\Post $post Publicación en la que se está comentando.
     * @return \Illuminate\Http\RedirectResponse Redirecciona de vuelta con mensaje de éxito.
     */
    public function store(Request $request, User $user, Post $post)
    {
        // Validar que el campo 'comentario' no esté vacío y tenga máximo 255 caracteres
        $validatedData = $request->validate([
            'comentario' => 'required|max:255',
        ]);  

        // Crear el comentario en la base de datos
        Comentario::create([
            'user_id' => Auth::user()->id,       // Usuario que comenta
            'post_id' => $post->id,              // Publicación comentada
            'comentario' => $request->comentario // Contenido del comentario
        ]); 

        return back()->with('mensaje', 'Comentario Realizado Correctamente');
    }

    /**
     * Elimina un comentario si el usuario autenticado es el autor o tiene rol de administrador.
     *
     * @param \App\Models\Comentario $comentario El comentario a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirecciona con mensaje según el resultado.
     */
    public function destroy(Comentario $comentario)
    {
        // Verifica que el usuario sea el autor del comentario o un administrador
        if (Auth::user()->id === $comentario->user_id || Auth::user()->rol === 'admin') {
            // Elimina el comentario
            $comentario->delete();
            return back()->with('mensaje', 'Comentario Eliminado Correctamente');
        }

        return back()->with('error', 'No tienes permisos para eliminar este comentario');
    }
}
