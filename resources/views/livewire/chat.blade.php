<div class="flex flex-col max-w-6xl gap-6 mx-auto md:flex-row">
    <!-- Lista de usuarios seguidos -->
    <div class="p-4 bg-white shadow md:w-1/4 rounded-2xl h-[70vh] overflow-y-auto">
        <h3 class="mb-3 text-lg font-bold text-gray-700">Usuarios Seguidos</h3>

        @if($followedUsers->isEmpty())
            <p class="text-sm text-gray-500">No sigues a nadie aún.</p>
        @else
            <ul class="divide-y divide-gray-100">
                @foreach ($followedUsers as $followedUser)
                    @php
                        $unreadCount = $unreadMessages[$followedUser->id] ?? 0;
                    @endphp

                    <li class="px-4 py-2 transition-all rounded-md hover:bg-gray-100">
                        <a wire:click="changeReceiver({{ json_encode($followedUser->username) }})" class="flex items-center gap-2 cursor-pointer">
                            <img class="object-cover w-6 h-6 rounded-full"
                                src="{{ $followedUser->imagen ? asset('perfiles/' . $followedUser->imagen) : asset('img/usuario.svg') }}"
                                alt="Imagen de perfil de {{ $followedUser->username }}">
                            <span class="text-sm text-gray-700">{{ $followedUser->username }}</span>
                            @if ($unreadCount > 0)
                                <span class="w-2 h-2 ml-1 bg-blue-500 rounded-full"></span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Chat con el usuario seleccionado -->
    <div class="p-6 bg-white shadow md:w-3/4 rounded-2xl h-[70vh] flex flex-col">
        @if ($receiver)
            <h3 class="pb-2 mb-4 text-xl font-semibold text-gray-700 border-b">
                <a href="{{ route('posts.index', $receiver) }}" class="flex items-center gap-2">
                    <img class="object-cover w-6 h-6 rounded-full"
                        src="{{ $receiver->imagen ? asset('perfiles/' . $receiver->imagen) : asset('img/usuario.svg') }}"
                        alt="Imagen de perfil de {{ $receiver->username }}">
                    {{ $receiver->username }}
                </a>
            </h3>

            <!-- Mensajes -->
            <div id="chat-container" class="flex-1 overflow-y-auto p-4 bg-white rounded shadow mb-4 space-y-2 max-h-[55vh]">
                @foreach ($chatMessages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div
                            class="max-w-md px-4 py-2 rounded-lg shadow
                                {{ $message->sender_id === auth()->id() ? 'bg-blue-600 text-white rounded-br-none' : 'bg-gray-200 text-gray-800 rounded-bl-none' }}">
                            <span class="block mb-1 text-xs font-semibold">
                                {{ $message->sender_id === auth()->id() ? 'Tú' : $message->sender->username }}
                            </span>
                            <p class="text-sm leading-tight break-words">
                                {{ $message->body }}
                            </p>
                        </div>
                    </div>
                @endforeach

                <div id="chat-bottom"></div>
            </div>

            <!-- Input fijo al fondo -->
            <form wire:submit.prevent="sendMessage" class="flex items-center gap-2 pt-2 mt-auto border-t">
                <input wire:model="messageBody" type="text" placeholder="Escribe un mensaje..."
                    class="w-full p-2 border border-gray-300 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-400" />
                @error('messageBody') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                <button type="submit"
                    class="px-4 py-2 font-semibold text-white transition bg-blue-500 rounded-lg hover:bg-blue-600">
                    Enviar
                </button>
            </form>
        @else
            <p class="text-gray-500">Selecciona un usuario para comenzar una conversación.</p>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function initLivewireHooks() {
            if (typeof Livewire !== 'undefined') {
                console.log('[Livewire] Detectado correctamente.');

                scrollToBottom();

                Livewire.hook('message.processed', () => {
                    setTimeout(scrollToBottom, 200);

                    // Nueva línea: Emitir evento Livewire para marcar como leídos si el chat está activo
                    Livewire.dispatch('mark-as-read-if-active');
                });

                window.addEventListener('message-sent', () => {
                    setTimeout(scrollToBottom, 300);
                });

                window.addEventListener('receiver-changed', () => {
                    setTimeout(scrollToBottom, 300);
                });

            } else {
                setTimeout(initLivewireHooks, 100);
            }
        }

        function scrollToBottom() {
            const container = document.getElementById('chat-container');
            if (container) {
                container.scrollTo({
                    top: container.scrollHeight,
                    behavior: 'auto'
                });
                console.log('[Scroll] chat-container scrollHeight:', container.scrollHeight);
            }
        }

        initLivewireHooks();
    });
</script>


