<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // almacenar like.
    public function store(Request $request, Post $post)
    {
        // almacenando like.
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        // redireccionando.
        return back();
    }

    // quitando like.
    public function destroy(Request $request, Post $post)
    {
        // eliminar like.
        $request->user()->likes()->where('post_id', $post->id)->delete();

        // redireccionando.
        return back();
    }
}
