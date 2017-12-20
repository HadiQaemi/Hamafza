<?php

Route::post('get_ticket_receive', ['as' => 'hamahang.tickets.get_ticket_receive', 'uses' => 'TicketController@get_ticket_receive', 'middleware' => ['dynamic_permission:posts.hamahang.tickets.get_ticket_receive']]);
Route::post('get_ticket_send', ['as' => 'hamahang.tickets.get_ticket_send', 'uses' => 'TicketController@get_ticket_send', 'middleware' => ['dynamic_permission:posts.hamahang.tickets.get_ticket_send']]);