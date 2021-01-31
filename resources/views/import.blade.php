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
