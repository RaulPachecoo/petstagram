@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{ Auth::user()->username }}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="p-6 bg-white shadow md:w-1/2">
            <form method="POST" action="{{ route('perfil.store') }}" enctype="multipart/form-data" class="mt-10 md:mt-0">
                @csrf
                <div class="mb-5">
                    <label for="username" class="block mb-2 font-bold text-gray-500 uppercase">Username</label>
                    <input id="username" name="username" type="text" placeholder="Tu Nombre de Usuario" class="w-full p-3 border rounded-lg @error('username') border-red-500 @enderror" value="{{ Auth::user()->username }}">
                    @error('username')
                        <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo Email -->
                <div class="mb-5">
                    <label for="email" class="block mb-2 font-bold text-gray-500 uppercase">Email</label>
                    <input id="email" name="email" type="email" placeholder="Tu Email" class="w-full p-3 border rounded-lg @error('email') border-red-500 @enderror" value="{{ Auth::user()->email }}">
                    @error('email')
                        <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo Contraseña -->
                <div class="mb-5">
                    <label for="password" class="block mb-2 font-bold text-gray-500 uppercase">Contraseña Nueva</label>
                    <input id="password" name="password" type="password" placeholder="Nueva Contraseña (Opcional)" class="w-full p-3 border rounded-lg @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-5">
                    <label for="password_confirmation" class="block mb-2 font-bold text-gray-500 uppercase">Confirmar Contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirmar Contraseña" class="w-full p-3 border rounded-lg @error('password_confirmation') border-red-500 @enderror">
                    @error('password_confirmation')
                        <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="imagen" class="block mb-2 font-bold text-gray-500 uppercase">Imagen Perfil</label>
                    <input id="imagen" name="imagen" type="file" class="w-full p-3 border rounded-lg" accept=".jpg, .jpeg, .png">
                </div>

                <input type="submit" value="Guardar Cambios" class="w-full p-3 font-bold text-white uppercase transition-colors rounded-lg cursor-pointer bg-sky-600 hover:bg-sky-700">
            </form>
        </div>
    </div>
@endsection
