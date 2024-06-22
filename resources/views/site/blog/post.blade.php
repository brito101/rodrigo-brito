@extends('site.master')

@section('content')
    <article class="post_page">
        <header class="post_page_header">
            <div class="post_page_hero">
                <h2 data-anime="400" class="fadeInRight">{{ $post->title }}</h2>
                <picture>
                    <source media="(max-width: 512px)" srcset="{{ url('storage/blog/min/' . $post->cover) }}"/>
                    <source media="(max-width: 762px)" srcset="{{ url('storage/blog/medium/' . $post->cover) }}"/>
                    <source media="(min-width: 763px)" srcset="{{ url('storage/blog/' . $post->cover) }}"/>
                    <img src="{{ url('storage/blog/' . $post->cover) }}" title="{{ $post->title }}" width="360"
                         height="207" alt="{{ $post->title }}"/>
                </picture>
                <div class="post_page_meta">
                    <div>Publicado em {{ date('d/m/y H:m', strtotime($post->created_at)) }}</div>
                    <div class="icon-bar-chart">Visualizações: {{ $post->views }}</div>
                </div>
            </div>
        </header>

        <div class="post_page_content fadeInScrool">
            <div class="htmlChars fadeInScrool">
                <h3>{{ $post->subtitle }}</h3>
                {!! $post->content !!}
            </div>
        </div>

        @if ($related->count() > 0)
            <div class="post_page_related fadeInScrool">
                <section>
                    <header class="post_page_related_header">
                        <h4>Veja também:</h4>
                        <p>Confira mais artigos relacionados</p>
                    </header>

                    <div class="portfolio_articles">
                        @foreach ($related as $item)
                            @include('site._partials.article', ['base' => 'blog', 'item' => $item])
                        @endforeach
                    </div>
                </section>
            </div>
        @endif
    </article>

@endsection

@section('custom_js')
    <script src="{{ asset('js/site/post.js') }}"></script>
@endsection
