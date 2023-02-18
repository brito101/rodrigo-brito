@extends('adminlte::page')

@section('title', '- Edição de Certificado')
@section('plugins.select2', true)
@section('plugins.BsCustomFileInput', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-graduation-cap"></i> Editar Certificado</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.certificates.index') }}">Certificados</a></li>
                        <li class="breadcrumb-item active">Editar Certificado</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @include('components.alert')

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dados Cadastrais do Certificad</h3>
                        </div>

                        <form method="POST"
                            action="{{ route('admin.certificates.update', ['certificate' => $certificate]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $certificate->id }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="name">Título</label>
                                        <input type="text" class="form-control" id="title"
                                            placeholder="Título do Certificado" name="title"
                                            value="{{ old('title') ?? $certificate->title }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status" required>
                                            <option
                                                {{ old('status') == 'post' ? 'selected' : ($certificate->status == 'post' ? 'selected' : '') }}
                                                value="post">Postado
                                            </option>
                                            <option
                                                {{ old('status') == 'draft' ? 'selected' : ($certificate->status == 'draft' ? 'selected' : '') }}
                                                value="draft">Rascunho
                                            </option>
                                            <option
                                                {{ old('status') == 'trash' ? 'selected' : ($certificate->status == 'trash' ? 'selected' : '') }}
                                                value="trash">Lixo
                                            </option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <x-adminlte-input-file name="cover" label="Imagem"
                                            placeholder="Selecione uma imagem..." legend="Selecionar" />
                                    </div>
                                </div>

                                @if ($certificate->cover)
                                    <div class='col-12 align-self-center mt-3 d-flex justify-content-center px-0'>
                                        <img src="{{ url('storage/certificates/' . $certificate->cover) }}"
                                            alt="{{ $certificate->title }}" title="{{ $certificate->title }}"
                                            class="img-thumbnail d-block">
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
