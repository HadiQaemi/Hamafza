<?php
Route::group(['prefix' => 'editor/modals', 'middleware' => ['dynamic_permission:editor.modals']], function ()
{
    Route::get('select_quran', ['as' => 'editor.modals.select_quran', 'uses' => 'View\ModalController@Quran', 'middleware' => ['dynamic_permission:editor.modals.select_quran']]);//js
    Route::get('dashboard', ['as' => 'editor.modals.dashboard', 'uses' => 'View\ModalController@dashboard', 'middleware' => ['dynamic_permission:editor.modals.dashboard']]);//js
    Route::get('form', ['as' => 'editor.modals.form', 'uses' => 'View\ModalController@Forms', 'middleware' => ['dynamic_permission:editor.modals.form']]);//js
    Route::get('alerts', ['as' => 'editor.modals.alerts', 'uses' => 'View\ModalController@Alerts', 'middleware' => ['dynamic_permission:editor.modals.alerts']]);//js
    Route::get('content', ['as' => 'editor.modals.content', 'uses' => 'View\ModalController@content', 'middleware' => ['dynamic_permission:editor.modals.content']]);//js
    Route::get('keywords', ['as' => 'editor.modals.keywords', 'middleware' => ['dynamic_permission:editor.modals.keywords']], function ()
    {
        return view('modals.editor.keywords');
    });//js
    Route::get('graph',['as' => 'editor.modals.graph', 'middleware' => ['dynamic_permission:editor.modals.graph']], function ()
    {
        return view('modals.editor.graph');
    });//js
    Route::get('pages-list',['as' => 'editor.modals.pages_list', function () { return view('modals.editor.pages-list'); }]);
    //Route::get('/{name}',['as' => 'editor.modals.name', 'uses' => 'View\ModalController@editor']);
});
