<div class="flex flex-col max-w-6xl min-h-screen gap-6 mx-auto md:flex-row">
    <!-- Botón para abrir modal (solo en móviles) -->
    <div class="flex items-center justify-between px-4 mb-4 md:hidden">
        <button onclick="toggleModal()" class="px-4 py-2 text-sm font-semibold text-white transition rounded-lg bg-pet-acento hover:bg-pet-acentoOscuro">
            Usuarios
        </button>
    </div>

    <!-- Modal de usuarios (solo para móviles) -->
    <div id="userModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 md:hidden">
        <div class="bg-pet-fondoTarjeta rounded-2xl w-[90%] max-h-[80vh] overflow-y-auto p-4 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-pet-marron">Usuarios Seguidos</h3>
                <button onclick="toggleModal()" class="text-xl transition text-pet-marron hover:text-pet-acento">&times;</button>
            </div>

            @if($followedUsers->isEmpty())
            <p class="text-sm text-pet-acento">No sigues a nadie aún.</p>
            @else
            <ul class="divide-y divide-pet-crema">
                @foreach ($followedUsers as $followedUser)
                @php
                $unreadCount = $unreadMessages[$followedUser->id] ?? 0;
                @endphp
                <li class="px-4 py-2 transition-all rounded-md cursor-pointer hover:bg-pet-crema">
                    <a wire:click="changeReceiver({{ json_encode($followedUser->username) }})" onclick="toggleModal()"
                        class="flex items-center gap-2 cursor-pointer">
                        <img class="object-cover w-6 h-6 rounded-full"
                            src="{{ $followedUser->imagen ? asset('perfiles/' . $followedUser->imagen) : asset('img/usuario.svg') }}"
                            alt="Imagen de perfil de {{ $followedUser->username }}">
                        <span class="text-sm text-pet-marron">{{ $followedUser->username }}</span>
                        @if ($unreadCount > 0)
                        <span class="w-2 h-2 ml-1 rounded-full bg-pet-acento"></span>
                        @endif
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

    <!-- Lista de usuarios seguidos para escritorio -->
    <div class="hidden md:block md:w-1/4 p-4 bg-pet-fondoTarjeta shadow rounded-2xl h-[70vh] overflow-y-auto">
        <h3 class="mb-3 text-lg font-bold text-pet-marron">Usuarios Seguidos</h3>
        @if($followedUsers->isEmpty())
        <p class="text-sm text-pet-acento">No sigues a nadie aún.</p>
        @else
        <ul class="divide-y divide-pet-crema">
            @foreach ($followedUsers as $followedUser)
            @php
            $unreadCount = $unreadMessages[$followedUser->id] ?? 0;
            @endphp

            <li class="px-4 py-2 transition-all rounded-md cursor-pointer hover:bg-pet-crema">
                <a wire:click="changeReceiver({{ json_encode($followedUser->username) }})"
                    class="flex items-center gap-2 cursor-pointer">
                    <img class="object-cover w-6 h-6 rounded-full"
                        src="{{ $followedUser->imagen ? asset('perfiles/' . $followedUser->imagen) : asset('img/usuario.svg') }}"
                        alt="Imagen de perfil de {{ $followedUser->username }}">
                    <span class="text-sm text-pet-marron">{{ $followedUser->username }}</span>
                    @if ($unreadCount > 0)
                    <span class="w-2 h-2 ml-1 rounded-full bg-pet-acento"></span>
                    @endif
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

    <!-- Chat con el usuario seleccionado -->
    <div class="p-4 md:p-6 bg-pet-fondoTarjeta shadow md:w-3/4 rounded-2xl flex flex-col h-full md:h-[70vh]">
        @if ($receiver)
        <h3 class="pb-2 mb-4 text-xl font-semibold border-b text-pet-marron border-pet-crema">
            <a href="{{ route('posts.index', $receiver) }}" class="flex items-center gap-2">
                <img class="object-cover w-6 h-6 rounded-full"
                    src="{{ $receiver->imagen ? asset('perfiles/' . $receiver->imagen) : asset('img/usuario.svg') }}"
                    alt="Imagen de perfil de {{ $receiver->username }}">
                {{ $receiver->username }}
            </a>
        </h3>

        <!-- Mensajes -->
        <div id="chat-container"
            class="flex-1 overflow-y-auto p-3 md:p-4 bg-pet-crema rounded shadow mb-4 space-y-2 max-h-[60vh] md:max-h-[55vh]">
            @foreach ($chatMessages as $message)
            <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div
                    class="max-w-[85%] px-3 py-2 text-sm rounded-lg shadow
                                {{ $message->sender_id === auth()->id() ? 'bg-pet-acento text-white rounded-br-none' : 'bg-pet-beige text-pet-marron rounded-bl-none' }}">
                    <span class="block mb-1 text-xs font-semibold">
                        {{ $message->sender_id === auth()->id() ? 'Tú' : $message->sender->username }}
                    </span>
                    <p class="leading-tight break-words">
                        {{ $message->body }}
                    </p>
                </div>
            </div>
            @endforeach
            <div id="chat-bottom"></div>
        </div>

        <!-- Input fijo al fondo -->
        <form wire:submit.prevent="sendMessage"
            class="sticky bottom-0 z-10 flex items-center gap-2 pt-2 mt-auto border-t bg-pet-fondoTarjeta border-pet-crema">
            <input wire:model="messageBody" type="text" placeholder="Escribe un mensaje..."
                class="w-full p-2 border rounded-lg shadow border-pet-crema focus:outline-none focus:ring-2 focus:ring-pet-acento" />
            @error('messageBody') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            <button type="submit" class="p-2 text-white transition rounded-lg bg-pet-acento hover:bg-pet-acentoOscuro">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </button>
        </form>
        @else
        <p class="text-pet-acento">Selecciona un usuario para comenzar una conversación.</p>
        @endif
    </div>
</div>

<script>
    function toggleModal() {
        const modal = document.getElementById('userModal');
        modal.classList.toggle('hidden');
    }
</script>
