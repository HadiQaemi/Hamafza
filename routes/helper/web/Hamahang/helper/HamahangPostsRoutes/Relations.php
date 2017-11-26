<?php
Route::post('get_relations', ['as' => 'hamahang.relations.get_relations', 'uses' => 'RelationsController@getRelations']);
Route::post('add_new_relation', ['as' => 'hamahang.relations.add_new_relation', 'uses' => 'RelationsController@addNewRelation']);
Route::post('edit_relation', ['as' => 'hamahang.relations.edit_relation', 'uses' => 'RelationsController@editRelation']);
Route::post('delete_relation', ['as' => 'hamahang.relations.delete_relation', 'uses' => 'RelationsController@deleteRelation']);
