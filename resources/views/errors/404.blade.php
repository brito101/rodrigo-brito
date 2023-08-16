@extends('site.master')

@section('content')
    <title>Rodrigo Brito - 404 | Ooops! Conteúdo indisponível!</title>
    <article class="not_found">
        <div>
            <header>
                <p class="error">&bull;404&bull;</p>
                <h1>Ooops! Conteúdo indisponível!</h1>
                <p>Sinto muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento ou foi
                    removido :(</p>
                <a title="Home" href="{{ route('site.home') }}">Continue Navegando</a>
            </header>
        </div>
    </article>
@endsection
