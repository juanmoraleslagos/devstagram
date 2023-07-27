<div>

    {{-- Mostrando Posts --}}
    @if ($posts->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        {{-- recorriendo arreglo $posts --}}
        @foreach ($posts as $post)
        <div>
            <a href="{{ route('posts.show', ['post' => $post, 'user' => $post ->user ]) }}">
                <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen Del Post {{ $post->titulo }}">
            </a>
        </div>
        @endforeach
    </div>

    {{-- paginación --}}
    <div class="my-10">
        {{ $posts->links() }}
    </div>
    @else
    <p class="text-gray-600 uppercase text-sm text-center font-bold">No Hay Posts, Sigue a Alguien Para Poder Mostrar
        Sus Posts</p>
    @endif

</div>