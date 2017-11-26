<?php
Route::group(['prefix' => 'Process', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.process']], function ()
{
    Route::get('list', ['as' => 'ugc.desktop.hamahang.process.list', 'uses' => 'ProcessController@ProcessList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.process.list']]);
    Route::get('DraftsList', ['as' => 'ugc.desktop.hamahang.process.drafts_list1', 'uses' => 'ProcessController@ProcessDraftsList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.process.drafts_list1']]);
    Route::get('process', ['as' => 'ugc.desktop.hamahang.process.index', 'uses' => 'ProcessController@Create', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.process.index']]);
    Route::get('ShowProcessEntity/{id1}', ['as' => 'ugc.desktop.hamahang.process.show_process_entity', 'uses' => 'ProcessController@ShowProcessEntity', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.process.show_process_entity']]);
});