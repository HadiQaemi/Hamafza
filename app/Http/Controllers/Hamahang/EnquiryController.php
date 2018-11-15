<?php

namespace App\Http\Controllers\Hamahang;

use DB;
use Request;
use Validator;
use Datatables;
use App\Models\hamafza\Post;
use App\Models\hamafza\Subject;
use App\Models\hamafza\Keyword;
use App\Http\Controllers\Controller;

class EnquiryController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    static public function get_keywords($sid = -1, $paginate = 0)
    {
        $sid = -1 == $sid ? config('constants.default_enquiry_portal_id') : $sid;
        $sub_kind = Subject::find($sid)->sub_kind;
        $sub_kind = 0 == $sub_kind ? 2 : $sub_kind;
        $term = Request::input('term');
        $keywords = Keyword::where('title', 'like', "%$term%")->withCount
        ([
            'questions' => function ($query) use ($sid, $sub_kind)
            {
                $query->where('portal_id', $sid)->where('type', $sub_kind);
            }
        ])->whereHas('questions', function ($query) use ($sid)
        {
            $query->where('portal_id', $sid);
        });
        if ($paginate)
        {
            $r = $keywords->paginate($paginate);
        } else
        {
            $r = $keywords->get();
        }
        return $r;
    }

    public function index_ajax_sidebar()
    {
        $sid = Request::exists('sid') == false ? config('constants.default_enquiry_portal_id') : Request::get('sid');
        $sub_kind = Subject::find($sid)->sub_kind;
        $sub_kind = 0 == $sub_kind ? 2 : $sub_kind;
        $no_empty = Request::get('no_empty');
        $keywords_results = Keyword::withCount(
        [
            'questions' => function ($query) use ($sid, $sub_kind)
            {
                $query->where('portal_id', $sid)->where('type', $sub_kind);
            }
        ]);
        if ('true' == $no_empty)
        {
            $keywords_results = $keywords_results->whereHas('questions', function ($query) use ($sid)
            {
                $query->where('portal_id', $sid);
            });
        }
        return Datatables::eloquent($keywords_results)->make(true);
    }

    public function index($sid = false)
    {
        $sid = false;
        $sid = $sid == false ? config('constants.default_enquiry_portal_id') : $sid;
        $sub_kind = Subject::find($sid)->sub_kind;
        $sub_kind = 0 == $sub_kind ? 2 : $sub_kind;
        $posts = Post::where('type', $sub_kind)->where('portal_id', $sid)->orderBy('reg_date', 'desc')->get();
        if (Request::exists('tagid'))
        {
            $keyword = Keyword::find(Request::get('tagid'));
            return view('hamahang.Enquiry.enquiry_index')->with(['posts' => $posts, 'sub_kind' => $sub_kind, 'keyword' => $keyword]);
        }
        else
        {
            return view('hamahang.Enquiry.enquiry_index')->with(['posts' => $posts, 'sub_kind' => $sub_kind]);
        }
    }

    public function show_question($sid = false, $post_id)
    {
        $sub_kind = Subject::find($sid / 10)->sub_kind;
        $res = variable_generator('page','enquiry',$sid, ['post_id' => $post_id]);
        $post = Post::find($post_id);
        $post->viewcount++;
        $post->save();
        switch ($sub_kind)
        {
            case 1:
                $title = 'نظر';
                break;
            case 3:
                $title = 'ایده';
                break;
            case 4:
                $title = 'تجربه';
                break;
            default:
                $title = 'پرسش';
                break;
        }
        $res['current_tab'] = "$sid/enquiry/$post_id";
        array_pop($res['tabs']);
        array_pop($res['tabs']);
        $res['tabs'][] =
        [
            'link' => "$sid/enquiry/$post_id",
            'href' => "$sid/enquiry/$post_id",
            'title' => $title,
            'selected' => true,
        ];
        return view($res['viewname'])->with($res);
    }

    public function index_ajax()
    {
        $sid = Request::exists('sid') == false ? config('constants.default_enquiry_portal_id') : Request::get('sid');
        $sub_kind = Subject::find($sid)->sub_kind;
        $sub_kind = 0 == $sub_kind ? 2 : $sub_kind;
        $kid = Request::get('tagid');
        $tab = Request::get('tab');
        $ord = Request::get('order');
        $ord_sort = 'asc' == $ord ? 'sortBy' : 'sortByDesc';
        switch ($tab)
        {
            case 20:
                if ($kid)
                {
                    $posts = Keyword::find($kid)->questions()->where('portal_id', $sid)->where('type', $sub_kind)->orderBy('reg_date', $ord)->get();
                } else
                {
                    $posts = Post::where('portal_id', $sid)->where('type', $sub_kind)->orderBy('reg_date', $ord)->get();
                }
            break;
            case 30:
                if ($kid)
                {
                    $posts = Keyword::find($kid)->questions->where('portal_id', $sid)->where('type', $sub_kind)->$ord_sort('TotalReward');
                } else
                {
                    $posts = Post::where('portal_id', $sid)->where('type', $sub_kind)->get()->$ord_sort('TotalReward');
                }
            break;
            case 40:
                if ($kid)
                {
                    //$posts = Keyword::find($kid)->questions->where('portal_id', $sid)->where('type', $sub_kind)->$ord_sort('reg_date');
                    $posts = [];
                } else
                {
                    $posts = Post::where('portal_id', $sid)->where('type', $sub_kind)->orderBy(DB::raw('GET_POST_ANSWER_COUNT(`id`)'), $ord)->orderBy(DB::raw('GET_POST_VOTE_COUNT(`id`)'), $ord)->get();
                    /*
                    DB::enableQueryLog();
                    //dd(DB::getQueryLog());
                    $posts = Post::where('portal_id', $sid)->where('type', '2')->orderBy('reg_date', $ord)->get();
                    DB::enableQueryLog();
                    $post_results = DB::table('posts AS P')
                        ->join('posts AS A', 'P.id', '=', 'A.parent_id')
                        ->select('P.*')
                        ->get();
                    dd(DB::getQueryLog());
                    $select =
                    "
                    SELECT
                        *
                    FROM
                        `posts`
                    WHERE
                        `portal_id` = 44131
                    ORDER BY
                        GET_POST_ANSWER_COUNT(`id`),
                        GET_POST_VOTE_COUNT(`id`),
                        GET_POST_REWARD_COUNT(`id`)
                    ";
                    $posts = DB::select($select);
                    */
                }
            break;
            case 50:
                if ($kid)
                {
                    $posts = Keyword::find($kid)->questions->where('portal_id', $sid)->where('type', $sub_kind)->$ord_sort('VoteCount');
                } else
                {
                    $posts = Post::where('portal_id', $sid)->where('type', '2')->get()->$ord_sort('VoteCount');
                }
            break;
        }
        $result = view('hamahang.Enquiry.enquiry_ajax')->with(['posts' => $posts, 'sid'=>$sid, 'sub_kind' => $sub_kind])->render();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function create()
    {

    }

    public function answer()
    {
        $validator = Validator::make
        (
            Request::all(),
            [
                'parent_id' => 'required',
                'desc' => 'required',
            ],
            [
                'desc.required' => 'پاسخ تان را بنویسید.',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $parent_id = Request::get('parent_id');
        $desc = Request::get('desc');

        $post = new Post;
        $post->parent_id = $parent_id;
        $post->uid = auth()->id();
        $post->type = 201;
        $post->desc = $desc;
        $post->reg_date = time();
        $result = $post->save();

        score_register('App\Models\hamafza\Post', $post->id, config('score.7'));

        return response()->json(['success' => true, 'result' => [$result, ]]);

    }

    public function accept()
    {
        $validator = Validator::make
        (
            Request::all(),
            [
                'answer_id' => 'required',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $answer_id = Request::get('answer_id');

        $post_state = Post::find(Post::find($answer_id)->parent_id);

        if ($post_state->uid == auth()->id() && !$post_state->accept)
        {
            $post = Post::find($post_state->id);
            $post->accepted = 1;
            $post->save();
            $answer = Post::find($answer_id);
            $answer->accepted = 1;
            $answer->save();

            return response()->json(['success' => 1, 'result' => []]);
        }
        else
        {
            return response()->json(['success' => 0, 'result' => []]);
        }
        {

        }
    }

    public function get()
    {
        $validator = Validator::make
        (
            Request::all(),
            [
                'what' => 'required',
            ]
        );
        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }
        $r = null;
        $what = Request::get('what');
        $sid = Request::input('sid', 0);
        $sub_kind = Request::input('sub_kind', 0);
        $sub_kind = 2 == $sub_kind ?  0 : $sub_kind;
//        db::enableQueryLog();
        switch ($what)
        {
            case 'portals':
//                $subject_result = Subject::where('kind', '20')->where('sub_kind', $sub_kind)->select(['id', 'title']);
                $subject_result = Subject::whereIn('kind', ['20', '21', '22', '27'] )->select(['id', 'title']);
                if ($sid)
                {
                    $subject_result = $subject_result->where('id', $sid);
                }
                $subject_result = $subject_result->get();
                $r = json_encode($subject_result->toArray());
            break;
        }
//        dd(db::getQueryLog());
        return response()->json(['success' => true, 'result' => [$r]]);
    }

}

