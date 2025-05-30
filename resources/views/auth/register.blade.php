@extends('layouts.app')

@section('titulo')
Regístrate en Petstagram
@endsection

@section('contenido')
<div class="md:flex md:justify-center md:gap-10 md:items-center">
    <div class="p-5 md:w-6/12">
        <img src="{{ asset('img/registro.png') }}" alt="Imagen registro de usuarios">
    </div>
    <div class="p-6 rounded-lg shadow-xl md:w-4/12 bg-pet-fondoTarjeta">
        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf
            <div class="mb-5">
                <label for="name" class="block mb-2 font-bold uppercase text-pet-marron">Nombre</label>
                <input id="name" name="name" type="text" placeholder="Tu Nombre"
                    class="w-full p-3 border rounded-lg @error('name') border-red-500 @enderror"
                    value="{{ old('name') }}">
                @error('name')
                <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="username" class="block mb-2 font-bold uppercase text-pet-marron">Username</label>
                <input id="username" name="username" type="text" placeholder="Tu Nombre de Usuario"
                    class="w-full p-3 border rounded-lg @error('username') border-red-500 @enderror"
                    value="{{ old('username') }}">
                @error('username')
                <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                @enderror
            </div>

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
                <label for="password_confirmation" class="block mb-2 font-bold uppercase text-pet-marron">Repetir
                    Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    placeholder="Repite tu Password" class="w-full p-3 border rounded-lg">
                @error('password_confirmation')
                <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                @enderror
            </div>

            <input type="submit" value="Crear Cuenta"
                class="w-full p-3 font-bold text-white uppercase transition-colors rounded-lg cursor-pointer bg-pet-acento hover:bg-pet-acentoOscuro">
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-pet-marron">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="font-semibold text-pet-acento hover:text-pet-acentoOscuro hover:underline">
                    Inicia sesión
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
