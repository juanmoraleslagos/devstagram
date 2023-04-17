<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        // validaciones.
        $this->validate($request,[
            'comentario' => 'required|max:255'
        ]);

        // almacenar el resultado.
        $data = [
            'user_id'    => auth()->user()->id,
            'post_id'    => $post->id,
            'comentario' => $request->comentario
        ];

        Comentario::create($data);


        // redireccionando e imprimiendo mensaje.
        return back()->with('mensaje','Comentario Realizado Correctamente');
    }
}
