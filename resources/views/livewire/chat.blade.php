<div class="flex flex-col h-full">
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

        <!-- Ancla de scroll -->
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function initLivewireHooks() {
            if (typeof Livewire !== 'undefined') {
                // Desplazar al final después de cada actualización de Livewire
                scrollToBottom();

                Livewire.hook('message.processed', (message, component) => {
                    scrollToBottom();
                });

                // Escuchar el evento de "messageSent" desde Livewire para hacer el scroll al final
                Livewire.on('messageSent', () => {
                    console.log('Mensaje enviado, desplazando al fondo.');
                    scrollToBottom();
                });
            } else {
                // Intentar cargar Livewire si no está definido aún
                setTimeout(initLivewireHooks, 100);
            }
        }

        function scrollToBottom() {
            const container = document.getElementById('chat-container');
            if (container) {
                container.scrollTo({
                    top: container.scrollHeight,
                    behavior: 'auto' // Cambiado a 'auto' para asegurar el desplazamiento inmediato
                });
            }
        }

        initLivewireHooks();
    });
</script>

