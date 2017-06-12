<?php

/**
 * Tracked objects groups module routes
 */
Route::resource('trackedobjects/groups', '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController');

Route::get('trackedobjects/groups/restore/{id}', [
    'as' => 'trackedobjects.groups.restore',
    'uses' => '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController@restore'
]);

Route::resource('trackedobjects/groups', '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController');

Route::put('trackedobjects/groups/update/{trackedObjectId}', [
    'as' => 'trackedObject.groups.updateGroups',
    'uses' => '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController@updateTrackedObjectsGroups'
]);

Route::get('trackedobjects/get/groups/{trackedObjectId}', [
    'as' => 'trackedObject.get.groups',
    'uses' => '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController@getTrackedObjectsGroups'
]);

//Route::get('trackedobjects/ajax/groups/get_tracked_object_groups/{trackedObjectId}', [
//    'as' => 'trackedObject.groups.index',
//    'uses' => '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController@getTrackedObjectsGroups'
//]);
//
//Route::post('trackedobjects/groups/add_tracked_object_to_group', '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController@addTrackedObjectToGroup');

Route::get('trackedobjects/groups/remove_tracked_object_from_group/{trackedObjectId}/{groupId}',[
    'as'=>'trackedObjects.groups.remove.trackedObject',
    'uses'=>'\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController@removeTrackedObjectFromGroup'
    ]);

// Route::get('trackedobjects/groups/reload_group_tracked_objects/{groupId}', '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController@reloadGroupTrackedObjects');
Route::get('trackedobjects/ajax/brand/get_models/{brandId}', [
    'as' => 'trackedobjects.get.brand.models',
    'uses' => '\App\Modules\TrackedObjects\Http\Controllers\BrandController@getBrandModels'
]);

Route::get('trackedobjects/groups/get/trackedobjects/{groupId}', [
    'as' => 'group.get.trackedObjects',
    'uses' => '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController@getTrackedObjects'
]);

Route::put('trackedobjects/groups/sync/{groupId}', [
    'as' => 'group.trackedObjects.sync',
    'uses' => '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsGroupsController@syncTrackedObjectsWithGroup'
]);

/**
 * Tracked objects module routes
 */
Route::resource('trackedobjects', '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsController');
Route::get('trackedobjects/restore/{id}', ['as' => 'trackedobjects.restore', 'uses' => '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsController@restore']);

// don't uncomment this unless it works
// Route::get('trackedobjects/ajax/get_models_by_brand/{brandId}', '\App\Modules\TrackedObjects\Http\Controllers\Ajax\TrackedObjectsGroupsController@getModelsByBrand');

Route::post('trackedobjects/check_trackedobject_id', [
    'as' => 'trackedobject.check.identification.number',
    'uses' => '\App\Modules\TrackedObjects\Http\Controllers\TrackedObjectsController@checkTrackedObjectId'
]);
