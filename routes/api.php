<?php


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
*/
//Hooks
Route::get('/checkout/{$id}', 'Payment\PaymentController@getCheckout');

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
    Route::resource('user.products', 'Product\UserProductController');
    Route::get('profile/{username}', 'User\UserController@profile');

    Route::resource('media', 'Media\MediaController');
    Route::post('asset', 'Media\MediaController@saveAsset');

    // Product & Cart
    Route::resource('product', 'Product\ProductController');
    Route::post('/cart/{slug}', 'Product\ProductController@cartStore');
    Route::delete('/cart/{slug}', 'Product\ProductController@cartDestroy');

    Route::resource('category', 'Category\CategoryController');

});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => 'public:api'], function () {
    Route::get('product', 'Product\ProductController@index');
    Route::get('product/{id}', 'Product\ProductController@show');
    //Route::get('/user/{username}/products', 'Product\UserProductController@index');
});