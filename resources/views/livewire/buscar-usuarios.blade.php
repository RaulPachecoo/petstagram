<div class="relative">
    <input
        type="text"
        wire:model.live="search"
        placeholder="Buscar usuarios..."
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
    />


    @if(strlen($search) >= 2)
        <ul class="absolute left-0 right-0 z-10 mt-1 bg-white border rounded shadow-lg">
            @forelse($usuarios as $usuario)
        <li class="px-4 py-2 hover:bg-gray-100">
            <a href="{{ route('posts.index', $usuario) }}" class="flex items-center gap-2">
                <!-- Imagen de perfil o el ícono por defecto -->
                <img class="object-cover w-6 h-6 rounded-full"
                    src="{{ $usuario->imagen ? asset('perfiles/' . $usuario->imagen) : asset('img/usuario.svg') }}"
                    alt="Imagen de perfil de {{ $usuario->username }}">

                {{ $usuario->username }}
            </a>
        </li>
    @empty
        <li class="px-4 py-2 text-gray-500">No se encontraron usuarios.</li>
    @endforelse

        </ul>
    @endif
</div>

