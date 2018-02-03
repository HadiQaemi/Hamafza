<?php
Route::post('GetMyBookmark', ['as' => 'hamafza.get_my_bookmark', 'uses' => 'View\AjaxController@GetMyBookmark', 'middleware' => ['dynamic_permission:posts.hamafza.get_my_bookmark']]);
Route::post('GetsubjectFields', ['as' => 'hamafza.get_subject_fields', 'uses' => 'View\AjaxController@GetSubjectFields', 'middleware' => ['dynamic_permission:posts.hamafza.get_subject_fields']]);
Route::post('AddSubject', ['as' => 'hamafza.add_subject', 'uses' => 'View\FormsController@AddSubject'/*, 'middleware' => ['dynamic_permission:posts.hamafza.add_subject']*//* check FormsController@AddSubject too*/]);
Route::post('EditPageSend', ['as' => 'hamafza.edit_page_send', 'uses' => 'View\PageController@EditPageSend', 'middleware' => ['dynamic_permission:posts.hamafza.edit_page_send']]);
Route::post('announce_send', ['as' => 'hamafza.announce_send', 'uses' => 'View\FormsController@announce_send', 'middleware' => ['dynamic_permission:posts.hamafza.announce_send']]);
Route::post('AddThesaurus', ['as' => 'hamafza.add_thesaurus', 'uses' => 'DesktopController@AddThesaurus', 'middleware' => ['dynamic_permission:posts.hamafza.add_thesaurus']]);
Route::post('regProcess', ['as' => 'hamafza.reg_process', 'uses' => 'View\FormsController@regProcess', 'middleware' => ['dynamic_permission:posts.hamafza.reg_process']]);
Route::post('form_add', ['as' => 'hamafza.form_add', 'uses' => 'View\FormsController@form_add', 'middleware' => ['dynamic_permission:posts.hamafza.form_add']]);
Route::post('form_edit', ['as' => 'hamafza.form_edit', 'uses' => 'View\FormsController@form_edit', 'middleware' => ['dynamic_permission:posts.hamafza.form_edit']]);
Route::post('editProcess', ['as' => 'hamafza.edit_process', 'uses' => 'DesktopController@editProcess', 'middleware' => ['dynamic_permission:posts.hamafza.edit_process']]);
Route::post('user_settings', ['as' => 'hamafza.user_settings', 'uses' => 'UserController@user_settings', 'middleware' => ['dynamic_permission:posts.hamafza.user_settings']]);
Route::post('update_subject', ['as' => 'hamafza.update_subject', 'uses' => 'View\FormsController@update_subject', 'middleware' => ['dynamic_permission:posts.hamafza.update_subject']]);
Route::post('update_relations', ['as' => 'hamafza.update_relations', 'uses' => 'View\PageController@update_relations', 'middleware' => ['dynamic_permission:posts.hamafza.update_relations']]);
Route::post('update_Access', ['as' => 'hamafza.update_access', 'uses' => 'View\FormsController@update_Access', 'middleware' => ['dynamic_permission:posts.hamafza.update_access']]);
Route::post('update_Help', ['as' => 'hamafza.update_help', 'uses' => 'View\FormsController@update_Help', 'middleware' => ['dynamic_permission:posts.hamafza.update_help']]);
Route::post('report_save', ['as' => 'hamafza.report_save', 'uses' => 'View\FormsController@report_save', 'middleware' => ['dynamic_permission:posts.hamafza.report_save']]);
Route::post('ForgetPas', ['as' => 'hamafza.forget_pas', 'uses' => 'SSO@ForgetPas', 'middleware' => ['dynamic_permission:posts.hamafza.forget_pas']]);
Route::post('ADDPageSlide', ['as' => 'hamafza.add_page_slide', 'uses' => 'View\PageController@ADDPageSlide', 'middleware' => ['dynamic_permission:posts.hamafza.add_page_slide']]);
Route::post('ADDPageFilm', ['as' => 'hamafza.add_page_film', 'uses' => 'View\PageController@ADDPageFilm', 'middleware' => ['dynamic_permission:posts.hamafza.add_page_film']]);
Route::post('newCircle', ['as' => 'hamafza.new_circle', 'uses' => 'View\FormsController@newCircle', 'middleware' => ['dynamic_permission:posts.hamafza.new_circle']]);
Route::post('newOrgGroup', ['as' => 'hamafza.new_org_group', 'uses' => 'View\FormsController@newOrgGroup', 'middleware' => ['dynamic_permission:posts.hamafza.new_org_group']]);
Route::post('sendMessage', ['as' => 'hamafza.send_message', 'uses' => 'View\FormsController@sendMessage', 'middleware' => ['dynamic_permission:posts.hamafza.send_message']]);
Route::post('sharePage', ['as' => 'hamafza.share_page', 'uses' => 'View\UserController@sharePage', 'middleware' => ['dynamic_permission:posts.hamafza.share_page']]);
Route::post('UpdateGroup', ['as' => 'hamafza.update_group', 'uses' => 'View\UserController@UpdateGroup', 'middleware' => ['dynamic_permission:posts.hamafza.update_group']]);
Route::post('FieldUpdate', ['as' => 'hamafza.field_update', 'uses' => 'DesktopController@FieldUpdate', 'middleware' => ['dynamic_permission:posts.hamafza.field_update']]);
Route::post('SubjectTypeSave', ['as' => 'hamafza.subject_type_save', 'uses' => 'View\FormsController@SubjectTypeSave', 'middleware' => ['dynamic_permission:posts.hamafza.subject_type_save']]);
Route::post('GroupSettingUpdate', ['as' => 'hamafza.group_setting_update', 'uses' => 'View\UserController@GroupSettingUpdate', 'middleware' => ['dynamic_permission:posts.hamafza.group_setting_update']]);
Route::post('AlertSave', ['as' => 'hamafza.alert_save', 'uses' => 'View\FormsController@AlertSave', 'middleware' => ['dynamic_permission:posts.hamafza.alert_save']]);
Route::post('UserSecSave', ['as' => 'hamafza.user_sec_save', 'uses' => 'View\FormsController@UserSecSave', 'middleware' => ['dynamic_permission:posts.hamafza.user_sec_save']]);
Route::post('UserSave', ['as' => 'hamafza.user_save', 'uses' => 'View\FormsController@UserSave', 'middleware' => ['dynamic_permission:posts.hamafza.user_save']]);
Route::post('measure_sendReport', ['as' => 'hamafza.measure_send_report', 'uses' => 'View\FormsController@measure_sendReport', 'middleware' => ['dynamic_permission:posts.hamafza.measure_send_report']]);
Route::post('MainSlideSave', ['as' => 'hamafza.main_slide_save', 'uses' => 'HomeController@MainSlideSave', 'middleware' => ['dynamic_permission:posts.hamafza.main_slide_save']]);
Route::post('HelpSave', ['as' => 'hamafza.help_save', 'uses' => 'LocalController@HelpSave', 'middleware' => ['dynamic_permission:posts.hamafza.help_save']]); //default:url
Route::post('saveForm', ['as' => 'hamafza.save_form', 'uses' => 'View\FormsController@saveForm', 'middleware' => ['dynamic_permission:posts.hamafza.save_form']]);
Route::post('keyword_update', ['as' => 'hamafza.keyword_update', 'uses' => 'View\FormsController@keyword_update', 'middleware' => ['dynamic_permission:posts.hamafza.keyword_update']]);
Route::post('keyword_delete', ['as' => 'hamafza.keyword_delete', 'uses' => 'DesktopController@keyword_delete', 'middleware' => ['dynamic_permission:posts.hamafza.keyword_delete']]);
Route::post('keyword_merge', ['as' => 'hamafza.keyword_merge', 'uses' => 'DesktopController@keyword_merge', 'middleware' => ['dynamic_permission:posts.hamafza.keyword_merge']]);
Route::post('SaveDepartments', ['as' => 'hamafza.save_departments', 'uses' => 'View\FormsController@SaveDepartments', 'middleware' => ['dynamic_permission:posts.hamafza.save_departments']]);
Route::post('subst_save', ['as' => 'hamafza.subst_save', 'uses' => 'View\FormsController@subst_save', 'middleware' => ['dynamic_permission:posts.hamafza.subst_save']]);
Route::post('postlike', ['as' => 'hamafza.post_like', 'uses' => 'View\AjaxController@postlike', 'middleware' => ['dynamic_permission:posts.hamafza.post_like']]); //js
Route::post('postcomment', ['as' => 'hamafza.post_comment', 'uses' => 'View\AjaxController@postcomment', 'middleware' => ['dynamic_permission:posts.hamafza.post_comment']]); //js
Route::post('newpost', ['as' => 'hamafza.new_post', 'uses' => 'View\AjaxController@newpost', 'middleware' => ['dynamic_permission:posts.hamafza.new_post']]); //js, php
Route::post('GetMyCircle', ['as' => 'hamafza.get_my_circle', 'uses' => 'View\AjaxController@GetMyCircle', 'middleware' => ['dynamic_permission:posts.hamafza.get_my_circle']]); //js && blade
Route::post('DefimagePage', ['as' => 'hamafza.def_image_page', 'uses' => 'View\AjaxController@DefimagePage', 'middleware' => ['dynamic_permission:posts.hamafza.def_image_page']]); //js
Route::post('page_edit_description', ['as' => 'hamafza.page_edit_description', 'uses' => 'View\AjaxController@page_edit_description', 'middleware' => ['dynamic_permission:posts.hamafza.page_edit_description']]); //js
Route::post('printsubject', ['as' => 'print_subject', 'uses' => 'View\AjaxController@printsubject', 'middleware' => ['dynamic_permission:posts.hamafza.print_subject']]);
Route::post('bookmark', ['as' => 'hamafza.bookmark', 'uses' => 'View\FormsController@bookmark', 'middleware' => ['dynamic_permission:posts.hamafza.bookmark']]);
Route::post('deletesubject', ['as' => 'hamafza.delete_subject', 'uses' => 'View\AjaxController@deletesubject', 'middleware' => ['dynamic_permission:posts.hamafza.delete_subject']]);
Route::post('keyrel', ['as' => 'hamafza.key_rel', 'uses' => 'View\AjaxController@keyrel', 'middleware' => ['dynamic_permission:posts.hamafza.key_rel']]);
Route::post('showtabs', ['as' => 'hamafza.show_tabs', 'uses' => 'View\AjaxController@showtabs', 'middleware' => ['dynamic_permission:posts.hamafza.show_tabs']]);
Route::post('showpagebody', ['as' => 'hamafza.show_page_body', 'uses' => 'View\AjaxController@showpagebody', 'middleware' => ['dynamic_permission:posts.hamafza.show_page_body']]);
Route::post('showhighlight', ['as' => 'hamafza.show_highlight', 'uses' => 'View\AjaxController@showhighlight', 'middleware' => ['dynamic_permission:posts.hamafza.show_highlight']]);
Route::post('DeleteTreeNode', ['as' => 'hamafza.delete_tree_node', 'uses' => 'View\AjaxController@DeleteTreeNode', 'middleware' => ['dynamic_permission:posts.hamafza.delete_tree_node']]);
Route::post('NewTreeNode', ['as' => 'hamafza.new_tree_node', 'uses' => 'View\AjaxController@NewTreeNode', 'middleware' => ['dynamic_permission:posts.hamafza.new_tree_node']]);
Route::post('DeleteRow', ['as' => 'hamafza.delete_row', 'uses' => 'View\AjaxController@DeleteRow', 'middleware' => ['dynamic_permission:posts.hamafza.delete_row']]); //js
Route::post('GetTreeNode', ['as' => 'hamafza.get_tree_node', 'uses' => 'View\AjaxController@GetTreeNode', 'middleware' => ['dynamic_permission:posts.hamafza.get_tree_node']]);
Route::post('pophelp', ['as' => 'hamafza.pop_help', 'uses' => 'View\AjaxController@pophelp', 'middleware' => ['dynamic_permission:posts.hamafza.pop_help']]);
Route::post('searchPerson', ['as' => 'hamafza.search_person', 'uses' => 'View\AjaxController@searchPerson', 'middleware' => ['dynamic_permission:posts.hamafza.search_person']]);
Route::post('changepageview', ['as' => 'hamafza.change_page_view', 'uses' => 'View\AjaxController@changepageview', 'middleware' => ['dynamic_permission:posts.hamafza.change_page_view']]);
Route::post('addGroup', ['as' => 'hamafza.add_group', 'uses' => 'View\AjaxController@addGroup', 'middleware' => ['dynamic_permission:posts.hamafza.add_group']]); //js
Route::post('AcceptUser2Group', ['as' => 'hamafza.accept_user_to_group', 'uses' => 'View\AjaxController@AcceptUser2Group', 'middleware' => ['dynamic_permission:posts.hamafza.accept_user_to_group']]); //js
Route::post('GetPoodmanNode', ['as' => 'hamafza.get_poodman_node', 'uses' => 'View\AjaxController@GetPoodmanNode', 'middleware' => ['dynamic_permission:posts.hamafza.get_poodman_node']]);
Route::post('showhelps', ['as' => 'hamafza.show_helps', 'uses' => 'View\AjaxController@showhelps', 'middleware' => ['dynamic_permission:posts.hamafza.show_helps']]); //review?//
Route::post('showhelprel', ['as' => 'hamafza.show_help_rel', 'uses' => 'View\AjaxController@showhelprel', 'middleware' => ['dynamic_permission:posts.hamafza.show_help_rel']]); //review?//
Route::post('FormField', ['as' => 'hamafza.form_field', 'uses' => 'View\AjaxController@FormField', 'middleware' => ['dynamic_permission:posts.hamafza.form_field']]); //review?//
Route::post('FormReports', ['as' => 'hamafza.form_reports', 'uses' => 'View\AjaxController@FormReports', 'middleware' => ['dynamic_permission:posts.hamafza.form_reports']]); //review?//
Route::post('Sharepost', ['as' => 'hamafza.share_post', 'uses' => 'View\ModalController@Sharepost', 'middleware' => ['dynamic_permission:posts.hamafza.share_post']]);
Route::post('AddCircle', ['as' => 'hamafza.add_circle', 'uses' => 'View\AjaxController@AddCircle', 'middleware' => ['dynamic_permission:posts.hamafza.add_circle']]); //js
Route::post('DelBookmark', ['as' => 'hamafza.del_bookmark', 'uses' => 'View\AjaxController@DelBookmark', 'middleware' => ['dynamic_permission:posts.hamafza.del_bookmark']]); //js
Route::post('relationSave', ['as' => 'hamafza.relation_save', 'uses' => 'View\UserController@relationSave', 'middleware' => ['dynamic_permission:posts.hamafza.relation_save']]);
Route::post('addAdSetting', ['as' => 'hamafza.add_ad_setting', 'uses' => 'Hamahang\BasicdataController@addAdSetting', 'middleware' => ['dynamic_permission:posts.hamafza.add_ad_setting']]);
Route::post('updateAdSetting', ['as' => 'hamafza.update_ad_setting', 'uses' => 'Hamahang\BasicdataController@updateAdSetting', 'middleware' => ['dynamic_permission:posts.hamafza.update_ad_setting']]);
Route::post('addSliderSetting', ['as' => 'hamafza.add_slider_setting', 'uses' => 'Hamahang\BasicdataController@addSliderSetting', 'middleware' => ['dynamic_permission:posts.hamafza.add_slider_setting']]);
Route::post('addItemSocial', ['as' => 'hamafza.add_item_social', 'uses' => 'Hamahang\BasicdataController@addItemSocial', 'middleware' => ['dynamic_permission:posts.hamafza.add_item_social']]);
Route::post('updateSliderSetting', ['as' => 'hamafza.update_slider_setting', 'uses' => 'Hamahang\BasicdataController@updateSliderSetting', 'middleware' => ['dynamic_permission:posts.hamafza.update_slider_setting']]);
Route::post('updateItemtab', ['as' => 'hamafza.update_item_tab', 'uses' => 'Hamahang\BasicdataController@updateItemSocial', 'middleware' => ['dynamic_permission:posts.hamafza.update_item_tab']]);
Route::post('addNewsSetting', ['as' => 'hamafza.add_news_setting', 'uses' => 'Hamahang\BasicdataController@addNewsSetting', 'middleware' => ['dynamic_permission:posts.hamafza.add_news_setting']]);
Route::post('updateNewsSetting', ['as' => 'hamafza.update_news_setting', 'uses' => 'Hamahang\BasicdataController@updateNewsSetting', 'middleware' => ['dynamic_permission:posts.hamafza.update_news_setting']]);
Route::post('getKeywordsForTree', ['as' => 'hamafza.get_keywords_for_tree', 'uses' => 'Hamahang\KeywordsController@getKeywordsForTree', 'middleware' => ['dynamic_permission:posts.hamafza.get_keywords_for_tree']]);
Route::post('addItemResearch', ['as' => 'hamafza.add_item_research', 'uses' => 'Hamahang\BasicdataController@addItemResearch', 'middleware' => ['dynamic_permission:posts.hamafza.add_item_research']]);
Route::post('addItemResearchSelect2', ['as' => 'hamafza.add_item_research_select_2', 'uses' => 'Hamahang\BasicdataController@addItemResearchSelect2', 'middleware' => ['dynamic_permission:posts.hamafza.add_item_research_select_2']]);
Route::post('updateItemResearch', ['as' => 'hamafza.update_item_research', 'uses' => 'Hamahang\BasicdataController@updateItemResearch', 'middleware' => ['dynamic_permission:posts.hamafza.update_item_research']]);
Route::post('getKeywordsList', ['as' => 'hamafza.get_keywords_list', 'uses' => 'Hamahang\KeywordsController@getKeywordsList', 'middleware' => ['dynamic_permission:posts.hamafza.get_keywords_list']]);
Route::post('pages_list_load_more', ['as' => 'pages_list_load_more', 'uses' => 'Services\PageController@pages_list']);
/* ??? */Route::post('keywords/save', ['as' => 'keywords.save', 'uses' => 'Hamahang\KeywordsController@save_new_keyword']);
/* ??? */Route::post('GroupContentsPaging', ['as' => 'GroupContentsPaging', 'uses' => 'View\AjaxController@GroupContentsPaging']);
/* ??? */Route::post('savePageImage', ['as' => 'savePageImage', 'uses' => 'View\PageController@savePageImage']);
/* ??? */Route::post('renamePageImage', ['as' => 'renamePageImage', 'uses' => 'View\PageController@renamePageImage']);
/* ??? */Route::post('removePageImage', ['as' => 'removePageImage', 'uses' => 'View\PageController@removePageImage']);
/* ??? */Route::post('searchUser', 'View\AjaxController@searchUser');
/* ??? */Route::post('PageWallPaging', ['as' => 'PageWallPaging', 'uses' => 'View\AjaxController@PageWallPaging']);
/* ??? */Route::post('GetUserContentPaging', ['as' => 'GetUserContentPaging', 'uses' => 'View\AjaxController@GetUserContentPaging']);
/* ??? */Route::post('GetWallByPaging', ['as' => 'GetWallByPaging', 'uses' => 'View\AjaxController@GetWallByPaging']);
/* ??? */Route::post('highlight', ['as' => 'highlight', 'uses' => 'View\AjaxController@highlight']);
/* ??? */Route::post('measure_add', ['as' => 'measure_add', 'uses' => 'View\FormsController@measure_add']);
/* ??? */Route::post('SearchTags', ['as' => 'SearchTags', 'uses' => 'View\AjaxController@SearchTags']);
/* ??? */Route::post('asubjects', ['as' => 'asubjects', 'uses' => 'SubjectController@asubjects']);
/* ??? */Route::post('search', ['as' => 'search', 'uses' => 'View\AjaxController@search']);
/* ??? */Route::post('endorse', ['as' => 'hamafza.endorse', 'uses' => 'View\AjaxController@endorse']);
/* ??? */Route::post('user_measures', ['as' => 'hamafza.user_measures', 'uses' => 'DesktopController@user_measures']); //review?//
/* ??? */Route::post('like', ['as' => 'hamafza.page_like', 'uses' => 'View\AjaxController@pagelike']);
/* ??? */Route::post('follow', ['as' => 'hamafza.page_follow', 'uses' => 'View\AjaxController@pagefollow']);

Route::post('pages_list_load_more', ['as' => 'pages_list_load_more', 'uses' => 'Services\PageController@pages_list']);

Route::group(['prefix' => 'bookmarks'], function ()
{
    Route::post('/', ['uses' => 'View\AjaxController@bookmarks', 'as' => 'bookmarks', ]);
    Route::post('/add', ['uses' => 'View\AjaxController@bookmark_add', 'as' => 'bookmark_add', ]);
    Route::post('/delete', ['uses' => 'View\AjaxController@bookmarks_delete', 'as' => 'bookmarks.delete', ]);
});

Route::post('/portals', ['uses' => 'View\AjaxController@portals', 'as' => 'portals', ]);

