<?php
// UGC = User or Group or Chanel

Route::group(['prefix' => 'ACL', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.acl']], function ()
{
    Route::get('/', ['as' => 'ugc.desktop.hamahang.acl.index', 'uses' => 'AclController@index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.acl.index']]);
});

/*Route::group(['prefix' => 'Access'], function ()
{
   Route::get('Index', ['as' => 'Access.Index', 'uses' => 'AccessController@Index']);
});*/