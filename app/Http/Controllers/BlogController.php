<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BlogEntry; // Asegúrate que el modelo existe

class BlogController extends Controller
{
    public function index()
    {
        $entries = BlogEntry::orderBy('created_at', 'desc')->paginate(10); // obtén entradas paginadas

        return view('blog.index', compact('entries'));
    }

    public function show($id)
    {
        $entry = BlogEntry::findOrFail($id);
        return view('blog.show', compact('entry'));
    }

    public function create()
    {
        // Solo admin puede acceder (puedes mover esto a middleware si lo prefieres)
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'No autorizado');
        }

        return view('blog.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'No autorizado');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('entries'), $imageName);
            $validated['image'] = $imageName;
        }

        BlogEntry::create($validated);

        return redirect()->route('blog.index')->with('success', 'Entrada creada correctamente.');
    }
}
