<?php

namespace App\Http\Controllers\Hamahang;

use Request;
use Validator;
use App\Models\hamafza\Post;
use App\Models\Hamahang\Vote;
use App\Http\Controllers\Controller;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function set()
    {
        $validator = Validator::make
        (
            Request::all(),
            [
                'target_table' => 'required',
                'target_id' => 'required',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $target_table = Request::get('target_table');
        $target_id = Request::get('target_id');
        $type = Request::get('type');
        $get_vote = Vote::getVote($target_table, $target_id, auth()->id());
        $post = Post::find($target_id);
        $do_job = false;
        switch ($type)
        {
            case +1:
            case 'up':
                if ($get_vote)
                {
                    Vote::voteOff($target_table, $target_id);
                    score_real_unregister($target_table, $target_id);
                    score_real_unregister($target_table, $target_id, $post->uid);
                    if (-1 == $get_vote)
                    {
                        $do_job = true;
                        /*
                        Vote::voteUp($target_table, $target_id);
                        score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '17' : '19')));
                        score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '21' : '23')), $post->uid);
                        */
                    }
                } else
                {
                    $do_job = true;
                    /*
                    Vote::voteUp($target_table, $target_id);
                    score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '17' : '19')));
                    score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '21' : '23')), $post->uid);
                    */
                }
                if ($do_job)
                {
                    Vote::voteUp($target_table, $target_id);
                    score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '17' : '19')));
                    score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '21' : '23')), $post->uid);
                }
                break;
            case -1:
            case 'down':
                if ($get_vote)
                {
                    Vote::voteOff($target_table, $target_id);
                    score_real_unregister($target_table, $target_id);
                    score_real_unregister($target_table, $target_id, $post->uid);
                    if (+1 == $get_vote)
                    {
                        $do_job = true;
                        /*
                        Vote::voteDown($target_table, $target_id);
                        score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '18' : '20')));
                        score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '22' : '24')), $post->uid);
                        */
                    }
                } else
                {
                    $do_job = true;
                    /*
                    Vote::voteDown($target_table, $target_id);
                    score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '18' : '20')));
                    score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '22' : '24')), $post->uid);
                    */
                }
                if ($do_job)
                {
                    Vote::voteDown($target_table, $target_id);
                    score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '18' : '20')));
                    score_register('App\Models\hamafza\Post', $target_id, config('score.' . (2 == $post->type ? '22' : '24')), $post->uid);
                }
                break;
        }

        $get_vote = Vote::getVote($target_table, $target_id, auth()->id());
        $get_sum = Vote::getSum($target_table, $target_id);

        return response()->json(['success' => true, 'result' => [ $get_vote, $get_sum, ]]);
    }

    /*
    public function get()
    {
    }
    */
}

