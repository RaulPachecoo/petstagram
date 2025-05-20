@extends('layouts.app')

@section('titulo')
Perfil: {{ $user->username }}
@endsection

@section('contenido')

<div class="flex justify-center">
    <div class="flex flex-row items-center justify-center w-auto gap-4 mx-auto md:w-8/12 lg:w-6/12">
        <!-- Imagen de perfil -->
        <div class="w-28 h-28 md:w-[260px] md:px-5 md:h-auto flex-shrink-0 flex items-center justify-center">
            <img class="object-cover w-24 h-24 rounded-full md:w-full md:h-full" src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}" alt="Imagen Usuario">
        </div>

        <!-- Info de usuario -->
        <div class="flex flex-col items-start px-2 py-4 md:items-start md:px-5 md:py-10">
            <div class="flex items-center gap-2">
                <p class="mb-3 text-lg font-semibold text-pet-marron md:mb-5 md:text-2xl">{{ $user->username }}</p>
                @auth
                @if($user->id === Auth::user()->id)
                <a href="{{ route('perfil.index') }}" class="transition-colors cursor-pointer text-pet-acento hover:text-pet-acentoOscuro">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                    </svg>
                </a>
                @endif
                @endauth
            </div>

            @auth
                @if(auth()->user()->rol === 'user')
                    @livewire('follow-button', ['user' => $user])

                    @if(auth()->user()->id !== $user->id && auth()->user()->siguiendo($user))
                        <a href="{{ route('chat', ['user' => $user->username]) }}"
                            class="inline-flex items-center justify-center px-4 py-2 mt-4 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                            Enviar Mensaje
                        </a>
                    @endif
                @endif
            @endauth
        </div>
    </div>
</div>

@if($user->rol === 'user')
<section class="container px-6 mx-auto mt-10">
    <h2 class="my-10 text-4xl font-black text-center text-pet-marron">Publicaciones</h2>
    @if($posts->count())
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($posts as $post)
        <div>
            <a href="{{ route('posts.show', ['post' => $post, 'user' => $user]) }}">
                <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
            </a>
        </div>
        @endforeach
    </div>

    <div class="my-10">
        {{ $posts->links('pagination::tailwind') }}
    </div>

    @else
    <p class="text-sm font-bold text-center uppercase text-pet-marron">Todavía no hay publicaciones</p>
    @endif
</section>
@endif
@endsection
