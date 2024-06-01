@extends('site.master')

@section('content')
    <section class="blog_page">
        <header class="blog_page_header">
            <h2 data-anime="400" class="fadeInDown">BLOG</h2>
            <p data-anime="800" class="fadeInDown">
                @isset($description)
                    {{ $description }}
                @else
                    Confira dicas e sacadas sobre desenvolvimento web.
                @endisset
            </p>
            <form data-anime="1200" class="fadeInDown" action="{{ route('site.blog.search') }}" method="get">
                <div>
                    <input type="text" name="s" placeholder="Encontre um artigo:" required />
                    <button class="icon-search icon-notext" aria-label="Botão de Pesquisa"></button>
                </div>
            </form>
        </header>

        @if ($posts->count() == 0 && isset($search))
            <div class="empty_content fadeInUp" data-anime="1600">
                <h3>Sua pesquisa não retornou resultados :/</h3>
                <p>Você pesquisou por <b>{{ $search }}</b>. Tente outros termos.</p>
                <a href="{{ route('site.blog') }}" title="Blog">...ou volte ao Blog</a>
            </div>
        @elseif ($posts->count() == 0)
            <div class="empty_content fadeInUp" data-anime="1600">
                <h3>Ainda estou trabalhando aqui!</h3>
                <p>Estou preparando um conteúdo de primeira para você.</p>
            </div>
        @else
            <div class="portfolio_content fadeInUp" data-anime="1600">
                <div class="portfolio_articles">
                    @foreach ($posts as $post)
                        @include('site._partials.article', ['base' => 'blog', 'item' => $post])
                    @endforeach
                </div>

                {{ $posts->onEachSide(2)->links() }}
            </div>
        @endif
    </section>
@endsection
