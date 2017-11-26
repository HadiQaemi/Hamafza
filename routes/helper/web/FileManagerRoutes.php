<?php
Route::group(['prefix' => 'FileManager', 'middleware' => ['dynamic_permission:file_manager']], function ()
{
    Route::get('ShowGridMyFiles', ['as' => 'FileManager.ShowGridMyFiles', 'uses' => 'Hamahang\FileManagerController@ShowGridMyFiles', 'middleware' => ['dynamic_permission:file_manager.show_grid_my_files']]);
    Route::post('Upload/{section}', ['as' => 'FileManager.UploadWithAddToSession', 'uses' => 'Hamahang\FileManagerController@UploadWithAddToSession', 'middleware' => ['dynamic_permission:file_manager.upload_with_add_to_session']]);
    Route::post('AddSelectedFile/{section}', ['as' => 'FileManager.AddSelectedFileToSession', 'uses' => 'Hamahang\FileManagerController@AddSelectedFileToSession', 'middleware' => ['dynamic_permission:file_manager.add_selected_file_to_session']]);
    Route::post('RemoveFFS/{section}/{record}', ['as' => 'FileManager.RemoveFileFromSession', 'uses' => 'Hamahang\FileManagerController@RemoveFFS', 'middleware' => ['dynamic_permission:file_manager.remove_file_from_session']]);
    Route::post('GridMyFiles', ['as' => 'FileManager.GridMyFiles', 'uses' => 'Hamahang\FileManagerController@GridMyFiles', 'middleware' => ['dynamic_permission:file_manager.grid_my_files']]);
    Route::post('tinymce_external_filemanager', ['as' => 'FileManager.tinymce_external_filemanager', 'uses' => 'Hamahang\FileManagerController@tinymce_external_filemanager', 'middleware' => ['dynamic_permission:file_manager.tinymce_external_file_manager']]);
    Route::get('tinymce_external_filemanager_form', ['as' => 'FileManager.tinymce_external_filemanager_form', 'uses' => 'Hamahang\FileManagerController@tinymce_external_filemanager_form', 'middleware' => ['dynamic_permission:file_manager.tinymce_external_file_manager_form']]);
    //Route::get('tinymce_external_filemanager_plugin', ['uses' => 'Hamahang\FileManagerController@tinymce_external_filemanager_plugin', 'as' => 'FileManager.tinymce_external_filemanager_plugin']);

});
