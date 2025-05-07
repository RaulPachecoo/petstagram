<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class ImagenController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('es');
    }

    public function store(Request $request)
    {
        $imagen = $request->file('file');
        
        $nombreImagen = Str::uuid() . "." . $imagen->extension();
        
        $imagenServidor = Image::make($imagen); 
        $imagenServidor->fit(1000, 1000); // Ajuste de imagen

        $imagenPath = public_path('uploads') . '/' . $nombreImagen; 

        // Guardar la imagen en la carpeta uploads
        $imagenServidor->save($imagenPath);
        
        // Retornar el nombre de la imagen
        return response()->json(['imagen' => $nombreImagen]);
    }
}
