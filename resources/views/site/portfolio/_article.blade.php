<article class="portfolio_article">

    <a title="{{ $post->title }}" href="{{ route('site.portfolio.post', ['uri' => $post->uri]) }}">
        <picture>
            <source media="(max-width: 512px)" srcset="{{ url('storage/portfolio/min/' . $post->cover) }}" />
            <source media="(max-width: 762px)" srcset="{{ url('storage/portfolio/medium/' . $post->cover) }}" />
            <source media="(min-width: 763px)" srcset="{{ url('storage/portfolio/' . $post->cover) }}" />
            <img src="{{ url('storage/portfolio/' . $post->cover) }}" title="{{ $post->title }}" width="860"
                height="487" />
        </picture>
    </a>
    <header>
        <p class="meta">
            Categorias:
            @foreach ($post->categories as $cat)
                <a title="Artigos em {{ $cat->portfolio->title }}"
                    href="{{ route('site.portfolio.category', ['category' => $cat->category->uri]) }}">
                    {{ $cat->portfolio->title }} &bull;</a>
            @endforeach
            {{ date('d/m/y', strtotime($post->created_at)) }}
        </p>
        <h2><a title="{{ $post->title }}"
                href="{{ route('site.portfolio.post', ['uri' => $post->uri]) }}">{{ $post->title }}</a>
        </h2>
        <p><a title="{{ $post->title }}" href="{{ route('site.portfolio.post', ['uri' => $post->uri]) }}">
                {{ Str::of($post->subtitle)->limit(100) }}</a></p>
    </header>
</article>
