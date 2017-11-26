<?php
Route::group(['prefix' => 'OrgChart', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart']], function ($username)
{
    Route::get('ShowCharts/{chart_id}', ['as' => 'ugc.desktop.hamahang.org_chart.show_chart', 'uses' => 'OrgChartController@OrgChartShow', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.show_chart']]);
    //Route::get('ajax_OrgChart_data/{id}', ['as' => 'ugc.desktop.hamahang.org_chart.ajax_org_chart_data', 'uses' => 'OrgChartController@AjaxOrgChartData', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.ajax_org_chart_data']]);
    //Route::get('ShowCharts/{ChartID}', ['as' => 'ugc.desktop.hamahang.org_chart.show_chart', 'uses' => 'OrgChartController@OrgChartShow']);
    /* ??? */Route::get('OrgOrgans/list', ['as' => 'ugc.desktop.hamahang.org_chart.OrgOrgans.list', 'uses' => 'OrgChartController@OrgOrgansList']);
    /* ??? */Route::get('Chart/list/{OrgID}', ['as' => 'ugc.desktop.hamahang.org_chart.list', 'uses' => 'OrgChartController@OrgChartList']);
    /* ??? */Route::get('organizations', ['as' => 'ugc.desktop.hamahang.org_chart.organization', 'uses' => 'OrganizationController@index']);
    /* ??? */Route::get('organizations_list', ['as' => 'ugc.desktop.hamahang.org_chart.show_organizations', 'uses' => 'OrganizationController@organizations_list']);

});
