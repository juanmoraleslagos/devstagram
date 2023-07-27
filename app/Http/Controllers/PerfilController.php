<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    // proteger ruta.
    public function __construct()
    {
        $this->middleware('auth');
    }

    // mostrar formulario editar perfil.
    public function index()
    {
        return view('perfil.index');
    }

    // guardar cambio perfil.
    public function store(Request $request)
    {
        // modificando-reescribiendo variable $request.
        $request->request->add(['username' => Str::slug($request->username)]);

        // validando campos formulario.
        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20', 'not_in:twitter,facebook,youtube,pinterest,editar-perfil'],
        ]);

        // verificar si hay imagen.
        if ($request->imagen) {
            // subir imagen en memoria.
            $imagen = $request->file('imagen');

            // generar id único para nombre imagen.
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            //  guardar imagen en el servidor - intevention image.
            $imagenServidor = Image::make($imagen);

            // usar efectos de intervention image.
            $imagenServidor->fit(1000, 1000);

            // crear ruta imagen en el servidor.
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;

            // guardar imagen servidor.
            $imagenServidor->save($imagenPath);
        }

        // guardar cambios.
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // redireccionar.
        return redirect()->route('posts.index', $usuario->username);
    }
}
