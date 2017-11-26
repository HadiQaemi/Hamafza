<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
    use softDeletes;
    protected $table = 'hamahang_votes';

    public static function getCount($target_table = 'App\Models\NAMESPACE\MODEL', $target_id = 0)
    {
        return Vote::where('target_table', $target_table)->where('target_id', $target_id)->count();
    }

    public static function getSum($target_table = 'App\Models\NAMESPACE\MODEL', $target_id = 0)
    {
        return Vote::where('target_table', $target_table)->where('target_id', $target_id)->get()->sum('type');
    }

    public static function getVote($target_table = 'App\Models\NAMESPACE\MODEL', $target_id = 0, $uid = 0)
    {
        $r = false;
        $result = Vote::where('target_table', $target_table)->where('target_id', $target_id)->where('uid', $uid);
        if ($result->count())
        {
            $r = $result->first()->type;
        }
        return $r;
    }

    public static function hasVote($target_table = 'App\Models\NAMESPACE\MODEL', $target_id = 0, $uid = 0)
    {
        return (bool) Vote::where('target_table', $target_table)->where('target_id', $target_id)->where('uid', $uid)->count();
    }

    private static function setVote($target_table, $target_id, $type)
    {
        $vote = new Vote;
        $vote->uid = auth()->id();
        $vote->target_table = $target_table;
        $vote->target_id = $target_id;
        $vote->type = $type;
        $vote->save();
    }

    public static function voteUp($table = 'App\Models\NAMESPACE\MODEL', $id = 0)
    {
        self::setVote($table, $id, 1);
    }

    public static function voteDown($table = 'App\Models\NAMESPACE\MODEL', $id = 0)
    {
        self::setVote($table, $id, -1);
    }

    public static function voteOff($table = 'App\Models\NAMESPACE\MODEL', $id = 0)
    {
        $vote = Vote::where('uid', auth()->id())->where('target_table', $table)->where('target_id', $id);
        $vote->delete();
    }

    /*
    public function setSetNameHereAttribute($target_id)
    {
        dd($target_id);
    }
    // usage:
    $vote = new Vote;
    $vote->A(5);
    $vote->save();
    */

}
















