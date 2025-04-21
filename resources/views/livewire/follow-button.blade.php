<div>
    <!-- Contador de seguidores -->
    <p class="mb-3 text-sm font-bold text-gray-800">
        {{ $followersCount }}
        <span class="font-normal">@choice('Seguidor|Seguidores', $followersCount)</span>
    </p>
    <p class="mb-3 text-sm font-bold text-gray-800">
        {{ $user->following->count() }}
        <span class="font-normal">Siguiendo</span>
    </p>
    <p class="mb-3 text-sm font-bold text-gray-800">
        {{ $user->posts->count() }}
        <span class="font-normal">Posts</span>
    </p>
    @auth
        @if($user->id !== Auth::user()->id)
            <!-- Botón de seguir/dejar de seguir con diseño original -->
            <button wire:click="toggleFollow" class="px-4 py-2 text-xs font-bold text-white uppercase bg-blue-600 rounded-lg cursor-pointer hover:bg-blue-800"
                style="background-color: {{ $isFollowing ? '#e3342f' : '#3490dc' }};">
                {{ $isFollowing ? 'Dejar de Seguir' : 'Seguir' }}
            </button>
        @endif
    @endauth
</div>