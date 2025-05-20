@extends('layouts.app')

@section('titulo')
Inicia Sesión en Petstagram
@endsection

@section('contenido')
<div class="md:flex md:justify-center md:gap-10 md:items-center">
    <div class="p-5 md:w-6/12">
        <img src="{{ asset('img/login.png') }}" alt="Imagen login de usuarios">
    </div>
    <div class="p-6 rounded-lg shadow-xl md:w-4/12 bg-pet-fondoTarjeta">
        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf
            @if (session('mensaje'))
            <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ session('mensaje') }}</p>
            @endif

            <div class="mb-5">
                <label for="email" class="block mb-2 font-bold uppercase text-pet-marron">Email</label>
                <input id="email" name="email" type="email" placeholder="Tu Email de Registro"
                    class="w-full p-3 border rounded-lg @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}">
                @error('email')
                <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password" class="block mb-2 font-bold uppercase text-pet-marron">Password</label>
                <input id="password" name="password" type="password" placeholder="Password de Registro"
                    class="w-full p-3 border rounded-lg @error('password') border-red-500 @enderror">
                @error('password')
                <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <input type="checkbox" name="remember">
                <label class="text-sm text-pet-marron"> Mantener sesión abierta</label>
            </div>

            <input type="submit" value="Iniciar Sesión"
                class="w-full p-3 font-bold text-white uppercase transition-colors rounded-lg cursor-pointer bg-pet-acento hover:bg-pet-acentoOscuro">
        </form>

        <div class="mb-5 text-right">
            <a href="{{ route('password.request') }}" class="text-sm text-pet-acento hover:text-pet-acentoOscuro hover:underline">
                ¿Olvidaste tu contraseña?
            </a>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-pet-marron">
                ¿Aún no tienes cuenta?
                <a href="{{ route('register') }}" class="font-semibold text-pet-acento hover:text-pet-acentoOscuro hover:underline">
                    Crea una
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
