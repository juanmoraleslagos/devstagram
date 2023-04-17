<div>    
    @if ($posts->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        @foreach ($posts as $post)            
            <div>
                <a href="{{ route('post.show', ['post' => $post, 'user' => $post->user ]) }}">
                    <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen Del Post {{ $post->titulo }}">
                </a>
            </div>            
        @endforeach
    </div>

    <!-- creando paginación -->
    <div class="my-10">
        {{ $posts->links('pagination::tailwind') }}
    </div>
    @else
        <p class="text-center">No hay Post, Sigue A Alguien Para Poder Mostrar Sus Posts</p>
    @endif
</div>