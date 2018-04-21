<?php
Route::group(['prefix' => 'Project', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.project']], function ()
{
    Route::get('list', ['as' => 'ugc.desktop.hamahang.project.list', 'uses' => 'ProjectController@ProjectsList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.project.list']]);
    /* ??? */Route::get('HierarchicalView/{project_id}', ['as' => 'ugc.desktop.hamahang.project.hierarchical_view', 'uses' => 'ProjectController@HierarchicalView', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.project.hierarchical_view']]);
    /* ??? */Route::get('ShowGanttChart', ['as' => 'ugc.desktop.hamahang.project.show_gantt_chart', 'uses' => 'ProjectController@ShowGanttChart', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.project.show_gantt_chart']]);
    /* ??? */Route::get('GanttChart/{ProjectID}', ['as' => 'ugc.desktop.hamahang.project.gantt_chart', 'uses' => 'ProjectController@GanttChartShow', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.project.gantt_chart']]);
    /* ??? */Route::get('Gantti', ['as' => 'ugc.desktop.hamahang.project.gantt_chart1', 'uses' => 'ProjectController@project_gantt_data', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.project.gantt_chart1']]);
    /* ??? */Route::get('project', ['as' => 'project', 'uses' => 'ProjectController@NewProject', 'menu' => 'true', 'route_title' => trans("route_tile.project"), 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.project.project']]);
    /* ??? *///Route::get('project_window', ['as' => 'Project.project_window', 'uses' => 'ProjectController@new_project_window', 'menu' => 'true', 'route_title' => trans("route_tile.project")]);
});