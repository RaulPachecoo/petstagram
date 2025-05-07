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
use Illuminate\Http\JsonResponse;


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
        $validatedData = $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required|string',
        ]);

        $nombreImagen = $request->imagen;
        $imagePath = public_path('uploads/' . $nombreImagen);

        if (!file_exists($imagePath)) {
            $error = ['imagen' => ['La imagen no existe en el servidor']];
            return $request->expectsJson()
                ? response()->json(['errors' => $error], 422)
                : back()->withErrors($error)->withInput();
        }

        $ollama = new OllamaService();
        $prompts = [
            "¿Esta imagen contiene contenido sensible o inapropiado? Responde solo 'sí' o 'no'.",
            "¿Esta imagen contiene algún animal o mascota? Responde solo 'sí' o 'no'."
        ];

        $responses = $ollama->analyzeImage($imagePath, $prompts);
        $normalize = fn($r) => strtolower(preg_replace('/[^a-z]/i', '', Str::ascii($r)));

        $contenidoSensible = isset($responses[0]['response']) && $normalize($responses[0]['response']) === 'si';
        $contieneAnimal = isset($responses[1]['response']) && $normalize($responses[1]['response']) === 'si';

        if ($contenidoSensible || !$contieneAnimal) {
            unlink($imagePath);
            $errorMsg = $contenidoSensible
                ? 'La imagen contiene contenido sensible o inapropiado.'
                : 'La imagen debe contener un animal o mascota.';
            $error = ['imagen' => [$errorMsg]];
            return $request->expectsJson()
                ? response()->json(['errors' => $error], 422)
                : back()->withErrors($error)->withInput();
        }

        $request->user()->posts()->create([
            'titulo' => $validatedData['titulo'],
            'descripcion' => $validatedData['descripcion'],
            'imagen' => $nombreImagen,
        ]);

        $redirectUrl = route('posts.index', $request->user()->username);

        return $request->expectsJson()
            ? response()->json(['redirect' => $redirectUrl])
            : redirect($redirectUrl);
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
