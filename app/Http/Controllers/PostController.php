<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\OllamaService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;


class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
        Carbon::setLocale('es');
    }

    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required|string'
        ]);

        $nombreImagen = $request->imagen;
        $imagePath = public_path('uploads/' . $nombreImagen);

        // Verificamos si la imagen existe
        if (!file_exists($imagePath)) {
            return back()->withErrors(['imagen' => 'La imagen no existe en el servidor']);
        }

        $ollama = new OllamaService();

        // Prompts para Ollama
        $prompts = [
            "¿Esta imagen contiene contenido sensible o inapropiado? Responde solo 'sí' o 'no'.",
            "¿Esta imagen contiene algún animal o mascota? Responde solo 'sí' o 'no'."
        ];

        // Enviar la imagen a Ollama para análisis
        $responses = $ollama->analyzeImage($imagePath, $prompts);

        // Función de normalización
        $normalize = fn($respuesta) => strtolower(preg_replace('/[^a-z]/i', '', Str::ascii($respuesta)));

        $contenidoSensible = isset($responses[0]['response']) && $normalize($responses[0]['response']) === 'si';
        $contieneAnimal = isset($responses[1]['response']) && $normalize($responses[1]['response']) === 'si';

        // Verificamos si la imagen tiene contenido sensible o un animal
        if ($contenidoSensible) {
            unlink($imagePath); // Eliminar la imagen si tiene contenido sensible
            return back()->withErrors(['imagen' => 'La imagen contiene contenido sensible o inapropiado.']);
        }

        if (!$contieneAnimal) {
            unlink($imagePath); // Eliminar la imagen si no contiene un animal
            return back()->withErrors(['imagen' => 'La imagen debe contener un animal o mascota.']);
        }

        // Si la imagen pasa las validaciones, crear el post
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion, // Usamos la descripción proporcionada por el usuario
            'imagen' => $nombreImagen,  // Solo almacenamos el nombre de la imagen
            'user_id' => Auth::id()
        ]);

        // Redirigir con éxito
        return redirect()->route('posts.index', $request->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();
        $imagenPath = public_path('uploads/' . $post->imagen);

        if (File::exists($imagenPath)) {
            unlink($imagenPath);
        }

        if (Auth::user()->rol === 'admin') {
            return redirect()->route('posts.index', $post->user->username);
        }

        return redirect()->route('posts.index', Auth::user()->username);
    }
}
