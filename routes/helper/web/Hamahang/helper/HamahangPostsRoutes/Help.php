<?php

Route::post('help_content', ['as' => 'hamahang.help.help_content', 'uses' => 'HelpController@HelpContent']);
Route::post('add_help_permission', ['as' => 'hamahang.tasks.add_help_permission', 'uses' => 'HelpController@AddHelpPermission']);
Route::post('take_help_permissions', ['as' => 'hamahang.tasks.take_help_permissions', 'uses' => 'HelpController@TakeHelpPermissions']);