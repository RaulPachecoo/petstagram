<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon; // Add this line

class ImagenController extends Controller
{
    public function __construct(){
        Carbon::setLocale('es'); // Add this line
    }

    public function store(Request $request){
        $imagen = $request->file('file');
        
        $nombreImagen = Str::uuid() . "." . $imagen->extension();
        
        $imagenServidor = Image::make($imagen); 
        $imagenServidor->fit(1000, 1000);

        $imagenPath = public_path('uploads') . '/' . $nombreImagen; 

        $imagenServidor->save($imagenPath);
        
        return response()->json(['imagen' => $nombreImagen]); 
    }
}