<?php
Route::get('/', ['as' => 'hamahang.bazaar.index', 'uses' => 'BazaarController@bazaar', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.index']]);
Route::post('/bazaar_update', ['as' => 'hamahang.bazaar.bazaar_update', 'uses' => 'BazaarController@bazaar_update', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.bazaar_update']]);
//Route::post('/part2', ['as' => 'bazaar.part2', 'uses' => 'BazaarController@part2',]);

/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * begin cart routes
 *
 */

// get cart content
Route::post('/cart_content', ['as' => 'hamahang.bazaar.cart_content', 'uses' => 'BazaarController@cart_content', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.cart_content']]);
// add an item to cart
Route::post('/cart_add', ['as' => 'hamahang.bazaar.cart_add', 'uses' => 'BazaarController@cart_add', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.cart_add']]);
// update cart
Route::post('/cart_update', ['as' => 'hamahang.bazaar.cart_update', 'uses' => 'BazaarController@cart_update', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.cart_update']]);
// delete an item from cart
Route::post('/cart_delete', ['as' => 'hamahang.bazaar.cart_delete', 'uses' => 'BazaarController@cart_delete', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.cart_delete']]);
// make cart empty
Route::post('/cart_empty', ['as' => 'hamahang.bazaar.cart_empty', 'uses' => 'BazaarController@cart_empty', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.cart_empty']]);
// get cart count
Route::post('/cart_count', ['as' => 'hamahang.bazaar.cart_count', 'uses' => 'BazaarController@cart_count', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.cart_count']]);
// check a discountcoupon validaty
Route::post('/cart_discountcoupon_check', ['as' => 'hamahang.bazaar.cart_discountcoupon_check', 'uses' => 'BazaarController@cart_discountcoupon_check', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.cart_discountcoupon_check']]);

/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * begin shipping routes
 *
 */

// get shipping content
Route::post('/shipping_content', ['as' => 'hamahang.bazaar.shipping_content', 'uses' => 'BazaarController@shipping_content', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.shipping_content']]);
// preparing info for next step
Route::post('/shipping_prepare', ['as' => 'hamahang.bazaar.shipping_prepare', 'uses' => 'BazaarController@shipping_prepare', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.shipping_prepare']]);

/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * begin review routes
 *
 */

// get review content
Route::post('/review_content', ['as' => 'hamahang.bazaar.review_content', 'uses' => 'BazaarController@review_content', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.review_content']]);
Route::post('/review_prepare', ['as' => 'hamahang.bazaar.review_prepare', 'uses' => 'BazaarController@review_prepare', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.review_prepare']]);

/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * begin payment routes
 *
 */

// get payment content
Route::post('/payment_content', ['as' => 'hamahang.bazaar.payment_content', 'uses' => 'BazaarController@payment_content', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.payment_content']]);
Route::post('/payment_invoice', ['as' => 'hamahang.bazaar.payment_invoice', 'uses' => 'BazaarController@payment_invoice', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.payment_invoice']]);
// check a discountcoupon validaty
Route::post('/payment_discountcoupon_check', ['as' => 'hamahang.bazaar.payment_discountcoupon_check', 'uses' => 'BazaarController@payment_discountcoupon_check', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.payment_discountcoupon_check']]);
// load payment page directly
Route::post('/pay_prepare', ['as' => 'hamahang.bazaar.pay_prepare', 'uses' => 'BazaarController@pay_prepare', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.pay_prepare']]);

/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * begin discount coupon routes
 *
 */

// get discount coupon records into datatable directly
Route::post('/discountcoupon_get_datatable', ['as' => 'hamahang.bazaar.discountcoupon_get_datatable', 'uses' => 'BazaarController@discountcoupon_get_datatable', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.discountcoupon_get_datatable']]);
// request discountcoupon
/* ??? */Route::post('/discountcoupon_request', ['as' => 'hamahang.bazaar.discountcoupon_request', 'uses' => 'BazaarController@discountcoupon_request', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.discountcoupon_request']]);


/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * begin invoices routes
 *
 */

// get invoice records into datatable directly
Route::post('/invoice_get_datatable', ['as' => 'hamahang.bazaar.invoice_get_datatable', 'uses' => 'BazaarController@invoice_get_datatable', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.invoice_get_datatable']]);
Route::post('/invoice_mysales_get_datatable', ['as' => 'hamahang.bazaar.invoice_mysales_get_datatable', 'uses' => 'BazaarController@invoice_mysales_get_datatable', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.invoice_mysales_get_datatable']]);
Route::post('/invoice_my_get_datatable', ['as' => 'hamahang.bazaar.invoice_my_get_datatable', 'uses' => 'BazaarController@invoice_my_get_datatable', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.invoice_my_get_datatable']]);
Route::post('/invoice_status_submit', ['as' => 'hamahang.bazaar.invoice_status_submit', 'uses' => 'BazaarController@invoice_status_submit', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar.invoice_status_submit']]);

/**
 *
 * end discount coupon routes
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */