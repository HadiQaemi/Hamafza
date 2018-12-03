<?php

namespace App\HamafzaServiceClasses;

use DB;
use Auth;
use App\User;
use App\Models\Hamahang\Score;
use App\Models\Hamahang\Reward;
use App\Models\Hamahang\BasicdataValue;
use App\HamafzaPublicClasses\FunctionsClass;

class PostsClass {

    public static function strip_word_html($text, $allowed_tags = '<b><i><sup><sub><em><strong><u><br><a><br /><br/>') {
        mb_regex_encoding('UTF-8');
        //replace MS special characters first
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        //make sure _all_ html entities are converted to the plain ascii equivalents - it appears
        //in some MS headers, some html entities are encoded and some aren't
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        //try to strip out any C style comments first, since these, embedded in html comments, seem to
        //prevent strip_tags from removing html comments (MS Word introduced combination)
        if (mb_stripos($text, '/*') !== FALSE) {
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
        //'<1' becomes '< 1'(note: somewhat application specific)
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        //strip out inline css and simplify style tags
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
        //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains
        //some MS Style Definitions - this last bit gets rid of any leftover comments */
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if ($num_matches) {
            $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
        return $text;
    }

    public static function Sharepost($uid, $sesid, $ShareGroup, $users, $emails, $inmypage, $descr, $post_id, $content) {
        $p = DB::table('posts as p')->join('user as u', 'p.uid', '=', 'u.id')->where('p.id', $post_id)
                        ->select('desc', 'p.pic', 'title', 'u.Name', 'u.Family')->first();
        if ($p) {
            $content = $p->desc;
            $title = 'بازنشر: ' . $p->title;
            if ($p->pic != '') {
                $content = '<img src="' . config('constants.SiteAddress') . '/uploads/' . $p->pic . '"><br>' . $content;
            }
            $content = $descr . '<hr><br>' . $p->Name . ' ' . $p->Family . ' نوشته است<br>' . $content;
        }
        $forgroup = false;


        if (is_array($emails) && count($emails) > 0) {
            $p = DB::table('user')->where('id', $uid)
                            ->select('Name', 'Family')->first();
            if ($p) {
                $N = $p->Name . ' ' . $p->Family;
            }
            $title = "$N برای شما یک مطلب را باز نشر کرده است";
            foreach ($emails as $value) {
                return Alerts::Email($title, $content, '', $value);
            }
        }
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        if (is_array($users) && count($users) > 0) {
            $tid = DB::table('tickets')->insertGetId(array('uid' => $uid, 'title' => $title, 'login' => '0', 'reg_date' => $reg_date));
            DB::table('ticket_answer')->insert(array('uid' => $uid, 'tid' => $tid, 'comment' => $content, 'reg_date' => $reg_date));
            foreach ($users as $value) {
                if (intval($value) != 0) {
                    DB::table('ticket_recieve')->insert(array('tid' => $tid, 'uid' => $value));
                }
            }
        }
        $ShareGroup = str_replace('"', '', $ShareGroup);
        $ShareGroup = explode(',', $ShareGroup);
        if (is_array($ShareGroup) && count($ShareGroup)) {
            $forgroup = true;
            $time = time();
            $pid = DB::table('posts')->insertGetId(array('uid' => $uid, 'shid' => $post_id, 'desc' => $descr, 'reg_date' => $time));
            foreach ($ShareGroup as $value) {
                if (intval($value) != 0) {
                    DB::table('post_view')->insert(array('pid' => $pid, 'gid' => $value, 'view' => '1'));
                }
            }
        }
        if ($inmypage && $forgroup == false) {
            $pid = DB::table('posts')->insertGetId(array('uid' => $uid, 'shid' => $post_id, 'desc' => $descr, 'reg_date' => $time));
        }

        $table = 'انجام شد';
        $err = false;
        return $table;
    }

    public static function GetPost($uid, $postid, $sesid) {
        $UC = new UserClass();
        $table = DB::table('posts as p')
                        ->distinct()->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                        ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                        ->leftjoin('post_like as pl', 'pl.pid', '=', 'p.id')
                        ->where('p.id', $postid)
                        ->select('p.title', 'v.gid', 'pl.id as islike', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->get();
        $nums = 0;
        foreach ($table as $row) {
            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
            $row->desc = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row->desc);
            $row->desc = PostsClass::strip_word_html($row->desc);
            $row->type = PostsClass::PostType($row->type);
            $GR = DB::table('user_group')
                            ->where('id', $row->gid)->select('isorgan', 'name', 'link', 'uid', 'pic')->first();

            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->OrganName = $GR->name;
                $row->Organlink = '';
                $row->Organlink = $GR->link;
                $row->OrganPic = $GR->pic;
            }


            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->InsertedOrgan = $GR->name;
                $row->InsertedOrganlink = $GR->link;
            } else {
                $row->InsertedOrgan = '';
                $row->InsertedOrganlink = '';
            }

            if ($row->gid != '' && $GR->isorgan == '0') {
                $row->InsertedGroup = $GR->name;
                $row->InsertedGrouplink = $GR->link;
            } else {
                $row->InsertedGroup = '';
                $row->InsertedGrouplink = '';
            }
            if ($row->sid != '0') {
                $GR = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')
                                ->where('s.id', $row->sid)->select('s.title', 'p.id')->first();
                if ($GR) {
                    $row->InsertedSubject = $GR->title;
                    $row->InsertedSubjectlink = $GR->id;
                } else {
                    $row->InsertedSubject = '';
                    $row->InsertedSubjectlink = '';
                }
            } else {
                $row->InsertedSubject = '';
                $row->InsertedSubjectlink = '';
            }

            $keys = DB::table('post_keys as pk')
                            ->join('keywords as k', 'k.id', '=', 'pk.kid')
                            ->where('pid', $row->id)
                            ->select('k.id', 'k.title')->take(10)->get();

            $row->keywords = $keys;
            $tables = DB::table('post_comment as p')
                            ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                            ->where('pid', $row->id)
                            ->orderBy('reg_date')->select('p.id', 'p.comment', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic')->take(10)->get();
            foreach ($tables as $rows) {
                $rows->reg_date = PublicsClass::timeAgo($rows->reg_date);
                $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                $rows->comment = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $rows->comment);
            }
            $row->comments = $tables;
            $useID = $row->uid;
            $pic = 'pics/user/Users.png';
            if (trim($row->Pic) != '') {
                $pic = 'pics/user/' . $row->Pic;
            }


            $text = PostsClass::strip_word_html($row->desc);

            $Uname = $row->Uname;
            $row->reg_date = PublicsClass::timeAgo($row->reg_date);
            if ($row->shid != '0') {
                $tables = DB::table('posts as p')
                                ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                                ->where('p.id', $row->shid)->select('p.title', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->first();
                if ($tables) {
                    $row->share_user = $tables->Name . '  ' . $tables->Family;
                    $row->share_userlink = $tables->Uname;
                    $row->share_content = $tables->Uname;
                    $row->share_pic = $tables->pic;
                    $row->share_video = $tables->video;
                    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                    $row->share_content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $tables->desc);
                } else {
                    $row->shid = 0;
                }
            }
        }
        $err = false;
        return $table;
    }

    public static function WallCount($uid) {
        $wallCount = 0;
        $pc = new PostsClass();
        $sr = $pc->postSelect('user', 'wall', $uid, 1, $uid);
        // $sr .= ' OR p.id = 1';
        $table = DB::table('posts as p')
                        ->distinct()->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                        ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                        ->whereRaw($sr)->where('p.read', '0')->count();
        return $table - 1;
    }

    public static function PosetDelete($id) {
        DB::table('post_comment')->where('pid', $id)->delete();
        DB::table('post_like')->where('pid', $id)->delete();
        DB::table('post_keys')->where('pid', $id)->delete();
        DB::table('posts')->where('id', $id)->delete();
    }

    public static function CommentDelete($id) {
        DB::table('post_comment')->where('id', $id)->delete();
    }

    public static function delpage($id) {
        DB::table('subjects')->where('id', $id)->update(array('archive' => '1'));
        $pages = DB::table('pages')->where('sid', $id)->select('id')->get();
        foreach ($pages as $value) {
            DB::table('bookmarks')->where('link', $value->id)->delete();
        }
    }

    public static function GetSecGroup($uid, $sesid) {
        $user = UserClass::CheckLogin($uid, $sesid);
        $user = ($user == TRUE) ? 'true' : 'false';
        $err = true;
        $message = trans('labels.FailUser');
        if ($user) {
            $message = DB::table('sec_groups as a')->select('id', 'name')->get();
            $err = false;
        }
        return Response::json(array(
                    'error' => $err,
                    'data' => $message), 200
                )->setCallback(Input::get('callback'));
    }

    public function SubjectWall_rightCol($sid, $uid, $count) {
        $sr = PostsClass::postSelect('subject', 'contents', $sid, 1, $sid);
        // $sr .= ' OR p.id = 1';
        config('app.temp', $uid);
        $table = DB::table('posts as p')
                        ->distinct()->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                        ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                        ->whereRaw($sr)
                        ->orderBy('p.id', 'desc')->select('p.title', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->take($count)->get();
        $nums = 0;
        foreach ($table as $row) {
            if (trim($row->title) == '') {
                $charset = 'UTF-8';
                $length = 50;
                $string = $row->desc;
                if (mb_strlen($string, $charset) > $length) {
                    $string = mb_substr($string, 0, $length - 3, $charset) . '...';
                }
                $row->title = $string;
            }
            $useID = $row->uid;
            $text = PostsClass::strip_word_html($row->desc);

            $Uname = $row->Uname;
            $nums++;
            // $row->reg_date = PublicsClass::timeAgo($row->reg_date);
        }
        if ($nums == 0) {
            $table = trans('labels.rhightcol_pagewall_no_data');
        }
        return $table;
    }

    public function SubjectWall($sid, $uid, $sesid, $in = 'json') {
        $sr = PostsClass::postSelect('subject', 'contents', $sid, 1, $sid);
        config('app.temp', $uid);
        $table = DB::table('posts as p')
                        ->distinct()->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                        ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                        ->leftjoin('post_like as pl', function ($join) {
                            $value = config('app.temp');
                            $join->on('pl.pid', '=', 'p.id')
                            ->where('pl.uid', '=', $value);
                        })
                        ->whereRaw($sr)
                        ->orderBy('p.id', 'desc')->select('p.title', 'pl.id as islike', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic as Pic', 'p.accepted')->take(10)->get();
        $nums = 0;
        foreach ($table as $row) {
            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
            $row->desc = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row->desc);
            $row->desc = PostsClass::strip_word_html($row->desc);

            $row->InsertedOrgan = '';
            $row->InsertedOrganlink = '';

            $row->InsertedGroup = '';
            $row->InsertedGrouplink = '';

            $row->InsertedSubject = '';
            $row->InsertedSubjectlink = '';
            $keys = DB::table('post_keys as pk')
                            ->join('keywords as k', 'k.id', '=', 'pk.kid')
                            ->where('pid', $row->id)
                            ->select('k.id', 'k.title')->take(10)->get();

            $row->keywords = $keys;

            $tables = DB::table('post_comment as p')
                            ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                            ->where('pid', $row->id)
                            ->orderBy('reg_date')->select('p.id', 'p.comment', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->take(10)->get();
            foreach ($tables as $rows) {
                $rows->reg_date = PublicsClass::timeAgo($rows->reg_date);
                $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                $rows->comment = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $rows->comment);
            }
            $row->comments = $tables;
            $useID = $row->uid;
            $pic = 'pics/user/Users.png';
            if (trim($row->Pic) != '') {
                $pic = 'pics/user/' . $row->Pic;
            }

            $row->type = PostsClass::PostType($row->type);

            $text = $row->desc;
            $Uname = $row->Uname;
            $row->reg_date = PublicsClass::timeAgo($row->reg_date);
            if ($row->shid != '0') {
                $tables = DB::table('posts as p')
                                ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                                ->where('p.id', $row->shid)->select('p.title', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->first();
                if ($tables) {
                    $row->share_user = $tables->Name . '  ' . $tables->Family;
                    $row->share_userlink = $tables->Uname;
                    $row->share_content = $tables->Uname;
                    $row->share_pic = $tables->pic;
                    $row->share_video = $tables->video;
                    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                    $row->share_content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $tables->desc);
                } else {
                    $row->shid = 0;
                }
            }
        }
        $message = $table;
        $err = false;
        if ($in == 'json') {
            return FunctionsClass::JSON($message, $err);
        } else {
            return $message;
        }
    }

    public function SubjectWallJson($sid, $uid, $sesid, $in = 'json', $lastpostid) {
        $user = UserClass::CheckLogin($uid, $sesid);
        $user = ($user == TRUE) ? 'true' : 'false';
        if ($user) {
            $sr = PostsClass::postSelect('subject', 'contents', $sid, 1, $sid);
            // $sr .= ' OR p.id = 1';
            config('app.temp', $uid);
            $table = DB::table('posts as p')
                            ->distinct()->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                            ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                            ->leftjoin('post_like as pl', function ($join) {
                                $value = config('app.temp');
                                $join->on('pl.pid', '=', 'p.id')
                                ->where('pl.uid', '=', $value);
                            })
                            ->whereRaw($sr)->where('p.id', '<', $lastpostid)
                            ->orderBy('p.id', 'desc')->select('p.title', 'pl.id as islike', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic as Pic')->take(10)->get();
            $nums = 0;
            foreach ($table as $row) {
                $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                $row->desc = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row->desc);
                $row->desc = PostsClass::strip_word_html($row->desc);

                $row->InsertedOrgan = '';
                $row->InsertedOrganlink = '';

                $row->InsertedGroup = '';
                $row->InsertedGrouplink = '';

                $row->InsertedSubject = '';
                $row->InsertedSubjectlink = '';
                $keys = DB::table('post_keys as pk')
                                ->join('keywords as k', 'k.id', '=', 'pk.kid')
                                ->where('pid', $row->id)
                                ->select('k.id', 'k.title')->take(10)->get();

                $row->keywords = $keys;

                $tables = DB::table('post_comment as p')
                                ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                                ->where('pid', $row->id)
                                ->orderBy('reg_date')
                                ->select('p.id', 'p.comment', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')
                                ->take(10)->get();
                foreach ($tables as $rows) {
                    $rows->reg_date = PublicsClass::timeAgo($rows->reg_date);
                    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                    $rows->comment = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $rows->comment);
                }
                $row->comments = $tables;
                $useID = $row->uid;
                $pic = 'pics/user/Users.png';
                if (trim($row->Pic) != '') {
                    $pic = 'pics/user/' . $row->Pic;
                }

                $row->type = PostsClass::PostType($row->type);

                $text = $row->desc;
                $Uname = $row->Uname;
                $row->reg_date = PublicsClass::timeAgo($row->reg_date);
                if ($row->shid != '0') {
                    $tables = DB::table('posts as p')
                                    ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                                    ->where('p.id', $row->shid)
                                    ->select('p.title', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->first();
                    if ($tables) {
                        $row->share_user = $tables->Name . '  ' . $tables->Family;
                        $row->share_userlink = $tables->Uname;
                        $row->share_content = $tables->Uname;
                        $row->share_pic = $tables->pic;
                        $row->share_video = $tables->video;
                        $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                        $row->share_content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $tables->desc);
                    } else {
                        $row->shid = 0;
                    }
                }
            }
            $message = $table;
            $err = false;
        } else {
            $message = trans('labels.FailUser');
            $err = true;
        }
        if ($in == 'json') {
            return FunctionsClass::JSON($message, $err);
        } else {
            return $message;
        }
    }

    public function UserWall($uid, $num, $offset = 0,$fromAPI = false) {
        $sr = PostsClass::postSelect('user', 'wall', $uid, 1, $uid);
        // $sr .= ' OR p.id = 1';
        app('config')->set('app.temp', $uid);

        $table = DB::table('posts as p')
                ->distinct()->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                ->leftjoin('post_like as pl', function ($join) {
                    $join->on('pl.pid', '=', 'p.id')
                    ->where('pl.uid', '=', config('app.temp'));
                })
                ->whereRaw($sr)
                ->orderBy('p.id', 'desc')
                ->select('p.title', 'v.gid','pl.id as islike', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS '.($fromAPI ? 'uPic' :'Pic'), 'u.avatar')
                ->take($num)
                ->skip($offset)
                ->get();
        $nums = 0;
        foreach ($table as $row) {
            if ($row->avatar) {
                $row->avatar_img_url = route('FileManager.DownloadFile', ['type' => 'ID', 'id' => enCode($row->avatar), 'default_img' => 'user_avatar.png']);
            } else {
                $row->avatar_img_url = route('FileManager.DownloadFile', ['type' => 'ID', 'id' => enCode(-1), 'default_img' => 'user_avatar.png']);
            }
            if (trim($row->title) == '') {
                $charset = 'UTF-8';
                $length = 50;
                $string = $row->desc;
                if (mb_strlen($string, $charset) > $length) {
                    $string = mb_substr($string, 0, $length - 3, $charset) . '...';
                }
                $row->title = $string;
            }

            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
            $row->desc = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row->desc);
            $row->desc = PostsClass::strip_word_html($row->desc);

            $row->type = PostsClass::PostType($row->type);
            $GR = DB::table('user_group')
                            ->where('id', $row->gid)->select('isorgan', 'name', 'link', 'uid', 'pic')->first();

            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->OrganName = $GR->name;
                $row->Organlink = '';
                $row->Organlink = $GR->link;
                $row->OrganPic = $GR->pic;
            }

            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->InsertedOrgan = $GR->name;
                $row->InsertedOrganlink = $GR->link;
            } else {
                $row->InsertedOrgan = '';
                $row->InsertedOrganlink = '';
            }

            if ($row->gid != '' && $GR->isorgan == '0') {
                $row->InsertedGroup = $GR->name;
                $row->InsertedGrouplink = $GR->link;
            } else {
                $row->InsertedGroup = '';
                $row->InsertedGrouplink = '';
            }
            $row->comments = DB::table('post_comment as p')
                ->where('p.pid', '=', $row->id)
                ->select('uid','comment','reg_date','id')
                ->get();
        }
        return $table;
    }

    public function GetWallByPaging($user, $cuid, $num, $lastpostid) {
        $UC = new UserClass();
        $user = $UC->UserName2id($user);
        $sr = PostsClass::postSelect('user', 'wall', $user, 1, $user);
        //        // $sr .= ' OR p.id = 1';
        config('app.temp', $cuid);
        $table = DB::table('posts as p')
                        ->distinct()->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                        ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                        ->leftjoin('post_like as pl', function ($join) {
                            $value = config('app.temp');
                            $join->on('pl.pid', '=', 'p.id')
                            ->where('pl.uid', '=', $value);
                        })
                        ->whereRaw($sr)->where('p.id', '<', $lastpostid)
                        ->orderBy('p.id', 'desc')->select('p.title', 'v.gid', 'pl.id as islike', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->take($num)->get();
        $nums = 0;
        foreach ($table as $row) {
            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
            $row->desc = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row->desc);
            $row->desc = PostsClass::strip_word_html($row->desc);

            $row->type = PostsClass::PostType($row->type);
            $GR = DB::table('user_group')
                            ->where('id', $row->gid)->select('isorgan', 'name', 'link', 'uid', 'pic')->first();

            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->OrganName = $GR->name;
                $row->Organlink = '';
                $row->Organlink = $GR->link;
                $row->OrganPic = $GR->pic;
            }


            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->InsertedOrgan = $GR->name;
                $row->InsertedOrganlink = $GR->link;
            } else {
                $row->InsertedOrgan = '';
                $row->InsertedOrganlink = '';
            }

            if ($row->gid != '' && $GR->isorgan == '0') {
                $row->InsertedGroup = $GR->name;
                $row->InsertedGrouplink = $GR->link;
            } else {
                $row->InsertedGroup = '';
                $row->InsertedGrouplink = '';
            }
            if ($row->sid != '0') {
                $GR = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')
                                ->where('s.id', $row->sid)->select('s.title', 'p.id')->first();
                if ($GR) {
                    $row->InsertedSubject = $GR->title;
                    $row->InsertedSubjectlink = $GR->id;
                } else {
                    $row->InsertedSubject = '';
                    $row->InsertedSubjectlink = '';
                }
            } else {
                $row->InsertedSubject = '';
                $row->InsertedSubjectlink = '';
            }

            $keys = DB::table('post_keys as pk')
                            ->join('keywords as k', 'k.id', '=', 'pk.kid')
                            ->where('pid', $row->id)
                            ->select('k.id', 'k.title')->take(10)->get();

            $row->keywords = $keys;
            $tables = DB::table('post_comment as p')
                            ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                            ->where('pid', $row->id)
                            ->orderBy('reg_date')->select('p.id', 'p.comment', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic')->take(10)->get();
            foreach ($tables as $rows) {
                $rows->reg_date = PublicsClass::timeAgo($rows->reg_date);
                $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                $rows->comment = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $rows->comment);
            }
            $row->comments = $tables;
            $useID = $row->uid;
            $pic = 'pics/user/Users.png';
            if (trim($row->Pic) != '') {
                $pic = 'pics/user/' . $row->Pic;
            }


            $text = $row->desc;
            $Uname = $row->Uname;
            $row->reg_date = PublicsClass::timeAgo($row->reg_date);
            if ($row->shid != '0') {
                $tables = DB::table('posts as p')
                                ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                                ->where('p.id', $row->shid)->select('p.title', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->first();
                if ($tables) {
                    $row->share_user = $tables->Name . '  ' . $tables->Family;
                    $row->share_userlink = $tables->Uname;
                    $row->share_content = $tables->Uname;
                    $row->share_pic = $tables->pic;
                    $row->share_video = $tables->video;
                    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                    $row->share_content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $tables->desc);
                } else {
                    $row->shid = 0;
                }
            }
        }
        return FunctionsClass::JSON($table, false);
    }

    public function MyWall($user, $cuid, $num, $islocal = '') {
        //$UC = new UserClass();
        //$User = User::where('Uname', $user)->firstOrFail();
        $User = auth()->user();
        if ($User->Uname != $user) {
            abort(403);
        }
        $Aboute1 = [];
        $Aboute1['id'] = $User->id;
        $Aboute1['UName'] = $User->Uname;
        $Aboute1['Name'] = $User->Name;
        $Aboute1['Family'] = $User->Family;
        $Aboute1['Email'] = $User->Email;
        //$UserTabs = $UC->UserTabs($User->id, $Aboute1['UName'], $cuid);
        $res['preview'] = $Aboute1;
        //$res['Tabs'] = $UserTabs;
        $sr = PostsClass::postSelect('user', 'wall', $User->id, 1, $User->id);
        // $sr .= ' OR p.id = 1';
        $table = DB::table('posts as p')
                ->distinct()
                ->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                ->leftjoin('post_like as pl', function ($join) {
                    $join->on('pl.pid', '=', 'p.id')
                    ->where('pl.uid', '=', session('uid'));
                })
                ->whereRaw($sr)
                ->orderBy('p.id', 'desc')
                ->select('p.title', 'v.gid', 'pl.id as islike', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')
                //->take($num)
                ->get();
        $nums = 0;
        foreach ($table as $row) {
            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
            $row->desc = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row->desc);
            $row->desc = PostsClass::strip_word_html($row->desc);
            $row->type = PostsClass::PostType($row->type);
            $GR = DB::table('user_group')
                    ->where('id', $row->gid)
                    ->select('isorgan', 'name', 'link', 'uid', 'pic')
                    ->first();

            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->OrganName = $GR->name;
                $row->Organlink = '';
                $row->Organlink = $GR->link;
                $row->OrganPic = $GR->pic;
            }

            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->InsertedOrgan = $GR->name;
                $row->InsertedOrganlink = $GR->link;
            } else {
                $row->InsertedOrgan = '';
                $row->InsertedOrganlink = '';
            }

            if ($row->gid != '' && $GR->isorgan == '0') {
                $row->InsertedGroup = $GR->name;
                $row->InsertedGrouplink = $GR->link;
            } else {
                $row->InsertedGroup = '';
                $row->InsertedGrouplink = '';
            }
            if ($row->sid != '0') {
                $GR = DB::table('pages as p')
                        ->join('subjects as s', 's.id', '=', 'p.sid')
                        ->where('s.id', $row->sid)
                        ->select('s.title', 'p.id')
                        ->first();
                if ($GR) {
                    $row->InsertedSubject = $GR->title;
                    $row->InsertedSubjectlink = $GR->id;
                } else {
                    $row->InsertedSubject = '';
                    $row->InsertedSubjectlink = '';
                }
            } else {
                $row->InsertedSubject = '';
                $row->InsertedSubjectlink = '';
            }

            $keys = DB::table('post_keys as pk')
                    ->join('keywords as k', 'k.id', '=', 'pk.kid')
                    ->where('pid', $row->id)
                    ->select('k.id', 'k.title')
                    //->take(10)
                    ->get();

            $row->keywords = $keys;
            $tables = DB::table('post_comment as p')
                    ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                    ->where('pid', $row->id)
                    ->orderBy('reg_date')
                    ->select('p.id', 'p.comment', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic')
                    //->take(10)
                    ->get();
            foreach ($tables as $rows) {
                $rows->reg_date = PublicsClass::timeAgo($rows->reg_date);
                $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                $rows->comment = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $rows->comment);
            }
            $row->comments = $tables;
            $useID = $row->uid;
            $pic = 'pics/user/Users.png';
            if (trim($row->Pic) != '') {
                $pic = 'pics/user/' . $row->Pic;
            }
            $text = $row->desc;
            $Uname = $row->Uname;
            $row->reg_date = PublicsClass::timeAgo($row->reg_date);
            if ($row->shid != '0') {
                $tables = DB::table('posts as p')
                        ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                        ->where('p.id', $row->shid)
                        ->select('p.title', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')
                        ->first();
                if ($tables) {
                    $row->share_user = $tables->Name . '  ' . $tables->Family;
                    $row->share_userlink = $tables->Uname;
                    $row->share_content = $tables->Uname;
                    $row->share_pic = $tables->pic;
                    $row->share_video = $tables->video;
                    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                    $row->share_content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $tables->desc);
                } else {
                    $row->shid = 0;
                }
            }
        }
        $res['Posts'] = $table;
        if ($islocal == 'local') {
            return $res;
        } else {
            return \App\HamafzaPublicClasses\FunctionsClass::JSON($res, false);
        }
    }

    public function GetUserContentPaging($user, $cuid, $lastpostid) {
        $UC = new UserClass();
        $user = $UC->UserName2id($user);
        $sr = PostsClass::postSelect('user', 'content', $user, 1, $user);

        config('app.temp', $cuid);
        $table = DB::table('posts as p')
                        ->distinct()
                        ->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                        ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                        ->leftjoin('post_like as pl', function ($join) {
                            $value = config('app.temp');
                            $join->on('pl.pid', '=', 'p.id')
                            ->where('pl.uid', '=', $value);
                        })
                        ->whereRaw($sr)->where('p.id', '<', $lastpostid)
                        ->orderBy('p.id', 'desc')->select('v.gid', 'p.title', 'pl.id as islike', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->take(15)->get();

        $nums = 0;
        foreach ($table as $key => $row) {
            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
            $row->desc = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row->desc);
            $row->desc = PostsClass::strip_word_html($row->desc);

            $GR = DB::table('user_group')
                            ->where('id', $row->gid)->select('isorgan', 'name', 'link', 'uid', 'pic')->first();
            if ($GR && $row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                unset($table[$key]);
            }
            if ($GR && $row->gid != '' && $GR->isorgan == '1' && $GR->uid != $row->uid) {
                $row->InsertedOrgan = $GR->name;
                $row->InsertedOrganlink = $GR->link;
            } else {
                $row->InsertedOrgan = '';
                $row->InsertedOrganlink = '';
            }

            if ($GR && $row->gid != '') {
                $row->InsertedGroup = $GR->name;
                $row->InsertedGrouplink = $GR->link;
            } else {
                $row->InsertedGroup = '';
                $row->InsertedGrouplink = '';
            }
            if ($row->sid != '0') {
                $GR = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')
                                ->where('s.id', $row->sid)->select('s.title', 'p.id')->first();
                if ($GR) {
                    $row->InsertedSubject = $GR->title;
                    $row->InsertedSubjectlink = $GR->id;
                } else {
                    $row->InsertedSubject = '';
                    $row->InsertedSubjectlink = '';
                }
            } else {
                $row->InsertedSubject = '';
                $row->InsertedSubjectlink = '';
            }

            $keys = DB::table('post_keys as pk')
                            ->join('keywords as k', 'k.id', '=', 'pk.kid')
                            ->where('pid', $row->id)
                            ->select('k.id', 'k.title')->take(10)->get();

            $row->keywords = $keys;
            $tables = DB::table('post_comment as p')
                            ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                            ->where('pid', $row->id)
                            ->orderBy('reg_date')->select('p.id', 'p.comment', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->take(10)->get();
            foreach ($tables as $rows) {
                $rows->reg_date = PublicsClass::timeAgo($rows->reg_date);
                $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                $rows->comment = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $rows->comment);
            }
            $row->comments = $tables;

            $useID = $row->uid;
            $pic = 'pics/user/Users.png';
            if (trim($row->Pic) != '') {
                $pic = 'pics/user/' . $row->Pic;
            }
            $row->type = PostsClass::PostType($row->type);
            $text = $row->desc;
            $Uname = $row->Uname;
            $row->reg_date = PublicsClass::timeAgo($row->reg_date);
            if ($row->shid != '0') {
                $tables = DB::table('posts as p')
                                ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                                ->where('p.id', $row->shid)->select('p.title', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->first();
                if ($tables) {
                    $row->share_user = $tables->Name . '  ' . $tables->Family;
                    $row->share_userlink = $tables->Uname;
                    $row->share_content = $tables->Uname;
                    $row->share_pic = $tables->pic;
                    $row->share_video = $tables->video;
                    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                    $row->share_content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $tables->desc);
                } else {
                    $row->shid = 0;
                }
            }
        }
        return Response::json(array(
                    'error' => false,
                    'posts' => $table), 200
                )->setCallback(Input::get('callback'));
    }

    public function UserContent($user, $cuid, $islocal) {
        $UC = new UserClass();
        $User = DB::table('user as u')
                        ->where('u.id', $user)->distinct()
                        ->select('id', 'u.Uname', 'Name', 'Family', 'Pic', 'Email')->first();
        $Aboute = array();
        $Aboute1 = array();
        $Aboute1['id'] = $User->id;
        $Aboute1['UName'] = $User->Uname;
        $Aboute1['Name'] = $User->Name;
        $Aboute1['Family'] = $User->Family;
        $Aboute1['Email'] = $User->Email;
        $UserTabs = $UC->UserTabs($user, $Aboute1['UName'], $cuid);
        $res['preview'] = $Aboute1;
        $res['Tabs'] = $UserTabs;
        $sr = PostsClass::postSelect('user', 'content', $user, 1, $user);
//        // $sr .= ' OR p.id = 1';
        config('app.temp', $cuid);
        $table = DB::table('posts as p')
                        ->distinct()
                        ->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                        ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                        ->leftjoin('post_like as pl', function ($join) {
                            $value = config('app.temp');
                            $join->on('pl.pid', '=', 'p.id')
                            ->where('pl.uid', '=', $value);
                        })
                        ->whereRaw($sr)
                        ->orderBy('p.id', 'desc')
                        ->select('v.gid', 'p.title', 'pl.id as islike', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic', 'p.accepted')->take(10)->get(); //:TODO:why take 10 lazy load is off why is take 10
        $nums = 0;
        foreach ($table as $key => $row) {
            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
            $row->desc = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row->desc);
            $row->desc = PostsClass::strip_word_html($row->desc);
            $GR = DB::table('user_group')
                            ->where('id', $row->gid)->select('isorgan', 'name', 'link', 'uid', 'pic')->first();
//            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
//                unset($table[$key]);
//            }
            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid != $row->uid) {
                $row->InsertedOrgan = $GR->name;
                $row->InsertedOrganlink = $GR->link;
            } else {
                $row->InsertedOrgan = '';
                $row->InsertedOrganlink = '';
            }

            if ($row->gid != '') {
                $row->InsertedGroup = $GR->name;
                $row->InsertedGrouplink = $GR->link;
            } else {
                $row->InsertedGroup = '';
                $row->InsertedGrouplink = '';
            }
            if ($row->sid != '0') {
                $GR = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')
                                ->where('s.id', $row->sid)->select('s.title', 'p.id')->first();
                if ($GR) {
                    $row->InsertedSubject = $GR->title;
                    $row->InsertedSubjectlink = $GR->id;
                } else {
                    $row->InsertedSubject = '';
                    $row->InsertedSubjectlink = '';
                }
            } else {
                $row->InsertedSubject = '';
                $row->InsertedSubjectlink = '';
            }

            $keys = DB::table('post_keys as pk')
                            ->join('keywords as k', 'k.id', '=', 'pk.kid')
                            ->where('pid', $row->id)
                            ->select('k.id', 'k.title')->take(10)->get();
            $row->keywords = $keys;
            $tables = DB::table('post_comment as p')
                            ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                            ->where('pid', $row->id)
                            ->orderBy('reg_date')->select('p.id', 'p.comment', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->take(10)->get();
            foreach ($tables as $rows) {
                $rows->reg_date = PublicsClass::timeAgo($rows->reg_date);
                $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                $rows->comment = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $rows->comment);
            }
            $row->comments = $tables;

            $useID = $row->uid;
            $pic = 'pics/user/Users.png';
            if (trim($row->Pic) != '') {
                $pic = 'pics/user/' . $row->Pic;
            }
            $row->type = PostsClass::PostType($row->type);
            $text = $row->desc;
            $Uname = $row->Uname;
            $row->reg_date = PublicsClass::timeAgo($row->reg_date);
            if ($row->shid != '0') {
                $tables = DB::table('posts as p')
                                ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                                ->where('p.id', $row->shid)
                                ->select('p.title', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->first();
                if ($tables) {
                    $row->share_user = $tables->Name . '  ' . $tables->Family;
                    $row->share_userlink = $tables->Uname;
                    $row->share_content = $tables->Uname;
                    $row->share_pic = $tables->pic;
                    $row->share_video = $tables->video;
                    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                    $row->share_content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $tables->desc);
                } else {
                    $row->shid = 0;
                }
            }
        }
        $res['Posts'] = $table;
        if ($islocal == 'local') {
            return $res;
        }
    }

    private function postSelect($type = 'user', $tab = 'content', $tid = 0, $owner = 0, $UID = 0) {
        $sr = 'p.id > 0';
        $uid = $UID;
        if ($type == 'user') {
            if ($tab == 'content') {
                if ($owner == 1) {
                    $sr = 'p.uid = ' . $tid . ' ';
                } else {
                    $circles[] = 0;
                    if ($uid != 0) {
                        $table = DB::table('user_friend as f')
                                ->leftjoin('user_friend_circle as c', 'f.id', '=', 'c.fid')
                                ->where('f.uid', '=', $tid)
                                ->where('f.fid', '=', $uid)
                                ->select('c.cid')
                                ->get();
                        foreach ($table as $row) {
                            $circles[] = $row->cid;
                        }
                    }
                    $sr = 'p.uid = ' . $tid . ' AND ( p.view = \'1\' OR v.cid IN (' . implode(',', $circles) . '))';
                }
            } elseif ($tab == 'wall' && $owner == 1 && $tid == $uid) {
                $sr = 'f.uid = 0';
                $table = DB::table('user_friend as f')
                        ->where('f.uid', '=', $tid)
                        ->where("f.follow", '1')
                        ->select('f.fid')
                        ->get();
                foreach ($table as $row) {
                    $circles[] = $row->fid;
                }
                if (isset($users) && is_array($users)) {
                    $sr = '(f.uid IN (' . implode(',', $users) . '))';
                }
                $table = DB::table('user_friend as f')
                        ->join('user_friend_circle as c', 'f.id', '=', 'c.fid')
                        ->where('f.uid', '=', $tid)
                        ->whereRaw($sr)
                        ->select('c.cid')
                        ->get();
                foreach ($table as $row) {
                    $circles[] = $row->cid;
                }


                $table = DB::table('user_group_member')
                        ->distinct()
                        ->where('uid', '=', $uid)
                        ->where('follow', '1')
                        ->select('gid', 'relation')
                        ->get();
                foreach ($table as $row) {
                    $circles[] = $row->gid;
                    if ($row->relation == '2') {
                        $members[] = $row->gid;
                    } else {
                        $groups[] = $row->gid;
                    }
                }
                $table = DB::table('subject_member')
                        ->distinct()
                        ->where('uid', '=', $uid)
                        ->where('follow', '1')
                        ->select('sid', 'relation')
                        ->get();
                foreach ($table as $row) {
                    if ($row->relation == '2') {
                        $managers[] = $row->sid;
                    } else {
                        $subjects[] = $row->sid;
                    }
                }
                $sr = '';
                if (isset($users) && is_array($users)) {
                    $sr .= ($sr != '') ? 'OR ' : '';
                    $sr .= '(p.view = \'1\' AND p.uid IN (' . implode(',', $users) . '))';
                }
                if (isset($circles) && is_array($circles)) {
                    $sr .= ($sr != '') ? ' OR ' : '';
                    $sr .= '(v.gid = 0 AND v.cid IN (' . implode(',', $circles) . '))';
                }
                if (isset($groups) && is_array($groups)) {
                    $sr .= ($sr != '') ? ' OR ' : '';
                    $sr .= '(p.view = \'1\' AND v.gid IN (' . implode(',', $groups) . '))';
                }
                if (isset($members) && is_array($members)) {
                    $sr .= ($sr != '') ? ' OR ' : '';
                    $sr .= '(v.gid IN (' . implode(',', $members) . '))';
                }
                if (isset($subjects) && is_array($subjects)) {
                    $sr .= ($sr != '') ? ' OR ' : '';
                    $sr .= '(p.view = \'1\' AND p.sid IN (' . implode(',', $subjects) . '))';
                }
                if (isset($managers) && is_array($managers)) {
                    $sr .= ($sr != '') ? ' OR ' : '';
                    $sr .= '(p.sid IN (' . implode(',', $managers) . '))';
                }
                $sr = ($sr != '') ? '(' . $sr . ')' : 'p.uid = 0';
            }
        }
        if ($type == 'group') {
            $group_id = $tid;
            if ($owner == 1) {
                $sr = 'v.cid = 0 AND v.gid = ' . $group_id . ' ';
            } else {
                $sr = 'v.cid = 0 AND v.gid = ' . $group_id . ' AND p.view = \'1\'';
            }
        }
        if ($type == 'subject') {
            $subject_id = $tid;
            if ($owner == 1) {
                $sr = 'p.sid = ' . $subject_id . ' ';
            } else {
                $sr = ' p.sid = ' . $subject_id . ' AND p.view = \'1\'';
            }
        }
        return $sr;
    }

    public function NewPost($uid, $sesid, $sid_org = 0, $type, $desc, $image, $video, $time, $all, $keys, $circles, $groups, $title, $portal_id = 0, $reward = 0, $selectText='') {
        $PC = new PageClass();

        switch ($type) {
            case 1:
                if (env('CONSTANTS_ENQUIRY_FOR_COMMENT')) {
                    $sid = $portal_id = env('CONSTANTS_ENQUIRY_FOR_COMMENT');
                }
                break;
            case 3:
                if (env('CONSTANTS_ENQUIRY_FOR_IDEA')) {
                    $sid = $portal_id = env('CONSTANTS_ENQUIRY_FOR_IDEA');
                }
                break;
            case 4:
                if (env('CONSTANTS_ENQUIRY_FOR_EXPERIENCE')) {
                    $sid = $portal_id = env('CONSTANTS_ENQUIRY_FOR_EXPERIENCE');
                }
                break;
        }

        $pid = DB::table('posts')->insertGetId(['uid' => $uid, 'sid' => $sid_org, 'type' => $type, 'desc' => "$desc", 'pic' => $image, 'video' => $video, 'reg_date' => $time, 'view' => $all, 'title' => "$title", 'portal_id' => $portal_id]);

        if ($type == 2 && $reward > 0) {
            $reward_id = Reward::create(
                            [
                                'from_user_id' => auth()->id(),
                                'to_user_id' => 0,
                                'target_table' => 'App\Models\hamafza\Post',
                                'target_id' => $pid,
                                'score' => $reward,
            ]);
        }
        $score_id = '';
        switch ($type) {
            case '1':
                $score_id = config('score.1');
                break;
            case '2':
                $score_id = config('score.2');
                break;
            case '3':
                $score_id = config('score.3');
                break;
            case '4':
                $score_id = config('score.4');
                break;
            case '12':
                $score_id = config('score.5');
                break;
            case '13':
                $score_id = config('score.6');
                break;
        }
        if(trim($score_id) != '')
            score_register('App\Models\hamafza\Post', $pid, $score_id,$uid);

        if ($keys != '') {
            $myArray = explode(',', $keys);
            foreach ($myArray as $value) {
                if ('old_method' === true) {
                    if ($value != '') {
                        DB::table('post_keys')->insert(['pid' => $pid, 'kid' => $value]);
                    }
                } else {
                    $exist_in = 'exist_in';
                    if ($exist_in == substr($value, 0, strlen($exist_in))) {
                        $value = str_replace($exist_in, null, $value);
                        DB::table('post_keys')->insert(['pid' => $pid, 'kid' => $value]);
                    }
                }
            }
        }
        if ($groups != '') {
            $gids = explode(',', $groups);
            if (count($gids) != 0) {
                foreach ($gids as $key => $val) {
                    $gid = intval($val);
                    if ($gid != 0) {
                        DB::table('post_view')->insert(['pid' => $pid, 'gid' => $gid]);
                    }
                }
            }
        }
        if ($circles != 'all') {
            $cids = array();
            $cids = explode(',', $circles);
            if (count($cids) != 0) {
                foreach ($cids as $key => $val) {
                    $cid = intval($val);
                    if ($cid != 0) {
                        DB::table('post_view')->insert(['pid' => $pid, 'cid' => $cid]);
                    }
                }
            }
        }
        $message = $pid;
        return $message;
    }

    public function GroupContents($group, $cuid) {
        $PC = new PostsClass();
        $sr = $this->postSelect('group', 'content', $group->id, 0, 0);
        config('app.temp', $cuid);
        $table = DB::table('posts as p')
                        ->distinct()
                        ->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                        ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                        ->leftjoin('post_like as pl', function ($join) {
                            $value = config('app.temp');
                            $join->on('pl.pid', '=', 'p.id')
                            ->where('pl.uid', '=', $value);
                        })
                        ->whereRaw($sr)
                        ->orderBy('p.id', 'desc')
                        ->select('p.title', 'v.gid', 'pl.id as islike', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')
                        ->take(10)->get();
        $nums = 0;
        //dd($table);
        foreach ($table as $row) {
            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
            $row->desc = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row->desc);
            $row->desc = PostsClass::strip_word_html($row->desc);

            $row->desc = nl2br($row->desc);
            $pic = 'pics/user/Users.png';
            if (trim($row->Pic) != '') {
                $pic = 'pics/user/' . $row->Pic;
            }
            $row->type = PostsClass::PostType($row->type);
            $GR = DB::table('user_group')
                            ->where('id', $row->gid)->select('id', 'isorgan', 'name', 'link', 'uid', 'pic')->first();
            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->OrganName = $GR->name;
                $row->Organlink = '';
                $row->Organlink = $GR->link;
                $row->OrganPic = $GR->pic;
            }
            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->InsertedOrgan = $GR->name;
                $row->InsertedOrganlink = $GR->link;
            } else {
                $row->InsertedOrgan = '';
                $row->InsertedOrganlink = '';
            }
            if ($row->gid != '' && $GR->isorgan == '0' && $row->gid != $group->id) {
                $row->InsertedGroup = $GR->name;
                $row->InsertedGrouplink = $GR->link;
            } else {
                $row->InsertedGroup = '';
                $row->InsertedGrouplink = '';
            }
            if ($row->sid != '0') {
                $GR = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')
                                ->where('s.id', $row->sid)->select('s.title', 'p.id')->first();
                if ($GR) {
                    $row->InsertedSubject = $GR->title;
                    $row->InsertedSubjectlink = $GR->id;
                } else {
                    $row->InsertedSubject = '';
                    $row->InsertedSubjectlink = '';
                }
            } else {
                $row->InsertedSubject = '';
                $row->InsertedSubjectlink = '';
            }


            $tables = DB::table('post_comment as p')
                            ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                            ->where('pid', $row->id)
                            ->orderBy('reg_date')
                            ->select('p.id', 'p.comment', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')
                            ->take(10)->get();
            foreach ($tables as $rows) {
                $rows->reg_date = PublicsClass::timeAgo($rows->reg_date);
                $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                $rows->comment = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $rows->comment);
            }
            $row->comments = $tables;

            $useID = $row->uid;


            $text = $row->desc;
            $Uname = $row->Uname;
            $row->reg_date = PublicsClass::timeAgo($row->reg_date);

            if ($row->shid != '0') {
                $tables = DB::table('posts as p')
                                ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                                ->where('p.id', $row->shid)->select('p.title', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->first();
                if ($tables) {
                    $row->share_user = $tables->Name . '  ' . $tables->Family;
                    $row->share_userlink = $tables->Uname;
                    $row->share_content = $tables->Uname;
                    $row->share_pic = $tables->pic;
                    $row->share_video = $tables->video;
                    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                    $row->share_content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $tables->desc);
                } else {
                    $row->shid = 0;
                }
            }
        }
        return $table;
    }

    public function GroupContentsPaging($group, $cuid, $lastpostid) {
        $PC = new PostsClass();
        $sr = $this->postSelect('group', 'content', $group->id, 0, 0);
        config('app.temp', $cuid);
        $table = DB::table('posts as p')
                        ->distinct()->leftjoin('post_view as v', 'v.pid', '=', 'p.id')
                        ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                        ->leftjoin('post_like as pl', function ($join) {
                            $value = config('app.temp');
                            $join->on('pl.pid', '=', 'p.id')
                            ->where('pl.uid', '=', $value);
                        })
                        ->whereRaw($sr)->where('p.id', '<', $lastpostid)
                        ->orderBy('p.id', 'desc')->select('p.title', 'v.gid', 'pl.id as islike', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->take(10)->get();
        $nums = 0;
        foreach ($table as $row) {
            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
            $row->desc = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row->desc);
            $row->desc = PostsClass::strip_word_html($row->desc);

            $row->desc = nl2br($row->desc);
            $pic = 'pics/user/Users.png';
            if (trim($row->Pic) != '') {
                $pic = 'pics/user/' . $row->Pic;
            }
            $row->type = PostsClass::PostType($row->type);
            $GR = DB::table('user_group')
                            ->where('id', $row->gid)->select('id', 'isorgan', 'name', 'link', 'uid', 'pic')->first();
            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->OrganName = $GR->name;
                $row->Organlink = '';
                $row->Organlink = $GR->link;
                $row->OrganPic = $GR->pic;
            }
            if ($row->gid != '' && $GR->isorgan == '1' && $GR->uid == $row->uid) {
                $row->InsertedOrgan = $GR->name;
                $row->InsertedOrganlink = $GR->link;
            } else {
                $row->InsertedOrgan = '';
                $row->InsertedOrganlink = '';
            }
            if ($row->gid != '' && $GR->isorgan == '0' && $row->gid != $group->id) {
                $row->InsertedGroup = $GR->name;
                $row->InsertedGrouplink = $GR->link;
            } else {
                $row->InsertedGroup = '';
                $row->InsertedGrouplink = '';
            }
            if ($row->sid != '0') {
                $GR = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')
                                ->where('s.id', $row->sid)->select('s.title', 'p.id')->first();
                if ($GR) {
                    $row->InsertedSubject = $GR->title;
                    $row->InsertedSubjectlink = $GR->id;
                } else {
                    $row->InsertedSubject = '';
                    $row->InsertedSubjectlink = '';
                }
            } else {
                $row->InsertedSubject = '';
                $row->InsertedSubjectlink = '';
            }


            $tables = DB::table('post_comment as p')
                            ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                            ->where('pid', $row->id)
                            ->orderBy('reg_date')->select('p.id', 'p.comment', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->take(10)->get();
            foreach ($tables as $rows) {
                $rows->reg_date = PublicsClass::timeAgo($rows->reg_date);
                $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                $rows->comment = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $rows->comment);
            }
            $row->comments = $tables;

            $useID = $row->uid;


            $text = $row->desc;
            $Uname = $row->Uname;
            $row->reg_date = PublicsClass::timeAgo($row->reg_date);
            if ($row->shid != '0') {
                $tables = DB::table('posts as p')
                                ->leftjoin('user as u', 'p.uid', '=', 'u.id')
                                ->where('p.id', $row->shid)->select('p.title', 'p.id', 'p.shid', 'p.uid', 'p.sid', 'p.type', 'p.likes', 'p.coms', 'p.shares', 'p.desc', 'p.pic', 'p.video', 'p.reg_date', 'u.id as uid', 'u.Uname', 'u.Name', 'u.Family', 'u.Pic AS Pic')->first();
                if ($tables) {
                    $row->share_user = $tables->Name . '  ' . $tables->Family;
                    $row->share_userlink = $tables->Uname;
                    $row->share_content = $tables->Uname;
                    $row->share_pic = $tables->pic;
                    $row->share_video = $tables->video;
                    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                    $row->share_content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $tables->desc);
                }
            }
        }

        return $table;
    }

    public static function PostLike($uid, $postid, $sesid, $like) {
        $user = UserClass::CheckLogin($uid, $sesid);
        $user = ($user == TRUE) ? 'true' : 'false';
        $message='';
        if ($user) {
            if ($like == 1) {
                $nums = DB::table('post_like')->where('pid', $postid)->where('uid', $uid)
                                ->select('id')->count();
                if ($nums == 0) {
                    DB::table('post_like')->insertGetId(
                            array('pid' => $postid, 'uid' => $uid)
                    );
                    DB::table('posts')->where('id', $postid)
                            ->increment('likes');
                    $message = trans('labels.LikeOK');
                    $err = false;
                }
            } else {
                if ($like == 0) {
                    $nums = DB::table('post_like')->where('pid', $postid)->where('uid', $uid)
                                    ->select('id')->count();
                    if ($nums != 0) {
                        DB::table('post_like')->where('uid', $uid)->where('pid', $postid)->delete();
                        DB::table('posts')->where('id', $postid)
                                ->decrement('likes');
                        $message = trans('labels.LikeRemove');
                        $err = false;
                    }
                }
            }
        } else {
            $message = trans('labels.FailUser');
            $err = true;
        }

        return $message;
    }

    private static function PostType($id) {
        switch ($id) {
            case "0":
                return "سایر";
                break;
            case "1":
                return "نظر";
                break;
            case "2":
                return "پرسش";
                break;
            case "3":
                return "ایده";
                break;
            case "4":
                return "تجربه";
                break;
            case "12":
                return "خبر";
                break;
            case "13":
                return "مرور";
                break;
            default :
                return "نظر";
                break;
        }
    }

    public static function PostComment($uid, $postid, $sesid, $comment) {
        $comment = str_replace("[and]", "&", $comment);
        $comment = json_decode($comment);
        $cid = DB::table('post_comment')->insertGetId(
                array('pid' => $postid, 'uid' => $uid, 'comment' => $comment, 'reg_date' => time())
        );
        DB::table('posts')->where('id', $postid)
                ->increment('coms');
        $message = trans('labels.CommentOK');
        $err = false;
        $mes['id'] = $cid;
        $mes['text'] = $message;
        return $mes;
    }

}
