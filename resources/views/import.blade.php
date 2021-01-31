<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 7 PDF Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>nome</th>
        <th>lugar_vacinacao</th>
        <th>grupo_prioritario</th>
        <th>criado_em</th>
    </tr>
    </thead>
    <tbody>
    @foreach($immunizeds as $immunized)
        <tr>
            <td>{{ $immunized->name }}</td>
            <td>{{ $immunized->vacinationplace->name }}</td>
            <td>{{ $immunized->prioritygroup->name }}</td>
            <td>{{ $immunized->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>

</html>
