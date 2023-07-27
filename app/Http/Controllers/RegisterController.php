<?php

namespace App\Http\Controllers;

use Stringable;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('principal');
    }

    // crear cuenta usuario.
    public function create()
    {
        return view('auth.register');
    }

    // almacenar datos usuario.
    public function store(Request $request)
    {
        // modificando-reescribiendo variable $request.
        $request->request->add(['username' => Str::slug($request->username)]);

        // validando campos formulario.
        $this->validate($request, [
            'name'     => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email'    => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        // creando data.
        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ];

        // creando registro.
        User::create($data);

        // autenticando usuario - con credenciales.
        auth()->attempt([
            'email'    => $request->email,
            'password' => $request->password
        ]);

        // Redireccionando.
        return redirect()->route('posts.index');
    }
}
