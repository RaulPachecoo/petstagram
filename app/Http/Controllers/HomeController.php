<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador que gestiona el acceso a la página de inicio (dashboard) para usuarios autenticados.
 * Su comportamiento varía según si el usuario es administrador o usuario normal.
 */
class HomeController extends Controller
{
    /**
     * Aplica el middleware de autenticación.
     * Solo los usuarios autenticados pueden acceder a este controlador.
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    /**
     * Método __invoke(): se ejecuta cuando este controlador se llama directamente como una función.
     * 
     * Si el usuario es administrador, muestra todos los demás usuarios registrados.
     * Si es un usuario normal, muestra posts recientes de usuarios que sigue, excluyendo los ya vistos.
     *
     * @return \Illuminate\View\View Vista de la página de inicio con los datos correspondientes.
     */
    public function __invoke()
    {
        $user = Auth::user();

        // Vista para administrador: lista de todos los usuarios excepto él mismo
        if ($user->rol === 'admin') {
            $usuarios = User::where('id', '!=', $user->id)->get();
            return view('home', [
                'usuarios' => $usuarios
            ]);
        }

        // Vista para usuario normal

        // IDs de usuarios seguidos
        $ids = $user->following->pluck('id')->toArray();

        // IDs de posts que ya ha visto
        $viewedPostIds = $user->postViews->pluck('post_id')->toArray();

        // Obtener posts de usuarios seguidos que aún no ha visto
        $postsQuery = Post::whereIn('user_id', $ids)
            ->whereNotIn('id', $viewedPostIds)
            ->latest();

        $posts = $postsQuery->paginate(20);

        // Si no hay nuevos posts, mostrar todos los más recientes de los seguidos
        if ($posts->isEmpty()) {
            $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);
        }

        return view('home', [
            'posts' => $posts
        ]);
    }
}
