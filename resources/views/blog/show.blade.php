@extends('layouts.app')

@section('titulo', $entry->title)

@section('contenido')
<article class="max-w-3xl p-6 mx-auto border shadow-lg bg-pet-fondoTarjeta border-pet-crema rounded-2xl">

    @if($entry->image)
        <img src="{{ asset('entries/' . $entry->image) }}" alt="{{ $entry->title }}"
             class="object-cover w-full h-64 mb-6 shadow-md rounded-xl">
    @endif

    <div class="text-lg leading-relaxed whitespace-pre-line text-pet-marron">
        {!! nl2br(e($entry->content)) !!}
    </div>

    <a href="{{ route('blog.index') }}"
       class="inline-block mt-8 font-medium text-pet-acento hover:text-pet-acentoOscuro">
        ← Volver al blog
    </a>
</article>
@endsection
