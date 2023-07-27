<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // método constructor.
    public function __construct()
    {
        $this->middleware('auth');
    }

    // mostrar página principal.
    public function __invoke()
    {
        // obtener a quienes seguimos.
        $ids = auth()->user()->followings->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

        // renderizando vista.
        return view('home', [
            'posts' => $posts
        ]);
    }
}
