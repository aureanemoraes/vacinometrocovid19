<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Phone;
use Illuminate\Http\Request;

class PreFormController extends Controller
{
    public function index() {
        return view('pre-form');
    }

    public function store(Request $request) {
        //dd($request->name);
        $form = Form::create($request->all());
        if(isset($request->phone_1)) {
            $form->phones()->create([
                'number' => $request->phone_1,
                'type' => $request->type_phone_1,
                'person' => $request->person_1
            ]);
        }
        if(isset($request->phone_2)) {
            $form->phones()->create([
                'number' => $request->phone_2,
                'type' => $request->type_phone_2,
                'person' => $request->person_2
            ]);
        }
      //  dd($form->load('phones'), $request->all());
    }

}
