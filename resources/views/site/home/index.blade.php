@extends('site.master')

@section('custom_css')
    <link rel="preload" fetchpriority="high" as="image" href="{{ asset('/img/cyber.webp') }}" type="image/webp">
@endsection

@section('content')
    <article class="home_featured">
        <div class="home_featured_content">
            <canvas class="snow"></canvas>
            <canvas class="snow"></canvas>
            <header>
                <h2 data-anime="400" class="fadeInDown">Rodrigo Brito <br>Desenvolvedor Web / AppSec</h2>
                <p class="headline">FullStack PHP | Web Designer | DCPT | CNSP | CAP | SYCP</p>
                <p data-anime="1200" class="fadeInDown">
                    <button data-go=".home_opt_in">
                        Conheça meu Portfólio</button>
                </p>
            </header>
        </div>

        <div class="home_featured_app">
            <img data-anime="2000" class="fadeInUp" src="{{ asset('img/avatar.webp') }}" alt="Rodrigo Brito"
                title="Rodrigo Brito" width="300" height="300" />
            <img data-anime="2000" class="fadeInUp" src="{{ asset('img/breve.webp') }}" alt="Brevê Guerra Cibernética"
                title="Brevê Guerra Cibernética" width="350" height="100" />
        </div>
    </article>

    <article class="home_opt_in">
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
                            @include('site._partials.article', ['base' => 'portfolio', 'item' => $post])
                        @endforeach
                    </div>
                </div>
            </section>

            <article class="opt_in_link fadeInScrool">
                <h4 class="hide">Conheça todo o portfólio</h4>
                <a href="{{ route('site.portfolio') }}">Conheça todo o portfólio</a>
            </article>
        @endif

    </article>

    <section class="home_certifications">
        <header>
            <h2>Certificações</h2>
        </header>
        <div class="fadeInScrool">
            <article>
                <h3>DCPT</h3>                
                <div>
                    <img src="{{ asset('img/dcpt.webp') }}" alt="DCPT" title="DCPT" width="300" height="130" />
                </div>
                <p>Desec Certified Penetration Tester</p>
            </article>
            <article>
                <h3>CAP</h3>                
                <div>
                    <img src="{{ asset('img/cap.webp') }}" alt="CAP" title="CAP" width="300" height="300" />
                </div>
                <p>Certified AppSec Practitioner</p>
            </article>
            <article>
                <h3>CNSP</h3>                
                <div>
                    <img src="{{ asset('img/cnsp.webp') }}" alt="CNSP" title="CNSP" width="300" height="300" />
                </div>
                <p>Certified Network Security Practitioner</p>
            </article>
            <article>
                <h3>SYCP</h3>                
                <div>
                    <img src="{{ asset('img/sycp.webp') }}" alt="SYCP" title="SYCP" width="300" height="300" />
                </div>
                <p>Solyd Certified Pentester</p>
            </article>
        </div>
    </section>
@endsection

@section('custom_js')
    <script src="{{ asset('js/site/home.js') }}"></script>
@endsection
