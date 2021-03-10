<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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

Route::get('/vacinados/primeira-dose', function() {
    return view('first_dose');
});

Route::get('/vacinados/segunda-dose', function() {
    return view('second_dose');
});

Route::get('/noaccess', function () {
    return view('no_access');
});

Route::post('/exportcsv', [\App\Http\Controllers\IndexController::class, 'export']);
Route::get('/pre-cadastro', [\App\Http\Controllers\PreFormController::class, 'index']);
Route::post('/pre-cadastro', [\App\Http\Controllers\PreFormController::class, 'store']);


Route::post('/cep', function(Request $request){
    $zip_code = $request->input('zip_code');
    $address = $request->input('public_place');

    if(isset($zip_code)) {
        $cepResponse = \Canducci\Cep\Facades\Cep::find($request->input('zip_code'));
        $data = $cepResponse->getCepModel();
        return response()->json($data);
    }
});



