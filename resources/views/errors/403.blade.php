@extends('site.master')

@section('title')
    <title>{{ env('APP_SHORT_NAME') }} - 403 | Ooops! Acesso não autorizado!</title>
@endsection

@section('content')
    <article class="not_found">
        <div>
            <header>
                <p class="error">&bull;403&bull;</p>
                <h1>Ooops! Acesso não autorizado!</h1>
                <p>Sinto muito, mas você está tentando acessar uma área sem permissão! :(</p>
                <a title="Home" href="{{ route('site.home') }}">Continue Navegando</a>
            </header>
        </div>
    </article>
@endsection
