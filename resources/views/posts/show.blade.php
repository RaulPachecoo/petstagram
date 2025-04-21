@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container px-10 mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
            <div class="flex items-center gap-4 p-3">
                @auth
                    <livewire:like-post :post="$post" />
                @endauth
            </div>
            <div>
                <p class="font-bold">{{ $post->user->username }}</p>
                <p class="text-sm text-gray-500">
                    {{ $post->created_at->diffForHumans() }}
                </p>
                <p class="mt-5">
                    {{ $post->descripcion }}
                </p>
            </div>
            @auth
                @if ($post->user_id === Auth::user()->id)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Eliminar Publicación"
                            class="p-2 mt-4 font-bold text-white bg-red-500 rounded cursor-pointer hover:bg-red-600" />
                    </form>
                @endif
            @endauth
        </div>

        <div class="p-5 md:w-1/2">
            <div class="p-5 mb-5 bg-white shadow">
                <livewire:comentarios :post="$post" />
            </div>
        </div>
    </div>
@endsection
