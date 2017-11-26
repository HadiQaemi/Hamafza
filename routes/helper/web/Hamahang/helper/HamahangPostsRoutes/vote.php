<?php
Route::post('set', ['as' => 'hamahang.vote.set', 'uses' => 'VoteController@set', 'middleware' => ['dynamic_permission:posts.hamahang.vote.set']]);
//Route::post('get', ['as' => 'vote.get', 'uses' => 'vote@get', ]);