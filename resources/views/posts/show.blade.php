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
                    @if(auth()->user()->rol !== 'admin')
                        <livewire:like-post :post="$post" />
                    @endif
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
                @if ($post->user_id === Auth::user()->id || Auth::user()->rol === 'admin')
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
               
                @if (Auth::user()->rol === 'admin') <!-- Los comentarios se muestran para todos los usuarios -->
                    <div>
                   
                        <h3 class="text-lg font-bold">Comentarios</h3>
                        <ul class="mt-4">
                            @foreach($post->comentarios as $comentario)
                                <li class="mb-4">
                                    <div class="flex items-center justify-between">
                                        <p class="font-semibold">{{ $comentario->user->username }}</p>
                                        @if(auth()->user()->rol === 'admin')
                                            <form method="POST" action="{{ route('comentarios.destroy', $comentario) }}">
                                                @method('DELETE')
                                                @csrf
                                                <input type="submit" value="Eliminar Comentario"
                                                    class="font-bold text-red-500 cursor-pointer hover:text-red-600" />
                                            </form>
                                        @endif
                                    </div>
                                    <p class="text-gray-600">{{ $comentario->comentario }}</p>
                                </li>
                            @endforeach
                        </ul>
                    
                    </div>
                @endif
                <!-- Permitir que los usuarios normales comenten, pero no los administradores -->
                @auth
                    @if(auth()->user()->rol !== 'admin')
                        <livewire:comentarios :post="$post" />
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endsection
