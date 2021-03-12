@extends('layouts.app')

@section('title', 'VacinômetroCOVID19')


@section('css')
    .c-body {
        background-color: white;
    }

    .number_vac_banner {
        background: #2E0854;
        max-width: 400px;
        padding: 10px;
    }
    .number_vac_label {
        font-size: 30px;
        width: fit-content;
        padding: 10px;
        border-radius: 10px;
        background: #4ff4a2;

    }

    .number_vac_count {
        font-size: 40px;
        font-weight: bold;
    }

    .card-columns {
    -webkit-column-count:2;
    -moz-column-count:2;
    column-count:1;

    }
@endsection

@section('main')
    @if(isset($vacinationplaces) && ($counter > 0 || $counter_2 > 0))
        <div class="container ">
            <h1>Vacinômetro COVID19</h1>

            <div class="container">
                <div class="card-columns" align="center">
                    <div class="card  number_vac_banner shadow p-3 mb-5 rounded mx_auto" >
                        <div class="card-body">
                            <p class="text-white number_vac_label">TOTAL DE VACINADOS</p>
                            <p class="text-white number_vac_count">
                                {{$counter}}
                            </p>
                            <p class="text-white number_vac_label">1ª DOSE</p>
                            <a href="/vacinados/primeira-dose" class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="card  number_vac_banner shadow p-3 mb-5 rounded mx_auto" >
                        <div class="card-body">
                            <p class="text-white  number_vac_label">TOTAL DE VACINADOS</p>
                            <p class="text-white number_vac_count">
                                {{$counter_2}}
                            </p>
                            <p class="text-white  number_vac_label">2ª DOSE</p>
                            <a href="/vacinados/segunda-dose" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                {{--
                <h1 class="display-4"><strong class="text-success">{{$counter}}</strong> pessoas foram
                    vacinadas em Macapá/AP!</h1>
                <p class="lead">Última atualização em: {{date_format($last_form->created_at, 'd/m/Y H:i')}}</p>
                <p class="lead">Fonte: Secretaria Municipal de Saúde de Macapá</p>
                <hr class="my-4">

                <div class="row">
                </div>
                --}}
            </div>


            <div class="card">
                <div class="card-header" role="tab" type="button" data-toggle="collapse" data-target="#c2">
                    <h4>Lista de locais de vacinação</h4>
                    <span class="text-info">(clique aqui)</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive collapse" id="c2">
                        <table class="table table-sm table-hover table-bordered mx-auto" style="width: fit-content;">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">1ª Dose</th>
                                <th scope="col">2ª Dose</th>
                            </tr>
                            </thead>
                            @foreach($vacinationplaces as $vacinationplace)
                                @if(($vacinationplace->qtd > 0 || $vacinationplace->qtd_2 > 0))
                                    <tbody>
                                    <tr>
                                        <td>{{$vacinationplace->name}}</td>
                                        <td>{{$vacinationplace->qtd}}</td>
                                        <td>{{$vacinationplace->qtd_2}}</td>
                                    </tr>
                                    </tbody>
                                @endif
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header" role="tab" type="button" data-toggle="collapse" data-target="#c1">
                    <h4>Lista de grupos prioritários</h4>
                    <span class="text-info">(clique aqui)</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive collapse" id="c1">
                        <table class="table table-sm table-hover table-bordered mx-auto" style="width: fit-content;">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">1ª Dose</th>
                                <th scope="col">2ª Dose</th>
                            </tr>
                            </thead>
                            @foreach($prioritygroups as $prioritygroup)
                                @if(($prioritygroup->qtd > 0 || $prioritygroup->qtd_2 > 0))
                                    <tbody>
                                    <tr>
                                        <td>{{$prioritygroup->name}}</td>
                                        <td>{{$prioritygroup->qtd}}</td>
                                        <td>{{$prioritygroup->qtd_2}}</td>

                                    </tr>
                                    </tbody>

                                @endif
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>


        </div>
    @else
        <p>Ainda não há dados para serem exibidos.</p>
    @endif
@endsection



