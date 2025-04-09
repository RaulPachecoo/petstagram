@extends('layouts.app')

@section('titulo')
    Perfil:{{ $user->username }}
@endsection

@section('contenido')

    <div class="flex justify-center">
        <div class="flex flex-col items-center w-full md:w-8/12 lg:w-6/12 md:flex-row">
            <div class="w-8/12 px-5 lg:w-6/12">
                <img class="object-cover w-48 h-48 rounded-full"
                    src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}"
                    alt="Imagen Usuario">

            </div>
            <div
                class="flex flex-col items-center px-5 py-10 md:w-8/12 lg:w-6/12 md:justify-center md:items-start md:py-10">
                <div class="flex items-center gap-2">
                    <p class="text-2xl text-gray-700">{{ $user->username }}</p>

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
                <p class="mt-5 mb-3 text-sm font-bold text-gray-800">
                    {{ $user->followers->count() }}
                    <span class="font-normal">@choice('Seguidor|Seguidores', $user->followers->count())</span>
                </p>
                <p class="mb-3 text-sm font-bold text-gray-800">
                    {{ $user->following->count() }}
                    <span class="font-normal">Siguiendo</span>
                </p>
                <p class="mb-3 text-sm font-bold text-gray-800">
                    {{ $user->posts->count() }}
                    <span class="font-normal">Posts</span>
                </p>
                @auth
                    @if($user->id !== Auth::user()->id)
                        @if(!$user->siguiendo(Auth::user()))
                            <form action="{{ route('users.follow', $user) }}" method="POST">
                                @csrf
                                <input type="submit"
                                    class="px-3 py-1 text-xs font-bold text-white uppercase bg-blue-600 rounded-lg cursor-pointer"
                                    value="Seguir">
                            </form>
                        @else
                            <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit"
                                    class="px-3 py-1 text-xs font-bold text-white uppercase bg-red-600 rounded-lg cursor-pointer"
                                    value="Dejar de Seguir">
                            </form>
                        @endif
                    @endif

                @endauth
            </div>
        </div>
    </div>

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
            <p class="text-sm font-bold text-center text-gray-600 uppercase">Todavia no hay publicaciones</p>
        @endif
    </section>
@endsection