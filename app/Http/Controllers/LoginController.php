<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // renderizando vista principal Login Usuario.
    public function index()
    {
        return view('auth.login');
    }

    // autenticando usuario.
    public function store(Request $request)
    {
        // validando campos formulario.
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // comprobando si credenciales son correctas.
        if (!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        // redireccionando hacia muro.
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
