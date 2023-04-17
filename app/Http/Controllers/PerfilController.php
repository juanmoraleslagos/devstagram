<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use Intervention\Image\Facades\Image;


class PerfilController extends Controller
{
    // protegiendo ruta editar-perfil.
    public function __construct()
    {
        $this->middleware('auth');
    }

    // mostrando formulario para perfil usuario.
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        // modificar el Request.
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => [
                'required',
                'unique:users,username,' . auth()->user()->id,
                'min:3',
                'max:20',
                'not_in:twitter,editar-perfil',
            ],
        ]);

        if ($request->imagen) {
            $imagen = $request->file('imagen');
            // generando id unicos para las imagenes.
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
            // creando imagen para subir al servidor.
            $imagenServidor = Image::make($imagen);
            // utilizando efectos de interventionImages.
            $imagenServidor->fit(1000, 1000);
            // creando ruta para guardar las imagenes.
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            // guardando imagen en el servidor.
            $imagenServidor->save($imagenPath);
        }

        // guardar cambios.
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // redireccionando.
        return redirect()->route('post.index', $usuario->username);
    }
}
