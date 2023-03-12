@extends('site.master')

@section('content')
    <section class="blog_page">
        <header class="blog_page_header">
            <h2 data-anime="400" class="fadeInDown">
                @if ($title)
                    {{ $title }}
                @else
                    BLOG
                @endif
            </h2>
            <p data-anime="800" class="fadeInDown">
                Confira dicas e sacadas sobre desenvolvimento web!
            </p>
            <form data-anime="1200" class="fadeInDown" action="{{ route('site.blog.search') }}" method="post">
                @csrf
                <div>
                    <input type="text" name="search" placeholder="Encontre um artigo:" required />
                    <button class="icon-search icon-notext" aria-label="Botão de Pesquisa"></button>
                </div>
            </form>
        </header>

        @if ($posts->count() == 0 && $search)
            <div class="empty_content fadeInUp" data-anime="1600">
                <h3>Sua pesquisa não retornou resultados :/</h3>
                <p>Você pesquisou por <b>{{ $search }}</b>. Tente outros termos.</p>
                <a href="{{ route('site.blog') }}" title="Blog">...ou volte ao Blog</a>
            </div>
        @elseif (!$posts)
            <div class="empty_content fadeInUp" data-anime="1600">
                <h3>Ainda estou trabalhando aqui!</h3>
                <p>Estou preparando um conteúdo de primeira para você.</p>
            </div>
        @else
            <div class="portfolio_content fadeInUp" data-anime="1600">
                <div class="portfolio_articles">
                    @foreach ($posts as $post)
                        @include('site.blog._article')
                    @endforeach
                </div>

                {{ $posts->links() }}
            </div>
        @endif
    </section>
@endsection
