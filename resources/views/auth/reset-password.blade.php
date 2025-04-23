@extends('layouts.app')

@section('titulo')
    Restablecer Contraseña
@endsection

@section('contenido')
<div class="md:flex md:justify-center md:gap-10 md:items-center">
    <div class="p-5 md:w-6/12">
        <img src="{{ asset('img/registro.png') }}" alt="Imagen reset contraseña">
    </div>
    <div class="p-6 bg-white rounded-lg shadow-xl md:w-4/12">
        <h2 class="mb-6 text-2xl font-bold text-center">Establece una nueva contraseña</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-5">
                <label for="email" class="block mb-2 font-bold text-gray-500 uppercase">Email</label>
                <input id="email" name="email" type="email" class="w-full p-3 border rounded-lg @error('email') border-red-500 @enderror"
                    value="{{ old('email', $email ?? '') }}" readonly>
                @error('email')
                    <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password" class="block mb-2 font-bold text-gray-500 uppercase">Nueva Contraseña</label>
                <input id="password" name="password" type="password" class="w-full p-3 border rounded-lg @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password_confirmation" class="block mb-2 font-bold text-gray-500 uppercase">Confirmar Contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full p-3 border rounded-lg">
            </div>

            <input type="submit" value="Restablecer contraseña"
                class="w-full p-3 font-bold text-white uppercase transition-colors rounded-lg cursor-pointer bg-sky-600 hover:bg-sky-700">
        </form>
    </div>
</div>
@endsection
