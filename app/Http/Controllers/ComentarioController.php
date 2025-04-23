<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        // Validación de datos del comentario
        $validatedData = $request->validate([
            'comentario' => 'required|max:255',
        ]);  

        // Crear el comentario
        Comentario::create([
            'user_id' => Auth::user()->id, 
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]); 

        return back()->with('mensaje', 'Comentario Realizado Correctamente');
    }

    public function destroy(Comentario $comentario)
    {
        // Verificar que el comentario pertenece al usuario logueado o que es un administrador
        if (Auth::user()->id === $comentario->user_id || Auth::user()->rol === 'admin') {
            // Eliminar el comentario
            $comentario->delete();
            return back()->with('mensaje', 'Comentario Eliminado Correctamente');
        }

        return back()->with('error', 'No tienes permisos para eliminar este comentario');
    }
}
