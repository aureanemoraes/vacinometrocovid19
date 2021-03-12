@extends('layouts.app')

@section('title', 'VacinometroCOVID19 - Lista 1ª dose')

@section('links')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
@endsection

@section('main')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Lista de vacinados - 1ª dose</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" >
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
                </div>
                <input type="hidden" name="dose" value="0">
                <button type="submit" class="btn btn-primary">Exportar</button>
            </form>


        </div>
    </div>
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
                    url: "{{url('api/vacinados/1')}}",
                    dataSrc: "",

                },
                "columns": [
                    {"data": "name_formatted"},
                    {'data': 'age_formatted'},
                    {'data': 'vacinationplace.name'},
                    {'data': 'prioritygroup.name'}

                ]
            });
        });
    </script>
@endsection
