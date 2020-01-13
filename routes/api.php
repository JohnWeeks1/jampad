<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->prefix('auth')->group(function () {

    Route::post('register', 'AuthController@register')->name('register');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout')->name('logout');
    Route::post('refresh', 'AuthController@refresh')->name('refresh');

    Route::post('user', 'Api\Users\UserController@index')->name('api.users.user.index');
    Route::get('image', 'Api\Users\UserController@image')->name('api.users.user.image');
    Route::patch('user/{id}', 'Api\Users\UserController@update')->name('api.users.user.update');
    Route::post('user/{id}', 'Api\Users\UserController@store')->name('api.users.user.store');

    Route::get('song/{id}', 'Api\Songs\SongController@songById')->name('api.songs.song.song-by-id');
    Route::get('songs/{userId}', 'Api\Songs\SongController@songsByUserId')->name('api.songs.song.songs-by-user-id');
    Route::post('add-song/{userId}', 'Api\Songs\SongController@store')->name('api.users.user.store');

});
