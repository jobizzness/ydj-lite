<?php


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
*/


// Hooks
Route::post('/auth/register', 'Auth\RegisterController@create');

Route::get('/order/{order}/payment/succeed', 'PaymentController@verifyPaypalTransaction')->name('getDone');

Route::get('/order/{order}/payment/fail', 'PaymentController@getCancel')->name('getCancel');

Route::group(['middleware' => 'public:api'], function () {

    // Product
    Route::get('/product/{id}', 'Product\ProductController@show');

});

/*
|--------------------------------------------------------------------------
| Protected Routes. |
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => 'auth:api'], function () {

    // User & Seller with Store
    Route::resource('user', 'User\UserController');
    Route::resource('user.products', 'Product\UserProductController');
    Route::get('profile/{username}', 'User\UserController@profile');
    Route::get('/seller/make', 'User\UserController@makeSeller');

    //Media & Assets
    Route::resource('media', 'Media\MediaController');
    Route::post('asset', 'Media\MediaController@saveAsset');

    // Product & Cart
    Route::resource('product', 'Product\ProductController');
    Route::post('/cart/{slug}', 'Product\ProductController@cartStore');
    Route::delete('/cart/{slug}', 'Product\ProductController@cartDestroy');
    Route::post('product-status/{command}', 'Product\ProductController@changeStatus');
    Route::get('/favorites', 'Product\ProductController@favorites');
    Route::get('/requests', 'Product\ProductController@productRequests');
    Route::get('/favorites/{slug}', 'Product\ProductController@toggleLike');
    Route::get('/product-view/{slug}', 'Product\ProductController@viewProduct');

    // Checkout
    Route::get('/checkout', 'Payment\PaymentController@checkout');
    Route::get('/checkout/key', 'Payment\PaymentController@generateKey');

    //Withdrawals
    Route::resource('withdrawal', 'Payment\WithdrawalController');

    // App Global stuff
    Route::resource('category', 'Category\CategoryController');

});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => 'public:api'], function () {

    // Product
    Route::get('product', 'Product\ProductController@index');

});