<?php

/**
 * Start Dashboard routes
 */
Route::post('dashboard/json/getLastData', ['as' => 'dashboard.json.getLastData', 'uses' => '\App\Modules\Dashboard\Http\Controllers\DashboardController@getTrackedObjectsLastData']);
Route::post('dashboard/json/getDailyToStatistics', ['as' => 'dashboard.json.getDailyToStatistics', 'uses' => '\App\Modules\Dashboard\Http\Controllers\DashboardController@getDailyToStatistics']);

Route::get('trains/{id}/manage', ['as' => 'trains.manage', 'uses' => '\App\Modules\Dashboard\Http\Controllers\TrainsController@getTrainsManage']);
Route::post('trains/store', ['as' => 'trains.store', 'uses' => '\App\Modules\Dashboard\Http\Controllers\TrainsController@postTrainsManage']);

/**
 * End Dashboard routes
 */
