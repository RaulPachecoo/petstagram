<div class="relative w-full max-w-xs mx-auto md:mx-0">
    <!-- Contenedor con la lupa a la izquierda -->
    <div class="flex items-center border rounded-lg bg-pet-beige">
        <!-- Icono de lupa a la izquierda -->
        <div class="px-3">
            <svg class="w-5 h-5 text-pet-marron" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </div>

        <!-- Input con fondo transparente para igualar el fondo del contenedor -->
        <input
            type="text"
            wire:model.live="search"
            placeholder="Buscar usuarios..."
            class="w-full py-2 pl-2 pr-4 bg-transparent border-none focus:outline-none focus:ring focus:border-blue-300 text-pet-marron placeholder:text-pet-marron"
        />
    </div>

    @if(strlen($search) >= 2)
        <ul class="absolute left-0 right-0 z-10 mt-1 border rounded shadow-lg bg-pet-beige">
            @forelse($usuarios as $usuario)
                <li class="px-4 py-2 hover:bg-pet-crema">
                    <a href="{{ route('posts.index', $usuario) }}" class="flex items-center gap-2 text-pet-marron">
                        <img class="object-cover w-6 h-6 rounded-full"
                            src="{{ $usuario->imagen ? asset('perfiles/' . $usuario->imagen) : asset('img/usuario.svg') }}"
                            alt="Imagen de perfil de {{ $usuario->username }}">
                        {{ $usuario->username }}
                    </a>
                </li>
            @empty
                <li class="px-4 py-2 text-pet-marron">No se encontraron usuarios.</li>
            @endforelse
        </ul>
    @endif
</div>
