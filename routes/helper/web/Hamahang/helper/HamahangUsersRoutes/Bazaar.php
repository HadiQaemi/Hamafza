<?php
// UGC = User or Group or Chanel

Route::group(['prefix' => 'bazaar', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar']], function ()
{
    // load cart page directly
    Route::get('/cart', ['as' => 'ugc.desktop.hamahang.bazaar.cart', 'uses' => 'BazaarController@cart', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar.cart']]);

    // load shipping page directly
    Route::get('/shipping', ['as' => 'ugc.desktop.hamahang.bazaar.shipping', 'uses' => 'BazaarController@shipping', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar.shipping']]);

    // load review page directly
    Route::get('/review', ['as' => 'ugc.desktop.hamahang.bazaar.review', 'uses' => 'BazaarController@review', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar.review']]);

    // load payment page directly
    Route::get('/payment', ['as' => 'ugc.desktop.hamahang.bazaar.payment', 'uses' => 'BazaarController@payment', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar.payment']]);

    // load payment page directly
    Route::get('/pay', ['as' => 'ugc.desktop.hamahang.bazaar.pay', 'uses' => 'BazaarController@pay', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar.pay']]);

    // load discountcoupon page directly
    Route::get('/discountcoupon', ['as' => 'ugc.desktop.hamahang.bazaar.discountcoupon', 'uses' => 'BazaarController@discountcoupon', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar.discountcoupon']]);

    // load invoice page directly
    Route::group(['prefix' => 'invoices', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar.invoices']], function ()
    {
        require(__DIR__ . '/helper/bazaar/invoices.php');
    });
});