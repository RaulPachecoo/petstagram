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
            <a href="{{ route('password.request') }}"
                class="text-sm text-pet-acento hover:text-pet-acentoOscuro hover:underline">
                ¿Olvidaste tu contraseña?
            </a>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('google.login') }}" class="flex items-center justify-center w-full gap-3 px-4 py-2 font-bold uppercase transition-colors bg-white border-2 rounded-lg text-pet-marron border-pet-acento hover:bg>
                <svg class="w-5 h-5 " viewBox="0 0 48 48">
                <g>
                    <path fill="#4285F4"
                        d="M24 9.5c3.54 0 6.7 1.22 9.19 3.22l6.85-6.85C36.68 2.36 30.77 0 24 0 14.82 0 6.73 5.08 2.69 12.44l7.98 6.2C12.13 13.09 17.62 9.5 24 9.5z" />
                    <path fill="#34A853"
                        d="M46.1 24.55c0-1.64-.15-3.22-.42-4.74H24v9.01h12.42c-.54 2.9-2.18 5.36-4.65 7.01l7.19 5.59C43.93 37.36 46.1 31.45 46.1 24.55z" />
                    <path fill="#FBBC05"
                        d="M10.67 28.65c-1.13-3.36-1.13-6.99 0-10.35l-7.98-6.2C.7 16.09 0 19.95 0 24c0 4.05.7 7.91 2.69 11.9l7.98-6.2z" />
                    <path fill="#EA4335"
                        d="M24 48c6.48 0 11.92-2.15 15.89-5.85l-7.19-5.59c-2.01 1.35-4.59 2.15-8.7 2.15-6.38 0-11.87-3.59-14.33-8.85l-7.98 6.2C6.73 42.92 14.82 48 24 48z" />
                    <path fill="none" d="M0 0h48v48H0z" />
                </g>
                </svg>
                Inicia sesión con Google
            </a>
        </div>



        <div class="mt-6 text-center">
            <p class="text-sm text-pet-marron">
                ¿Aún no tienes cuenta?
                <a href="{{ route('register') }}"
                    class="font-semibold text-pet-acento hover:text-pet-acentoOscuro hover:underline">
                    Crea una
                </a>
            </p>
        </div>

    </div>
</div>
@endsection