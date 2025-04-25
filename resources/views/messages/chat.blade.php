@extends('layouts.app')

@section('titulo')
    Chat con {{ $receiver->username }}
@endsection

@section('contenido')
<div class="flex flex-col max-w-6xl gap-6 mx-auto md:flex-row">
    <!-- Lista de usuarios seguidos -->
    <div class="p-4 bg-white shadow md:w-1/4 rounded-2xl h-[70vh] overflow-y-auto">
        <h3 class="mb-3 text-lg font-bold text-gray-700">Usuarios Seguidos</h3>

        @php
            $followedUsers = Auth::user()->following ?? collect();
        @endphp

        @if($followedUsers->isEmpty())
            <p class="text-sm text-gray-500">No sigues a nadie aún.</p>
        @else
            <ul class="divide-y divide-gray-100">
                @foreach ($followedUsers as $followedUser)
                    <li class="px-4 py-2 transition-all rounded-md hover:bg-gray-100">
                        <a href="{{ route('chat', ['user' => $followedUser->username]) }}" class="flex items-center gap-2">
                            <img class="object-cover w-6 h-6 rounded-full"
                                src="{{ $followedUser->imagen ? asset('perfiles/' . $followedUser->imagen) : asset('img/usuario.svg') }}"
                                alt="Imagen de perfil de {{ $followedUser->username }}">
                            <span class="text-sm text-gray-700">{{ $followedUser->username }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Chat con el usuario seleccionado -->
    <div class="p-6 bg-white shadow md:w-3/4 rounded-2xl h-[70vh] flex flex-col">
        <h3 class="pb-2 mb-4 text-xl font-semibold text-gray-700 border-b">Conversación con {{ $receiver->username }}</h3>
        <div class="flex-1 overflow-y-auto">
            <livewire:chat :receiver="$receiver" :chatMessages="$chatMessages" />
        </div>
    </div>
</div>

@endsection
