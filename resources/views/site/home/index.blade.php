@extends('site.master')

@section('content')
    <article class="home_featured">
        <div class="home_featured_content">
            <canvas class="snow"></canvas>
            <canvas class="snow"></canvas>
            <header>
                <h2 data-anime="400" class="fadeInDown">Rodrigo Brito <br>Desenvolvedor Web</h2>
                <p class="headline">FullStack PHP | Web Designer</p>
                <p data-anime="1200" class="fadeInDown">
                    <button data-go=".home_optin">
                        Conheça meu Portfólio</button>
                </p>
            </header>
        </div>

        <div class="home_featured_app">
            <img data-anime="2000" class="fadeInUp" src="{{ asset('img/avatar.webp') }}" alt="Rodrigo Brito"
                title="Rodrigo Brito" width="300" height="300" />
        </div>
    </article>

    <article class="home_optin">
        <h3 class="hide">Conteúdo Principal</h3>
        <!--PORTFOLIO-->
        @if (!$posts || $posts->count() == 0)
            <div class="empty_content  fadeInUp" data-anime="2400">
                <h3>Ainda estou trabalhando aqui!</h3>
                <p>Estou preparando meu portfólio para você.</p>
            </div>
        @else
            <section class="portfolio fadeInScrool">
                <div class="portfolio_content">
                    <header class="portfolio_header">
                        <h2>Portfólio</h2>
                        <p>Confira meus trabalhos e projetos</p>
                    </header>

                    <div class="portfolio_articles fadeInScrool">
                        @foreach ($posts as $post)
                            @include('site.home._article')
                        @endforeach
                    </div>
                </div>
            </section>

            <article class="optin_link fadeInScrool">
                <h4 class="hide">Conheça todo o portfólio</h4>
                <a href="{{ route('site.portfolio') }}">Conheça todo o portfólio</a>
            </article>
        @endif

    </article>
@endsection

@section('custom_js')
    <script src="{{ asset('js/site/home.js') }}"></script>
@endsection
