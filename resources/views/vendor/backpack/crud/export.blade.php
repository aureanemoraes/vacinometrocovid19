@extends(backpack_view('blank'))

@section('header')

@endsection

@section('content')

    <div class="container">
        <form action="export" method="POST">
            @csrf
            <div class="form-group">
                <label for="initial_date">Data inicial</label>
                <input type="date" class="form-control" id="initial_date" name="initial_date">
            </div>

            <div class="form-group">
                <label for="final_date">Data final</label>
                <input type="date" class="form-control" id="final_date" name="final_date">
            </div>

            <button type="submit">Exportar</button>
        </form>
    </div>


@endsection

