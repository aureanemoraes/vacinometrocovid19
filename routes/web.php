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
    $initial_date = $request->input('initial_date');
    $final_date = $request->input('final_date');
    $export_type = $request->input('export_type');
        switch($export_type) {
            case 'csv_virgula':
                return (new FormExport($initial_date, $final_date, ','))->download('vacinometrocovid19_'.$initial_date.'_to_'.$final_date.'.csv');
                break;
            case 'csv_ponto_virgula':
                return (new FormExport($initial_date, $final_date, ';'))->download('vacinometrocovid19_'.$initial_date.'_to_'.$final_date.'.csv');
                break;
            case 'xlsx':
                return (new FormExport($initial_date, $final_date, ';'))->download('vacinometrocovid19_'.$initial_date.'_to_'.$final_date.'.xlsx');
                break;
        }
});
