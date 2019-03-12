<?php
Route::group(['prefix' => 'OrgChart', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart']], function ($username)
{
    Route::get('ShowCharts/{chart_id}', ['as' => 'ugc.desktop.hamahang.org_chart.show_chart', 'uses' => 'OrgChartController@OrgChartShow', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.show_chart']]);
    Route::get('ShowList/{chart_id}', ['as' => 'ugc.desktop.hamahang.org_chart.show_list', 'uses' => 'OrgChartController@OrgListShow', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.show_chart']]);
    Route::get('ShowJobList/{chart_id}', ['as' => 'ugc.desktop.hamahang.org_chart.show_job_list', 'uses' => 'OrgChartController@ShowJobList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.show_chart']]);
    Route::get('ShowPostList/{chart_id}', ['as' => 'ugc.desktop.hamahang.org_chart.show_post_list', 'uses' => 'OrgChartController@ShowPostList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.show_chart']]);
    //Route::get('ajax_OrgChart_data/{id}', ['as' => 'ugc.desktop.hamahang.org_chart.ajax_org_chart_data', 'uses' => 'OrgChartController@AjaxOrgChartData', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.ajax_org_chart_data']]);
    //Route::get('ShowCharts/{ChartID}', ['as' => 'ugc.desktop.hamahang.org_chart.show_chart', 'uses' => 'OrgChartController@OrgChartShow']);
    /* ??? */Route::get('OrgOrgans/list', ['as' => 'ugc.desktop.hamahang.org_chart.OrgOrgans.list', 'uses' => 'OrgChartController@OrgOrgansList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.OrgOrgans.list']]);
    /* ??? */Route::get('OrgOrgans/organs', ['as' => 'ugc.desktop.hamahang.org_chart.OrgOrgans.organs', 'uses' => 'OrgChartController@OrgansList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.OrgOrgans.list']]);
    /* ??? */Route::get('OrgOrgans/staff', ['as' => 'ugc.desktop.hamahang.org_chart.OrgOrgans.staff', 'uses' => 'OrgChartController@staff', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.OrgOrgans.list']]);
    /* ??? */Route::get('Chart/list/{OrgID}', ['as' => 'ugc.desktop.hamahang.org_chart.list', 'uses' => 'OrgChartController@OrgChartList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.list']]);
    /* ??? */Route::get('organizations', ['as' => 'ugc.desktop.hamahang.org_chart.organization', 'uses' => 'OrganizationController@index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.organization']]);
    /* ??? */Route::get('organizations_list', ['as' => 'ugc.desktop.hamahang.org_chart.show_organizations', 'uses' => 'OrganizationController@organizations_list', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.show_organizations']]);

});
