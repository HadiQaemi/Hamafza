<?php
Route::group(['prefix' => 'WebRTC', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.web_rtc']], function ()
{
    /* ??? */Route::get('Operator/{id}', ['as' => 'ugc.desktop.hamahang.web_rtc.operator', 'uses' => 'WebRTC@OperatorShow', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.web_rtc.operator']]);
});

//Route::group(['prefix' => 'WebRTC'], function ()
//{
//    Route::get('Operator/{id}', ['as' => 'ugc.desktop.hamahang.WebRTC.Operator', 'uses' => 'WebRTC@OperatorShow']);
//});