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

    public function help_content()
    {
        //$help = Help::query();
        $help = DB::table('hamahang_helps')
            ->leftJoin('hamahang_help_blocks','hamahang_help_blocks.help_id','=','hamahang_helps.id')
            ->whereNull('hamahang_helps.deleted_at')
            ->whereNull('hamahang_help_blocks.deleted_at')
            ->select('hamahang_helps.*', DB::raw('count(*) as total'))
            ->groupBy('hamahang_help_blocks.help_id')
            ->get();
        $r = Datatables::of($help)
            ->editColumn('id', function ($q) { return enCode($q->id); })
            ->addColumn('blocks_count', function ($q) { return $q->total; })
//            ->addColumn('usages', function ($q)
//            {
//                $r = null;
//                $PRE_r = [];
//                $items = $q->usages;
//                foreach ($items as $item)
//                {
//                    $PRE_r[] = '<a href="' . url($item->id) . '" target="_blank">' . $item->subject->title . '</a>';
//                }
//                $r = implode(', ', $PRE_r);
//                return $r ? $r : '-';
//            })
//            ->addColumn('see_also', function ($q)
//            {
//                $r = null;
//                $PRE_r = [];
//                $items = $q->SeeAlsos;
//                foreach ($items as $item)
//                {
//                    $PRE_r[] = $item->title;
//                }
//                $r = '<a class="jsPanels" href="' . route('modals.help.seealso') . '?id=' . enCode($q->id) . '">' . (empty($PRE_r) ? 'بدون پیوند' : implode(', ', $PRE_r)) . '<a>';
//                return $r;
//            })
//            ->rawColumns(['usages', 'see_also'])
            ->make(true);
        return $r;
    }

}

