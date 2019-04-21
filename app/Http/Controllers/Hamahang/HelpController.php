<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\Pages;
use App\Models\Hamahang\Help;
use App\Models\Hamahang\Help2SeeAlso;
use Datatables;
use DB;

class HelpController extends Controller
{

    public function AddSeeAlsoHelp()
    {
        $cnt = Help2SeeAlso::where('help_1_id', '=', deCode(\Request::get('help_id')))
            ->where('help_2_id', '=', \Request::get('see_also_id'))->get()->count();
        if ($cnt == 0) {
            Help2SeeAlso::create([
                'help_1_id' => deCode(\Request::get('help_id')),
                'help_2_id' => \Request::get('see_also_id')
            ]);
        }
        return [
            'see_also_id' => enCode(\Request::get('see_also_id')),
            'success' => true
        ];
    }
    public function RemoveSeeAlsoHelp()
    {
        $help_id = deCode(\Request::get('help_id'));
        $help = Help2SeeAlso::where('id', '=', $help_id);
        if($help->delete())
            return json_encode(['status' => true]);
        return json_encode(['status' => false]);
    }

    public function help($Uname)
    {
        $variable_generator = variable_generator('user', 'desktop', $Uname);
        return view('hamahang.help.help', $variable_generator);
    }

    public function HelpContent()
    {
        $help = DB::table('hamahang_helps')
            ->leftJoin('hamahang_help_blocks', 'hamahang_help_blocks.help_id', '=', 'hamahang_helps.id')
            ->whereNull('hamahang_helps.deleted_at')
            ->whereNull('hamahang_help_blocks.deleted_at')
            ->select('hamahang_helps.*', DB::raw('count(*) as total'))
            ->groupBy('hamahang_help_blocks.help_id')
            ->get();

//        $help = DB::table('hamahang_helps_new')
//            ->whereNull('hamahang_helps_new.deleted_at')
//        $help = DB::table('hamahang_helps')
//            ->whereNull('hamahang_helps.deleted_at')
//            ->get();
        $r = Datatables::of($help)
            ->editColumn('id', function ($q) {
                return enCode($q->id);
            })
            ->make(true);
        return $r;
    }

    public function help_content()
    {
        //$help = Help::query();
        $help = Help::whereHas('HelpBlocks');
        $r = Datatables::eloquent($help)
            ->editColumn('id', function ($q) {
                return enCode($q->id);
            })
            ->addColumn('blocks_count', function ($q) {
                return $q->blocks_count;
            })
            ->addColumn('usages', function ($q) {
                $r = null;
                $PRE_r = [];
                $items = $q->usages;
                foreach ($items as $item) {
                    $PRE_r[] = '<a href="' . url($item->id) . '" target="_blank">' . $item->subject->title . '</a>';
                }
                $r = implode(', ', $PRE_r);
                return $r ? $r : '-';
            })
            ->addColumn('see_also', function ($q) {
                $r = null;
                $PRE_r = [];
                $items = $q->SeeAlsos;
                foreach ($items as $item) {
                    $PRE_r[] = $item->title;
                }
                $r = '<a class="jsPanels" href="' . route('modals.help.seealso') . '?id=' . enCode($q->id) . '">' . (empty($PRE_r) ? 'بدون پیوند' : implode(', ', $PRE_r)) . '<a>';
                return $r;
            })
            ->rawColumns(['usages', 'see_also'])
            ->make(true);
        return $r;
    }

    public function AddHelpPermission()
    {
        DB::table('hamahang_help_relations')->insert
        ([
            'target_type' => 'App\Permission',
            'target_id' => \Request::input('permission_id'),
            'help_id' => deCode(\Request::input('help_id')),
            'created_by' => auth()->id(),
        ]);
    }

    public function TakeHelpPermissions()
    {
        $result['data'] = DB::table('hamahang_help_relations')
            ->leftJoin('permissions', '')
            ->where('help_id', '=', deCode(\Request::input('help_id')))
            ->get();
        return json_encode($result);
    }

}

