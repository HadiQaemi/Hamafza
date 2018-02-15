<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\Pages;
use App\Models\Hamahang\Help;
use Datatables;

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
        $help = Help::whereHas('HelpBlocks');
        $r = Datatables::eloquent($help)
            ->editColumn('id', function ($q) { return enCode($q->id); })
            ->addColumn('blocks_count', function ($q) { return $q->blocks_count; })
            ->addColumn('usages', function ($q)
            {
                $r = null;
                $PRE_r = [];
                $items = $q->usages;
                foreach ($items as $item)
                {
                    $PRE_r[] = '<a href="' . url($item->id) . '" target="_blank">' . $item->subject->title . '</a>';
                }
                $r = implode(', ', $PRE_r);
                return $r ? $r : '-';
            })
            ->addColumn('see_also', function ($q)
            {
                $r = null;
                $PRE_r = [];
                $items = $q->SeeAlsos;
                foreach ($items as $item)
                {
                    $PRE_r[] = $item->title;
                }
                $r = '<a class="jsPanels" href="' . route('modals.help.seealso') . '?id=' . enCode($q->id) . '">' . (empty($PRE_r) ? 'بدون پیوند' : implode(', ', $PRE_r)) . '<a>';
                return $r;
            })
            ->rawColumns(['usages', 'see_also'])
            ->make(true);
        return $r;
    }

}

