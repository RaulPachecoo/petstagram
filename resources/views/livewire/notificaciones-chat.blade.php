<div class="relative" wire:poll.5s>
    <a href="{{ route('chat.default') }}"
        class="flex items-center text-gray-600 hover:text-indigo-600 md:p-2 md:rounded md:text-sm md:font-bold">

        <!-- Icono con contador -->
        <div class="relative mr-2">
            <img src="{{ asset('img/send.png') }}" alt="Chat Icon" class="w-5 h-5">

            @if ($unreadCount > 0)
            <span
                class="absolute -top-1 -right-1 min-w-[16px] h-[16px] bg-blue-500 text-white text-[10px] font-bold flex items-center justify-center rounded-full ring-2 ring-white px-[4px] leading-none">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
            @endif
        </div>

        <!-- Texto "Chat" en escritorio y móvil -->
        <span class="hidden md:block">Chat</span>
    </a>
</div>