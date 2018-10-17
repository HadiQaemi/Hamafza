<?php

Route::post('GetMyBookmark', ['as' => 'hamafza.get_my_bookmark', 'uses' => 'View\AjaxController@GetMyBookmark']);
Route::post('GetsubjectFields', ['as' => 'GetMyPortal', 'uses' => 'View\AjaxController@GetSubjectFields']);
Route::post('GetMyPortal', ['as' => 'GetMyPortal', 'uses' => 'View\AjaxController@GetMyPortal']);
Route::post('search', ['as' => 'search', 'uses' => 'View\AjaxController@search']);
Route::post('SearchTags', ['as' => 'SearchTags', 'uses' => 'View\AjaxController@SearchTags']);
Route::post('GetTreeNode', ['as' => 'GetTreeNode', 'uses' => 'View\AjaxController@GetTreeNode']);
Route::post('GetTreeNodes', ['as' => 'GetTreeNodes', 'uses' => 'View\AjaxController@GetTreeNodes']);


Route::group(array('prefix' => 'v43', 'namespace' => 'Services'), function () {
    Route::get('get_sites', [
        'uses' => 'PublicController@GetSites'
    ]);
    /* Route::post('get_portals', [
      'uses' => 'PublicController@GetPortals'
      ]); */
    Route::get('searchkeywords', [
        'uses' => 'PublicController@searchKeywords'
    ]);
    Route::get('keywords', [
        'as' => 'api.v43.keywords',
        'uses' => 'AutoCompleteController@keywords',
        'middleware' => ['dynamic_permission:auto_complete.keywords']]);
    Route::get('userslist', [
        'as' => 'api.v43.userslist',
        'uses' => 'AutoCompleteController@userslist',
        'middleware' => ['dynamic_permission:auto_complete.users']]);
    Route::get('search', [
        'uses' => 'PublicController@search'
    ]);
    Route::get('get_page_detail', [
        'as' => 'api.v43.get_page_detail',
        'uses' => 'PageController@PageDetail'
    ]);
    Route::post('like', [
        'as' => 'api.v43.like',
        'uses' => 'PageController@like'
    ]);
    Route::post('dislike', [
        'as' => 'api.v43.dislike',
        'uses' => 'PageController@dislike'
    ]);
    Route::post('newpost', [
        'as' => 'api.v43.newpost',
        'uses' => 'PageController@newpost'
    ]);
    Route::post('follow', [
        'as' => 'api.v43.follow',
        'uses' => 'PageController@follow'
    ]);
    Route::post('unfollow', [
        'as' => 'api.v43.unfollow',
        'uses' => 'PageController@unfollow'
    ]);

    Route::post('toggle_bookmark', [
        'as' => 'api.v43.toggle_bookmark',
        'uses' => 'PageController@bookmark_toggle'
    ]);

    Route::post('delete_bookmark', [
        'as' => 'api.v43.delete_bookmark',
        'uses' => 'PageController@bookmark_delete'
    ]);

    Route::post('add_announce', [
        'as' => 'api.v43.add_announce',
        'uses' => 'PageController@announce_add'
    ]);
    Route::post('delete_announce', [
        'as' => 'api.v43.delete_announce',
        'uses' => 'PageController@delete_announce'
    ]);
    Route::post('send_message', [
        'as' => 'api.v43.send_message',
        'uses' => 'PageController@sendMessage'
    ]);
    Route::post('new_organ', [
        'as' => 'api.v43.new_organ',
        'uses' => 'PageController@newOrgan'
    ]);
    Route::post('post_comment', [
        'as' => 'api.v43.post_comment',
        'uses' => 'PageController@post_comment'
    ]);

    Route::post('delete_comment', [
        'as' => 'api.v43.delete_comment',
        'uses' => 'PageController@delete_comment'
    ]);

    Route::post('delete_post', [
        'as' => 'api.v43.delete_post',
        'uses' => 'PageController@delete_post'
    ]);

    Route::post('post_share', [
        'as' => 'api.v43.post_share',
        'uses' => 'PageController@Sharepost'
    ]);



    Route::post('get_persons', [
        'as' => 'api.v43.get_persons',
        'uses' => 'UserController@get_persons'
    ]);

    /* Route::post('get_people_you_may_know', [
      'as' => 'api.v43.get_people_you_may_know',
      'uses' => 'UserController@get_people_you_may_know'
      ]); */

    Route::post('get_my_posts', [
        'as' => 'api.v43.get_my_posts',
        'uses' => 'UserController@get_my_posts'
    ]);

    Route::post('get_about_me', [
        'as' => 'api.v43.get_about_me',
        'uses' => 'UserController@get_about_me'
    ]);

    Route::post('update_user', [
        'as' => 'api.v43.update_user',
        'uses' => 'UserController@updateUser'
    ]);
    Route::group(array('prefix' => 'tasks'), function () {
        Route::get('get_my_tasks', [
            'as' => 'api.v43.tasks.get_my_tasks',
            'uses' => 'TaskController@get_my_tasks'
        ]);
    });
    Route::group(array('prefix' => 'tasks'), function () {
        Route::post('rapid_new_task', [
            'as' => 'api.v43.tasks.rapid_new_task',
            'uses' => 'TaskController@rapid_new_task'
        ]);
    });
    Route::group(array('prefix' => 'message'), function () {
        Route::post('get_inbox_messages', [
            'as' => 'api.v43.message.get_inbox_messages',
            'uses' => 'MessageController@get_inbox_messages'
        ]);
    });

    Route::group(array('prefix' => 'user'), function () {
        Route::post('login', [
            'as' => 'api.v43.user.login',
            'uses' => 'AuthController@login'
        ]);
        Route::post('register', [
            'as' => 'api.v43.user.register',
            'uses' => 'AuthController@register'
        ]);
        Route::post('password_reset', [
            'as' => 'api.v43.user.password_reset',
            'uses' => 'AuthController@password_reset'
        ]);
        Route::get('desktop', [
            'as' => 'api.v43.user.desktop',
            'uses' => 'UserController@desktop'
        ]);
        Route::post('get_my_notes', [
            'as' => 'api.v43.user.get_my_notes',
            'uses' => 'UserController@get_my_notes'
        ]);
        Route::post('get_my_groups', [
            'as' => 'api.v43.user.get_my_groups',
            'uses' => 'UserController@get_my_groups'
        ]);
        Route::get('bookmarks', [
            'as' => 'api.v43.user.bookmarks',
            'uses' => 'UserController@get_bookmarks'
        ]);
        Route::get('portals', [
            'as' => 'api.v43.user.portals',
            'uses' => 'UserController@portals'
        ]);
        Route::get('get_my_wall', [
            'as' => 'api.v43.user.get_my_wall',
            'uses' => 'UserController@get_my_wall'
        ]);
        Route::get('get_my_groups', [
            'as' => 'api.v43.user.get_my_groups',
            'uses' => 'UserController@MyGroups'
        ]);

        Route::get('announces', [
            'as' => 'api.v43.user.announces',
            'uses' => 'UserController@announces'
        ]);

        Route::get('highlights', [
            'as' => 'api.v43.user.highlights',
            'uses' => 'UserController@highlights'
        ]);

        Route::get('inbox', [
            'as' => 'api.v43.user.inbox',
            'uses' => 'UserController@inbox'
        ]);

        Route::get('outbox', [
            'as' => 'api.v43.user.outbox',
            'uses' => 'UserController@outbox'
        ]);

        Route::post('update_user_specials', [
            'as' => 'api.v43.user.update_user_specials',
            'uses' => 'UserController@updateUserSpecials',
            'middleware' => ['dynamic_permission:posts.hamahang.users.update_user_specials']
        ]);
        Route::post('add_user_work', [
            'as' => 'api.v43.user.add_user_work',
            'uses' => 'UserController@addUserWork',
            'middleware' => ['dynamic_permission:posts.hamahang.users.add_user_work']
        ]);
        Route::post('update_user_work', [
            'as' => 'api.v43.user.update_user_work',
            'uses' => 'UserController@updateUserWork',
            'middleware' => ['dynamic_permission:posts.hamahang.users.update_user_work']
        ]);
        Route::post('delete_user_work', [
            'as' => 'api.v43.user.delete_user_work',
            'uses' => 'UserController@deleteUserWork',
            'middleware' => ['dynamic_permission:posts.hamahang.users.delete_user_work']
        ]);
        Route::post('add_user_education', [
            'as' => 'api.v43.user.add_user_education',
            'uses' => 'UserController@addUserEducation',
            'middleware' => ['dynamic_permission:posts.hamahang.users.add_user_education']]);
        Route::post('update_user_education', [
            'as' => 'api.v43.user.update_user_education',
            'uses' => 'UserController@updateUserEducation',
            'middleware' => ['dynamic_permission:posts.hamahang.users.update_user_education']
        ]);
        Route::post('delete_user_education', [
            'as' => 'api.v43.user.delete_user_education',
            'uses' => 'UserController@deleteUserEducation',
            'middleware' => ['dynamic_permission:posts.hamahang.users.delete_user_education']
        ]);
        Route::get('get_avatar', [
            'as' => 'api.v43.user.get_avatar',
            'uses' => 'UserController@getAvatar'
        ]);









        /* Route::post('password_reset', [
          'as'    => 'api.v43.password_reset',
          'uses'  => 'Services\AuthController@password_reset'
          ]); */
        /*        Route::post('active_token_list', [
          'as'    => 'api.v43.active.token.list',
          'uses'  => 'Services\AuthController@active_token_list'
          ]);
          Route::post('active_token_list', [
          'as'    => 'api.v43.active.token.list',
          'uses'  => 'Services\AuthController@active_token_list'
          ]); */
//        Route::post('logout', [
//            'uses' => 'Services\AuthController@logout'
//        ]);
//        Route::post('profile', [
//            'uses' => 'Services\AuthController@create'
//        ]);
//        Route::post('about', [
//            'uses' => 'Services\UserController@about'
//        ]);
//        Route::post('list', [
//            'uses' => 'Services\AuthController@list'
//        ]);
//        Route::post('{id}', [
//            'uses' => 'Services\AuthController@show'
//        ]);
    });
});


Route::group(array('prefix' => 'admin_methods'), function () {

    Route::post('assignRoleUser', function (\Illuminate\Http\Request $request) {
        $secret_key = $request->secret_key;
        $role_id = $request->role_id;
        $user_id = $request->user_id;
        if ($secret_key != 'assignRoleUserIHEFIAWYHEFkjoes8r7689ih34n5ilh3kjbfgH7') {
            abort(403);
        }
        $role = App\Role::findOrFail($role_id);
//        dd($role);
        if (ctype_alpha($user_id)) {
            $users = \App\User::all();
            foreach ($users as $user) {
                if (!$user->hasRole($role->id)) {
                    $user->attachRole($role);
                }
            }
        } else {
            $user = \App\User::find($user_id);
            $user->attachRole($role);
        }
        return 'Done!';
    });

    Route::post('assignPermissionRole', function (\Illuminate\Http\Request $request) {
        $secret_key = $request->secret_key;
        $role_id = $request->role_id;
        if ($secret_key != 'assignPermission_roleIHEFIAWYHEFk6876kjgjoes8r7689ih34n5ilh3kjbfgH7') {
            abort(403);
        }
        $role = App\Role::findOrFail($role_id);

        $permissions = \App\Permission::all();
        foreach ($permissions as $permission) {
            $role->attachPermission($permission);
        }
        return 'Done!';
    });

    Route::post('assignRolePolicy', function (\Illuminate\Http\Request $request) {
        $secret_key = $request->secret_key;
        $role_id = $request->role_id;
        $page_title = $request->page_title;
        $can_edit = $request->can_edit;
        if ($secret_key != 'assignRolePolicyIOIOsd98798njk87bhfbdfjgNIHISF0879hsnkjy') {
            abort(403);
        }
        switch ($page_title) {
            case 'subject':
                $subjects = App\Models\hamafza\Subject::all();
                foreach ($subjects as $subject) {
                    //$subject->role_policies_view()->sync([$role_id => ['type' => '1']]);
                    if ($can_edit == 1) {
                        $subject->role_policies_edit()->attach([$role_id => ['type' => '2']]);
                    }
                    if ($can_edit == 0) {
                        $subject->role_policies_edit()->attach([$role_id => ['type' => '1']]);
                    }
                }
                return 'subject_done';
                break;
            case 'subject_type':
                $subject_types = \App\Models\hamafza\SubjectType::all();
                foreach ($subject_types as $subject_type) {
                    //$subject_type->role_policies_personal()->sync([$role_id => ['type' => '1']]);
                    if ($can_edit == 1) {
                        $subject_type->role_policies_personal()->attach([$role_id => ['type' => '1']]);
                    }
                    if ($can_edit == 2) {
                        $subject_type->role_policies_official()->attach([$role_id => ['type' => '2']]);
                    }
                }
                return 'subject_type_done';
                break;
            case 'tools':
                $Tools = App\Models\Hamahang\Tools\Tools::all();
                foreach ($Tools as $Tool) {
                    $Tool->role_policy()->attach($role_id);
                }
                return 'tools_done';
                break;
            case 'menus':
                $menus = \App\Models\Hamahang\Menus\Menus::all();
                foreach ($menus as $menu) {
                    $menu->role_policy()->attach($role_id);
                }
                return 'menus_done';
                break;
            case 'menu_items':
                $menu_items = \App\Models\Hamahang\Menus\MenuItem::all();
                foreach ($menu_items as $menu_item) {
                    $menu_item->role_policy()->attach($role_id);
                }
                return 'menu_items_done';
                break;
        }
    });

    Route::get('convertPageFiles/{secret_key}', function ($secret_key) {
        if ($secret_key != 'convertPageFilesIHE6565w346TAWYHEFoes8r7689ih34n5ilh3kfgH7') {
            abort(404);
        }
        $res = [];
        $old_files = \Storage::disk('page_files')->allFiles();
        //dd($old_files);
        foreach ($old_files as $old_file) {
            $CustomUID = auth()->id();
            $CustomUID = $CustomUID ? $CustomUID : 0;
            $arr = explode(".", $old_file);
            $originalName = $arr[0];
            $page_file = DB::table('page_file')->where('name', $old_file)->select('pid')->first();
            if ($page_file) {
                $file_content = \Storage::disk('page_files')->get($old_file);
                $mimeType = \Storage::disk('page_files')->mimeType($old_file);
                $extension = App\Models\Hamahang\FileManager\FileMimeTypes::where('mimeType', $mimeType)->first()->ext;
                $size = \Storage::disk('page_files')->size($old_file);
                $Path = '/uploads/pages';
                $OriginalFileName = HFM_Sanitize($originalName);
                $filename = $CustomUID . '_' . md5($file_content) . "_" . time() . $extension;
                \Storage::disk('FileManager')->put($Path . '/' . $filename, $file_content);
                $FileSave = new \App\Models\Hamahang\FileManager\FileManager();
                $FileSave->uid = $CustomUID;
                $FileSave->originalName = $OriginalFileName;
                $FileSave->extension = $extension;
                $FileSave->mimeType = $mimeType;
                $FileSave->filename = $filename;
                $FileSave->size = $size;
                $FileSave->path = '/uploads/pages';
                $FileSave->save();
                $new_file = new App\Models\Hamahang\FileManager\Fileable();
                $new_file->fileable_id = $page_file->pid;
                $new_file->fileable_type = 'App\Models\hamafza\Pages';
                $new_file->type = '2';
                $new_file->save();
                $res[] = $new_file->id;
            }
        }
        return $res;
    });

    Route::get('deleteExtraPages/{secret_key}', function ($secret_key) {
        if ($secret_key != 'deleteExtraPagesIHE6565w346TAWYHEFoFkjghkjkffes8r7689ih34n5ilh3kfgH7') {
            abort(404);
        }
        // ini_set('memory_limit', '-1');
        $res = [];
        $pages = \App\Models\hamafza\Pages::all()->take(100);
        foreach ($pages as $page) {
            foreach ($page->subject->pages as $item) {
                $res[] = $item->id;
            }
        }
        for ($i = 1; $i <= 100; $i++) {
            if (!in_array($i, $res)) {
                $res[] = $i;
            }
        }
        \App\Models\hamafza\Pages::whereNotIn('id', $res)
                ->forceDelete();
    });

    Route::get('deleteSubjectsWithNoPages/{secret_key}', function ($secret_key) {
        if ($secret_key != 'deleteSubjectsWithNoPagesIHE6565w34jhkEAWYHEFoFkjes8r7689ih34n5ilh3kfgH7') {
            abort(404);
        }
        $res = [];
        $subjects = App\Models\hamafza\Subject::whereHas('pages')->get();
        foreach ($subjects as $subject) {
            $res[] = $subject->id;
        }
        App\Models\hamafza\Subject::whereNotIn('id', $res)
                ->forceDelete();
    });

    Route::get('convertAvatars/{secret_key}', function ($secret_key) {
        if ($secret_key != 'convertAvatarsIHE6565w34jAWYHEFoFkllFFOUes8r7689ih34n5ilh3kfgH7') {
            abort(404);
        }
        $old_files = \Storage::disk('user_pics_files')->allFiles();
        foreach ($old_files as $old_file) {
            $user = \App\User::where('Pic', $old_file)->first();
            if ($user) {
                $CustomUID = $user->id;
                $arr = explode(".", $user->Pic);
                $originalName = $arr[0];

                $file_content = \Storage::disk('user_pics_files')->get($old_file);
                $mimeType = \Storage::disk('user_pics_files')->mimeType($old_file);
                $extension = App\Models\Hamahang\FileManager\FileMimeTypes::where('mimeType', $mimeType)->first()->ext;
                $size = \Storage::disk('user_pics_files')->size($old_file);
                $Path = '/uploads/';

                $OriginalFileName = HFM_Sanitize($originalName);
                $filename = $CustomUID . '_' . md5($file_content) . "_" . time() . $extension;

                \Storage::disk('FileManager')->put($Path . '/' . $filename, $file_content);

                $FileSave = new \App\Models\Hamahang\FileManager\FileManager();
                $FileSave->uid = $CustomUID;
                $FileSave->originalName = $OriginalFileName;
                $FileSave->extension = $extension;
                $FileSave->mimeType = $mimeType;
                $FileSave->filename = $filename;
                $FileSave->size = $size;
                $FileSave->path = '/uploads/';
                $FileSave->save();

                $user->Avatar = $FileSave->id;
                $user->save();
            }
        }
    });

    Route::get('fillSubjectTypeFields/{secret_key}', function ($secret_key) {
        if ($secret_key != 'fillSubjectTypeFieldsIHE6565w3DKIUS4jAWYHEFoiu6kllFFOUes8r7689ih34n5ilh3kfgH7') {
            abort(404);
        }
        $subject_type_fields = \App\Models\hamafza\SubjectTypeField::all();

        foreach ($subject_type_fields as $subject_type_field) {
            $field = \App\Models\hamafza\Field::find($subject_type_field->field_id);
            if ($field) {
                $subject_type_field->name = $field->field_name;
                $subject_type_field->type = $field->field_type;
                $subject_type_field->save();
            }
        }
        return 'Done!';
    });
});



/*
Route::get('/amirs', function ()
{
    $news = DB::table('subject_type_fieldss as stf')->leftjoin('fields as f', 'f.id', '=', 'stf.field_id')
        ->select('stf.id', 'stf.name', 'stf.defvalue', 'stf.type', 'f.id as fid', 'f.field_type', 'field_name')->get();
//    foreach ($news as $item) {
//        DB::table('subject_type_fields')->where('id', $item->id)->update(['name' => $item->field_name, 'type' => $item->field_type]);
//    }
});*/
/* ??? */
/*Route::get('/amirs2', function ()
{
    $news = DB::table('subject_fields_report')->get();
    foreach ($news as $item)
    {
        $news2 = DB::table('subject_type_fields as stf')->leftjoin('subjects as s', 's.kind', '=', 'stf.stid')
            ->leftjoin('fields as f', 'f.id', '=', 'stf.field_id')
            ->where('s.id', $item->sid)
            ->select('stf.id', 'f.id as fid', 'stf.name', 's.id as sid', 'stf.defvalue', 'stf.stid', 'stf.type', 'f.id as fid', 'f.field_type', 'field_name')->get();

        foreach ($news2 as $items)
        {
            DB::table('subject_fields_report')->where('field_id', $items->fid)
                ->where('sid', $items->sid)
                ->update(['field_id' => $items->id]);
        }
    }
});*/
/* ??? */
