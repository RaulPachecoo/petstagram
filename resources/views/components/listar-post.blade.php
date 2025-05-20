<div class="container px-6 mx-auto">
    @if($posts->count())
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($posts as $post)
        <div>
            <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
            </a>
        </div>
        @endforeach
    </div>

    <div class="my-10">
        {{ $posts->links('pagination::tailwind') }}
    </div>
    @else
    <div class="flex flex-col items-center justify-center h-64 text-center bg-white rounded-lg shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-4 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 13V7a2 2 0 00-2-2h-3.17a2 2 0 01-1.42-.59l-1.41-1.41A2 2 0 0010.83 3H6a2 2 0 00-2 2v6m0 0v6a2 2 0 002 2h12a2 2 0 002-2v-6m-6 4h.01M12 17h.01" />
        </svg>
        <h2 class="mb-2 text-xl font-semibold text-gray-700">No hay posts todavía</h2>
        <p class="text-gray-500">Sigue a otros usuarios para ver sus publicaciones aquí.</p>
    </div>

    @endif
</div>