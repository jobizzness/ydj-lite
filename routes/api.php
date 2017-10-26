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
    Route::get('profile/{username}', 'User\UserController@profile');
    Route::resource('media', 'Media\MediaController');
    Route::resource('product', 'Product\ProductController');
    Route::resource('category', 'Category\CategoryController');

});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => 'public:api'], function () {

});