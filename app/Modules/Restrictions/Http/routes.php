<?php        

/**
 * Restrictions routes
 */
Route::resource('/restrictions', '\App\Modules\Restrictions\Http\Controllers\RestrictionController');
Route::get('restriction/restore/{restriction}', [
	'as' => 'restrictions.restore',
	'uses' => '\App\Modules\Restrictions\Http\Controllers\RestrictionController@restore'
]);