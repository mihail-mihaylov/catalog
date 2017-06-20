<?php

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

    // Dashboard routes
    Route::post('dashboard/json/getLastData', [
        'as' => 'dashboard.json.getLastData',
        'uses' => '\App\Modules\Dashboard\Http\Controllers\DashboardController@getDevicesLastData'
    ]);
    Route::resource('dashboard', '\App\Modules\Dashboard\Http\Controllers\DashboardController');

    # General report
    Route::get('/reports/general/trips/{date}/{device_id}', '\App\Modules\Reports\Http\Controllers\GeneralReportController@getTrips');
    Route::get('/reports/general/lastEvent/{device_id}', '\App\Modules\Reports\Http\Controllers\GeneralReportController@getLastEvent');
    Route::post('/reports/general/report', ['as' => 'reports.general.report', 'uses' => '\App\Modules\Reports\Http\Controllers\GeneralReportController@report']);
    Route::resource('/reports/general', '\App\Modules\Reports\Http\Controllers\GeneralReportController');

    # Poi report
    Route::post('/reports/poi/report', [
        'as' => 'reports.poi.report',
        'uses' => '\App\Modules\Reports\Http\Controllers\PoiReportController@report'
    ]);
    Route::resource('/reports/poi', '\App\Modules\Reports\Http\Controllers\PoiReportController');

    // Pois
    Route::get('/pois/json', '\App\Modules\Pois\Http\Controllers\PoiController@json');
    Route::resource('/pois', '\App\Modules\Pois\Http\Controllers\PoiController');
    Route::get('pois/restore/{id}', [
        'as' => 'pois.restore',
        'uses' => '\App\Modules\Pois\Http\Controllers\PoiController@restore'
    ]);

    // Restrictions
    Route::resource('/restrictions', '\App\Modules\Restrictions\Http\Controllers\RestrictionController');
    Route::get('restriction/restore/{restriction}', [
        'as' => 'restrictions.restore',
        'uses' => '\App\Modules\Restrictions\Http\Controllers\RestrictionController@restore'
    ]);

    // Devices
    Route::get('devices/restore/{id}', ['as' => 'devices.restore', 'uses' => '\App\Modules\TrackedObjects\Http\Controllers\DevicesController@restore']);
    Route::resource('device', '\App\Modules\Devices\Http\Controllers\DeviceController');

    // Users
    Route::get('user/restore/{id}', ['as' => 'user.restore', 'uses' => '\App\Modules\Users\Http\Controllers\UsersController@restore']);

    Route::get('group/row_template/{id}', ['as' => 'group.getRow', 'uses' => '\App\Modules\Users\Http\Controllers\GroupsController@getGroupRow']);
    Route::resource('group', '\App\Modules\Users\Http\Controllers\GroupsController');
    Route::get('group/restore/{id}', ['as' => 'group.restore', 'uses' => '\App\Modules\Users\Http\Controllers\GroupsController@restore']);
    Route::get('getEditGroup/{id}', ['as' => 'group.getEdit', 'uses' => '\App\Modules\Users\Http\Controllers\GroupsController@getEditGroup']);

    Route::resource('user', '\App\Modules\Users\Http\Controllers\UserController');
});
