@extends('adminlte::page')

@section('title', '- Dashboard')

@section('plugins.Chartjs', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)


@section('adminlte_css')
    <style>
        .callout-purple {
            border-left-color: #6f42c1
        }

        .border-purple {
            border-color: #6f42c1 !important;
            border-width: 5px !important;
        }
    </style>

@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-fw fa-digital-tachograph"></i> Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <x-adminlte-callout theme="purple" class="bg-gradient-dark"
                        title-class="pb-2 border-bottom border-purple" icon="fas fa-lg fa-blog text-white" title="Blog">
                        <p class="my-0">Publicados: {{ $posts->where('status', 'Postado')->count() }}</p>
                        <p class="my-1">Rascunhos: {{ $posts->where('status', 'Rascunho')->count() }}</p>
                        <p class="my-0">Lixeira: {{ $posts->where('status', 'Lixeira')->count() }}</p>
                    </x-adminlte-callout>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <x-adminlte-callout theme="purple" class="bg-gradient-dark"
                        title-class="pb-2 border-bottom border-purple" icon="fas fa-lg fa-file text-white"
                        title="Portifólio">
                        <p class="my-0">Publicados: {{ $projects->where('status', 'Postado')->count() }}</p>
                        <p class="my-1">Rascunhos: {{ $projects->where('status', 'Rascunho')->count() }}</p>
                        <p class="my-0">Lixeira: {{ $projects->where('status', 'Lixeira')->count() }}</p>
                    </x-adminlte-callout>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <x-adminlte-callout theme="purple" class="bg-gradient-dark"
                        title-class="pb-2 border-bottom border-purple" icon="fas fa-lg fa-graduation-cap text-white"
                        title="Certificados">
                        <p class="my-0">Publicados: {{ $certificates->where('status', 'Postado')->count() }}</p>
                        <p class="my-1">Rascunhos: {{ $certificates->where('status', 'Rascunho')->count() }}</p>
                        <p class="my-0">Lixeira: {{ $certificates->where('status', 'Lixeira')->count() }}</p>
                    </x-adminlte-callout>
                </div>
            </div>

            @if (Auth::user()->hasRole('Programador|Administrador'))
                <div class="card text-center">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Acessos nos últimos 10 dias</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th class="text-left">Dia</th>
                                        <th>Total de Acessos</th>
                                        <th>Usuários</th>
                                        <th>Páginas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitors->reverse() as $visit)
                                        <tr>
                                            <td class="text-left">{{ date('d/m/Y', strtotime($visit[0]->created_at)) }}</td>
                                            <td>{{ $visit->count() }}</td>
                                            <td> {{ $visit->groupBy('ip')->count() }}</td>
                                            <td>{{ $visit->groupBy('url')->count() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row px-2">
                    <div class="card col-12">
                        <div class="card-header">
                            Top 10 Acessados
                        </div>
                        <div class="card-body px-0 pb-0 d-flex flex-wrap justify-content-center">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-header border-0">
                                        <p class="mb-0">Posts</p>
                                    </div>
                                    <div class="cardy-body py-2">
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas id="posts-chart" style="display: block; width: 203px; height: 100px;"
                                                class="chartjs-render-monitor" width="203" height="100"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-header border-0">
                                        <p class="mb-0">Projetos</p>
                                    </div>
                                    <div class="cardy-body py-2">
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas id="projects-chart" style="display: block; width: 203px; height: 100px;"
                                                class="chartjs-render-monitor" width="203" height="100"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                            <h3 class="card-title align-self-center">Acessos Diário</h3>
                        </div>
                    </div>

                    @php
                        $heads = [['label' => 'Hora', 'width' => 10], 'Página', 'IP', 'User-Agent', 'Plataforma', 'Navegador', 'Usuário', 'Método', 'Requisição'];
                        $config = [
                            'ajax' => url('/admin'),
                            'columns' => [['data' => 'time', 'name' => 'time'], ['data' => 'url', 'name' => 'url'], ['data' => 'ip', 'name' => 'ip'], ['data' => 'useragent', 'name' => 'useragent'], ['data' => 'platform', 'name' => 'platform'], ['data' => 'browser', 'name' => 'browser'], ['data' => 'name', 'name' => 'name'], ['data' => 'method', 'name' => 'method'], ['data' => 'request', 'name' => 'request']],
                            'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                            'order' => [0, 'desc'],
                            'destroy' => true,
                            'autoFill' => true,
                            'processing' => true,
                            'serverSide' => true,
                            'responsive' => true,
                            'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
                            'dom' => '<"d-flex flex-wrap col-12 justify-content-between"Bf>rtip',
                            'buttons' => [
                                ['extend' => 'pageLength', 'className' => 'btn-default'],
                                ['extend' => 'copy', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-copy text-secondary"></i>', 'titleAttr' => 'Copiar', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                ['extend' => 'print', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-print text-info"></i>', 'titleAttr' => 'Imprimir', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                ['extend' => 'csv', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-csv text-primary"></i>', 'titleAttr' => 'Exportar para CSV', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                ['extend' => 'excel', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-excel text-success"></i>', 'titleAttr' => 'Exportar para Excel', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                ['extend' => 'pdf', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-pdf text-danger"></i>', 'titleAttr' => 'Exportar para PDF', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                            ],
                        ];
                    @endphp

                    <div class="card-body">
                        <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads" :config="$config" striped
                            hoverable beautify />
                    </div>
                </div>

                <div class="row px-0">

                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Usuários Online: <span
                                            id="onlineusers">{{ $onlineUsers }}</span></h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg" id="accessdaily">{{ $access }}</span>
                                        <span>Acessos Diários</span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right">
                                        <span id="percentclass"
                                            class="{{ $percent > 0 ? 'text-success' : 'text-danger' }}">
                                            <i id="percenticon"
                                                class="fas {{ $percent > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}  mr-1"></i><span
                                                id="percentvalue">{{ $percent }}</span>%
                                        </span>
                                        <span class="text-muted">em relação ao dia anterior</span>
                                    </p>
                                </div>

                                <div class="position-relative mb-4">
                                    <div class="chartjs-size-monitor" z>
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <canvas id="visitors-chart" style="display: block; width: 489px; height: 200px;"
                                        class="chartjs-render-monitor" width="489" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </section>
@endsection

@section('custom_js')
    @if (Auth::user()->hasRole('Programador|Administrador'))
        <script>
            const posts = document.getElementById('posts-chart');
            if (posts) {
                posts.getContext('2d');
                const postsChart = new Chart(posts, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($postsChart['label']) !!},
                        datasets: [{
                            label: 'Posts',
                            data: {!! json_encode($postsChart['data']) !!},
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(0, 63, 92, 0.5)',
                                'rgba(47, 75, 124, 0.5)',
                                'rgba(102, 81, 145, 0.5)',
                                'rgba(160, 81, 149, 0.5)',
                                'rgba(212, 80, 135, 0.5)',
                                'rgba(249, 93, 106, 0.5)',
                                'rgba(255, 124, 67, 0.5)',
                                'rgba(255, 166, 0, 0.5)',
                                'rgba(188, 245, 28, 0.5)',
                                'rgba(28, 245, 154, 0.5)',
                                'rgba(28, 167, 245, 0.5)',
                                'rgba(123, 28, 245, 0.5)',
                            ],
                            borderColor: [
                                'rgba(0, 63, 92)',
                                'rgb(47, 75, 124)',
                                'rgb(102, 81, 145)',
                                'rgb(160, 81, 149)',
                                'rgb(212, 80, 135)',
                                'rgb(249, 93, 106)',
                                'rgb(255, 124, 67)',
                                'rgb(255, 166, 0)',
                                'rgb(188, 245, 28)',
                                'rgb(28, 245, 154)',
                                'rgb(28, 167, 245)',
                                'rgb(123, 28, 245)',
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'left',
                            fontColor: "#f8f9fa",
                            fontSize: 12
                        },
                    },
                });
            }

            const projects = document.getElementById('projects-chart');
            if (projects) {
                projects.getContext('2d');
                const projectsChart = new Chart(projects, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($projectsChart['label']) !!},
                        datasets: [{
                            label: 'Projetos',
                            data: {!! json_encode($projectsChart['data']) !!},
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(0, 63, 92, 0.5)',
                                'rgba(47, 75, 124, 0.5)',
                                'rgba(102, 81, 145, 0.5)',
                                'rgba(160, 81, 149, 0.5)',
                                'rgba(212, 80, 135, 0.5)',
                                'rgba(249, 93, 106, 0.5)',
                                'rgba(255, 124, 67, 0.5)',
                                'rgba(255, 166, 0, 0.5)',
                                'rgba(188, 245, 28, 0.5)',
                                'rgba(28, 245, 154, 0.5)',
                                'rgba(28, 167, 245, 0.5)',
                                'rgba(123, 28, 245, 0.5)',
                            ],
                            borderColor: [
                                'rgba(0, 63, 92)',
                                'rgb(47, 75, 124)',
                                'rgb(102, 81, 145)',
                                'rgb(160, 81, 149)',
                                'rgb(212, 80, 135)',
                                'rgb(249, 93, 106)',
                                'rgb(255, 124, 67)',
                                'rgb(255, 166, 0)',
                                'rgb(188, 245, 28)',
                                'rgb(28, 245, 154)',
                                'rgb(28, 167, 245)',
                                'rgb(123, 28, 245)',
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'left',
                            fontColor: "#f8f9fa",
                            fontSize: 12
                        },
                    },
                });
            }
        </script>

        <script>
            const ctx = document.getElementById('visitors-chart');
            if (ctx) {
                ctx.getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ({!! json_encode($chart->labels) !!}),
                        datasets: [{
                            label: 'Acessos por hora',
                            data: {!! json_encode($chart->dataset) !!},
                            borderWidth: 1,
                            borderColor: '#007bff',
                            backgroundColor: 'transparent'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        legend: {
                            labels: {
                                boxWidth: 0,
                            }
                        },
                    },
                });

                let getData = function() {

                    $.ajax({
                        url: "{{ route('admin.home.chart') }}",
                        type: "GET",
                        success: function(data) {
                            myChart.data.labels = data.chart.labels;
                            myChart.data.datasets[0].data = data.chart.dataset;
                            myChart.update();
                            $("#onlineusers").text(data.onlineUsers);
                            $("#accessdaily").text(data.access);
                            $("#percentvalue").text(data.percent);
                            const percentclass = $("#percentclass");
                            const percenticon = $("#percenticon");
                            percentclass.removeClass('text-success');
                            percentclass.removeClass('text-danger');
                            percenticon.removeClass('fa-arrow-up');
                            percenticon.removeClass('fa-arrow-down');
                            if (parseInt(data.percent) > 0) {
                                percentclass.addClass('text-success');
                                percenticon.addClass('fa-arrow-up');
                            } else {
                                percentclass.addClass('text-danger');
                                percenticon.addClass('fa-arrow-down');
                            }
                        }
                    });
                };
                setInterval(getData, 10000);
            }
        </script>
    @endif
@endsection
