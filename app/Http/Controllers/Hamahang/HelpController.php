<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\Pages;
use App\Models\Hamahang\Help;
use Datatables;
use DB;

class HelpController extends Controller
{

    public function help($Uname)
    {
        $variable_generator = variable_generator('user', 'desktop', $Uname);
        return view('hamahang.help.help', $variable_generator);
    }

    public function HelpContent()
    {
        $help = DB::table('hamahang_helps')
            ->leftJoin('hamahang_help_blocks','hamahang_help_blocks.help_id','=','hamahang_helps.id')
            ->whereNull('hamahang_helps.deleted_at')
            ->whereNull('hamahang_help_blocks.deleted_at')
            ->select('hamahang_helps.*', DB::raw('count(*) as total'))
            ->groupBy('hamahang_help_blocks.help_id')
            ->get();

        $help = DB::table('hamahang_helps_new')
            ->whereNull('hamahang_helps_new.deleted_at')
            ->get();
        $r = Datatables::of($help)
            ->editColumn('id', function ($q) { return enCode($q->id); })
            ->make(true);
        return $r;
    }

    public function AddHelpPermission()
    {
        DB::table('hamahang_help_relations')->insert
        ([
            'target_type' => 'App\Permission',
            'target_id' => \Request::input('permission_id'),
            'help_id' =>  deCode(\Request::input('help_id')),
            'created_by' => auth()->id(),
        ]);
    }
    public function TakeHelpPermissions()
    {
        $result['data'] = DB::table('hamahang_help_relations')
            ->leftJoin('permissions','')
            ->where('help_id', '=', deCode(\Request::input('help_id')))
            ->get();
        return json_encode($result);
    }

}

