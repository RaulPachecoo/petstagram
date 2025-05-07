@extends('layouts.app')

@section('titulo')
Crea una nueva Publicación
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('contenido')
<div class="md:flex md:items-center">
    <div class="px-10 md:w-1/2">
        <form action="{{ route('imagenes.store') }}" method="POST" enctype="multipart/form-data" id="dropzone"
            class="flex flex-col items-center justify-center w-full border-2 border-dashed rounded dropzone h-96">
            @csrf
        </form>
    </div>

    <div class="p-10 mt-10 bg-white rounded-lg shadow-xl md:w-1/2 md:mt-0">
        <div id="error-container" class="hidden mb-4">
            <div class="flex items-start gap-2 p-4 text-sm text-red-800 bg-red-100 border border-red-300 rounded-lg" role="alert">
                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11.414V6a1 1 0 10-2 0v.586a1 1 0 00.293.707L10 9l.707-.707a1 1 0 00.293-.707zM9 12a1 1 0 112 0 1 1 0 01-2 0z"
                        clip-rule="evenodd" />
                </svg>
                <div id="error-messages" class="flex flex-col gap-1"></div>
            </div>
        </div>
        

        <form id="postForm" action="{{ route('posts.store') }}" method="POST" novalidate>
            @csrf
            <div class="mb-5">
                <label for="titulo" class="block mb-2 font-bold text-gray-500 uppercase">Título</label>
                <input id="titulo" name="titulo" type="text" placeholder="Título de la Publicación"
                    class="w-full p-3 border rounded-lg" value="{{ old('titulo') }}">
            </div>
            <div class="mb-5">
                <label for="descripcion" class="block mb-2 font-bold text-gray-500 uppercase">Descripción</label>
                <textarea id="descripcion" name="descripcion" placeholder="Descripción de la Publicación"
                    class="w-full p-3 border rounded-lg">{{ old('descripcion') }}</textarea>
            </div>
            <div class="mb-5">
                <input name="imagen" type="hidden" value="{{ old('imagen') }}" />
            </div>

            <input type="submit" value="Crear Publicación"
                class="w-full p-3 font-bold text-white uppercase transition-colors rounded-lg cursor-pointer bg-sky-600 hover:bg-sky-700">
        </form>
    </div>
</div>
@endsection
