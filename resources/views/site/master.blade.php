<!--
My code is forged by a lot of sweat and study and constantly evolving!
I know very little yet, if you find a hole in the code, the most honorable thing is to contribute with the knowledge!
Not everything is money in life, what matters most is knowledge!
Good journey!
@born October 7, 2020
@author Rodrigo Brito <contato@rodrigobrito.dev.br>
-->
<!DOCTYPE html>
<html lang="pt-br" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Google Tag Manager -->
    <script src="{{ asset('js/site/google-tag-manager.js') }}"></script>
    <!-- End Google Tag Manager -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @metas
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@RCBrito101" />
    <meta name="twitter:creator" content="@RCBrito101" />
    <meta name="twitter:domain" content="{{ env('APP_URL') }}" />
    <meta property="article:publisher" content="https://www.facebook.com/RodrigoBritoWebDeveloper" />
    <meta property="article:author" content="https://www.facebook.com/rodrigo.carvalhodebrito" />
    <meta property="fb:app_id" content="550149899141611" />
    <meta itemprop="name" content="{{ env('APP_NAME') }}" />
    <meta itemprop="description" content="{{ env('APP_DESCRIPTION') }}" />
    <meta itemprop="url" content="{{ env('APP_URL') }}" />
    <meta itemprop="image" content="{{ asset('img/share.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.svg') }}" />

    <link rel="stylesheet" href="{{ asset('site/fonts/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/site/style.css') }}" />

    @laravelPWA
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KBGXKNM" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header class="main_header">
        <div>
            <div class="main_header_logo">
                <a title="Home" href="{{ route('site.home') }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Rodrigo Brito" width="75" height="76" />
                    <h1>Rodrigo Brito</h1>
                </a>
            </div>
            <nav>
                <h2 class="hide">Barra de Navegação</h2>
                <button class="j_menu_mobile_open icon-bars icon-no-text" title="Abrir Menu"></button>
                <div class="j_menu_mobile_tab">
                    <button class="j_menu_mobile_close icon-times icon-no-text" title="Fechar Menu"></button>
                    <ul>
                        <li><a class="link {{ Route::current()->getName() == 'site.home' ? 'active' : '' }}"
                                href="https://www.rodrigobrito.dev.br">Home</a></li>
                        <li data-dropdown><a class="link "
                                href="https://www.rodrigobrito.dev.br/portfolio">Portfólio</a>
                            <ul class='dropdown-menu'>
                                <li><a href='https://www.rodrigobrito.dev.br/portfolio/em/e-commerce'>E-commerce</a>
                                </li>
                                <li><a
                                        href='https://www.rodrigobrito.dev.br/portfolio/em/institucional'>Institucional</a>
                                </li>
                                <li><a href='https://www.rodrigobrito.dev.br/portfolio/em/landing-page'>Landing Page</a>
                                </li>
                                <li><a href='https://www.rodrigobrito.dev.br/portfolio/em/sistemas'>Sistemas</a></li>
                            </ul>
                        </li>
                        <li data-dropdown><a class="link " href="https://www.rodrigobrito.dev.br/blog">Blog</a>
                            <ul class='dropdown-menu'>
                                <li><a href='https://www.rodrigobrito.dev.br/blog/em/cyber-war'>Cyber War</a></li>
                                <li><a href='https://www.rodrigobrito.dev.br/blog/em/javascript'>JavaScript</a></li>
                                <li><a href='https://www.rodrigobrito.dev.br/blog/em/js-tricks'>JS Tricks</a></li>
                                <li><a href='https://www.rodrigobrito.dev.br/blog/em/laravel'>Laravel</a></li>
                            </ul>
                        </li>
                        <li><a class="link {{ Route::current()->getName() == 'site.about' ? 'active' : '' }}"
                                href="{{ route('site.about') }}">Sobre mim</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main class="main_content">
        @yield('content')
    </main>

    <footer class="main_footer">
        <div class="main_footer_container">
            <section class="main_footer_content">
                <h2 class="hide">Footer</h2>
                <article>
                    <h2>Sobre:</h2>
                    <p>{{ env('APP_DESCRIPTION') }}</p>
                    <a title="Termos de uso" href="{{ route('site.terms') }}">Termos de uso</a>
                </article>
                <article>
                    <h2>Mais:</h2>
                    <a title="Home" href="{{ route('site.home') }}">Home</a>
                    <a title="Portfólio" href="https://www.rodrigobrito.dev.br/portfolio">Portfólio</a>
                    <a title="Blog" href="https://www.rodrigobrito.dev.br/blog">Blog</a>
                    <a title="Sobre mim" href="{{ route('site.about') }}">Sobre mim</a>
                </article>
                <article>
                    <h2>Contato:</h2>
                    <p class="icon-phone"><b>Telefone:</b><br>
                        <a href="https://wa.me/5521992247968" title="Contato via WhatsApp" target="_blank"
                            rel="noreferrer">+55 (21) 99224-7968</a>
                    </p>
                    <p class="icon-envelope"><b>Email:</b><br>
                        <a title="Contato por e-mail" href="mailto:contato@rodrigobrito.dev.br"
                            rel="noreferrer">contato@rodrigobrito.dev.br</a>
                    </p>
                </article>
                <article class="social">
                    <h2>Social:</h2>
                    <div>
                        <a target="_blank" rel="noreferrer" class="icon-facebook"
                            href="https://www.facebook.com/RodrigoBritoWebDeveloper"
                            title="Rodrigo Brito no Facebook"></a>
                        <a target="_blank" rel="noreferrer" class="icon-github" href="https://github.com/brito101"
                            title="Rodrigo Brito no Github"></a>
                        <a target="_blank" rel="noreferrer" class="icon-packagist"
                            href="https://packagist.org/users/brito101/packages/"
                            title="Rodrigo Brito no Packagist"></a>
                        <a target="_blank" rel="noreferrer" class="icon-stack-overflow"
                            href="https://pt.stackoverflow.com/users/193373/rodrigo-carvalho-de-brito"
                            title="Rodrigo Brito no Stackoverflow"></a>
                        <a target="_blank" rel="noreferrer" class="icon-instagram"
                            href="https://www.instagram.com/rodrigobrito101" title="Rodrigo Brito no Instagram"></a>
                    </div>
                </article>
            </section>
        </div>
    </footer>

    <button aria-label="Voltar ao topo da página" title="Voltar ao topo da página"
        class="smoothScroll-top icon-chevron-circle-up icon-no-text"></button>

    <script src="{{ asset('js/site/script.js') }}"></script>
    @yield('custom_js')
</body>

</html>
