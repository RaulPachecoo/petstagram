<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BlogEntry; // Modelo que representa las entradas del blog

/**
 * Controlador para gestionar las funcionalidades del blog.
 * Incluye visualización, creación y almacenamiento de entradas.
 */
class BlogController extends Controller
{
    /**
     * Muestra un listado paginado de las entradas del blog, ordenadas por fecha de creación.
     *
     * @return \Illuminate\View\View Vista con las entradas del blog.
     */
    public function index()
    {
        $entries = BlogEntry::orderBy('created_at', 'desc')->paginate(10); // 10 por página
        return view('blog.index', compact('entries'));
    }

    /**
     * Muestra una entrada individual del blog según su ID.
     *
     * @param  int  $id ID de la entrada.
     * @return \Illuminate\View\View Vista con los detalles de la entrada.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra la entrada.
     */
    public function show($id)
    {
        $entry = BlogEntry::findOrFail($id);
        return view('blog.show', compact('entry'));
    }

    /**
     * Muestra el formulario para crear una nueva entrada del blog.
     * Solo accesible por usuarios con rol de administrador.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\Response Vista de creación o error 403 si no autorizado.
     */
    public function create()
    {
        // Comprobación de rol de administrador
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'No autorizado');
        }

        return view('blog.create');
    }

    /**
     * Almacena una nueva entrada del blog en la base de datos tras validar los datos del formulario.
     * Solo accesible por administradores.
     *
     * @param  \Illuminate\Http\Request  $request Datos de entrada del formulario.
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito.
     */
    public function store(Request $request)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'No autorizado');
        }

        // Validación de los campos del formulario
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // Opcional, debe ser imagen válida
        ]);

        // Si se ha subido una imagen, se guarda con nombre único en la carpeta pública
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Nombre único
            $image->move(public_path('entries'), $imageName);
            $validated['image'] = $imageName;
        }

        // Creación de la entrada en la base de datos
        BlogEntry::create($validated);

        return redirect()->route('blog.index')->with('success', 'Entrada creada correctamente.');
    }
}
