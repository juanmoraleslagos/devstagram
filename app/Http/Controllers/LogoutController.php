<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    // método cerrar sesión.
    public function store()
    {
        // cerrando sesión con helpers.
        auth()->logout();

        // redireccionando.
        return redirect()->route('login');
    }
}
