<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); 
    }

    public function __invoke()
    {
        $user = Auth::user();

        if ($user->rol === 'admin') {
            $usuarios = User::where('id', '!=', $user->id)->get(); // Todos menos él mismo
            return view('home', [
                'usuarios' => $usuarios
            ]);
        }

        // Si es un usuario normal
        $ids = $user->following->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);
        
        return view('home', [
            'posts' => $posts
        ]);
    }
}
