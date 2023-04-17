<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

        // generando id unicos para las imagenes.
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        // creando imagen para subir al servidor.
        $imagenServidor = Image::make($imagen);

        // utilizando efectos de interventionImages.
        $imagenServidor->fit(1000, 1000);

        // creando ruta para guardar las imagenes.
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;

        // guardando imagen en el servidor.
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
