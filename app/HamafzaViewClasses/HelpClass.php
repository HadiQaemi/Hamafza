<?php

namespace App\HamafzaViewClasses;

use Auth;
use Illuminate\Support\Facades\DB;
use App\HamafzaGrids\SubjectGrids;

class HelpClass {

    public static function Show($uname) {
        $s = AJAX::showAllhelps();
        
        return array('content' => $c,);

        return View::make('pages.Desktop.allhelps', array('PageType' => 'desktop', 'SiteLogo' => $ret['SiteLogo'], 'MyOrganGroups' => $MyOrganGroups, 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                    'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                    'menu' => $ret['menu'], 'content' => $s, 'Files' => '', 'keywords' => '',
                    'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'menutools' => $MenuTools));
    }

    public static function Shown($uname) {
        $uid = Auth::id();
        $pages = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')->select('p.id', 's.title', 'p.body')->whereRaw("body like '%{{Help+%'")->get();
        $op = '';
        $ss = array();
        $i = 1;
        foreach ($pages as $page) {
            $body = $page->body;
            $pattern = "/{{Help\+.*=.*}}/";
            if ($num1 = preg_match_all($pattern, $body, $array)) {
                for ($x = 0; $x < $num1; $x++) {
                    $orig = $array['0'][$x];
                    $key = str_replace("{{Help+", "", $array['0'][$x]);
                    $key = str_replace("}}", "", $key);
                    $pos = strpos($key, "=");
                    $key = substr($key, $pos + 1, strlen($key) - $pos);
                    $Rel = '';
                    $pages = DB::table('page_help_groups')->where('R', $orig)->get();
                    foreach ($pages as $values) {
                        $v = $values->T;
                        $keys = str_replace("{{Help+", "", $v);
                        $keys = str_replace("}}", "", $keys);
                        $pos = strpos($keys, "=");
                        $keys = substr($keys, $pos + 1, strlen($keys) - $pos);
                        $Rel .= ',' . $keys;
                    }

                    $s = array("pid" => $page->id, "page_title" => $page->title, "title" => $key, "orig" => $orig, "sortid" => $i, "Rel" => $Rel);
                    $pages = DB::table('page_help_groups')->where('T', $orig)->get();
                    foreach ($pages as $values) {
                        $v = $values->R;
                        $keys = str_replace("{{Help+", "", $v);
                        $keys = str_replace("}}", "", $keys);
                        $pos = strpos($keys, "=");
                        $keys = substr($keys, $pos + 1, strlen($keys) - $pos);
                        $Rel .= ',' . $keys;
                    }
                    $s = array("pid" => $page->id, "page_title" => $page->title, "title" => $key, "orig" => $orig, "sortid" => $i, "Rel" => $Rel);
                    array_push($ss, $s);
                    $i++;
                }
            }
        }

        return
                    [
                    'PageType' => 'desktop',
                    'current_tab' => 'desktop',
                    'content' => $s
        ];
    }

}
