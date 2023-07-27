<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    // Protegiendo (ruta) con middleware
    public function __construct()
    {
        // ejecutando middleware de autenticación.
        $this->middleware('auth')->except(['show', 'index']);
    }

    // renderizar vista muro usuario.
    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('layouts.dashboard', [
            'user'  => $user,
            'posts' => $posts
        ]);
    }

    // crear publicaciones.
    public function create()
    {
        return view('posts.create');
    }

    // almacenar posts usuarios.
    public function store(Request $request)
    {
        // validando campos formulario.
        $this->validate($request, [
            'titulo'      => 'required|max:255',
            'descripcion' => 'required',
            'imagen'      => 'required'
        ]);

        // Guardando datos desde formulario.
        $request->user()->posts()->create([
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen'      => $request->imagen,
            'user_id'     => auth()->user()->id
        ]);

        // redireccionar usuario.
        return redirect()->route('posts.index', auth()->user()->username);
    }

    // mostrar foto en particular.
    public function show(User $user, Post $post)
    {

        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    // eliminando post.
    public function destroy(Post $post)
    {
        // verificando permisos para eliminar.
        $this->authorize('delete', $post);

        // borrar publicación.
        $post->delete();

        // ELIMINAR IMAGEN.
        // ------------------------------------------------------------
        // dirección imagen servidor.
        $imagen_path = public_path('uploads/' . $post->imagen);

        // verificar si existe archivo.
        if (File::exists($imagen_path)) {
            unlink($imagen_path);
        }

        // redireccionando a muro usuario.
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
