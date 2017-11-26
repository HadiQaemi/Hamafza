<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\Keyword;
use App\Models\hamafza\Subject;
use Request;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    static public function get_keywords($sid = -1, $paginate = 0)
    {
        $term = Request::input('term');
        $keywords = Keyword::where('title', 'like', "%$term%")->withCount
        (['subjects' => function($q)
        {
            $q->where('kind', '11');
        }])->whereHas('subjects', function($q)
        {
            $q->where('kind', '11');
        });
        if ($paginate)
        {
            $r = $keywords->paginate($paginate);
        } else
        {
            $r = $keywords->get();
        }
        //dd($sid);
        return $r;
    }

    public function index_ajax()
    {
        //$sid = Request::exists('sid') == false ? config('constants.default_enquiry_portal_id') : Request::get('sid');
        $kid = Request::get('tagid');
        $tab = Request::get('tab');
        $ord = Request::get('order');
        $ord_sort = 'asc' == $ord ? 'sortBy' : 'sortByDesc';
        switch ($tab)
        {
            case 20:
                if ($kid)
                {
                    //dd("kid: $kid");
                    $contents = \App\Models\hamafza\Subject::where('kind', '11')
                    ->whereHas('keywords', function($q) use ($kid)
                    {
                        $q->where('keywords.id', $kid);
                    })
                    ->orderBy('reg_date', $ord)->get();
                } else
                {
                    $contents = \App\Models\hamafza\Subject::where('kind', '11')->orderBy('reg_date', $ord)->get();
                }
            break;
        }
        $result = view('hamahang.news.news_ajax')->with(['contents' => $contents])->render();
        return response()->json(['success' => true, 'result' => $result]);
    }
}














































