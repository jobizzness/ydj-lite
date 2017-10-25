<?php


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
*/

Route::post('/auth/register', 'Auth\RegisterController@create');

/*
|--------------------------------------------------------------------------
| Protected Routes. |
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => 'auth:api'], function () {

    Route::get('/seller/make', 'User\UserController@makeSeller');
    Route::resource('user', 'User\UserController');
    Route::resource('media', 'Media\MediaController');

});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => 'public:api'], function () {

});