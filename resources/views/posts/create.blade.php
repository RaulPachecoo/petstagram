@extends('layouts.app')

@section('titulo')
    Crea una nueva Publicación
@endsection

@section('contenido')
    <div class="md:flex md:items-center">
        <div class="md:w-1/2">
            Imagen aquí
        </div>

        <div class="p-10 mt-10 bg-white rounded-lg shadow-xl md:w-1/2 md:mt-0">
            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf
                <div class="mb-5">
                    <label for="titulo" class="block mb-2 font-bold text-gray-500 uppercase">Título</label>
                    <input id="titulo" name="titulo" type="text" placeholder="Título de la Publicación" class="w-full p-3 border rounded-lg @error('name') border-red-500 @enderror" value="{{ old('titulo') }}">
                    @error('titulo')
                        <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="descripcion" class="block mb-2 font-bold text-gray-500 uppercase">Descripción</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Descripción de la Publicación" class="w-full p-3 border rounded-lg @error('name') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                    @enderror
                </div>
                <input type="submit" value="Crear Publicación" class="w-full p-3 font-bold text-white uppercase transition-colors rounded-lg cursor-pointer bg-sky-600 hover:bg-sky-700">
            </form>
        </div>
    </div>
@endsection