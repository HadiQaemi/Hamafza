<?php
Route::post('get_substs', ['as' => 'hamahang.substs.get_substs', 'uses' => 'SubstsController@getSubsts']);
Route::post('add_new_subst', ['as' => 'hamahang.substs.add_new_subst', 'uses' => 'SubstsController@addNewSubst']);
Route::post('edit_subst_view', ['as' => 'hamahang.substs.edit_subst_view', 'uses' => 'SubstsController@editSubstView']);
Route::post('edit_subst', ['as' => 'hamahang.substs.edit_subst', 'uses' => 'SubstsController@editSubst']);
Route::post('delete_subst', ['as' => 'hamahang.substs.delete_subst', 'uses' => 'SubstsController@deleteSubst']);
