@extends('site.master')

@section('content')
    <article class="post_page">
        <header class="post_page_header">
            <div class="post_page_hero">
                <h2 data-anime="400" class="fadeInRight">{{ $post->title }}</h2>
                <picture>
                    <source media="(max-width: 512px)" srcset="{{ url('storage/portfolio/min/' . $post->cover) }}" />
                    <source media="(max-width: 762px)" srcset="{{ url('storage/portfolio/medium/' . $post->cover) }}" />
                    <source media="(min-width: 763px)" srcset="{{ url('storage/portfolio/' . $post->cover) }}" />
                    <img src="{{ url('storage/portfolio/' . $post->cover) }}" title="{{ $post->title }}" width="360"
                        height="207" />
                </picture>
                <div class="post_page_meta">
                    <div>Publicado em {{ date('d/m/y', strtotime($post->created_at)) }}</div>
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
                            @include('site.portfolio._article', ['post' => $item->post])
                        @endforeach
                    </div>
                </section>
            </div>
        @endif
    </article>

    </article>
@endsection

@section('custom_js')
    <script src="{{ asset('js/site/post.js') }}"></script>
@endsection
