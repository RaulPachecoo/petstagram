@extends('layouts.app')

@section('titulo')
Perfil:{{ $user->username }}
@endsection

@section('contenido')

<div class="flex justify-center">
    <div class="flex flex-col items-center justify-center w-full gap-4 md:w-8/12 lg:w-6/12 md:flex-row">
        <div class="w-[260px] px-5 h-auto">
            <img class="object-cover w-full h-full rounded-full"
                src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}"
                alt="Imagen Usuario">
        </div>

        <div class="flex flex-col items-center px-5 py-10 md:justify-center md:items-start md:py-10">
            <div class="flex items-center gap-2">
                <p class="mb-5 text-2xl text-gray-700">{{ $user->username }}</p>

                @auth
                @if($user->id === Auth::user()->id)
                <a href="{{ route('perfil.index') }}" class="text-gray-500 cursor-pointer hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path
                            d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
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
    <h2 class="my-10 text-4xl font-black text-center">Publicaciones</h2>
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
    <p class="text-sm font-bold text-center text-gray-600 uppercase">Todavía no hay publicaciones</p>
    @endif
</section>
@endif
@endsection