<?php

use App\Models\hamafza\Subject;
use App\Models\Hamahang\FileManager\Fileable;
use App\Models\Hamahang\FileManager\FileMimeTypes;
use App\Models\Hamahang\Score;

Route::get('test', function ()
{
    //$help = Help::find(1);
    //dd($help->SeeAlsos);
    return 'test';
});

Route::get('abort/{code}', function ($code)
{
    abort($code);
});

Route::get('emails', function ()
{
    foreach (\App\User::all() as $user){
        $email = $user->Email;
        $email_parts = explode('@', $email);
        $user->Email = $email_parts[0] . '@sapco.com';
        $user->save();
    }
    return 'Done!';
});

Route::get('users', function ()
{
    foreach (\App\User::all() as $user){
        $user->Uname = 'u' . $user->Uname;
        $user->save();
    }
    return 'Done!';
});

Route::get('image', function ()
{
    return '<img src="' . HFM_DownloadByID(489, $not_found_img = '404.png', true) . '"/>';
});

Route::get('ch', function ()
{
    $flat_array =[
        ['id'=>1,'parent_id'=>0,'title'=>'test1'],
        ['id'=>2,'parent_id'=>1,'title'=>'test2'],
        ['id'=>3,'parent_id'=>2,'title'=>'test3'],
        ['id'=>4,'parent_id'=>3,'title'=>'test4'],
        ['id'=>5,'parent_id'=>4,'title'=>'test5'],
        ['id'=>6,'parent_id'=>5,'title'=>'test6'],
        ['id'=>7,'parent_id'=>5,'title'=>'test7'],
        ['id'=>8,'parent_id'=>5,'title'=>'test8'],
    ];
    $r = find_all_descendant_from_flat_array($flat_array,1,false);
    dd($r);
});