<?php

namespace App\Models\Hamahang\Tools;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class ToolsRoles extends Model
{
    use softdeletes;
    protected $table ='hamahang_access_tools_role';
    public function getRole($tools_id)
    {
        $roles = DB::table('roles')
            ->select('roles.id','roles.name')
            ->join('hamahang_access_tools_role as tr','roles.id','tr.role_id')
            ->where('tr.tools_id','=',$tools_id)
            ->get();
        return $roles;
    }
}
