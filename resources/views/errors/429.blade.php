@extends('site.master')

@section('title')
    <title>{{ env('APP_SHORT_NAME') }} - 429 | Ooops! Excesso de requisições!</title>
@endsection

@section('content')
    <article class="not_found">
        <div>
            <header>
                <p class="error">&bull;429&bull;</p>
                <h1>Ooops! Excesso de requisições</h1>
                <p>Sinto muito, mas você atingiu o limite de requisições por período! Aguarde por três minutos por favor :(
                </p>
            </header>
        </div>
    </article>
@endsection
