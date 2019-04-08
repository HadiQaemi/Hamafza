<?php
Route::group(['prefix' => 'modals', 'middleware' => ['dynamic_permission:modals']], function ()
{
    Route::post('profile_avatar', ['as' => 'modals.profile_avatar', 'uses' => 'View\ModalController@profile_avatar', 'middleware' => ['dynamic_permission:modals.profile_avatar']]);
    Route::post('formshow', ['as' => 'modals.form_show', 'uses' => 'View\ModalController@forShow', 'middleware' => ['dynamic_permission:modals.form_show']]);
    Route::post('newsubject', ['as' => 'modals.new_subject', 'uses' => 'View\ModalController@newSubject', 'middleware' => ['dynamic_permission:modals.new_subject']]);
    Route::post('viewSubject', ['as' => 'modals.view_subject', 'uses' => 'View\ModalController@viewSubject', 'middleware' => ['dynamic_permission:modals.view_subject']]);
    Route::post('postlike', ['as' => 'modals.post_like', 'uses' => 'View\ModalController@postlike', 'middleware' => ['dynamic_permission:modals.post_like']]);
    Route::post('postshare', ['as' => 'modals.post_share', 'uses' => 'View\ModalController@postshare', 'middleware' => ['dynamic_permission:modals.post_share']]);
    Route::post('viewsubjects', ['as' => 'modals.view_subjects', 'uses' => 'View\ModalController@viewSubjects', 'middleware' => ['dynamic_permission:modals.view_subjects']]);
    Route::post('viewreports', ['as' => 'modals.view_reports', 'uses' => 'View\ModalController@viewReports', 'middleware' => ['dynamic_permission:modals.view_reports']]);
    Route::post('viewfromreport', ['as' => 'modals.view_from_report', 'uses' => 'View\ModalController@viewFromreport', 'middleware' => ['dynamic_permission:modals.view_from_report']]);
    Route::post('editrports', ['as' => 'modals.edit_reports', 'uses' => 'View\ModalController@editrPorts', 'middleware' => ['dynamic_permission:modals.edit_reports']]);
    Route::post('keyword_delete', ['as' => 'modals.keyword_delete', 'uses' => 'View\ModalController@keyword_delete', 'middleware' => ['dynamic_permission:modals.keyword_delete']]);
    Route::post('mergkeyword', ['as' => 'modals.merge_keyword', 'uses' => 'View\ModalController@mergKeyword', 'middleware' => ['dynamic_permission:modals.merge_keyword']]);
    Route::post('editkeyword', ['as' => 'modals.edit_Keyword', 'uses' => 'View\ModalController@keyword_addedit_form', 'middleware' => ['dynamic_permission:modals.edit_Keyword']]);
    Route::post('helpview', ['as' => 'modals.help_view', 'uses' => 'View\ModalController@helpView']);
    Route::post('share', ['as' => 'modals.share', 'uses' => 'View\ModalController@share', 'middleware' => ['dynamic_permission:modals.share']]);
    Route::post('sociasearch', ['as' => 'modals.social_search', 'uses' => 'View\ModalController@sociaSearch', 'middleware' => ['dynamic_permission:modals.social_search']]);
    Route::post('addsubtem', ['as' => 'modals.add_sub_item', 'uses' => 'View\ModalController@addSubtem', 'middleware' => ['dynamic_permission:modals.add_sub_item']]);
    Route::post('helprel', ['as' => 'modals.help_rel', 'uses' => 'View\ModalController@helpRel', 'middleware' => ['dynamic_permission:modals.help_rel']]);
    Route::post('BasicData_create_view', ['as' => 'modals.basicdata_create_view', 'uses' => 'View\ModalController@BasicData_create_view', 'middleware' => ['dynamic_permission:modals.basicdata_create_view']]);
    Route::post('BasicData_value_create_view', ['as' => 'modals.basicdata_value_create_view', 'uses' => 'View\ModalController@BasicData_value_create_view', 'middleware' => ['dynamic_permission:modals.basicdata_value_create_view']]);
    Route::post('BasicData_adssetting_add_new_value', ['as' => 'modals.basicdata_ads_setting_add_new_value', 'uses' => 'View\ModalController@BasicData_adssetting_add_new_value', 'middleware' => ['dynamic_permission:modals.basicdata_ads_setting_add_new_value']]);
    Route::post('BasicData_edit_view', ['as' => 'modals.basicdata_edit_view', 'uses' => 'View\ModalController@BasicData_edit_view', 'middleware' => ['dynamic_permission:modals.basicdata_edit_view']]);
    Route::post('BasicData_createEdit', ['as' => 'modals.basicdata_create_edit', 'uses' => 'View\ModalController@BasicData_createedit', 'middleware' => ['dynamic_permission:modals.basicdata_create_edit']]);
    Route::post('BasicData_valuecreateedit', ['as' => 'modals.basicdata_value_create_edit', 'uses' => 'View\ModalController@BasicData_valuecreateedit', 'middleware' => ['dynamic_permission:modals.basicdata_value_create_edit']]);
    Route::post('BasicdataValueCreateEdit_Scores', ['as' => 'modals.basicdata_value_create_edit_scores', 'uses' => 'View\ModalController@BasicdataValueCreateEdit_Scores', 'middleware' => ['dynamic_permission:modals.basicdata_value_create_edit_scores']]);
    Route::post('BasicdataValueCreateEdit_Medals', ['as' => 'modals.basicdata_value_create_edit_medals', 'uses' => 'View\ModalController@BasicdataValueCreateEdit_Medals', 'middleware' => ['dynamic_permission:modals.basicdata_value_create_edit_medals']]);
    Route::post('BasicdataValueCreateEdit_PostMethods', ['as' => 'modals.basicdata_value_create_edit_post_methods', 'uses' => 'View\ModalController@BasicdataValueCreateEdit_PostMethods', 'middleware' => ['dynamic_permission:modals.basicdata_value_create_edit_post_methods']]);
    Route::post('BasicData_delete', ['as' => 'modals.basicdata_delete', 'uses' => 'View\ModalController@BasicData_delete', 'middleware' => ['dynamic_permission:modals.basicdata_delete']]);
    Route::post('BasicData_valuedelete', ['as' => 'modals.basicdata_value_delete', 'uses' => 'View\ModalController@BasicData_valuedelete', 'middleware' => ['dynamic_permission:modals.basicdata_value_delete']]);
    Route::post('BasicData_value_set_default_ad', ['as' => 'modals.basicdata_value_set_default_ad', 'uses' => 'View\ModalController@BasicData_value_set_default_ad', 'middleware' => ['dynamic_permission:modals.basicdata_value_set_default_ad']]);
    Route::post('addresses_add_form', ['as' => 'modals.addresses_add_form', 'uses' => 'View\ModalController@addresses_add_form', 'middleware' => ['dynamic_permission:modals.addresses_add_form']]);
    Route::post('addresses_add', ['as' => 'modals.addresses_add', 'uses' => 'View\ModalController@addresses_add', 'middleware' => ['dynamic_permission:modals.addresses_add']]);
    Route::post('addresses_delete', ['as' => 'modals.addresses_delete', 'uses' => 'View\ModalController@addresses_delete', 'middleware' => ['dynamic_permission:modals.addresses_delete']]);
    Route::post('discountcoupon_addedit_form', ['as' => 'modals.discount_coupon_add_edit_form', 'uses' => 'View\ModalController@discountcoupon_addedit_form', 'middleware' => ['dynamic_permission:modals.discount_coupon_add_edit_form']]);
    Route::post('discountcoupon_request_form', ['as' => 'modals.discount_coupon_request_form', 'uses' => 'View\ModalController@discountcoupon_request_form', 'middleware' => ['dynamic_permission:modals.discount_coupon_request_form']]);
    Route::post('discountcoupon_addedit', ['as' => 'modals.discount_coupon_add_edit', 'uses' => 'View\ModalController@discountcoupon_addedit', 'middleware' => ['dynamic_permission:modals.discount_coupon_add_edit']]);
    Route::post('discountcoupon_request', ['as' => 'modals.discount_coupon_request', 'uses' => 'View\ModalController@discountcoupon_request', 'middleware' => ['dynamic_permission:modals.discount_coupon_request']]);
    Route::post('discountcoupon_delete', ['as' => 'modals.discount_coupon_delete', 'uses' => 'View\ModalController@discountcoupon_delete', 'middleware' => ['dynamic_permission:modals.discount_coupon_delete']]);
    Route::post('basicdata_ad_settings_view', ['as' => 'modals.basicdata_ad_settings_view', 'uses' => 'View\ModalController@basicdata_ad_settings_view', 'middleware' => ['dynamic_permission:modals.basicdata_ad_settings_view']]);
    Route::post('basicdata_ad_soclial_view', ['as' => 'modals.basicdata_ad_social_view', 'uses' => 'View\ModalController@basicdata_ad_social_view', 'middleware' => ['dynamic_permission:modals.basicdata_ad_social_view']]);
    Route::post('basicdata_slider_settings_view', ['as' => 'modals.basicdata_slider_settings_view', 'uses' => 'View\ModalController@basicdata_slider_settings_view', 'middleware' => ['dynamic_permission:modals.basicdata_slider_settings_view']]);
    Route::post('basicdata_social_settings_view', ['as' => 'modals.basicdata_social_settings_view', 'uses' => 'View\ModalController@basicdata_social_settings_view', 'middleware' => ['dynamic_permission:modals.basicdata_social_settings_view']]);
    Route::post('basicdata_news_settings_view', ['as' => 'modals.basicdata_news_settings_view', 'uses' => 'View\ModalController@basicdata_news_settings_view', 'middleware' => ['dynamic_permission:modals.basicdata_news_settings_view']]);
    Route::post('invoice_details_form', ['as' => 'modals.invoice_details_form', 'uses' => 'View\ModalController@invoice_details_form', 'middleware' => ['dynamic_permission:modals.invoice_details_form']]);
    Route::post('invoice_status_form', ['as' => 'modals.invoice_status_form', 'uses' => 'View\ModalController@invoice_status_form', 'middleware' => ['dynamic_permission:modals.invoice_status_form']]);
    Route::post('invoice_subjects_form', ['as' => 'modals.invoice_subjects_form', 'uses' => 'View\ModalController@invoice_subjects_form', 'middleware' => ['dynamic_permission:modals.invoice_subjects_form']]);
    Route::post('invoice_coupon_form', ['as' => 'modals.invoice_coupon_form', 'uses' => 'View\ModalController@invoice_coupon_form', 'middleware' => ['dynamic_permission:modals.invoice_coupon_form']]);
    Route::post('invoice_paymentdata_form', ['as' => 'modals.invoice_payment_data_form', 'uses' => 'View\ModalController@invoice_paymentdata_form', 'middleware' => ['dynamic_permission:modals.invoice_payment_data_form']]);
    Route::post('invoice_paymentdatadetails_form', ['as' => 'modals.invoice_payment_data_details_form', 'uses' => 'View\ModalController@invoice_paymentdatadetails_form', 'middleware' => ['dynamic_permission:modals.invoice_payment_data_details_form']]);
    Route::post('basicdata_ad_research_view', ['as' => 'modals.basicdata_ad_research_view', 'uses' => 'View\ModalController@basicdata_ad_research_view', 'middleware' => ['dynamic_permission:modals.basicdata_ad_research_view']]);
    Route::post('basicdata_items_research_view', ['as' => 'modals.basicdata_items_research_view', 'uses' => 'View\ModalController@basicdata_items_research_view', 'middleware' => ['dynamic_permission:modals.basicdata_items_research_view']]);
    Route::post( 'setting_user_view', ['as' => 'modals.setting_user_view', 'uses' => 'View\ModalController@setting_user_view', 'middleware' => ['dynamic_permission:modals.setting_user_view']]);
    Route::post( 'multi_task', ['as' => 'modals.multi_task', 'uses' => 'View\ModalController@multi_task', 'middleware' => ['dynamic_permission:modals.multi_task']]);
    Route::post( 'task_time', ['as' => 'modals.task_time', 'uses' => 'View\ModalController@task_time', 'middleware' => ['dynamic_permission:modals.multi_task']]);
    Route::post( 'add_user_view', ['as' => 'modals.add_user_view', 'uses' => 'View\ModalController@add_user_view', 'middleware' => ['dynamic_permission:modals.add_user_view']]);
    Route::post( 'manager_charts', ['as' => 'modals.manager_charts', 'uses' => 'View\ModalController@manager_charts', 'middleware' => ['dynamic_permission:modals.manager_charts']]);
    Route::post( 'change_score', ['as' => 'modals.change_score', 'uses' => 'View\ModalController@changeScore', 'middleware' => ['dynamic_permission:modals.manager_charts']]);
    Route::post( 'add_organ', ['as' => 'modals.add_organ', 'uses' => 'View\ModalController@add_organ', 'middleware' => ['dynamic_permission:modals.add_organ']]);
    Route::post( 'add_new_organ', ['as' => 'modals.add_new_organ', 'uses' => 'View\ModalController@add_new_organ', 'middleware' => ['dynamic_permission:modals.add_organ']]);
    Route::post( 'assign_new_staff', ['as' => 'modals.assign_new_staff', 'uses' => 'View\ModalController@assign_new_staff', 'middleware' => ['dynamic_permission:modals.add_organ']]);
    Route::post( 'add_new_post', ['as' => 'modals.add_new_post', 'uses' => 'View\ModalController@add_new_post', 'middleware' => ['dynamic_permission:modals.add_organ']]);
    Route::post( 'edit_show_post', ['as' => 'modals.edit_show_post', 'uses' => 'View\ModalController@edit_show_post', 'middleware' => ['dynamic_permission:modals.add_organ']]);
    Route::post( 'edit_job_unit', ['as' => 'modals.edit_job_unit', 'uses' => 'View\ModalController@edit_job_unit', 'middleware' => ['dynamic_permission:modals.add_organ']]);
    Route::post( 'add_new_organ_form', ['as' => 'modals.add_new_organ_form', 'uses' => 'View\ModalController@add_new_organ_form', 'middleware' => ['dynamic_permission:modals.add_organ']]);
    Route::post( 'edit_organ', ['as' => 'modals.edit_organ', 'uses' => 'View\ModalController@edit_organ', 'middleware' => ['dynamic_permission:modals.edit_organ']]);
    Route::post( 'edit_chart', ['as' => 'modals.edit_chart', 'uses' => 'View\ModalController@edit_chart', 'middleware' => ['dynamic_permission:modals.edit_chart']]);
    Route::post('basicdata_get_users_scores', ['as' => 'modals.basicdata_get_users_scores', 'uses' => 'View\ModalController@basicdataGetUsersScores', 'middleware' => ['dynamic_permission:modals.basicdata_get_users_scores']]);
    /* ??? */Route::post('newCircle', ['as' => 'new_circle', 'uses' => 'View\ModalController@newCircle', 'middleware' => ['dynamic_permission:modals.new_circle']]);
    /* ??? */Route::post('login', ['as' => 'login', 'uses' => 'View\ModalController@login', 'middleware' => ['dynamic_permission:modals.login']]);
    Route::post('message', ['as' => 'message', 'uses' => 'View\ModalController@message', 'middleware' => ['dynamic_permission:modals.message']]);
    /* ??? */Route::post('neworgan', ['as' => 'new_organ', 'uses' => 'View\ModalController@newOrgan', 'middleware' => ['dynamic_permission:modals.new_organ']]);
    /* ??? */Route::post('announce', ['as' => 'announce', 'uses' => 'View\ModalController@announce', 'middleware' => ['dynamic_permission:modals.announce']]);
    /* ??? */Route::post('print', ['as' => 'print', 'uses' => 'View\ModalController@mPrint', 'middleware' => ['dynamic_permission:modals.print']]);
    /* ??? */Route::post('export', ['as' => 'export', 'uses' => 'View\ModalController@export', 'middleware' => ['dynamic_permission:modals.export']]);
    /* ??? */Route::post('notification', ['as' => 'notification', 'uses' => 'View\ModalController@notification', 'middleware' => ['dynamic_permission:modals.notification']]);
    /* ??? */Route::post('delete', ['as' => 'delete', 'uses' => 'View\ModalController@mDelete', 'middleware' => ['dynamic_permission:modals.mDelete']]);
    /* ??? */Route::post('history', ['as' => 'history', 'uses' => 'View\ModalController@history', 'middleware' => ['dynamic_permission:modals.history']]);
    /* ??? */Route::post('seluser', ['as' => 'sel_user', 'uses' => 'View\ModalController@seluser', 'middleware' => ['dynamic_permission:modals.sel_user']]);
    Route::post('setting', ['as' => 'setting', 'uses' => 'View\ModalController@setting', 'middleware' => ['dynamic_permission:modals.setting']]);
    Route::post('keyword_addedit_form', ['as' => 'modals.keyword_add_edit_form', 'uses' => 'View\ModalController@keyword_addedit_form', 'middleware' => ['dynamic_permission:modals.keyword_addedit_form']]);
    /* ??? */Route::post('keyword_addedit', ['as' => 'modals.keyword_add_edit', 'uses' => 'View\ModalController@keyword_addedit', 'middleware' => ['dynamic_permission:modals.keyword_addedit']]);
    /* ??? */Route::post('newgroup', ['as' => 'new_group', 'uses' => 'View\ModalController@newGroup', 'middleware' => ['dynamic_permission:modals.new_group']]);
    Route::post('viewmessage', ['as' => 'modals.view_message', 'uses' => 'View\ModalController@viewMessage', 'middleware' => ['dynamic_permission:modals.view_message']]);
    /* ??? */Route::post('getaccessusers', ['as' => 'get_access_users', 'uses' => 'View\ModalController@getAccessUsers', 'middleware' => ['dynamic_permission:modals.get_access_users']]);
    /* ??? */Route::post('pageinsubject', ['as' => 'page_in_subject', 'uses' => 'View\ModalController@pageinSubject', 'middleware' => ['dynamic_permission:modals.page_in_subject']]);
    /* ??? */Route::post('addresses', ['as' => 'modals.addresses', 'uses' => 'View\ModalController@addresses', 'middleware' => ['dynamic_permission:modals.addresses']]);
    /* ??? */Route::post('addresses_form', ['as' => 'modals.addresses_form', 'uses' => 'View\ModalController@addresses_form', 'middleware' => ['dynamic_permission:modals.addresses_form']]);
    /* ??? */Route::post( 'show_edit_data_organ', ['as' => 'modals.show_edit_data_organ', 'uses' => 'View\ModalController@show_edit_data_organ', 'middleware' => ['dynamic_permission:modals.show_edit_data_organ']]);
    Route::post( 'edit_user_detail', ['as' => 'modals.edit_user_detail', 'uses' => 'View\ModalController@edit_user_detail', 'middleware' => ['dynamic_permission:modals.edit_user_detail']]);
    Route::post( 'add_edit_tools', ['as' => 'modals.add_edit_tools', 'uses' => 'View\ModalController@addEditTools', 'middleware' => ['dynamic_permission:modals.add_edit_tools']]);
    Route::post( 'add_roles_tools', ['as' => 'modals.add_roles_tools', 'uses' => 'View\ModalController@addRolesTools', 'middleware' => ['dynamic_permission:modals.add_roles_tools']]);
    Route::post( 'add_users_tools', ['as' => 'modals.add_users_tools', 'uses' => 'View\ModalController@addUsersTools', 'middleware' => ['dynamic_permission:modals.add_users_tools']]);
    Route::post( 'add_tool_group', ['as' => 'modals.add_tool_group', 'uses' => 'View\ModalController@addToolGroup', 'middleware' => ['dynamic_permission:modals.add_tool_group']]);
    Route::post( 'add_edit_menu', ['as' => 'modals.add_edit_menu', 'uses' => 'View\ModalController@addEditMenu', 'middleware' => ['dynamic_permission:modals.add_tool_group']]);
    Route::post( 'add_edit_menu_items', ['as' => 'modals.add_edit_menu_items', 'uses' => 'View\ModalController@addEditMenuItems', 'middleware' => ['dynamic_permission:modals.add_edit_menu_items']]);
    /* ??? */Route::post('CreateNewTask', ['as' => 'modals.create_new_task', 'uses' => 'View\ModalController@CreateNewTask', 'middleware' => ['dynamic_permission:modals.create_new_task']]);
    /* ??? */Route::post('ShowTaskForm', ['as' => 'modals.show_task_form', 'uses' => 'View\ModalController@ShowTaskForm', 'middleware' => ['dynamic_permission:modals.show_task_form']]);
    /* ??? */Route::post('ShowAssignTaskForm', ['as' => 'modals.show_assign_task_form', 'uses' => 'View\ModalController@ShowAssignTaskForm', 'middleware' => ['dynamic_permission:modals.show_assign_task_form']]);
    /* ??? */Route::post('ViewTaskForm', ['as' => 'modals.view_task_form', 'uses' => 'View\ModalController@ViewTaskForm', 'middleware' => ['dynamic_permission:modals.show_task_form']]);
    /* ??? */Route::post('ViewStaffForm', ['as' => 'modals.view_staff_form', 'uses' => 'View\ModalController@ViewStaffForm', 'middleware' => ['dynamic_permission:modals.show_task_form']]);
    /* ??? */Route::post('ShowTranscriptTaskForm', ['as' => 'modals.show_transcipt_task_form', 'uses' => 'View\ModalController@ShowTranscriptTaskForm', 'middleware' => ['dynamic_permission:modals.show_assign_task_form']]);
    /* ??? */Route::post('ShowLiberaryTaskForm', ['as' => 'modals.show_liberary_task_form', 'uses' => 'View\ModalController@ShowLiberaryTaskForm', 'middleware' => ['dynamic_permission:modals.show_liberary_task_form']]);
    /* ??? */Route::post('CreateNewProject', ['as' => 'modals.create_new_project', 'uses' => 'View\ModalController@CreateNewProject', 'middleware' => ['dynamic_permission:modals.create_new_project']]);
    /* ??? */Route::post('CreateNewProcess', ['as' => 'modals.create_new_process', 'uses' => 'View\ModalController@CreateNewProcess', 'middleware' => ['dynamic_permission:modals.create_new_process']]);
    /* ??? */Route::post('CreateNewCalendar', ['as' => 'modals.create_new_calendar', 'uses' => 'View\ModalController@CreateNewCalendar', 'middleware' => ['dynamic_permission:modals.create_new_calendar']]);
    /* ??? */Route::post('BasicData_adssetting_view', ['as' => 'modals.BasicData_adssetting_view', 'uses' => 'View\ModalController@BasicData_adssetting_view', 'middleware' => ['dynamic_permission:modals.BasicData_adssetting_view']]);
    /* ??? */Route::post('BasicdataValueCreateEdit_adsettings', ['as' => 'modals.BasicdataValueCreateEdit_adsettings', 'uses' => 'View\ModalController@BasicdataValueCreateEdit_adsettings', 'middleware' => ['dynamic_permission:modals.BasicdataValueCreateEdit_adsettings']]);
    /* ??? */Route::post('BasicData_value_edit_view', ['as' => 'modals.basicdata_value_edit_view', 'uses' => 'View\ModalController@BasicData_value_edit_view', 'middleware' => ['dynamic_permission:modals.BasicData_value_edit_view']]);
   // Route::get('url/{url_type}/{url_href}', ['as' => 'modals.url', 'uses' => 'View\ModalController@URL', 'middleware' => ['dynamic_permission:modals.url']]);
    //Route::get('route/{route_name}', ['as' => 'modals.route', 'uses' => 'View\ModalController@Route', 'middleware' => ['dynamic_permission:modals.route']]);
    Route::get('/{name}', ['as' => 'modals.name', 'uses' => 'View\ModalController@select', 'middleware' => ['dynamic_permission:modals.name']]);
    Route::post('getKeywordsListSubjectUsages', ['as' => 'modals.get_keywords_list_subject_usages', 'uses' => 'View\ModalController@getKeywordsListSubjectUsages', 'middleware' => ['dynamic_permission:posts.modals.get_keywords_list_subject_usages']]);

    Route::group(['prefix' => 'help'], function ()
    {
        Route::post('/view', ['uses' => 'View\ModalController@help_view', 'as' => 'modals.help.view', 'middleware' => ['dynamic_permission:posts.modals.help_view']]);
        Route::group(['prefix' => 'seealso'], function ()
        {
            Route::post('/', ['uses' => 'View\ModalController@help_seealso', 'as' => 'modals.help.seealso', 'middleware' => ['dynamic_permission:posts.modals.help_seealso']]);
            Route::post('/add', ['uses' => 'View\ModalController@help_seealso_add', 'as' => 'modals.help.seealso_add', 'middleware' => ['dynamic_permission:posts.modals.help_seealso_add']]);
            Route::post('/content', ['uses' => 'View\ModalController@help_seealso_content', 'as' => 'modals.help.seealso_content', 'middleware' => ['dynamic_permission:posts.modals.help_seealso_content']]);
            Route::post('/delete', ['uses' => 'View\ModalController@help_seealso_delete', 'as' => 'modals.help.seealso.delete', 'middleware' => ['dynamic_permission:posts.modals.help_seealso_delete']]);
        });
        Route::group(['prefix' => 'relation'], function ()
        {
            Route::post('/add', ['uses' => 'View\ModalController@help_relation_add', 'as' => 'modals.help.relation.add', 'middleware' => ['dynamic_permission:posts.modals.help_relation_add']]);
        });
    });
});