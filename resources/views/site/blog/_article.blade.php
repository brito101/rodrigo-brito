<article class="portfolio_article">
    <a title="{{ $post->title }}" href="{{ route('site.blog.post', ['uri' => $post->uri]) }}">
        <picture>
            <source media="(max-width: 512px)" srcset="{{ url('storage/blog/min/' . $post->cover) }}" />
            <source media="(max-width: 762px)" srcset="{{ url('storage/blog/medium/' . $post->cover) }}" />
            <source media="(min-width: 763px)" srcset="{{ url('storage/blog/' . $post->cover) }}" />
            <img src="{{ url('storage/blog/' . $post->cover) }}" title="{{ $post->title }}" width="360"
                height="207" />
        </picture>
    </a>
    <header>
        <p class="meta">
            @foreach ($post->categories as $item)
                <a title="Artigos em {{ $item->category->title }}" href=""> Categoria:
                    {{ $item->category->title }}</a>
            @endforeach
            &bull; {{ date('d/m/y', strtotime($post->created_at)) }}
        </p>
        <h2><a title="{{ $post->title }}"
                href="{{ route('site.blog.post', ['uri' => $post->uri]) }}">{{ $post->title }}</a>
        </h2>
        <p><a title="{{ $post->title }}" href="{{ route('site.blog.post', ['uri' => $post->uri]) }}">
                {{ Str::of($post->subtitle)->limit(100) }}</a></p>
    </header>
</article>
