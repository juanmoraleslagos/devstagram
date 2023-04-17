@extends('layouts.app')

@section('titulo')
    Crea Una Nueva Publicación
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('contenido')
    <div class="md:flex md:items-center">
        <!-- formulario subida imagen - dropozone -->
        <div class="md:w-1/2 px-10">
            <form 
                action="{{ route('imagenes.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="dropzone"
                class="dropzone border-dashed border-2 w-full h-96 
                       rounded flex flex-col justify-center items-center"
            >   
            @csrf         
            </form>
        </div>
        <!-- formulario envio posts -->
        <div class="md:w-1/2 p-10 bg-white rounded-lg shadow-xl mt-10 md:mt-10">
            <form action="{{ route('post.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="titulo" class="mb-2 block uppercase text-gray-500 font-bold">
                        Título
                    </label>
                    <input 
                        id="titulo"
                        type="text"
                        name="titulo"
                        placeholder="Título De La Publicación"
                        class="border p-3 w-full rounded-lg 
                                @error('name')
                                    border-red-500
                                @enderror"
                        value="{{ old('titulo') }}"
                    >
                    <!-- mostrando error de validacion -->
                    @error('titulo')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>                        
                    @enderror

                </div>                
                <div class="mb-5">
                    <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Descripción
                    </label>
                    <textarea 
                        id="descripcion"                        
                        name="descripcion"
                        placeholder="Descripción De La Publicación"
                        class="border p-3 w-full rounded-lg 
                                @error('name')
                                    border-red-500
                                @enderror"                        
                    >{{ old('descripcion') }}</textarea>
                    <!-- mostrando error de validacion -->
                    @error('descripcion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>                        
                    @enderror
                </div>     
                
                <!-- campo almacena valor imagen -->
                <div class="mb-5">
                    <input 
                        name="imagen"
                        type="hidden"
                        value="{{ old('imagen') }}"
                    >
                    <!-- mostrando error de validacion -->
                    @error('imagen')
                      <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>                        
                    @enderror
                </div>
                <input 
                    type="submit"
                    value="Publicar"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                >

            </form>
        </div>
        
    </div>
@endsection