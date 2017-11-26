<?php
/**
 * Created by PhpStorm.
 * User: hamahang
 * Date: 11/27/16
 * Time: 12:39 PM
 */
namespace App\Models\Hamahang\Calendar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar_Permission extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_calendar_permission';
    protected $dates = ['deleted_at'];
}