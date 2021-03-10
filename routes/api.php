<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('vacinados/1', function () {
    $forms = \App\Models\Form::with('vacinationplace:id,name', 'prioritygroup:id,name')->select('name','vacinationplace_id','prioritygroup_id','age')
        ->where('dose', 0)->get();
    return $forms;
});

Route::get('vacinados/2', function () {
    $forms = \App\Models\Form::with('vacinationplace:id,name', 'prioritygroup:id,name')->select('name','vacinationplace_id','prioritygroup_id','age')
        ->where('dose', 2)->get();
    return $forms;
});

