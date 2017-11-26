<?php

namespace App\HamafzaViewClasses;

use Illuminate\Support\Facades\DB;
use App\HamafzaServiceClasses\ConfigurationClass;
use Auth;

class PublicClass {

    public static function Departments($name, $uid, $sesid, $Selected, $Tree, $sublink = '') {
        if (!Auth::check()) {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        } else {
            $ret = DesktopClass::USER($name);
            $s = DB::table('departments')->where('view', '1')->orderby("orders")->select('id', 'name', 'pid')->get();
            $s = json_encode($s);
            $s = json_decode($s);
            $Portals = PageClass::GetProtals($uid, $sesid);
            $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups')) {
                $MyOrganGroups = session('MyOrganGroups');
            }
            $tabs = json_encode($ret['tabs']);
            $tabs = json_decode($tabs);
            $PgC = new PageClass();
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
            $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
            $shortTools = $tools['abzar'];
            return view('pages.Desktop.departments', array('PageType' => 'desktop', 'PageType' => 'desktop', 'SiteLogo' => $ret['SiteLogo'], 'MyOrganGroups' => $MyOrganGroups, 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                'menu' => $ret['menu'], 'content' => $s, 'Files' => '', 'keywords' => '',
                'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $tabs, 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
        }
    }

    public static function stemJson($string) {
        //$string=  json_encode($string);
        $newwords = array("ك" => "ک", "ي" => "ی", "&nbsp;" => " ", "­" => " ", "&zwnj;" => " ", "&zwj;" => " ", "&rlm;" => " ", "&lrm;" => " ", "&thinsp;" => " ", "&ensp;" => " ", "&emsp;" => " ", " " => " ", " " => " ", "  " => " ", "   " => " ", "    " => " ", "" => "‌"); //"‌"هشت‌ساله
        foreach ($newwords as $key => $val) {
            $string = str_replace($key, $val, $string);
        }
        $string = preg_replace('/&(\S)+;/', ' ', $string);
        return $string;
    }

    public static function Filter($value) {
        $value = trim(htmlentities(strip_tags($value)));
        $value = filter_var($value, FILTER_SANITIZE_STRING);
        $value = trim(strip_tags($value));
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        } else {
            $value = addslashes($value);
        }
        // $value = DB::connection()->getPdo()->quote($value);
        return $value;
    }

    public static function Share($sid, $pid, $type, $title, $alamat, $select) {
        $uid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        return view('modals.share', array('uid' => $uid, 'type' => $type, 'select' => $select, 'sid' => $sid, 'pid' => $pid, 'title' => $title));
    }

    public static function ShowHelp($id, $tagname, $hid, $pid) {
        $SP = new \App\HamafzaServiceClasses\PublicsClass();
        $menu = $SP->ShowHelp($id, $tagname, $hid, $pid);
        return view('modals.helpview', array('view' => $menu));
    }

    public function make_clickable($ret) {
        $ret = ' ' . $ret;
// in testing, using arrays here was found to be faster
        $ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', array($this, '_make_url_clickable_cb'), $ret);
        $ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', array($this, '_make_web_ftp_clickable_cb'), $ret);
        $ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', array($this, '_make_email_clickable_cb'), $ret);

// this one is not in an array because we need it to run last, for cleanup of accidental links within links
        $ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
        $ret = trim($ret);
        return $ret;
    }

    public static function get_smiley_array() {
        $smileys = array(
//	smiley			image name						width	height	alt
            ':)' => array('grin.gif', '19', '19', 'grin'),
            ':-)' => array('grin.gif', '19', '19', 'laugh'),
            ':lol:' => array('lol.gif', '19', '19', 'LOL'),
            ':cheese:' => array('cheese.gif', '19', '19', 'cheese'),
            ':)' => array('smile.gif', '19', '19', 'smile'),
            ';-)' => array('wink.gif', '19', '19', 'wink'),
            ';)' => array('wink.gif', '19', '19', 'wink'),
            ':smirk:' => array('smirk.gif', '19', '19', 'smirk'),
            ':roll:' => array('rolleyes.gif', '19', '19', 'rolleyes'),
            ':-S' => array('confused.gif', '19', '19', 'confused'),
            ':wow:' => array('surprise.gif', '19', '19', 'surprised'),
            ':bug:' => array('bigsurprise.gif', '19', '19', 'big surprise'),
            ':-P' => array('tongue_laugh.gif', '19', '19', 'tongue laugh'),
            '%-P' => array('tongue_rolleye.gif', '19', '19', 'tongue rolleye'),
            ';-P' => array('tongue_wink.gif', '19', '19', 'tongue wink'),
            ':P' => array('rasberry.gif', '19', '19', 'rasberry'),
            ':blank:' => array('blank.gif', '19', '19', 'blank stare'),
            ':long:' => array('longface.gif', '19', '19', 'long face'),
            ':ohh:' => array('ohh.gif', '19', '19', 'ohh'),
            ':grrr:' => array('grrr.gif', '19', '19', 'grrr'),
            ':gulp:' => array('gulp.gif', '19', '19', 'gulp'),
            '8-/' => array('ohoh.gif', '19', '19', 'oh oh'),
            ':down:' => array('downer.gif', '19', '19', 'downer'),
            ':red:' => array('embarrassed.gif', '19', '19', 'red face'),
            ':sick:' => array('sick.gif', '19', '19', 'sick'),
            ':shut:' => array('shuteye.gif', '19', '19', 'shut eye'),
            ':-/' => array('hmm.gif', '19', '19', 'hmmm'),
            '>:(' => array('mad.gif', '19', '19', 'mad'),
            ':mad:' => array('mad.gif', '19', '19', 'mad'),
            '>:-(' => array('angry.gif', '19', '19', 'angry'),
            ':angry:' => array('angry.gif', '19', '19', 'angry'),
            ':zip:' => array('zip.gif', '19', '19', 'zipper'),
            ':kiss:' => array('kiss.gif', '19', '19', 'kiss'),
            ':ahhh:' => array('shock.gif', '19', '19', 'shock'),
            ':coolsmile:' => array('shade_smile.gif', '19', '19', 'cool smile'),
            ':coolsmirk:' => array('shade_smirk.gif', '19', '19', 'cool smirk'),
            ':coolgrin:' => array('shade_grin.gif', '19', '19', 'cool grin'),
            ':coolhmm:' => array('shade_hmm.gif', '19', '19', 'cool hmm'),
            ':coolmad:' => array('shade_mad.gif', '19', '19', 'cool mad'),
            ':coolcheese:' => array('shade_cheese.gif', '19', '19', 'cool cheese'),
            ':vampire:' => array('vampire.gif', '19', '19', 'vampire'),
            ':snake:' => array('snake.gif', '19', '19', 'snake'),
            ':exclaim:' => array('exclaim.gif', '19', '19', 'excaim'),
            ':question:' => array('question.gif', '19', '19', 'question') // no comma after last item
        );
        return $smileys;
    }

    public static function parse_smileys($str = '', $image_url = '', $smileys = NULL) {
        if ($image_url == '') {
            return $str;
        }

        if (!is_array($smileys)) {
            if (FALSE === ($smileys = PublicClass::get_smiley_array())) {
                return $str;
            }
        }

        $image_url = preg_replace("/(.+?)\/*$/", "\\1/", $image_url);

        foreach ($smileys as $key => $val) {
            $str = str_replace($key, "<img src=\"" . $image_url . $smileys[$key][0] . "\" width=\"" . $smileys[$key][1] . "\" height=\"" . $smileys[$key][2] . "\" alt=\"" . $smileys[$key][3] . "\" style=\"border:0;\" />", $str);
        }

        return $str;
    }

    public function SearchResult($res, $searchword) {
        $i = 0;
        $Res = '';
        if (is_array($res)) {
            if (isset($res['pages'])) {
                $pages = $res['pages'];
                if (is_array($pages)) {
                    $Res .= '<div class=""><span class="col-md-6 " style="width:100%; padding: 4px 2px; margin:10px 15px 5px; box-shadow: 0px 2px 0px #fff!important;transition: all 0.3s;">صفحات(' . count($pages) . ')</span><br>';
                    $Res .= '<ul style="list-style: inside square;margin-top: 25px;">';
                    foreach ($pages as $value) {
                        $Res .= '<li style="margin-right:25px; line-height: 25px; list-style: inside none square; overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"><a title="' . $value['title'] . '" style="color:#fff;" href="' . url('/') . '/' . $value['url'] . '">' . $value['title'] . '</a></li>';
                        $i++;
                    }
                    $Res .= '</ul>';
                }
            }
            if (isset($res['posts'])) {
                $posts = $res['posts'];
                if (is_array($posts)) {
                    $Res .= '<div class=""><span class="col-md-6 " style="width:100%; padding: 4px 2px; margin:10px 15px 5px; box-shadow: 0px 2px 0px #fff!important;transition: all 0.3s;">پست ها(' . count($posts) . ')</span><br>';

                    $Res .= '<ul style="list-style: inside square;margin-top: 25px;">';
                    foreach ($posts as $value) {
                        if ($value['subject']) {
                            $url = route('page.forum', $value['subject']['id']);
                        } else {
                            $url = route('ugc.wall', $value['user']['Uname']);
                        }
                        $Res .= '<li style="margin-right:25px; line-height: 25px; list-style: inside none square; overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"><a title="' . $value['title'] . '" style="color:#fff" href="' . $url . '">' . $value['title'] . '</a></li>';
                        $i++;
                    }
                    $Res .= '</ul>';
                }
            }
        }
        $Res2 = '<div class=""><span class="col-md-6 " style="width:100%; box-shadow: 0px 4px 0px #fff!important;transition: all 0.3s;">یافته‌ها (' . $i . ')</span><br>';
        $Res2 .= $Res;
        $Res2 .= '</div>';
        session('SearchRes', $Res2);
        session('SearchWord', $searchword);
        return $Res2;
    }

    public function field_view_iust($field_id, $field_name, $field_type, $field_value, $requires, $report = array(), $width = '100%', $view = 'horizontal') {
        $str = '';
        $str .= '<td';
        if ($field_type == 'comment') {
            $str .= ' class="th"';
        }

        $str .= (($view == 'vertical') ? '' : ' width="120"');
        if ($field_type == 'hyperlink') {
            $str .= '>';
        } else {
            $str .= '>' . $field_name . '';
        }
        if ($requires == 1) {
            $str .= ' <font color="red">*</font>';
        }


        $str .= (($view == 'vertical') ? '<br/>' : '</td><td>');
//   $field_values 

        if ($field_type == 'datapicker') {
            $str .= '<input type="text" class="form-control" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report['0']) ? $report['0'] : implode('', $field_value)) . '" style="width:400px;" class="field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" /><input type="hidden" name="type[' . $field_id . ']" value="text" />';
            $str .= "  <script type='text/javascript'>
	    $(function() {
	        $('#field_$field_id').datepicker();
});</script>";
//$field_valueN = (isset($report['0']) ? $report['0'] : implode('', $field_value));
//  $str.=  "<a href='$field_valueN?pid=$pid'>{$field_name}</a>";
        } else {
            if ($field_type == 'hyperlink') {
                if (isset($_GET['pid']) && $_GET['pid'] != 0) {
                    $pid = $_GET['pid'];
                } else {
                    $pid = 0;
                }
// $str.=  $field_value;

                $field_valueN = (isset($report['0']) ? $report['0'] : implode('', $field_value));
// $str.=  $field_valueN;
                $str .= "<a target='_blank' href='$field_valueN?pid=$pid'>{$field_name}</a>";
                $str .= '<input type="hidden" name="type[' . $field_id . ']" value="text" />';
            } else {
                if ($field_type == 'text' || $field_type == 'number' || $field_type == 'email' || $field_type == 'mellicode' || $field_type == 'tel' || $field_type == 'mobile' || $field_type == 'score' || $field_type == 'users' || $field_type == 'persons') {
                    $str .= '<input type="text" class="form-control" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report['0']) ? $report['0'] : implode('', $field_value)) . '" style="width:400px;" class="field ' . $field_type . '';
                    if ($requires == 1) {
                        $str .= ' required';
                    }
                    $str .= '" /><input type="hidden" name="type[' . $field_id . ']" value="text" />';
                }
            }
        }
        if ($field_type == 'image_upload') {
            $str .= '<img  id="field_' . $field_id . '" name="field[' . $field_id . ']" style="max-width:150px;" src="' . Request::root() . '/files/forms/' . (isset($report['0']) ? $report['0'] : implode('|', $field_value)) . '" ><input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'textarea') {
            $str .= '<textarea class="form-control" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" class=" form-control field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }

            $str .= '" >' . (isset($report['0']) ? $report['0'] : implode('|', $field_value)) . '</textarea>
					<input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'select') {
            $str .= '<select id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" class="field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >';
            foreach ($field_value as $k => $v) {
                $str .= '<option value="' . trim($k) . '"';
                if (isset($report['0']) && $report['0'] == $k) {
                    $str .= ' selected';
                }
                $str .= '>' . trim($v) . '</option>';
            }
            $str .= '</select><input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'radio') {
            foreach ($field_value as $k => $v) {


                $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" value="' . trim($k) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if (isset($requires) && $requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                if (isset($report['0']) && $report['0'] == $k) {
                    $str .= ' checked';
                }
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'checkbox') {
            foreach ($field_value as $k => $v) {
                $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" name="field[' . $field_id . '][' . $k . ']" value="' . trim($k) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if ($requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                if (isset($report[$k]) && $report[$k] == 1) {
                    $str .= ' checked';
                }
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        $str .= '</td>';

        return $str;
    }

    public function field_view_kham($field_id, $field_name, $field_type, $field_value, $requires, $width = '100%', $view = 'horizontal', $question) {
        $str = '';
        $str .= '<td';
        if ($field_type == 'comment') {
            $str .= ' class="th"';
        }

        $str .= (($view == 'vertical') ? '' : ' width="120"');
        if ($question == '0') {
            $str .= '><div class="form-group"><label>' . $field_name . '<input type="hidden" name="field[' . $field_id . ']" value="" /></label>';
        } elseif ($field_type == 'hyperlink') {
            $str .= '><div class="form-group">';
        } else {
            $str .= '><div class="form-group"><label class="control-label">' . $field_name . '</label>';
        }

        if ($requires == '1') {
            $str .= ' <font color="red">*</font>';
        }

        $str .= (($view == 'vertical') ? '<br/>' : '</td><td>');
//   $field_values 
        if ($question == '0') {
            $str .= '<input type="hidden" name="type[' . $field_id . ']" value="text" /><br>';
        } else {
            if ($field_type == 'datapicker2') {
                $d = '<option value="فروردین">فروردین</option>';
                $d .= '<option value="اردیبهشت">اردیبهشت</option>';
                $d .= '<option value="خرداد">خرداد</option>';
                $d .= '<option value="تیر">تیر</option>';
                $d .= '<option value="مرداد">مرداد</option>';
                $d .= '<option value="شهریور">شهریور</option>';
                $d .= '<option value="مهر">مهر</option>';
                $d .= '<option value="آبان">آبان</option>';
                $d .= '<option value="آذر">آذر</option>';
                $d .= '<option value="دی">دی</option>';
                $d .= '<option value="بهمن">بهمن</option>';
                $d .= '<option value="اسفند">اسفند</option>';

                $str .= '<select class="form-control ' . $field_type . '" alt="' . $field_name . '" name="field[' . $field_id . ']" id="field_' . $field_id . '" ';
                if ($requires == 1) {
                    $str .= ' required" required ';
                }
                $str .= ' >';
                $str .= $d;
                $str .= ' <input type="hidden" name="type[' . $field_id . ']" value="datapicker2" />';
//            $str.= "  <script type='text/javascript'>$(function() {
//	        $('#field_$field_id').datepicker();});</script>";
            } else {
                if ($field_type == 'datapicker3') {
                    $d = '';
                    for ($i = 1385; $i < 1399; $i++) {
                        $d .= '<option value="' . $i . '">' . $i . '</option>';
                    }
                    $str .= '<select class="form-control ' . $field_type . '" alt="' . $field_name . '" name="field[' . $field_id . ']" id="field_' . $field_id . '" ';
                    if ($requires == 1) {
                        $str .= ' required" required ';
                    }
                    $str .= ' >';
                    $str .= $d;
                    $str .= ' <input type="hidden" name="type[' . $field_id . ']" value="datapicker3" />';
                } elseif ($field_type == 'hyperlink') {
                    if (isset($_GET['pid']) && $_GET['pid'] != 0) {
                        $pid = $_GET['pid'];
                    } else {
                        $pid = 0;
                    }
// $str.=  $field_value;

                    $field_valueN = (isset($report['0']) ? $report['0'] : implode('', $field_value));
// $str.=  $field_valueN;
                    $str .= "<a target='_blank' href='$field_valueN?pid=$pid'>{$field_name}</a>";
                    $str .= '<input type="hidden" name="type[' . $field_id . ']" value="text" />';
                } else {
                    if ($field_type == 'image_upload') {
                        $str .= '<input type="file" name="file[' . $field_id . ']"';
                        if ($requires == 1) {
                            $str .= ' required=""';
                        }
                        $str .= ' /><input type="hidden" id="field_' . $field_id . '" name="field[' . $field_id . ']" value="image_upload" /><input type="hidden" name="type[' . $field_id . ']" value="image_upload" />';
                    } else {
                        if ($field_type == 'text' || $field_type == 'number' || $field_type == 'email' || $field_type == 'mellicode' || $field_type == 'tel' || $field_type == 'mobile' || $field_type == 'score' || $field_type == 'users' || $field_type == 'persons') {
                            $str .= '<input type="text"  id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" style="width:400px;" class="form-control ';
                            if ($requires == 1) {
                                $str .= ' required" required=""';
                            } else {
                                $str .= ' "';
                            }
                            $str .= ' /><input type="hidden" name="type[' . $field_id . ']" value="text" />';
                        }
                    }
                }
            }
        }
        if ($field_type == 'textarea') {
            $str .= '<textarea class="form-control" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" class="field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }

            $str .= '"';
            if ($requires == 1) {
                $str .= ' required ';
            }
            $str .= '   ></textarea>
					<input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'select') {
            $str .= '<select id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" class="form-control ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >';
            foreach ($field_value as $k => $v) {
                $str .= '<option value="' . trim($v) . '"';

                $str .= '>' . trim($v) . '</option>';
            }
            $str .= '</select><input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'radio') {
            foreach ($field_value as $k => $v) {


                $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" value="' . trim($v) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if (isset($requires) && $requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'checkbox') {
            foreach ($field_value as $k => $v) {
                $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" name="field[' . $field_id . '][' . $k . ']" value="' . trim($k) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if ($requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                if (isset($report[$k]) && $report[$k] == 1) {
                    $str .= ' checked';
                }
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        $str .= '</div></td>';

        return $str;
    }

    public static function Newfield_view_bySedc($field_id, $field_name, $field_type, $field_value, $requires, $Desc, $report = array(), $width = '100%', $view = 'horizontal', $sid = 0) {
        $str = '';
        $str .= '<td';
        if ($field_type == 'comment') {
            $str .= ' class="th"';
        }

        $str .= (($view == 'vertical') ? '' : ' width="120"');
        if ($field_type == 'hyperlink') {
            $str .= '>s';
        } else {
            $str .= '>' . $field_name . '';
        }
        if ($requires == 1) {
            $str .= ' <font color="red">*</font>';
        }


        $str .= (($view == 'vertical') ? '<br/>' : '</td><td>');
//   $field_values 

        if ($field_type == 'datapicker') {
            $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report['0']) ? $report['0'] : implode('', $field_value)) . '"  class="field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" /><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
            $str .= "  <script type='text/javascript'>
	    $(function() {
	        $('#field_$field_id').datepicker();
});</script>";
        } elseif ($field_type == 'datapicker2') {
            $str .= '<select   id="field_' . $field_id . '" name="field[' . $field_id . ']" data-placeholder="انتخاب کنید"  style="width:200px;" class="form-control chzn-rtl field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >';
//(isset($report['0']) ? $report['0'] : implode('', $field_value)) . '
            $str .= '<option value="1">فروردین</option>';
            $str .= '<option value="2">اردیبهشت</option>';
            $str .= '<option value="3">خرداد</option>';
            $str .= '<option value="4">تیر</option>';
            $str .= '<option value="5">مرداد</option>';
            $str .= '<option value="6">شهریور</option>';
            $str .= '<option value="7">مهر</option>';
            $str .= '<option value="8">آبان</option>';
            $str .= '<option value="9">آذر</option>';
            $str .= '<option value="10">دی</option>';
            $str .= '<option value="11">بهمن</option>';
            $str .= '<option value="12">اسفند</option>';
            $str .= '</select><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
        } elseif ($field_type == 'datapicker3') {
            $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" placeholder="فقط سال مانند 1394" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report['0']) ? $report['0'] : implode('', $field_value)) . '" style="width:110px;" class="field number';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" /><input  type="hidden" name="type[' . $field_id . ']" value="text" />';
            if ($field_type == 'persons') {
                $str .= '<input  type="hidden" name="field_hid[' . $field_id . ']" class="users1" value="" />';
            }
        } else {
            if (strpos($field_type, 'EYWORD_') == 1) {
                $value = isset($report['0']) ? $report['0'] : implode('', $field_value);
                $keyword_ttype = str_replace("KEYWORD_", "", $field_type);
//  $str.= $this->NEW_auto_keywords('title', $value, $keyword_ttype, '400', 'تخصص ', 'required');
            }
        }
        if ($field_type == 'hyperlink') {
            if (isset($_GET['pid']) && $_GET['pid'] != 0) {
                $pid = $_GET['pid'];
            } else {
                $pid = 0;
            }
            if ($sid != 0) {
                $pid = $sid;
            }

//$str.= $field_value;

            $field_valueN = (isset($report['0']) ? $report['0'] : implode('', $field_value));
//$str.= $field_valueN;
            $str .= "<a target='_blank' href='$field_valueN?pid=$sid'>{$field_name}</a>";
            $str .= '<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
        } else {
            if ($field_type == 'text' || $field_type == 'number' || $field_type == 'email' || $field_type == 'mellicode' || $field_type == 'tel' || $field_type == 'mobile' || $field_type == 'score' || $field_type == 'users' || $field_type == 'persons') {
                $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report['0']) ? $report['0'] : implode('', $field_value)) . '"  class="field ' . $field_type . '';
                if ($requires == 1) {
                    $str .= ' required';
                }
                $str .= '" /><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
                if ($field_type == 'persons') {
                    $str .= '<input class="form-control col-xs-6" type="hidden" name="field_hid[' . $field_id . ']" class="users1" value="" />';
                }
            }
        }
        if ($field_type == 'textarea') {
            $str .= '<textarea id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" class=" col-xs-6 form-control field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >' . (isset($report['0']) ? $report['0'] : implode('|', $field_value)) . '</textarea>
					<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'select') {
            $str .= '<select id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" style="max-width:200px" class="form-control field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >';
            foreach ($field_value as $k => $v) {
                $str .= '<option value="' . trim($v) . '"';
                if (isset($report['0']) && $report['0'] == $k) {
                    $str .= ' selected';
                }
                $str .= '>' . trim($v) . '</option>';
            }
            $str .= '</select><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'radio') {
            foreach ($field_value as $k => $v) {
                $str .= '<label style="display:inline-flex;"><input class="form-control col-xs-6" type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" name="field[' . $field_id . ']" value="' . trim($v) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if (isset($requires) && $requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                if (isset($report['0']) && $report['0'] == $k) {
                    $str .= ' checked';
                }
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'checkbox') {
            foreach ($field_value as $k => $v) {
                $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input  type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" name="field[' . $field_id . '][' . $k . ']" value="' . trim($k) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if ($requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                if (isset($report[$k]) && $report[$k] == 1) {
                    $str .= ' checked';
                }
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($Desc != '') {
            $str .= '<div title="' . $Desc . '" data-placement="top" data-toggle="tooltip" '
                    . 'class="stooltip title-button1 status  icons  icon-rahnama" style="color:red;display: inline-block;font-size: 15px;height: 10px;margin: 10px 10px 0;">'
                    . '</div></td>';
        } else {
            $str .= '</td>';
        }
        return $str;
    }

    public static function PageSettingfields($field_id, $field_name, $field_type, $field_value, $requires, $Desc, $Rep_value, $report = array(), $width = '100%', $view = 'horizontal', $sid = 0) {
        $str = '';
        $str .= '<td';
        if ($field_type == 'comment') {
            $str .= ' class="th"';
        }

        $str .= (($view == 'vertical') ? '' : ' width="120"');
        if ($field_type == 'hyperlink') {
            $str .= '>s';
        } else {
            $str .= '>' . $field_name . '';
        }
        if ($requires == 1) {
            $str .= ' <font color="red">*</font>';
        }


        $str .= (($view == 'vertical') ? '<br/>' : '</td><td>');
//   $field_values 

        if ($field_type == 'datapicker') {
            $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . $Rep_value . '"  class="field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" /><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
            $str .= "  <script type='text/javascript'>
	    $(function() {
	        $('#field_$field_id').datepicker();
});</script>";
        } elseif ($field_type == 'datapicker2') {
            $str .= '<select    id="field_' . $field_id . '" name="field[' . $field_id . ']" data-placeholder="انتخاب کنید"  style="width:200px;" class="form-control chzn-rtl field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >';
//(isset($report['0']) ? $report['0'] : implode('', $field_value)) . '
            $str .= '<option value="1" ' . ($Rep_value == 'فروردین') ? 'selected' : '' . '>فروردین</option>';
            $str .= '<option value="2"' . ($Rep_value == 'اردیبهشت') ? 'selected' : '' . '>اردیبهشت</option>';
            $str .= '<option value="3"' . ($Rep_value == 'خرداد') ? 'selected' : '' . '>خرداد</option>';
            $str .= '<option value="4"' . ($Rep_value == 'تیر') ? 'selected' : '' . '>تیر</option>';
            $str .= '<option value="5"' . ($Rep_value == 'مرداد') ? 'selected' : '' . '>مرداد</option>';
            $str .= '<option value="6"' . ($Rep_value == 'شهریور') ? 'selected' : '' . '>شهریور</option>';
            $str .= '<option value="7"' . ($Rep_value == 'مهر') ? 'selected' : '' . '>مهر</option>';
            $str .= '<option value="8"' . ($Rep_value == 'آبان') ? 'selected' : '' . '>آبان</option>';
            $str .= '<option value="9"' . ($Rep_value == 'آذر') ? 'selected' : '' . '>آذر</option>';
            $str .= '<option value="10"' . ($Rep_value == 'دی') ? 'selected' : '' . '>دی</option>';
            $str .= '<option value="11"' . ($Rep_value == 'بهمن') ? 'selected' : '' . '>بهمن</option>';
            $str .= '<option value="12"' . ($Rep_value == 'اسفند') ? 'selected' : '' . '>اسفند</option>';
            $str .= '</select><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
        } elseif ($field_type == 'datapicker3') {
            $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" placeholder="فقط سال مانند 1394" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report['0']) ? $report['0'] : implode('', $field_value)) . '" style="width:110px;" class="field number';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" /><input  type="hidden" name="type[' . $field_id . ']" value="{{$Rep_value}}" />';
            if ($field_type == 'persons') {
                $str .= '<input  type="hidden" name="field_hid[' . $field_id . ']" class="users1" value="" />';
            }
        } else {
            if (strpos($field_type, 'EYWORD_') == 1) {
                $value = isset($report['0']) ? $report['0'] : implode('', $field_value);
                $keyword_ttype = str_replace("KEYWORD_", "", $field_type);
//  $str.= $this->NEW_auto_keywords('title', $value, $keyword_ttype, '400', 'تخصص ', 'required');
            }
        }
        if ($field_type == 'hyperlink') {
            if (isset($_GET['pid']) && $_GET['pid'] != 0) {
                $pid = $_GET['pid'];
            } else {
                $pid = 0;
            }
            if ($sid != 0) {
                $pid = $sid;
            }

//$str.= $field_value;

            $field_valueN = (isset($report['0']) ? $report['0'] : implode('', $field_value));
//$str.= $field_valueN;
            $str .= "<a target='_blank' href='$field_valueN?pid=$sid'>{$field_name}</a>";
            $str .= '<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
        } else {
            if ($field_type == 'text' || $field_type == 'number' || $field_type == 'email' || $field_type == 'mellicode' || $field_type == 'tel' || $field_type == 'mobile' || $field_type == 'score' || $field_type == 'users' || $field_type == 'persons') {
                $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . $Rep_value . '"  class="field ' . $field_type . '';
                if ($requires == 1) {
                    $str .= ' required';
                }
                $str .= '" /><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
                if ($field_type == 'persons') {
                    $str .= '<input class="form-control col-xs-6" type="hidden" name="field_hid[' . $field_id . ']" class="users1" value="" />';
                }
            }
        }
        if ($field_type == 'textarea') {
            $str .= '<textarea id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" class="form-control field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >' . $Rep_value . '</textarea>
					<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'select') {
            $str .= '<select id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" style="max-width:200px" class="form-control field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >';
            foreach ($field_value as $k => $v) {
                $str .= '<option value="' . trim($v) . '"';
                if ($Rep_value == $v) {
                    $str .= ' selected';
                }
                $str .= '>' . trim($v) . '</option>';
            }
            $str .= '</select><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'radio') {
            foreach ($field_value as $k => $v) {


                $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input class="form-control col-xs-6" type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" name="field[' . $field_id . ']" value="' . trim($k) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if (isset($requires) && $requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                if ($Rep_value == $k) {
                    $str .= ' checked';
                }
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'checkbox') {
            foreach ($field_value as $k => $v) {
                $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input  type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" name="field[' . $field_id . '][' . $k . ']" value="' . trim($k) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if ($requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                if ($Rep_value == 1) {
                    $str .= ' checked';
                }
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($Desc != '') {
            $str .= '<div title="' . $Desc . '" data-placement="top" data-toggle="tooltip" '
                    . 'class="stooltip title-button1 status  icons icon-etelaat" style="display: inline-block;font-size: 15px;height: 10px;margin: 10px 10px 0;">'
                    . '</div></td>';
        } else {
            $str .= '</td>';
        }
        return $str;
    }

    public static function field_view_bySedc($field_id, $field_name, $field_type, $field_value, $requires, $Desc, $report = array(), $width = '100%', $view = 'horizontal', $sid = 0) {
        $str = '';
        $str .= '<td';
        if ($field_type == 'comment') {
            $str .= ' class="th"';
        }

        $str .= (($view == 'vertical') ? '' : ' width="120"');
        if ($field_type == 'hyperlink') {
            $str .= '>s';
        } else {
            $str .= '>' . $field_name . '';
        }
        if ($requires == 1) {
            $str .= ' <font color="red">*</font>';
        }


        $str .= (($view == 'vertical') ? '<br/>' : '</td><td>');
//   $field_values 

        if ($field_type == 'datapicker') {
            $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report['0']) ? $report['0'] : implode('', $field_value)) . '"  class="field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" /><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
            $str .= "  <script type='text/javascript'>
	    $(function() {
	        $('#field_$field_id').datepicker();
});</script>";
        } elseif ($field_type == 'datapicker2') {
            $str .= '<select   id="field_' . $field_id . '" name="field[' . $field_id . ']" data-placeholder="انتخاب کنید"  style="width:200px;" class="chzn-select chzn-rtl field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >';
//(isset($report['0']) ? $report['0'] : implode('', $field_value)) . '
            $str .= '<option value="1">فروردین</option>';
            $str .= '<option value="2">اردیبهشت</option>';
            $str .= '<option value="3">خرداد</option>';
            $str .= '<option value="4">تیر</option>';
            $str .= '<option value="5">مرداد</option>';
            $str .= '<option value="6">شهریور</option>';
            $str .= '<option value="7">مهر</option>';
            $str .= '<option value="8">آبان</option>';
            $str .= '<option value="9">آذر</option>';
            $str .= '<option value="10">دی</option>';
            $str .= '<option value="11">بهمن</option>';
            $str .= '<option value="12">اسفند</option>';
            $str .= '</select><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
        } elseif ($field_type == 'datapicker3') {
            $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" placeholder="فقط سال مانند 1394" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report['0']) ? $report['0'] : implode('', $field_value)) . '" style="width:110px;" class="field number';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" /><input  type="hidden" name="type[' . $field_id . ']" value="text" />';
            if ($field_type == 'persons') {
                $str .= '<input  type="hidden" name="field_hid[' . $field_id . ']" class="users1" value="" />';
            }
        } else {
            if (strpos($field_type, 'EYWORD_') == 1) {
                $value = isset($report['0']) ? $report['0'] : implode('', $field_value);
                $keyword_ttype = str_replace("KEYWORD_", "", $field_type);
//  $str.= $this->NEW_auto_keywords('title', $value, $keyword_ttype, '400', 'تخصص ', 'required');
            }
        }
        if ($field_type == 'hyperlink') {
            if (isset($_GET['pid']) && $_GET['pid'] != 0) {
                $pid = $_GET['pid'];
            } else {
                $pid = 0;
            }
            if ($sid != 0) {
                $pid = $sid;
            }

//$str.= $field_value;

            $field_valueN = (isset($report['0']) ? $report['0'] : implode('', $field_value));
//$str.= $field_valueN;
            $str .= "<a target='_blank' href='$field_valueN?pid=$sid'>{$field_name}</a>";
            $str .= '<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
        } else {
            if ($field_type == 'text' || $field_type == 'number' || $field_type == 'email' || $field_type == 'mellicode' || $field_type == 'tel' || $field_type == 'mobile' || $field_type == 'score' || $field_type == 'users' || $field_type == 'persons') {
                $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report['0']) ? $report['0'] : implode('', $field_value)) . '"  class="field ' . $field_type . '';
                if ($requires == 1) {
                    $str .= ' required';
                }
                $str .= '" /><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
                if ($field_type == 'persons') {
                    $str .= '<input class="form-control col-xs-6" type="hidden" name="field_hid[' . $field_id . ']" class="users1" value="" />';
                }
            }
        }
        if ($field_type == 'textarea') {
            $str .= '<textarea id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" class="field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >' . (isset($report['0']) ? $report['0'] : implode('|', $field_value)) . '</textarea>
					<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'select') {
            $str .= '<select id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" class="field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >';
            foreach ($field_value as $k => $v) {
                $str .= '<option value="' . trim($k) . '"';
                if (isset($report['0']) && $report['0'] == $k) {
                    $str .= ' selected';
                }
                $str .= '>' . trim($v) . '</option>';
            }
            $str .= '</select><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'radio') {
            foreach ($field_value as $k => $v) {


                $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input class="form-control col-xs-6" type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" name="field[' . $field_id . ']" value="' . trim($k) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if (isset($requires) && $requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                if (isset($report['0']) && $report['0'] == $k) {
                    $str .= ' checked';
                }
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'checkbox') {
            foreach ($field_value as $k => $v) {
                $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input  type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" name="field[' . $field_id . '][' . $k . ']" value="' . trim($k) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if ($requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                if (isset($report[$k]) && $report[$k] == 1) {
                    $str .= ' checked';
                }
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($Desc != '') {
            $str .= '<div title="' . $Desc . '" data-placement="top" data-toggle="tooltip" '
                    . 'class="stooltip title-button1 status  icons icon-etelaat" style="display: inline-block;font-size: 15px;height: 10px;margin: 10px 10px 0;">'
                    . '</div></td>';
        } else {
            $str .= '</td>';
        }
        return $str;
    }

    public static function field_view($field_id, $field_name, $field_type, $field_value, $requires, $Desc, $report = '', $width = '100%', $view = 'horizontal', $sid = 0) {
        $str = '';
        $str .= '<td';
        if ($field_type == 'comment') {
            $str .= ' class="th"';
        }

        $str .= (($view == 'vertical') ? '' : ' width="120"');
        if ($field_type == 'hyperlink') {
            $str .= '>';
        } else {
            $str .= '>' . $field_name . '';
        }
        if ($requires == 1) {
            $str .= ' <font color="red">*</font>';
        }


        $str .= (($view == 'vertical') ? '<br/>' : '</td><td>');
//   $field_values 

        if ($field_type == 'datapicker') {
            $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report) ? $report : implode('', $field_value)) . '"  class="field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" />' . '<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
            $str .= "  <script type='text/javascript'>
	    $(function() {
	        $('#field_$field_id').datepicker();
});</script>";
        } elseif ($field_type == 'datapicker2') {
            $str .= '<select   id="field_' . $field_id . '" name="field[' . $field_id . ']" data-placeholder="انتخاب کنید"  style="width:200px;" class="chzn-select chzn-rtl field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >';
//(isset($report['0']) ? $report['0'] : implode('', $field_value)) . '
            $str .= '<option value="1">فروردین</option>';
            $str .= '<option value="2">اردیبهشت</option>';
            $str .= '<option value="3">خرداد</option>';
            $str .= '<option value="4">تیر</option>';
            $str .= '<option value="5">مرداد</option>';
            $str .= '<option value="6">شهریور</option>';
            $str .= '<option value="7">مهر</option>';
            $str .= '<option value="8">آبان</option>';
            $str .= '<option value="9">آذر</option>';
            $str .= '<option value="10">دی</option>';
            $str .= '<option value="11">بهمن</option>';
            $str .= '<option value="12">اسفند</option>';
            $str .= '</select><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
        } elseif ($field_type == 'datapicker3') {
            $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" placeholder="فقط سال مانند 1394" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report) ? $report : implode('', $field_value)) . '" style="width:110px;" class="field number';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" /><input  type="hidden" name="type[' . $field_id . ']" value="text" />';
            if ($field_type == 'persons') {
                $str .= '<input  type="hidden" name="field_hid[' . $field_id . ']" class="users1" value="" />';
            }
        } else {
            if (strpos($field_type, 'EYWORD_') == 1) {
                $value = isset($report) ? $report : implode('', $field_value);
                $keyword_ttype = str_replace("KEYWORD_", "", $field_type);
//  $str.= $this->NEW_auto_keywords('title', $value, $keyword_ttype, '400', 'تخصص ', 'required');
            }
        }
        if ($field_type == 'hyperlink') {
            if (isset($_GET['pid']) && $_GET['pid'] != 0) {
                $pid = $_GET['pid'];
            } else {
                $pid = 0;
            }
            if ($sid != 0) {
                $pid = $sid;
            }

//$str.= $field_value;

            $field_valueN = (isset($report) ? $report : implode('', $field_value));
//$str.= $field_valueN;
            $str .= "<a target='_blank' href='$field_valueN?pid=$sid'>{$field_name}</a>";
            $str .= '<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
        } else {
            if ($field_type == 'text' || $field_type == 'number' || $field_type == 'email' || $field_type == 'mellicode' || $field_type == 'tel' || $field_type == 'mobile' || $field_type == 'score' || $field_type == 'users' || $field_type == 'persons') {
                $str .= '<input class="form-control col-xs-6" type="text" id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" value="' . (isset($report) ? $report : implode('', $field_value)) . '"  class="field ' . $field_type . '';
                if ($requires == 1) {
                    $str .= ' required';
                }
                $str .= '" />' . '<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="text" />';
                if ($field_type == 'persons') {
                    $str .= '<input class="form-control col-xs-6" type="hidden" name="field_hid[' . $field_id . ']" class="users1" value="" />';
                }
            }
        }
        if ($field_type == 'textarea') {
            $str .= '<textarea id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" class="field ' . $field_type . ' form-control ';
            if ($requires == 1) {
                $str .= ' required';
            }

            $str .= '" >' . (isset($report) ? $report : implode('|', $field_value)) . '</textarea>
					<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'select') {
            $str .= '<select id="field_' . $field_id . '" name="field[' . $field_id . ']" alt="' . $field_name . '" class="field ' . $field_type . '';
            if ($requires == 1) {
                $str .= ' required';
            }
            $str .= '" >';
            foreach ($field_value as $k => $v) {
                $str .= '<option value="' . trim($k) . '"';
                if (isset($report) && $report == $k) {
                    $str .= ' selected';
                }
                $str .= '>' . trim($v) . '</option>';
            }
            $str .= '</select><input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'radio') {
            foreach ($field_value as $k => $v) {
                if ($v != '') {
                    $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" name="field[' . $field_id . ']" value="' . trim($k) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                    if (isset($requires) && $requires == 1) {
                        $str .= ' required';
                    }
                    $str .= '"';
                    if (isset($report) && $report == $k) {
                        $str .= ' checked';
                    }
                    $str .= '>&nbsp;' . trim($v) . '</label>';
                }
            }
            $str .= '<input class="form-control col-xs-6" type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($field_type == 'checkbox') {
            foreach ($field_value as $k => $v) {
                $str .= '<label style="width:' . $width . '%;display:inline-flex;"><input  type="' . $field_type . '" id="field_' . $field_id . '_' . $k . '" name="field[' . $field_id . '][' . $k . ']" value="' . trim($k) . '" alt="' . $field_value[$k] . '" class="field ' . $field_type . '';
                if ($requires == 1) {
                    $str .= ' required';
                }
                $str .= '"';
                if (isset($report) && $report == '1') {
                    $str .= ' checked';
                }
                $str .= '>&nbsp;' . trim($v) . '</label>';
            }
            $str .= '<input type="hidden" name="type[' . $field_id . ']" value="' . $field_type . '" />';
        }
        if ($Desc != '') {
            $str .= '<div title="' . $Desc . '" data-placement="top" data-toggle="tooltip" '
                    . 'class="stooltip title-button1 status  icons icon-etelaat" style="display: inline-block;font-size: 15px;height: 10px;margin: 10px 10px 0;">'
                    . '</div></td>';
        }
        $str .= '</td>';

        return $str;
    }

    public static function ShowAlert($mes, $type) {
        $res = "<script>jQuery.noticeAdd({
				text: '$mes',
				stay: false,
				type: '$type'
			});</script>";
        //$str .= $res;
    }

    public function GetSiteMenu() {
        if (session('SiteMenu') == '') {
            $urls = DB::table('departments')->where('view', '1')->select('id', 'name as title', 'pid')->orderBy('orders')->get();
            $s = $urls;
            session('SiteMenu', $s);
        } else {
            session('SiteMenu');
        }
        return $s;
    }

    public function CretaeTree1L($paramarray, $idname, $parentidname, $titlename, $x = '0') {
        $refs = '';
        foreach ($paramarray as $row) {
            $ref = &$refs[$row[$idname]];

            $ref['id'] = $row[$idname];
            $ref['parent_id'] = $row[$parentidname];
            $ref['name'] = $row[$titlename];
            if (array_key_exists($x, $row)) {
                $ref['url'] = $row[$x];
            } else {
                $ref['url'] = $row[$titlename];
            }

            if ($row[$parentidname] == 0) {
                $list[$row[$idname]] = &$ref;
            } else {
                $refs[$row[$parentidname]]['children'][$row[$idname]] = &$ref;
            }
        }
        return $refs;
    }

    public function CretaeTree3L($paramarray, $idname, $parentidname, $titlename, $x = '0') {
        $refs = '';
        foreach ( $paramarray as $row) {
            $row = (array) $row;
            $ref = &$refs[$row[$idname]];
            $ref['id'] = $row[$idname];
            $ref['parent_id'] = $row[$parentidname];
            $ref['name'] = $row[$titlename];
            if (array_key_exists($x, $row)) {
                $ref['url'] = $row[$x];
            } else {
                $ref['url'] = $row[$titlename];
            }
                $list[$row[$idname]] = &$ref;
        }
        return $refs;
    }

    public function CretaeTree2L($paramarray, $idname, $parentidname, $titlename) {
        $refs = '';
        foreach ($paramarray as $row) {
            $ref = &$refs[$row[$idname]];
            $ref['id'] = $row[$idname];
            $ref['parent_id'] = $row[$parentidname];
            $ref['name'] = $row[$titlename];
            $ref['url'] = $row[$titlename];

            if ($row[$parentidname] == 0) {
                $list[$row[$idname]] = &$ref;
            } else {
                $refs[$row[$parentidname]]['children'][$row[$idname]] = &$ref;
            }
        }
        return $refs;
    }

    function toUL(array $array) {
        $html = '<ul>' . PHP_EOL;

        foreach ($array as $value) {
            $html .= '<li>' . $value['name'];
            if (!empty($value['children'])) {
                $html .= $this->toUL($value['children']);
            }
            $html .= '</li>' . PHP_EOL;
        }

        $html .= '</ul>' . PHP_EOL;

        return $html;
    }

    function toChild(array $array) {
        $html = '';
        foreach ($array as $value) {
            $html .= "{ label: '" . $value['name'] . "',";
            if (!empty($value['children'])) {
                $html .= "children: [";
                $html .= $this->toChild($value['children']);
                $html .= "]";
            } else {
                $html = ltrim($html, ",");
            }
            $html .= ' },' . PHP_EOL;
        }
        $html = ltrim($html, ",");

        return $html;
    }

    function ULLI($base, $dir) {
        $res = '';
        foreach ($dir as $id => $item) {
            if ($item['parent_id'] == $base) {
                $res .= "<li><UL><LI>" . $item['name'] . "";
                $res .= $this->ULLI($id, $dir);
                $res .= "</LI></UL></LI>";
            }
        }
        return $res;
    }

    function Json($base, $dir, $select = '', $Selected = '') {
        $res = '';
        if (is_array($dir)) {
            foreach ($dir as $id => $item) {
//   if (array_key_exists("parent_id", $item)) {
                $parent = $item['parent_id'];
                $x = $item['url'];
                if (trim($parent) == '' || trim($parent) == '0') {
                    $parent = "#";
                }
                $title = strip_tags($item['name']);
                $url = str_replace($title, '', $item['name']);
                $url = str_replace('<a rel="nofollow" href="', '', $url);
                $url = str_replace('"></a>', '', $url);
                $state = '';
                if ($Selected != '') {
                    if (strripos($item['id'], $select) >= 0 && strripos($item['id'], $Selected) > 0) {
                        $state = ",  'state' : {
           'opened' : true,
           'selected' : true
         }";
                    }
                } else {
                    if ($item['id'] == $select) {
                        $state = ",  'state' : {
           'opened' : true,
           'selected' : true
         }";
                    }
                }

                $res .= '{"id": "' . $item['id'] . '", "parent": "' . $parent . '","li_attr":"' . $x . '", "text": "' . $title . '" ' . $state . ' }, ';
//  }
            }
        }

        return $res;
    }

}
