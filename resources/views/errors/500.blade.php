@extends('site.master')

@section('title')
    <title>{{ env('APP_SHORT_NAME') }} - 500 | Ooops! Estamos enfrentando problemas!</title>
@endsection

@section('content')
    <article class="not_found">
        <div>
            <header>
                <p class="error">&bull;500&bull;</p>
                <h1>Ooops! Estamos enfrentando problemas!</h1>
                <p>Parece que meu serviço não está diponível no momento. Já estou vendo isso, mas caso precise, envie um
                    e-mail :)</p>
                <a title="Contato por e-mail" href="mailto:contato@rodrigobrito.dev.br"
                    rel="noreferrer">contato@rodrigobrito.dev.br</a>
            </header>
        </div>
    </article>
@endsection
