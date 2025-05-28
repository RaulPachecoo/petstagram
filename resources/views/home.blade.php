@extends('layouts.app')

@section('titulo')
Página Principal
@endsection

@section('contenido')
<div class="container px-6 mx-auto">
    @if(auth()->user()->rol === 'user')
    @if($posts->count())
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($posts as $post)
        <div
            class="relative flex flex-col justify-between overflow-hidden transition-transform transform shadow-lg rounded-2xl hover:-translate-y-1 hover:shadow-xl bg-pet-crema min-h-[500px]">
            <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                <!-- Encabezado del usuario -->
                <div class="flex items-center gap-3 px-4 py-3 bg-pet-crema">
                    <img src="{{ $post->user->imagen ? asset('perfiles/' . $post->user->imagen) : asset('img/usuario2.svg') }}"
                        alt="Imagen de {{ $post->user->username }}"
                        class="object-cover w-8 h-8 border rounded-full border-pet-crema">
                    <a href="{{ route('posts.index', $post->user->username) }}"
                        class="text-sm font-semibold transition-colors duration-200 text-pet-marron hover:underline">
                        {{ $post->user->username }}
                    </a>
                </div>

                <!-- Imagen del post -->
                <div class="overflow-hidden">
                    <img src="{{ asset('uploads/' . $post->imagen) }}" alt="Imagen del post {{ $post->titulo }}"
                        class="object-cover w-full h-64 transition-transform duration-300 hover:scale-105">
                </div>

                <!-- Contenido -->
                <div class="px-4 py-3 space-y-2 bg-pet-crema">
                    <a href="{{ route('posts.index', $post->user->username) }}"
                        class="block text-sm font-bold text-pet-marron hover:underline">
                        {{ $post->user->username }}
                    </a>
                    <p class="text-sm leading-snug text-pet-marron min-h-[48px]">{{ Str::limit($post->descripcion, 100)
                        }}</p>
                    <p class="text-xs text-pet-acento">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </a>

            <!-- Footer con acciones -->
            <div class="flex items-center justify-between px-4 py-2 mt-auto bg-pet-crema rounded-b-2xl">
                @auth
                <livewire:like-post :post="$post" />
                @endauth
                <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}"
                    class="text-sm font-medium transition-colors duration-200 text-pet-acento hover:underline">
                    Comentarios
                </a>
            </div>
        </div>
        @endforeach

    </div>

    <div class="my-10">
        {{ $posts->links('pagination::tailwind') }}
    </div>
    @else
    <div class="flex flex-col items-center justify-center h-64 text-center shadow-inner bg-pet-beige rounded-2xl">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4" viewBox="0 0 64 64">
            <g class="face">
                <circle cx="32" cy="32" r="30" fill="#FFD93B" />
                <circle cx="22" cy="26" r="4" fill="#3E4347" />
                <circle cx="42" cy="26" r="4" fill="#3E4347" />
                <path d="M22 44c2.5-3 6.5-5 10-5s7.5 2 10 5" fill="none" stroke="#3E4347" stroke-width="3"
                    stroke-linecap="round" />
            </g>
            <path class="tear" d="M22.5 35c0-4 3-6 3-6s3 2 3 6a3 3 0 0 1 -6 0z" fill="#4BB9EC" />
        </svg>

        <h2 class="mb-2 text-xl font-semibold text-pet-marron">No hay posts aún</h2>
        <p class="text-pet-acento">Sigue a otros usuarios para ver sus publicaciones aquí.</p>
    </div>
    @endif
    @else
    <h2 class="mb-6 text-2xl font-bold text-center text-pet-marron">Usuarios registrados</h2>
    <div class="grid gap-6 px-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($usuarios as $usuario)
        <a href="{{ route('posts.index', $usuario->username) }}"
            class="flex items-center w-full max-w-xs p-4 mx-auto transition-transform transform shadow-md bg-pet-fondoTarjeta rounded-2xl hover:-translate-y-1 hover:shadow-lg hover:bg-pet-crema">
            <img src="{{ $usuario->imagen ? asset('perfiles/' . $usuario->imagen) : asset('img/usuario.svg') }}"
                class="object-cover w-12 h-12 mr-4 border rounded-full border-pet-crema"
                alt="Imagen de {{ $usuario->username }}">
            <p class="text-lg font-semibold text-pet-marron">{{ $usuario->username }}</p>
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection