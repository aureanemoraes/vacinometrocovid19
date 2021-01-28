@extends(backpack_view('blank'))

@section('header')

@endsection

@section('content')

    <div class="container">
        <form action="import" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Arquivo</label>
                <input type="file" class="form-control" id="file" name="file">
            </div>

            <button type="submit">Importar</button>
        </form>
    </div>


@endsection

