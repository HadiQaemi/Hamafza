<?php
Route::post('get_item_info', ['as' => 'hamahang.org_chart.item_info', 'uses' => 'OrgChartController@item_info', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.item_info']]);
Route::post('add_organ', ['as' => 'hamahang.org_chart.create_organ', 'uses' => 'OrgChartController@CreateOrgan', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.create_organ']]);
Route::post('edit_organ', ['as' => 'hamahang.org_chart.update_organ', 'uses' => 'OrgChartController@UpdateOrgan', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.update_organ']]);
Route::post('remove_organ', ['as' => 'hamahang.org_chart.Remove_organ', 'uses' => 'OrgChartController@RemoveOrgan', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.Remove_organ']]);
Route::post('add_new_chart', ['as' => 'hamahang.org_chart.add_new_chart', 'uses' => 'OrgChartController@AddNewChart', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.add_new_chart']]);
Route::post('SubmitChange', ['as' => 'hamahang.org_chart.submit_change', 'uses' => 'OrgChartController@SubmitChange', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.submit_change']]);
Route::post('add_new_post', ['as' => 'hamahang.org_chart.add_new_post', 'uses' => 'OrgChartController@add_new_post', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.add_new_post']]);
Route::post('add_new_node', ['as' => 'hamahang.org_chart.add_new_node', 'uses' => 'OrgChartController@add_new_node', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.add_new_node']]);
Route::post('add_post_user', ['as' => 'hamahang.org_chart.add_post_user', 'uses' => 'OrgChartController@add_post_user', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.add_post_user']]);
Route::post('ModifyChartInfo', ['as' => 'hamahang.org_chart.modify_chart_info', 'uses' => 'OrgChartController@ModifyChartInfo', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.modify_chart_info']]);
Route::post('update_chart_item', ['as' => 'hamahang.org_chart.update_chart_item', 'uses' => 'OrgChartController@UpdateChartItem', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.update_chart_item']]);
Route::post('remove_chart_item', ['as' => 'hamahang.org_chart.remove_chart_item', 'uses' => 'OrgChartController@RemoveChartItem', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.remove_chart_item']]);
Route::post('get_item_children', ['as' => 'hamahang.org_chart.get_item_children', 'uses' => 'OrgChartController@GetItemChildren', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.get_item_children']]);
Route::post('remove_post_user', ['as' => 'hamahang.org_chart.remove_post_user', 'uses' => 'OrgChartController@remove_post_user', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.remove_post_user']]);
Route::post('Charts/AjaxOrgCharts/{OrgID}', ['as' => 'hamahang.org_chart.ajax_org_charts', 'uses' => 'OrgChartController@AjaxOrgCharts', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.ajax_org_charts']]);
Route::post('OrgOrgans/AjaxOrgOrgans', ['as' => 'hamahang.org_chart.org_organs.ajax_org_organs', 'uses' => 'OrgChartController@AjaxOrgOrgans', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.ajax_org_organs']]);
Route::post('add_root_chart_item/{OrgansID?}', ['as' => 'hamahang.org_chart.add_root_chart_item', 'uses' => 'OrgChartController@AddRootChartItem', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.add_root_chart_item']]);
Route::post('select_list_organs', ['as' => 'hamahang.org_chart.select_list_organs', 'uses' => 'OrgChartController@select_list_organs', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.select_list_organs']]);
Route::post('select_list_edit_organs', ['as' => 'hamahang.org_chart.select_list_edit_organs', 'uses' => 'OrgChartController@select_list_edit_organs', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.select_list_edit_organs']]);
Route::post('insert_organs', ['as' => 'hamahang.org_chart.insert_organs', 'uses' => 'OrgChartController@insert_organs', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.insert_organs']]);
Route::post('edit_organs', ['as' => 'hamahang.org_chart.edit_organs', 'uses' => 'OrgChartController@edit_organs', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.edit_organs']]);
Route::post('edit_chart', ['as' => 'hamahang.org_chart.edit_chart', 'uses' => 'OrgChartController@edit_chart', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.edit_chart']]);
Route::post('add_chart_item_child', ['as' => 'hamahang.org_chart.add_chart_item_child', 'uses' => 'OrgChartController@add_chart_item_child', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.add_chart_item_child']]);
Route::post('add_chart_item_post', ['as' => 'hamahang.org_chart.add_chart_item_post', 'uses' => 'OrgChartController@add_chart_item_post', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.add_chart_item_post']]);
Route::post('delete_employ_post', ['as' => 'hamahang.org_chart.delete_employ_post', 'uses' => 'OrgChartController@delete_employ_post', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.delete_employ_post']]);
Route::post('select_list_employ', ['as' => 'hamahang.org_chart.select_list_employ', 'uses' => 'OrgChartController@select_list_employ', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.select_list_employ']]);
Route::post('add_employ_for_post', ['as' => 'hamahang.org_chart.add_employ_for_post', 'uses' => 'OrgChartController@add_employ_for_post', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.add_employ_for_post']]);
Route::post('delete_chart', ['as' => 'hamahang.org_chart.modals.delete_chart', 'uses' => 'ChartsController@deletechart', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.delete_chart']]);
Route::post('update_one_chart_item', ['as' => 'hamahang.org_chart.update_one_chart_item', 'uses' => 'OrgChartController@update_one_chart_item', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.update_one_chart_item']]);
Route::post('AjaxOrgChartDataShow', ['as' => 'hamahang.org_chart.ajax_org_chart_data_show', 'uses' => 'OrgChartController@AjaxOrgChartDataShow', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart.ajax_org_chart_data_show']]);
/* ??? */Route::post('fetch_organ_charts', ['as' => 'hamahang.org_chart.fetch_organ_charts', 'uses' => 'OrganizationController@fetch_organ_charts']);
