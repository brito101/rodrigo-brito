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
        <section class="portfolio fadeInScrool">
            <div class="portfolio_content">
                <header class="portfolio_header">
                    <h2>Portfólio</h2>
                    <p>Confira meus trabalhos e projetos</p>
                </header>

                <div class="portfolio_articles fadeInScrool">
                    <article class="portfolio_article">
                        <a title="Alfa Estágios" href="https://www.rodrigobrito.dev.br/portfolio/alfa-estagios">
                            <img title="Alfa Estágios" alt="Alfa Estágios"
                                src="https://www.rodrigobrito.dev.br/storage/images/cache/alfa-estagios-360x207-151254dc.webp"
                                width="360" height="207" />
                        </a>
                        <header>
                            <p class="meta">
                                <a title="Projetos em Sistemas"
                                    href="https://www.rodrigobrito.dev.br/portfolio/em/sistemas">Categoria:
                                    Sistemas</a>
                            </p>
                            <h2><a title="Alfa Estágios" href="https://www.rodrigobrito.dev.br/portfolio/alfa-estagios">Alfa
                                    Estágios</a></h2>
                            <p><a title="Alfa Estágios" href="https://www.rodrigobrito.dev.br/portfolio/alfa-estagios">
                                    Sistema de gestão de estagiários e alocação de vagas</a></p>
                        </header>
                    </article>
                    <article class="portfolio_article">
                        <a title="Acqua X do Brasil" href="https://www.rodrigobrito.dev.br/portfolio/acqua-x-do-brasil">
                            <img title="Acqua X do Brasil" alt="Acqua X do Brasil"
                                src="https://www.rodrigobrito.dev.br/storage/images/cache/acqua-x-do-brasil-360x207-e54bed1a.webp"
                                width="360" height="207" />
                        </a>
                        <header>
                            <p class="meta">
                                <a title="Projetos em Sistemas"
                                    href="https://www.rodrigobrito.dev.br/portfolio/em/sistemas">Categoria:
                                    Sistemas</a>
                            </p>
                            <h2><a title="Acqua X do Brasil"
                                    href="https://www.rodrigobrito.dev.br/portfolio/acqua-x-do-brasil">Acqua X do
                                    Brasil</a></h2>
                            <p><a title="Acqua X do Brasil"
                                    href="https://www.rodrigobrito.dev.br/portfolio/acqua-x-do-brasil">
                                    Sistema de Individualização de consumo de água em condomínios</a></p>
                        </header>
                    </article>
                    <article class="portfolio_article">
                        <a title="Decora Mais Você" href="https://www.rodrigobrito.dev.br/portfolio/decora-mais-voce">
                            <img title="Decora Mais Você" alt="Decora Mais Você"
                                src="https://www.rodrigobrito.dev.br/storage/images/cache/decora-mais-voce-360x207-76dbd17b.webp"
                                width="360" height="207" />
                        </a>
                        <header>
                            <p class="meta">
                                <a title="Projetos em E-commerce"
                                    href="https://www.rodrigobrito.dev.br/portfolio/em/e-commerce">Categoria:
                                    E-commerce</a>
                            </p>
                            <h2><a title="Decora Mais Você"
                                    href="https://www.rodrigobrito.dev.br/portfolio/decora-mais-voce">Decora Mais
                                    Você</a></h2>
                            <p><a title="Decora Mais Você"
                                    href="https://www.rodrigobrito.dev.br/portfolio/decora-mais-voce">
                                    Loja de decoração utilizando WP e WooCommerce</a></p>
                        </header>
                    </article>
                    <article class="portfolio_article">
                        <a title="Hasbrotel" href="https://www.rodrigobrito.dev.br/portfolio/hasbrotel">
                            <img title="Hasbrotel" alt="Hasbrotel"
                                src="https://www.rodrigobrito.dev.br/storage/images/cache/hasbrotel-360x207-de547c25.webp"
                                width="360" height="207" />
                        </a>
                        <header>
                            <p class="meta">
                                <a title="Projetos em Institucional"
                                    href="https://www.rodrigobrito.dev.br/portfolio/em/institucional">Categoria:
                                    Institucional</a>
                            </p>
                            <h2><a title="Hasbrotel"
                                    href="https://www.rodrigobrito.dev.br/portfolio/hasbrotel">Hasbrotel</a></h2>
                            <p><a title="Hasbrotel" href="https://www.rodrigobrito.dev.br/portfolio/hasbrotel">
                                    Transformando pdf em código</a></p>
                        </header>
                    </article>
                    <article class="portfolio_article">
                        <a title="Bikcraft-2021" href="https://www.rodrigobrito.dev.br/portfolio/bikcraft-2021">
                            <img title="Bikcraft-2021" alt="Bikcraft-2021"
                                src="https://www.rodrigobrito.dev.br/storage/images/cache/bikcraft-2021-360x207-bae050b4.webp"
                                width="360" height="207" />
                        </a>
                        <header>
                            <p class="meta">
                                <a title="Projetos em Institucional"
                                    href="https://www.rodrigobrito.dev.br/portfolio/em/institucional">Categoria:
                                    Institucional</a>
                            </p>
                            <h2><a title="Bikcraft-2021"
                                    href="https://www.rodrigobrito.dev.br/portfolio/bikcraft-2021">Bikcraft-2021</a>
                            </h2>
                            <p><a title="Bikcraft-2021" href="https://www.rodrigobrito.dev.br/portfolio/bikcraft-2021">
                                    Projeto de curso</a></p>
                        </header>
                    </article>
                    <article class="portfolio_article">
                        <a title="Prontmed Landing Page"
                            href="https://www.rodrigobrito.dev.br/portfolio/prontmed-landing-page">
                            <img title="Prontmed Landing Page" alt="Prontmed Landing Page"
                                src="https://www.rodrigobrito.dev.br/storage/images/cache/prontmed-landing-page-360x207-54efa84b.webp"
                                width="360" height="207" />
                        </a>
                        <header>
                            <p class="meta">
                                <a title="Projetos em Landing Page"
                                    href="https://www.rodrigobrito.dev.br/portfolio/em/landing-page">Categoria:
                                    Landing Page</a>
                            </p>
                            <h2><a title="Prontmed Landing Page"
                                    href="https://www.rodrigobrito.dev.br/portfolio/prontmed-landing-page">Prontmed
                                    Landing Page</a></h2>
                            <p><a title="Prontmed Landing Page"
                                    href="https://www.rodrigobrito.dev.br/portfolio/prontmed-landing-page">
                                    Utilizando WP</a></p>
                        </header>
                    </article>
                </div>
            </div>
        </section>

        <article class="opt_in_link fadeInScrool">
            <h4 class="hide">Conheça todo o portfólio</h4>
            <a href="https://www.rodrigobrito.dev.br/portfolio">Conheça todo o portfólio</a>
        </article>

    </article>
@endsection

@section('custom_js')
    <script src="{{ asset('js/site/home.js') }}"></script>
@endsection
