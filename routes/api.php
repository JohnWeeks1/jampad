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

    Route::get('image/{id}', 'Api\ProfileImageController@show')->name('api.image.show');

    Route::post('user', 'Api\UserController@index')->name('api.user.index');
    Route::patch('user/{id}', 'Api\UserController@update')->name('api.user.update');
    Route::post('user/{id}', 'Api\ProfileImageController@store')->name('api.users.user.store');

    Route::get('songs', 'Api\SongController@index')->name('api.song.index');
    Route::get('songs/{id}', 'Api\SongController@show')->name('api.song.show');
    Route::post('songs/{userId}', 'Api\SongController@store')->name('api.user.store');
    Route::delete('songs/{id}', 'Api\SongController@destroy')->name('api.song.destroy');

    Route::get('user/{userId}/songs', 'Api\User\SongsController@show')->name('api.user.songs.show');

    Route::get('youtube/{id}', 'Api\YoutubeController@show')->name('api.youtube.show');
    Route::post('youtube', 'Api\YoutubeController@store')->name('api.youtube.store');
    Route::delete('youtube/{id}', 'Api\YoutubeController@destroy')->name('api.youtube.destroy');

    Route::get('following/{id}', 'Api\FollowingController@show')->name('api.following.show');

});
