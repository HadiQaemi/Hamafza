<?php
Route::get('/', ['as' => 'ugc.desktop.hamahang.bazaar.invoices.index', 'uses' => 'BazaarController@invoices', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar.invoices.index']]);
Route::get('/my', ['as' => 'ugc.desktop.hamahang.bazaar.invoices.invoices_my', 'uses' => 'BazaarController@invoices_my', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar.invoices.invoices_my']]);
/* ??? */Route::get('/mysales', ['as' => 'ugc.desktop.hamahang.bazaar.invoices.invoices_mysales', 'uses' => 'BazaarController@invoices_mysales', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.bazaar.invoices.invoices_mysales']]);
