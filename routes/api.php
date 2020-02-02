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

    Route::get('image/{id}', 'Api\Users\ProfileImageController@show')->name('api.users.image.show');

    Route::post('user', 'Api\Users\UserController@index')->name('api.users.user.index');
    Route::patch('user/{id}', 'Api\Users\UserController@update')->name('api.users.user.update');
    Route::post('user/{id}', 'Api\Users\UserController@store')->name('api.users.user.store');

    Route::get('songs', 'Api\Songs\SongController@index')->name('api.songs.song.index');
    Route::get('song/{id}', 'Api\Songs\SongController@songById')->name('api.songs.song.song-by-id');
    Route::get('songs/{userId}', 'Api\Songs\SongController@songsByUserId')->name('api.songs.song.songs-by-user-id');
    Route::post('add-song/{userId}', 'Api\Songs\SongController@store')->name('api.users.user.store');
    Route::delete('song/{id}', 'Api\Songs\SongController@destroy')->name('api.songs.song.song-by-id');

    Route::get('youtube/{id}', 'Api\Youtube\YoutubeController@show')->name('api.youtube.youtube.show');
    Route::post('youtube', 'Api\Youtube\YoutubeController@store')->name('api.youtube.youtube.store');
    Route::delete('youtube/{id}', 'Api\Youtube\YoutubeController@destroy')->name('api.youtube.youtube.destroy');

    Route::get('following/{id}', 'Api\Following\FollowingController@show')->name('api.following.following.show');

});
