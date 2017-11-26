<?php
// PGS = Pages or Groups or Subjects

Route::group(['prefix' => 'Project', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.project']], function ()
{
    Route::get('list', ['as' => 'pgs.desktop.hamahang.project.list', 'uses' => 'ProjectController@ProjectsList', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.project.list']]);
});