<?php

use Illuminate\Support\Facades\Route;


Route::prefix('user')
        ->namespace('User')
        ->middleware('auth')
        ->group(function() {

//Route::get('admin/cabalauthtable', 'Admin\CabalAuthController@index')->name('plans.index');

//Route::get('admin/plans', 'Admin\PlanController@index')->name('plans.index');

// USER PROFILRE
Route::put('user/profile/{ID}', 'User\ProfileController@update')->name('user.update');
Route::get('user/profile/{ID}/edit', 'User\ProfileController@edit')->name('user.edit');
Route::get('user/profile', 'User\ProfileController@index')->name('user.profile');
Route::get('user', 'User\ProfileController@index')->name('user.index');
///////////////////

// USER CHARS
Route::get('user/chars/{id}', 'User\CharsController@show')->name('user.chars.show');
Route::get('user/chars', 'User\CharsController@index')->name('user.chars');
///////////////////

});

Route::get('/', function () {
    return view('welcome');
});

/**
 * Auth Routes
 */
Auth::routes();
