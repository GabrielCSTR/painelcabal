<?php

use Illuminate\Support\Facades\Route;

// USER PROFILRE
Route::put('user/profile/{ID}', 'User\ProfileController@update')->middleware('auth')->name('user.update');
Route::get('user/profile/{ID}', function () {
    return redirect('user/profile/');
});
Route::put('user/profile/{ID}/edit', 'User\ProfileController@edit')->middleware('auth')->name('user.edit');
Route::get('user/profile/{ID}/edit', 'User\ProfileController@edit')->middleware('auth')->name('user.edit');
Route::get('user/profile', 'User\ProfileController@index')->middleware('auth')->name('user.profile');
Route::get('user', 'User\ProfileController@index')->middleware('auth')->name('user.index');
///////////////////

// USER CHARS
Route::put('user/chars/{id}', 'User\CharsController@update')->middleware('auth')->name('user.chars.update');
Route::get('user/chars/{id}', 'User\CharsController@show')->middleware('auth')->name('user.chars.show');
Route::get('user/chars', 'User\CharsController@index')->middleware('auth')->name('user.chars');
///////////////////


Route::get('/', function () {
    //return view('welcome');
    return redirect('/login');
});

Route::post('/login/auth', 'Auth\LoginController@loginUser')->name('login.user');
Route::get('/login/auth', function () {
    return redirect('/login');
});

/**
 * Auth Routes
 */
Auth::routes();
