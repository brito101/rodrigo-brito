@extends('site.master')

@section('title')
    <title>{{ env('APP_SHORT_NAME') }} - 503 | Ooops! Estamos em manutenção!</title>
@endsection

@section('content')
    <article class="not_found">
        <div>
            <header>
                <p class="error">&bull;503&bull;</p>
                <h1>Ooops! Estamos em manutenção!</h1>
                <p>Voltaremos logo! Por hora estamos trabalhando para melhorar o conteúdo :P</p>
                <a title="Contato por e-mail" href="mailto:contato@rodrigobrito.dev.br"
                    rel="noreferrer">contato@rodrigobrito.dev.br</a>
            </header>
        </div>
    </article>
@endsection
