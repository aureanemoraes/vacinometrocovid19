<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Exports\FormExport;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index']);

Route::get('/noaccess', function () {
    return view('no_access');
});

Route::post('/exportcsv', function (Request $request) {
    $initialDate = $request->input('initial_date');
    $finalDate = $request->input('final_date');
    return (new FormExport($initialDate, $finalDate))->download('vacinometrocovid19_'.$initialDate.'_to_'.$finalDate.'.csv');
});
