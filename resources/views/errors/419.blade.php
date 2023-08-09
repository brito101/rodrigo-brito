@extends('site.master')
<title>Rodrigo Brito - 419 | Ooops! Página Expirada!</title>
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
