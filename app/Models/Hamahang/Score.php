<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_scores';
    protected $fillable =
        [
            'uid',
            'target_table',
            'target_id',
            'type_value_id',
            'value'
        ];

    public function default_value()
    {
        return $this->hasOne('App\Models\Hamahang\BasicdataValue', 'id', 'type_value_id');
    }

    public function getCreatedAtAttribute($v)
    {
        return HDate_GtoJ($v, "H:i - Y/m/d");
    }

    public static function register($target_table = 'App\Models\hamafza\Post', $target_id = 0, $score_id = 0, $uid = -1)
    {
        $uid_final = -1 == $uid ? auth()->id() : $uid;
        $basicdatavalue = BasicdataValue::find($score_id);
        self::create(
            [
                'uid' => $uid_final,
                'target_table' => $target_table,
                'target_id' => $target_id,
                'type_value_id' => $basicdatavalue->id,
                'value' => $basicdatavalue->value,
            ]);
    }

    public static function real_unregister($target_table = 'App\Models\hamafza\Post', $target_id = 0, $uid = -1)
    {
        $uid_final = -1 == $uid ? auth()->id() : $uid;
        $score = self::where('target_table', $target_table)->where('target_id', $target_id)->where('uid', $uid_final);
        if ($score)
        {
            $score->delete();
        }
    }

}

