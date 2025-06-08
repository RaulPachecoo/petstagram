<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

/**
 * Controlador responsable del procesamiento y almacenamiento de imágenes subidas por el usuario.
 */
class ImagenController extends Controller
{
    /**
     * Constructor de la clase.
     * Establece el idioma de la instancia de Carbon a español.
     */
    public function __construct()
    {
        Carbon::setLocale('es');
    }

    /**
     * Almacena una imagen enviada desde el cliente, la redimensiona y guarda en el servidor.
     *
     * @param Request $request Instancia de la solicitud HTTP que contiene el archivo de imagen.
     * @return \Illuminate\Http\JsonResponse Devuelve el nombre generado de la imagen en formato JSON.
     */
    public function store(Request $request)
    {
        // Obtener el archivo de imagen desde el request
        $imagen = $request->file('file');
        
        // Generar un nombre único para la imagen utilizando UUID
        $nombreImagen = Str::uuid() . "." . $imagen->extension();
        
        // Crear instancia de la imagen con Intervention Image
        $imagenServidor = Image::make($imagen); 

        // Redimensionar la imagen a un tamaño fijo (1000x1000 píxeles)
        $imagenServidor->fit(1000, 1000);

        // Definir la ruta en el servidor donde se almacenará la imagen
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;

        // Guardar la imagen en la ruta especificada
        $imagenServidor->save($imagenPath);
        
        // Devolver el nombre de la imagen en formato JSON como respuesta
        return response()->json(['imagen' => $nombreImagen]);
    }
}
