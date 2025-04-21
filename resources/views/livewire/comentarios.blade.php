<div>
    @auth
        <p class="mb-4 text-xl font-bold text-center">Agrega un Nuevo Comentario</p>

        @if (session()->has('mensaje'))
            <div class="p-2 mb-6 font-bold text-center text-white uppercase bg-green-500 rounded-lg">
                {{ session('mensaje') }}
            </div>
        @endif

        <form wire:submit.prevent="comentar">
            <div class="mb-5">
                <label for="comentario" class="block mb-2 font-bold text-gray-500 uppercase">Comentarios</label>
                <textarea id="comentario" wire:model.defer="comentario" placeholder="Añade un comentario"
                    class="w-full p-3 border rounded-lg @error('comentario') border-red-500 @enderror"></textarea>

                @error('comentario')
                    <p class="p-2 my-2 text-sm text-center text-white bg-red-500 rounded-lg">
                        {{ $errors->first('comentario') }}
                    </p>
                @enderror
                
                
            </div>
            <input type="submit" value="Comentar"
                class="w-full p-3 font-bold text-white uppercase transition-colors rounded-lg cursor-pointer bg-sky-600 hover:bg-sky-700">
        </form>
    @endauth

    <div class="mt-10 mb-5 overflow-y-scroll bg-white shadow max-h-96">
        @if ($comentarios->count())
            @foreach ($comentarios as $comentario)
                <div class="p-5 border-b border-gray-300">
                    <a href="{{ route('posts.index', $comentario->user) }}" class="font-bold">
                        {{ $comentario->user->username }}
                    </a>
                    <p>{{ $comentario->comentario }}</p>
                    <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        @else
            <p class="p-10 text-center">Todavía no hay comentarios</p>
        @endif
    </div>
</div>
