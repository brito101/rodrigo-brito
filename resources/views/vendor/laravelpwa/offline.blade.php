@extends('site.master')

@section('title')
    <title>{{ env('APP_SHORT_NAME') }} - PWA Offline</title>
@endsection

@section('content')
    <article class="not_found">
        <div>
            <header>
                <p class="error">&bull;PWA Offline&bull;</p>
                <h1>No momento você está sem conexão com internet</h1>
                <p>Verifique a rede do seu dispositivo</p>
            </header>
        </div>
    </article>
@endsection
