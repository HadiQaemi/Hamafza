<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class drafts extends Model
{
    use softdeletes;
    protected $table = 'hamahang_task_drafts';

    public static function GetDraftTaskFiles()
    {
        return DB::table('hamahang_task_drafts')
            ->where('uid', '=', Auth::id())
            ->where('id', '=', Request::input('tid'))
            ->select('files')->first();
    }

    public static function FetchDraftsList()
    {
        $total = DB::table('hamahang_task_drafts')
            ->whereNull('hamahang_task_drafts.deleted_at')
            ->where('hamahang_task_drafts.uid', '=', Auth::id())
            ->select('hamahang_task_drafts.form_data as title', 'hamahang_task_drafts.id as id', 'hamahang_task_drafts.created_at as cr')
            ->get();

        foreach ($total as $draft)
        {
            //die(var_dump(unserialize($draft->title)));
            $draft->title = unserialize($draft->title)['title'];
        }

        return $total;

    }
}
