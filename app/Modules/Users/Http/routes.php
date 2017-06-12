<?php

/**
 * START Users module
 */

Route::get('user/restore/{id}', ['as' => 'user.restore', 'uses' => '\App\Modules\Users\Http\Controllers\UsersController@restore']);

Route::get('group/row_template/{id}', ['as' => 'group.getRow', 'uses' => '\App\Modules\Users\Http\Controllers\GroupsController@getGroupRow']);
Route::resource('group', '\App\Modules\Users\Http\Controllers\GroupsController');
Route::get('group/restore/{id}', ['as' => 'group.restore', 'uses' => '\App\Modules\Users\Http\Controllers\GroupsController@restore']);
Route::get('getEditGroup/{id}', ['as' => 'group.getEdit', 'uses' => '\App\Modules\Users\Http\Controllers\GroupsController@getEditGroup']);

Route::resource('user', '\App\Modules\Users\Http\Controllers\UsersController');
/**
 * END Users module
 */
