@extends('layouts.app')

@section('titulo')
    Recuperar Contraseña
@endsection

@section('contenido')
<div class="md:flex md:justify-center md:gap-10 md:items-center">
    <div class="p-5 md:w-6/12">
        <img src="{{ asset('img/login.png') }}" alt="Imagen recuperación de contraseña">
    </div>
    <div class="p-6 rounded-lg shadow-xl bg-pet-fondoTarjeta md:w-4/12">
        <h2 class="mb-6 text-2xl font-bold text-center text-pet-marron">¿Olvidaste tu contraseña?</h2>

        @if (session('status'))
            <p class="p-2 my-2 text-sm text-center text-white bg-green-500 rounded-lg">
                {{ session('status') }}
            </p>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-5">
                <label for="email" class="block mb-2 font-bold uppercase text-pet-marron">Email</label>
                <input id="email" name="email" type="email" placeholder="Tu email registrado"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-pet-acento @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}">
                @error('email')
                    <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                @enderror
            </div>

            <input type="submit" value="Enviar enlace de recuperación"
                class="w-full p-3 font-bold text-white uppercase transition-colors rounded-lg cursor-pointer bg-pet-acento hover:bg-pet-acentoOscuro">
        </form>
    </div>
</div>
@endsection
