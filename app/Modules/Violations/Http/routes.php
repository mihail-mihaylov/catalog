<?php

/**
 * Restrictions routes
 */
// Route::get('violations/restore/{violation}', [
//     'as'   => 'violations.restore',
//     'uses' => '\App\Modules\Violations\Http\Controllers\ViolationController@restore',
// ]);

Route::get('violations/destroy/all', [
    'as'   => 'violations.destroy.all',
    'uses' => '\App\Modules\Violations\Http\Controllers\ViolationController@destroyAll'
]);

Route::get('violations/getViolationsByRestriction/{id}', [
    'as'   => 'violations.getViolationsByRestriction',
    'uses' => '\App\Modules\Violations\Http\Controllers\ViolationController@getViolationsByRestriction'
]);

// Route::group(['middleware' => 'ViolationEnactment'], function () {
//     Route::post('violations/perform/{id}/{companyId}', [
//         'as' => 'violation.perform', 'uses' => '\App\Modules\Violations\Http\Controllers\ViolationController@performViolation',
//     ]);
// });

Route::get('violationNotifications', [
    'as'   => 'violations.getNotifications',
    'uses' => '\App\Modules\Violations\Http\Controllers\ViolationController@getNotifications',
]);

Route::post('clearViolations', [
    'as'    => 'violations.clear',
    'uses'  => '\App\Modules\Violations\Http\Controllers\ViolationController@clearViolations',
]);

Route::get('getViolation/{violation}', [
    'as'   => 'violations.getViolation',
    'uses' => '\App\Modules\Violations\Http\Controllers\ViolationController@getViolation',
]);

Route::resource('violations', '\App\Modules\Violations\Http\Controllers\ViolationController');
