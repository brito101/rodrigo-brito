@extends('site.master')

@section('title')
    <title>{{ env('APP_SHORT_NAME') }} - 419 | Ooops! Página Expirada!</title>
@endsection

@section('content')
    <article class="not_found">
        <div>
            <header>
                <p class="error">&bull;419&bull;</p>
                <h1>Ooops! Página Expirada!</h1>
                <p>Sinto muito, mas você está tentando acessar uma expirada! :(</p>
                <a title="Home" href="{{ route('site.home') }}">Continue Navegando</a>
            </header>
        </div>
    </article>
@endsection
