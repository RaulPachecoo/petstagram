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

/**
 * Controlador para la gestión de posts.
 *
 * Proporciona métodos para listar, crear, mostrar y eliminar posts,
 * incluyendo validación avanzada de imágenes usando el servicio Ollama.
 */
class PostController extends Controller
{
    use AuthorizesRequests;

    /**
     * Configura middleware y localización.
     *
     * El middleware 'auth' protege todos los métodos excepto 'show' e 'index'.
     * Además establece el idioma de Carbon a español.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
        Carbon::setLocale('es');
    }

    /**
     * Muestra un listado paginado de posts de un usuario.
     *
     * @param  User  $user Instancia del usuario cuyo posts se listan
     * @return \Illuminate\View\View Vista 'dashboard' con posts y usuario
     */
    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo post.
     *
     * @return \Illuminate\View\View Vista 'posts.create'
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Almacena un nuevo post validando datos y analizando la imagen.
     *
     * Valida que el título, descripción y nombre de imagen existan,
     * verifica que la imagen esté en el servidor y no contenga contenido sensible.
     * Utiliza el servicio Ollama para análisis de la imagen.
     * En caso de error devuelve respuestas adecuadas para peticiones AJAX o web.
     *
     * @param  Request  $request Datos de la petición HTTP
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse Redirige o responde JSON con redirección o errores
     *
     * @throws ValidationException Si la validación falla
     */
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

        try {
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
         } catch (\Exception $e) {
            // Si Ollama no está disponible, eliminar imagen y mostrar error
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $error = ['imagen' => [
                'En estos momentos el servidor no está disponible. Prueba más tarde o ponte en contacto con los administradores.'
            ]];
            return $request->expectsJson()
                ? response()->json(['errors' => $error], 422)
                : back()->withErrors($error)->withInput();
        }

        // Crear el post asociado al usuario autenticado
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

    /**
     * Muestra un post específico.
     *
     * Si el usuario autenticado es de rol 'user' y no es el propietario del post,
     * registra la vista para contabilizarla.
     *
     * @param  User  $user Usuario propietario del post
     * @param  Post  $post Post a mostrar
     * @return \Illuminate\View\View Vista 'posts.show' con el post y usuario
     */
    public function show(User $user, Post $post)
    {
        if (Auth::check() && Auth::user()->rol === 'user' && Auth::id() !== $post->user_id) {
            $alreadyViewed = $post->views()->where('user_id', Auth::id())->exists();
            if (!$alreadyViewed) {
                $post->views()->create([
                    'user_id' => Auth::id(),
                ]);
            }
        }
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    /**
     * Elimina un post y su imagen asociada.
     *
     * Requiere autorización para borrar el post.
     * Elimina también la imagen física en el servidor.
     * Redirige según el rol del usuario autenticado.
     *
     * @param  Post  $post Post a eliminar
     * @return \Illuminate\Http\RedirectResponse Redirige a la lista de posts correspondiente
     */
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
