<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1'], function() {
    Route::resource('contact', 'ContactController', [
        'except' => ['edit', 'create']
    ]);
});

Route::post('user', 'AuthController@store');

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('user/signin', 'AuthController@signin');
    Route::post('user/logout', 'AuthController@logout');
    Route::post('user/refresh', 'AuthController@refresh');
    Route::post('user/me', 'AuthController@me');
});