<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

    <title>Document</title>
</head>
<body>
    <div class="container ">
        <h1>Vacinômetro COVID19</h1>
        <div class="table-responsive">
            <table class="table display" id="index_table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Idade</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Lugar de vacinação</th>
                        <th scope="col">Grupo prioritário</th>
                        <th scope="col">Gênero</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($forms as $form)
                        <tr>
                            <td>{{$form->id}}</td>
                            <td>{{$form->name}}</td>
                            <td>{{$form->age}}</td>

                            <td>{{$form->publicplace}}, {{$form->number}}, {{$form->neighborhood}}</td>
                            <td>{{$form->vacinationplace->name}}</td>
                            <td>{{$form->prioritygroup}}</td>
                            <td>{{$form->gender}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

        <div align="center">

            <form action="/exportcsv" method="POST">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="initial_date">Data inicial</label>
                            <input type="date" class="form-control" id="initial_date" name="initial_date">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="final_date">Data final</label>
                            <input type="date" class="form-control" id="final_date" name="final_date">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Exportar</button>
            </form>


        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>
<script>
    $(document).ready( function () {

        $('#index_table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
            }
        });
    } );
</script>
</html>



