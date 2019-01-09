<?php

Route::post('help_content', ['as' => 'hamahang.help.help_content', 'uses' => 'HelpController@help_content']);
Route::post('add_help_permission', ['as' => 'hamahang.tasks.add_help_permission', 'uses' => 'HelpController@AddHelpPermission']);