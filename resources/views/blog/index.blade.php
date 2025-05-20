@extends('layouts.app')

@section('titulo', 'Blog')

@section('contenido')
<div class="px-4">
    @auth
        @if(auth()->user()->rol === 'admin')
            <div class="flex justify-start mb-6">
                <a href="{{ route('blog.create') }}"
                   class="px-5 py-2 text-white transition duration-300 shadow-md bg-pet-acento hover:bg-pet-acentoOscuro rounded-xl">
                    + Nueva entrada
                </a>
            </div>
        @endif
    @endauth

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($entries as $entry)
            <article class="p-4 transition duration-300 bg-white border border-gray-200 shadow-md rounded-2xl hover:shadow-lg">
                @if($entry->image)
                    <img src="{{ asset('entries/' . $entry->image) }}" alt="{{ $entry->title }}"
                         class="object-cover w-full h-48 mb-4 rounded-xl">
                @endif
                <h2 class="mb-2 text-xl font-bold text-gray-800">{{ $entry->title }}</h2>
                <p class="mb-3 text-gray-600">{{ Str::limit($entry->content, 150) }}</p>
                <a href="{{ route('blog.show', $entry->id) }}"
                   class="inline-block font-medium text-pet-acento hover:text-pet-acentoOscuro">
                    Leer más →
                </a>
            </article>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $entries->links() }}
    </div>
</div>
@endsection
