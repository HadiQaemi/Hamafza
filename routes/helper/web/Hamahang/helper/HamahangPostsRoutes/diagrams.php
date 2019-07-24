<?php
Route::post('fetech_all_diagram', ['as' => 'hamahang.diagram.fetech_all_diagram', 'uses' => 'DiagramController@fetech_all_diagram', 'middleware' => ['dynamic_permission:ugc.desktop.form_list.me']]);
Route::post('save_diagram', ['as' => 'hamahang.diagram.save_diagram', 'uses' => 'DiagramController@save_diagram', 'middleware' => ['dynamic_permission:ugc.desktop.form_list.me']]);
