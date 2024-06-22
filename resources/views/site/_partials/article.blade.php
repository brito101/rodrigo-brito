<article class="portfolio_article">
    <a title="{{ $item->title }}" href="{{ route('site.' . $base . '.post', ['uri' => $item->uri]) }}">
        <picture>
            <source media="(max-width: 512px)" srcset="{{ url('storage/' . $base . '/min/' . $item->cover) }}" />
            <source media="(max-width: 762px)" srcset="{{ url('storage/' . $base . '/medium/' . $item->cover) }}" />
            <source media="(min-width: 763px)" srcset="{{ url('storage/' . $base . '/' . $item->cover) }}" />
            <img src="{{ url('storage/' . $base . '/' . $post->cover) }}" title="{{ $item->title }}" width="860"
                height="487" alt="{{ $item->title }}"/>
        </picture>
    </a>
    <header>
        <p class="meta">
            @if ($item->categories->count() > 0)
                @if ($post->categories->count() == 1)
                    Categoria:
                @else
                    Categorias:
                @endif
            @endif
            @foreach ($item->categories as $cat)
                <a title="Artigos em {{ $cat->category->title }}"
                    href="{{ route('site.' . $base . '.category', ['category' => $cat->category->uri]) }}">
                    {{ $cat->category->title }} &bull;</a>
            @endforeach
            {{ date('d/m/y', strtotime($item->created_at)) }}
        </p>
        <h2><a title="{{ $item->title }}"
                href="{{ route('site.' . $base . '.post', ['uri' => $item->uri]) }}">{{ $item->title }}</a>
        </h2>
        <p><a title="{{ $item->title }}" href="{{ route('site.' . $base . '.post', ['uri' => $item->uri]) }}">
                {{ Str::of($item->subtitle)->limit(100) }}</a></p>
    </header>
</article>
