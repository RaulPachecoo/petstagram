<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * Controlador encargado de gestionar los "me gusta" (likes) de los usuarios en publicaciones.
 */
class LikeController extends Controller
{
    /**
     * Añade un "me gusta" del usuario autenticado a una publicación específica.
     *
     * @param Request $request Instancia de la solicitud HTTP.
     * @param Post $post Publicación a la que se le va a dar "me gusta".
     * @return \Illuminate\Http\RedirectResponse Redirecciona de vuelta a la página anterior.
     */
    public function store(Request $request, Post $post)
    {
        // Crear un nuevo like asociado al usuario autenticado
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        return back();  
    }

    /**
     * Elimina el "me gusta" del usuario autenticado en una publicación específica.
     *
     * @param Request $request Instancia de la solicitud HTTP.
     * @param Post $post Publicación de la que se eliminará el "me gusta".
     * @return \Illuminate\Http\RedirectResponse Redirecciona de vuelta a la página anterior.
     */
    public function destroy(Request $request, Post $post)
    {
        // Buscar y eliminar el like del usuario para esa publicación
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
