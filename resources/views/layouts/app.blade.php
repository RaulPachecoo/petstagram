<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('styles')
    <title>Petstagram - @yield('titulo')</title>
    <link rel="icon" href="{{ asset('img/logo2.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('img/logo2.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Poppins:wght@700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
</head>

<body class="bg-pet-beige" x-data="{ buscarOpen: false }">
    {{-- ENCABEZADO DESKTOP --}}
    <header class="hidden bg-pet-beige md:block">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-2xl font-extrabold petstagram-logo text-pet-marron">
                <img src="{{ asset('img/logo2.png') }}" alt="Logo de Petstagram" class="w-10 h-auto">
                Petstagram
            </a>

            <nav class="flex items-center gap-6">
                @auth
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-pet-marron" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </div>
                    <livewire:buscar-usuarios />
                </div>

                {{-- Blog a la derecha del buscador para usuarios logueados --}}
                <a href="{{ route('blog.index') }}"
                    class="ml-2 text-sm font-semibold uppercase transition text-pet-marron hover:text-pet-acento">
                    Blog
                </a>
                <livewire:notificaciones-chat />

                 @if(auth()->user()->rol === 'user')
                <a href="{{ route('posts.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white transition rounded bg-pet-acento hover:bg-pet-acentoOscuro">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Crear
                </a>
                @endif

                <a href="{{ route('posts.index', Auth::user()->username) }}"
                    class="flex items-center gap-2 mr-2 text-sm font-semibold text-pet-marron">
                    <img src="{{ auth()->user()->imagen ? asset('perfiles/' . auth()->user()->imagen) : asset('img/usuario.svg') }}"
                        alt="Avatar" class="object-cover w-6 h-6 rounded-full">
                    Perfil
                </a>

                <form method="POST" action="{{ route('logout') }}" class="ml-6">
                    @csrf
                    <button type="submit"
                        class="text-sm font-semibold uppercase transition text-pet-marron hover:text-pet-acentoOscuro">
                        Cerrar Sesión
                    </button>
                </form>
                @endauth

                @guest
                {{-- Blog visible para usuarios no logueados en su posición original --}}
                <a href="{{ route('blog.index') }}"
                    class="text-sm font-semibold uppercase transition text-pet-marron hover:text-pet-acento">
                    Blog
                </a>

                <a class="text-sm font-semibold uppercase transition text-pet-marron hover:text-pet-acento"
                    href="{{ route('login') }}">Login</a>
                <a class="text-sm font-semibold uppercase transition text-pet-acento"
                    href="{{ route('register') }}">Crear Cuenta</a>
                @endguest
            </nav>
        </div>
    </header>

   
    {{-- ENCABEZADO MÓVIL --}}
    <header class="mobile-header md:hidden">
        <div class="container relative flex items-center justify-center p-2 mx-auto">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-extrabold text-pet-marron">
                <img src="{{ asset('img/logo2.png') }}" alt="Logo de Petstagram" class="w-6 h-auto">
                Petstagram
            </a>

            <a href="{{ route('blog.index') }}" class="absolute left-2 text-pet-acento hover:text-pet-acentoOscuro"
                aria-label="Blog">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 50 50" fill="currentColor"
                    role="img" aria-hidden="true">
                    <path
                        d="M 9 4 C 6.2504839 4 4 6.2504839 4 9 L 4 41 C 4 43.749516 6.2504839 46 9 46 L 41 46 C 43.749516 46 46 43.749516 46 41 L 46 9 C 46 6.2504839 43.749516 4 41 4 L 9 4>
                    </path>
                </svg>
            </a>



            @auth
            <div class="absolute right-2">
                <livewire:notificaciones-chat />
            </div>
            @endauth
        </div>
    </header>

    {{-- BUSCADOR MÓVIL --}}
    <div x-show="buscarOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 md:hidden">
        <div class="relative w-11/12 p-4 bg-white rounded-lg">
            <button @click="buscarOpen = false" class="absolute text-gray-600 top-2 right-2 hover:text-red-500">
                ✕
            </button>
            <livewire:buscar-usuarios />
        </div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="container mx-auto mt-6 mb-16 md:mb-10">
        @if(trim($__env->yieldContent('titulo')) !== 'Página Principal')
        <h2 class="mb-10 text-3xl font-black text-center text-pet-marron">
            @yield('titulo')
        </h2>
        @endif

        @yield('contenido')
    </main>


    {{-- PIE DE PÁGINA --}}
    <footer class="hidden p-5 mt-10 font-bold text-center uppercase text-pet-marron md:block">
        © Petstagram - Todos los derechos reservados - Raúl Pacheco Ropero {{ now()->year }}
    </footer>


    {{-- NAVEGACIÓN INFERIOR MÓVIL --}}
    <nav
        class="fixed bottom-0 left-0 right-0 z-40 flex justify-around py-2 border-t shadow-inner bg-pet-fondoTarjeta md:hidden">
        @auth
        <a href="{{ route('home') }}" class="flex flex-col items-center text-pet-marron">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 9.75L12 4l9 5.75V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z" />
            </svg>
        </a>
        <a href="#" @click.prevent="buscarOpen = true" class="flex flex-col items-center text-pet-acento">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </a>
        @if(auth()->user()->rol === 'user')
        <a href="{{ route('posts.create') }}" class="flex flex-col items-center text-pet-acentoOscuro">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </a>
        @endif
        <a href="{{ route('posts.index', Auth::user()->username) }}" class="flex flex-col items-center text-pet-marron">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5.121 17.804A9.953 9.953 0 0112 15c2.21 0 4.253.722 5.879 1.938M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </a>
        @endauth
    </nav>

    @livewireScripts
    @stack('scripts')
</body>

</html>
