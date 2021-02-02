@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => 'Bem vindo ao VacinômetroCOVID19!',
        'content'     => '<a href="'. route('form.create') . '" class="btn btn-square btn-info btn-lg btn-block">Cadastre um novo imunizado!</a>'
    ];
@endphp

