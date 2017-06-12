<?php

/**
 * Start Poi routes
 */

Route::get('/pois/json', '\App\Modules\Pois\Http\Controllers\PoiController@json');
Route::resource('/pois', '\App\Modules\Pois\Http\Controllers\PoiController');
// Route::post('/pois/create', [
//     'uses'       => '\App\Modules\Pois\Http\Controllers\PoiController@create',
//     'middleware' => 'CreatePoiMiddleware',
// ]);

Route::get('pois/restore/{id}', [
    'as' => 'pois.restore',
    'uses' => '\App\Modules\Pois\Http\Controllers\PoiController@restore'
]);

/**
 * End Poi routes
 */
