@extends('layouts.app')

@section('titulo', $entry->title)

@section('contenido')
    <article class="max-w-3xl p-6 mx-auto bg-white border border-gray-200 shadow-lg rounded-2xl">

        @if($entry->image)
            <img src="{{ asset('entries/' . $entry->image) }}" alt="{{ $entry->title }}"
                 class="object-cover w-full h-64 mb-6 rounded-xl">
        @endif

        <div class="text-lg leading-relaxed text-gray-700 whitespace-pre-line">
            {!! nl2br(e($entry->content)) !!}
        </div>

        <a href="{{ route('blog.index') }}"
           class="inline-block mt-8 font-medium text-pet-acento hover:text-pet-acentoOscuro">
            ← Volver al blog
        </a>
    </article>
@endsection
