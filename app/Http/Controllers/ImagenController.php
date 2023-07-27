<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    // almacenar imagenes.
    public function store(Request $request)
    {
        // subir imagen en memoria.
        $imagen = $request->file('file');

        // generar id único para nombre imagen.
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        //  guardar imagen en el servidor - intevention image.
        $imagenServidor = Image::make($imagen);

        // usar efectos de intervention image.
        $imagenServidor->fit(1000, 1000);

        // crear ruta imagen en el servidor.
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;

        // guardar imagen servidor.
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
