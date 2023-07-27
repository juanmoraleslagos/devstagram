@extends('layouts.app')

@section('titulo')
Página Principal
@endsection

@section('contenido')

{{-- utilizar componentes listar-post --}}
<x-listar-post :posts="$posts" />

@endsection