<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', ['admin'])

    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('vacinationplace', 'VacinationPlaceCrudController');

    Route::crud('form', 'FormCrudController');
    Route::get('form/export', 'FormCrudController@exportView');
    Route::post('form/export', 'FormCrudController@export');
    Route::get('form/import', 'FormCrudController@importView');
    Route::post('form/import', 'FormCrudController@import');
    Route::get('vacinationplace/import', 'VacinationPlaceCrudController@importView');
    Route::post('vacinationplace/import', 'VacinationPlaceCrudController@import');
    Route::get('prioritygroup/import', 'PriorityGroupCrudController@importView');
    Route::post('prioritygroup/import', 'PriorityGroupCrudController@import');
    Route::crud('user', 'UserCrudController');
    Route::crud('prioritygroup', 'PriorityGroupCrudController');
    Route::crud('healthprofessional', 'HealthProfessionalCrudController');
    Route::crud('vaccination', 'VaccinationCrudController');
}); // this should be the absolute last line of this file