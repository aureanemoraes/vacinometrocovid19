<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class PreFormController extends Controller
{
    public function index() {
        return view('pre-form');
    }

    public function store(Request $request) {
        //dd($request->name);
        $teste = Form::create($request->all());
        dd($teste, $request->all());
    }

}
