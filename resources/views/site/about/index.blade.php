@extends('site.master')

@section('content')
    <section class="about_page">
        <div class="about_page_content content">
            <header class="about_header">
                <h2 data-anime="400" class="fadeInDown">Um breve resumo...</h2>
                <p data-anime="800" class="page-about fadeInDown">
                    Me chamo Rodrigo Carvalho de Brito, nascido em Ourinhos-SP em 1985.<br>
                    Sou Militar, Bacharel em Sistemas de Informação e especializado em Segurança da Informação e em
                    Engenharia de Software.</p>
                <p data-anime="1200" class="page-about fadeInRight">Trabalho como Desenvolvedor web fullstack, tendo como
                    linguagem de back-end de forma plena o PHP. Nas horas vagas estudo muito, de forma incansável, para
                    ampliar meu
                    conhecimento e desenvolver sites e sistemas alinhados aos padrões de mercado.</p>
                <p data-anime="1600" class="page-about fadeInUp">Guerreiro Cibernético 438.</p>
                <p>
            </header>
            <div class="about_page_steps fadeIUp" data-anime="1200">
                <article>
                    <header>
                        <span class="icon icon-graduation-cap icon-no-text"></span>
                        <h2>Formação Acadêmica</h2>
                        <p>Bacharelado em Sistemas de Informação com especialização em Engenharia de Software e em Segurança
                            da Informação.</p>
                        <p>Cursado em Guerra Cibernética pelo Exército Brasileiro.</p>
                    </header>
                </article>
                <article>
                    <header>
                        <span class="icon icon-leanpub icon-no-text"></span>
                        <h2>Estudo Contínuo</h2>
                        <p>PHP, Python, Bash, Web Design, Tipografia, HTML5, CSS3, Sass, Bootstrap, JavaScript, jQuery,
                            WordPress, Elementor, Woocommerce, Laravel, MySQL, PostgreSQL e MongoDB.
                        </p>
                        <p>Red / Green / Yellow Team.</p>
                    </header>
                </article>
                <article>
                    <header>
                        <span class=" icon icon-cogs icon-no-text"></span>
                        <h2>Padronização de Processos</h2>
                        <p>Desenvolvimento alinhado com os padrões de projeto para gerar produtos com organização,
                            qualidade,
                            rapidez, manutenibilidade, escalabilidade e segurança.</p>
                    </header>
                </article>
            </div>
        </div>

        @if ($certificates->count() > 0)
            <div class="fadeInScrool about_page_courses">
                <header class="courses_header">
                    <h2>Cursos</h2>
                    <p>Minha lista de cursos realizados</p>
                </header>

                <ol class="about-courses-list fadeInScrool">
                    @foreach ($certificates as $certificate)
                        <li>
                            <div>
                                <h3>{{ $certificate->title }}</h3>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
            <header class="fadeInScrool certificates_header">
                <h2>Certificados</h2>
                <p>Relacionados a desenvolvimento web e segurança cibernética</p>
            </header>
            <div class="slide-wrapper">
                <ul class="slide">
                    @foreach ($certificates as $certificate)
                        <li>
                            <picture>
                                <source media="(max-width: 512px)"
                                    srcset="{{ url('storage/certificates/min/' . $certificate->cover) }}" />
                                <source media="(max-width: 762px)"
                                    srcset="{{ url('storage/certificates/medium/' . $certificate->cover) }}" />
                                <source media="(min-width: 763px)"
                                    srcset="{{ url('storage/certificates/' . $certificate->cover) }}" />
                                <img src="{{ url('storage/certificates/' . $certificate->cover) }}"
                                    title="{{ $certificate->title }}" width="800" height="564" class="lazyload"
                                    alt="{{ $certificate->title }}" />
                            </picture>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="arrow-nav">
                <button class="prev icon-chevron-left icon-no-text" title="Anterior"></button>
                <button class="next icon-chevron-right icon-no-text" title="Próximo"></button>
            </div>
        @endif

    </section>
@endsection

@section('custom_js')
    @if ($certificates->count() > 0)
        <script src="{{ asset('js/site/slide.js') }}"></script>
    @endif
@endsection
