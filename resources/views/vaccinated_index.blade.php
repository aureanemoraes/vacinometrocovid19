@extends('layouts.app')

@section('title', 'VacinômetroCOVID19')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
@endsection

@section('main')
    @if(isset($vacinationplaces) && $counter > 0)
        <div class="container ">
            <h1>Vacinômetro COVID19</h1>

            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4"><strong class="text-success">{{$counter}}</strong> pessoas foram
                        vacinadas em Macapá/AP!</h1>
                    <p class="lead">Última atualização em: {{date_format($last_form->created_at, 'd/m/Y H:i')}}</p>
                    <p class="lead">Fonte: Secretaria Municipal de Saúde de Macapá</p>
                    <hr class="my-4">

                    <div class="row">
                        @php
                            $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
                            $i=0;
                        @endphp
                        @foreach($vacinationplaces as $vacinationplace)
                            @if($vacinationplace->qtd > 0)
                                <div class="col-sm-2">
                                    <div class="c-callout c-callout-{{$colors[$i]}}">
                                        <small class="text-muted">{{$vacinationplace->name}}</small><br>
                                        <strong class="h4">{{$vacinationplace->qtd}} </strong>imunizados!
                                    </div>
                                </div>
                                @if($i == count($colors)-1)
                                    @php($i = 0)
                                @else
                                    @php($i++)
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            {{--
            <div class="card">
                <div class="card-header"><h4>Lista de locais de vacinação</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display" id="vp_table">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Qtd. imunizados</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h4>Lista de grupos prioritários</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display" id="gp_table">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Qtd. imunizados</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            --}}
            <div class="card">
                <div class="card-header"><h4>Lista de vacinados</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display" id="index_table">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Idade</th>
                                <th scope="col">Lugar de vacinação</th>
                                <th scope="col">Grupo prioritário</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div align="center">
                <form action="/exportcsv" method="POST">
                    <div class="form-group">
                        <select class="form-control" name="time">
                            <option value="one_day">Um dia atrás</option>
                            <option value="one_week">Uma semana atrás</option>
                            <option value="one_month">Um mês atrás</option>
                            <option value="all">Todos</option>
                        </select>
                    </div>

                    <div class="row" align="left">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="csv_virgula" id="export_type"
                                       name="export_type">
                                <label class="form-check-label" for="export_type">
                                    .CSV (separado por vírgula)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="csv_ponto_virgula" id="export_type"
                                       name="export_type">
                                <label class="form-check-label" for="export_type">
                                    .CSV (separado por ponto e vírgula)
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="xlsx" id="export_type"
                                       name="export_type">
                                <label class="form-check-label" for="export_type">
                                    .XLSX
                                </label>
                            </div>
                        </div>
                        <!--
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="pdf" id="export_type" name="export_type">
                                <label class="form-check-label" for="export_type">
                                    .PDF
                                </label>
                            </div>
                        </div>
                        /*
                                $pieces = explode(" ", $form->name);
                                for($i ; $i<count($pieces); $i++) {
                                    if($i=0) {
                                        $firstName = strtoupper($piece[$i])
                                    }
                                    $lastNames .= substr($piece[$i], 1) . '. ';
                                }*/

                        -->
                    </div>

                    <button type="submit" class="btn btn-primary">Exportar</button>
                </form>


            </div>
        </div>
    @else
        <p>Ainda não há dados para serem exibidos.</p>
    @endif
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {

            $('#index_table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
                },

                "ajax": {
                    url: "{{url('api/vacinados')}}",
                    dataSrc: "",

                },
                "columns": [
                    {"data": "name"},
                    {'data': 'age_formatted'},
                    {'data': 'vacinationplace.name'},
                    {'data': 'prioritygroup.name'}

                ]
            });
        });
    </script>
@endsection


