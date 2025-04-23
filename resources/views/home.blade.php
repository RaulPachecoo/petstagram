@extends('layouts.app')

@section('titulo')
    Página Principal
@endsection

@section('contenido')

    @if(auth()->user()->rol === 'user')
        <x-listar-post :posts="$posts" />
    @else
        <h2 class="mb-6 text-2xl font-bold text-center">Usuarios registrados</h2>
        <div class="grid gap-6 px-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($usuarios as $usuario)
                <a href="{{ route('posts.index', $usuario->username) }}" class="flex items-center justify-start w-full max-w-xs p-4 mx-auto bg-white rounded-lg shadow-md hover:bg-gray-100">
                    <img src="{{ $usuario->imagen ? asset('perfiles/' . $usuario->imagen) : asset('img/usuario.svg') }}" 
                         class="object-cover w-12 h-12 mr-4 rounded-full" 
                         alt="Imagen de {{ $usuario->username }}">
                    <p class="text-lg font-semibold text-gray-700">{{ $usuario->username }}</p>
                </a>
            @endforeach
        </div>
    @endif

@endsection
