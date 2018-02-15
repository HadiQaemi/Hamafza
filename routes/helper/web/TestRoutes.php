<?php

use App\Classes\SmartdetectClass;
use App\Models\hamafza\Subject;
use App\Models\Hamahang\FileManager\Fileable;
use App\Models\Hamahang\FileManager\FileMimeTypes;
use App\Models\Hamahang\Help;
use App\Models\Hamahang\Score;

Route::any('transfer_as21d23as1das546d6a5s1d23as1d2', function()
{
    $encoded_data = null;
    $decoded_data = null;
    if (request::file('data_file'))
    {
        $encoded_data = base64_encode(file_get_contents(request::file('data_file')->getRealPath()));
    }
    if (request::input('content'))
    {
        $decoded_data = 'c:\\' . time() . '.zip';
        file_put_contents($decoded_data, base64_decode(request::input('content')));
    }
    return view('transfer')->with(['encoded_data' => $encoded_data, 'decoded_data' => $decoded_data]);
});


Route::get('test', function ()
{

    //$columns = Schema::getColumnListing('user_profile');
    //dd(in_array('relevant_organization', $columns));

    if (4260 == auth()->id())
    {
        $smartdetect = new SmartdetectClass();
        dd($smartdetect->result_factors);
    }


    //ini_set('max_execution_time', '0');
    //$mail = Mail::send('test', [], function($message)
    //{
    //    $message->from('no-replay@hamafza.ir', 'no-replay@hamafza.ir');
    //    $message->to('mlotfi63@gmail.com');//->cc('bar@example.com');
    //});
    //dd($mail);
    //$smart_detect = new SmartDetect();
    //return 'test routes';
});











Route::get('get-old-id', function ()
{
    $out = 'Error.';
    if (Request::exists('name'))
    {
        $db = DB::table('page_file')->where('name', Request::input('name'))->get()->first();
        if ($db)
        {
            $out = $db->pid;
        } else
        {
            $out = 'File not found.';
        }
    } else
    {
        $out = 'Invalid request.';
    }
    dd($out);
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