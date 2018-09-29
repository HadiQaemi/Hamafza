<?php

namespace App\Http\Controllers\Services;

use DB;
use Request;
use Validator;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\hamafza\Post;
use App\Models\hamafza\Subject;

class PublicController extends Controller {

    public function GetSites() {
        try {
            $sites = DB::table('sites')->select(DB::Raw('name,url'))->get();
            return response()->json(['sites' => $sites, 'status' => "1"], 200)->header('Content-Type', 'text/plain');
        } catch (JWTException $e) {
            return response()->json(['sites' => 'failed', 'status' => "-1"], 200)->header('Content-Type', 'text/plain');
        }
    }

    public function GetPortals() {
        $validator = Validator::make(Request::all(), [
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            $error = validation_error_to_api_json($validator->errors());
            $res = [
                'status' => "-1",
                'error' => $error
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if (!CheckToken(Request::input('token')) && !CheckTokenGustMode(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => ['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $res = [
            'status' => "1",
            'main' => ['type' => '15', 'url' => 'api/v43/get_page_detail', 'data' => Get_Portals()]
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function searchKeywords() {

        //$keyword_types = ['special' => 'تخصص&zwnj;ها', 'subject' => 'صفحات', 'enquiry_pages' => 'صفحات دیگر', ];
        $request_keywords = Request::input('keywords') !== "" ? explode(",", Request::input('keywords')) : [];
        $keywords['special'] = User::whereHas('specials', function ($q) use ($request_keywords) {
            return $q->whereIn('keywords.id', $request_keywords);
        });
        $keywords['subject'] = Subject::whereHas('keywords', function ($q) use ($request_keywords) {
            return $q->whereIn('keywords.id', $request_keywords);
        });
        $keywords['enquiry_pages'] = Post::whereHas('keywords', function ($q) use ($request_keywords) {
            return $q->whereIn('post_keys.kid', $request_keywords);
        })->with('subject');
        if (Request::input('isAnd') == 1) {
            foreach ($request_keywords as $request_keyword) {
                $keywords['special'] = User::whereHas('specials', function ($q) use ($request_keyword) {
                    return $q->where('keywords.id', $request_keyword);
                });
                $keywords['subject'] = Subject::whereHas('keywords', function ($q) use ($request_keyword) {
                    return $q->where('keywords.id', $request_keyword);
                });
                $keywords['enquiry_pages'] = Post::whereHas('keywords', function ($q) use ($request_keyword) {
                    return $q->where('post_keys.kid', $request_keyword);
                })->with('subject');
            }
        }
        $keywords['subject']->Join('pages as p','subjects.id','=','p.sid')->select('p.id','subjects.title');
        $keywords['special'] = $keywords['special']->get();
        $keywords['subject'] = $keywords['subject']->get();
        $keywords['enquiry_pages'] = $keywords['enquiry_pages']->get();
        $r = [
            'keywords' => $keywords,
            //'keyword_types' => $keyword_types,
        ];
        return $r;
    }

    public function search() {
        $r = null;
        $posts = null;
        $searchs = ['posts', 'pages' => ['title', 'content']];
        $term = trim(Request::input('term'));
        $for_title = (bool) Request::input('for_title', false);
        $for_content = (bool) Request::input('for_content', false);
        $in_posts = (bool)Request::input('in_posts', false);
        $in_pages = (bool) Request::input('in_pages', false);

        if ($in_pages && $for_title) {
            $searchs['pages']['title'] = Subject::where('title', 'like', "%$term%")
                ->where('list', '1')
                ->where('archive', '0')
                ->whereHas('pages')
                ->with('pages')
                ->get();
        }

        if ($in_pages && $for_content) {
            $searchs['pages']['content'] = \App\Models\hamafza\Pages::where('body', 'like', "%$term%")
                ->with('subject', 'subject.tabs')
                ->get();
        }

        if ($in_posts) {
            $searchs['posts'] = Post::where(function ($query) use ($term, $for_title, $for_content) {
                if ($for_title) {
                    $posts = $query->orWhere('title', 'like', "%$term%");
                }
                if ($for_content) {
                    $posts = $query->orWhere('desc', 'like', "%$term%");
                }
            })->whereHas('subject')->with('subject')->get();
        }
        $r = [
            'searchs' => $searchs,
            'term' => $term,
            'in_posts' => $in_posts,
            'in_pages' => $in_pages,
            'for_title' => $for_title,
            'for_content' => $for_content,
        ];

        return $r;
    }

}
