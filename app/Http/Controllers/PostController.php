<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    public function index(User $user)
    {
        // generando busqueda de post por usuario.
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('layouts.dashboard', [
            'user'  => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        // validando campos formulario.
        $this->validate($request, [
            'titulo'      => 'required|max:255',
            'descripcion' => 'required',
            'imagen'      => 'required'
        ]);

        // creando data.
        $data = [
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen'      => $request->imagen,
            'user_id'     => auth()->user()->id
        ];

        // almacenando posts en BD.
        //Post::create($data);

        // Almacenando datos con relaciones establecidas.
        $request->user()->posts()->create($data);

        // redireccionando.
        return redirect()->route('post.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('post.show', [
            'user' => $user,
            'post' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        // eliminando post.
        $this->authorize('delete', $post);
        $post->delete();

        // eliminando imagen del post.
        $imagen_path = public_path('uploads/' . $post->imagen);

        if (File::exists($imagen_path)) {
            unlink($imagen_path);
        }

        // redirreccionando.
        return redirect()->route('post.index', auth()->user()->username);
    }
}
