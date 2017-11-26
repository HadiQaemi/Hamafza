<?php
Route::group(['prefix' => 'tickets', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tickets']], function ()
{
    Route::get('inbox', ['as' => 'ugc.desktop.hamahang.tickets.inbox', 'uses' => 'TicketController@inbox', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tickets.index']]);
    Route::get('outbox', ['as' => 'ugc.desktop.hamahang.tickets.outbox', 'uses' => 'TicketController@outbox', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tickets.outbox']]);
});
