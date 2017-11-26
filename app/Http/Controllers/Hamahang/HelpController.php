<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
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
        $help = Help::query();
        $r = Datatables::eloquent($help)
            ->editColumn('id', function ($q) { return enCode($q->id); })
            ->addColumn('usage_count', function ($q) { return $q->usage_count; })
            ->addColumn('usages', function ($q) { return '-'; })
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
            ->rawColumns(['see_also'])
            ->make(true);
        return $r;
    }

}

