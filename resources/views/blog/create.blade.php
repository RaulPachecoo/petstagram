@extends('layouts.app')

@section('titulo', 'Nueva Entrada')

@section('contenido')
    <div class="max-w-3xl mx-auto">
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block mb-1 font-semibold">Título</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring" value="{{ old('title') }}" required>
            </div>

            <div>
                <label for="content" class="block mb-1 font-semibold">Contenido</label>
                <textarea name="content" id="content" rows="6" class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring" required>{{ old('content') }}</textarea>
            </div>

            <div>
                <label for="image" class="block mb-1 font-semibold">Imagen (opcional)</label>
                <input type="file" name="image" id="image" class="w-full">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 text-white rounded-xl bg-pet-acento hover:bg-pet-acentoOscuro">
                    Publicar entrada
                </button>
            </div>
        </form>
    </div>
@endsection
