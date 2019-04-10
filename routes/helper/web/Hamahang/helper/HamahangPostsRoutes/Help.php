<?php

Route::post('help_content', ['as' => 'hamahang.help.help_content', 'uses' => 'HelpController@HelpContent']);
Route::post('add_help_permission', ['as' => 'hamahang.tasks.add_help_permission', 'uses' => 'HelpController@AddHelpPermission']);
Route::post('add_see_also_help', ['as' => 'hamahang.help.add_see_also_help', 'uses' => 'HelpController@AddSeeAlsoHelp']);
Route::post('remove_see_also_help', ['as' => 'hamahang.help.remove_see_also_help', 'uses' => 'HelpController@RemoveSeeAlsoHelp']);
Route::post('take_help_permissions', ['as' => 'hamahang.tasks.take_help_permissions', 'uses' => 'HelpController@TakeHelpPermissions']);