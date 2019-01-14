<?php

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

Route::get('/', 'HomeController@index')->name('home');
