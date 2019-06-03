<?php

namespace App\HamafzaServiceClasses;

use App\Models\Hamahang\Help;
use App\Models\Hamahang\Help2;
use App\Models\Hamahang\HelpBlock;

include ('PageClassExtend1.php');

class PageClass extends PageClassExtend1
{

    const help_tag_term = 'ر';

    public static function helper_finder($html)
    {
        $term = self::help_tag_term;
        $open = '\{\{';
        $close = '\}\}';
        $matches = [];
        $pattern = "$open$term\|(.+)(\|[0-9a-z]*)$close(.+)$open$term$close";
        $preg_match = preg_match_all("/$pattern/is", $html, $matches, PREG_SET_ORDER);
        return $preg_match ? $matches : false;
    }

    public static function helper_viewer($html)
    {
        $term = self::help_tag_term;
        $open = '{{';
        $close = '}}';
        $explode = explode("$open$term$close", $html);
        $r = [];
        foreach ($explode as $v)
        {
            $matches = self::helper_finder("$v$open$term$close");
            if (false == $matches)
            {
                $r[] = $v;
            } else
            {
                foreach ($matches as $match)
                {
                    $r[] = str_replace($match[0], $match[3], "$v$open$term$close");
                }
            }
        }
        return implode('', $r);
    }

    public static function helper_maker($html, $page_id)
    {
        $term = self::help_tag_term;
        $open = '{{';
        $close = '}}';
        $explode = explode("$open$term$close", $html);
        foreach ($explode as $v)
        {
            $is_new = false;
            $matches = self::helper_finder("$v$open$term$close");
            if (false == $matches)
            {
                $r[] = $v;
            } else
                foreach ($matches as $match_k => $match)
                {
                    $title = trim($match[1]);
                    $code = trim($match[2]);
                    $content = trim($match[3]);
                    $created_by = auth()->id();
                    $id = 0;
                    if ('|0' == $code)
                    {
                        $is_new = true;
                    } else
                    {
                        $explode = explode('h', str_replace('|', null, $code));
                        if (2 == count($explode))
                        {
                            if (hash('crc32', $explode[0]) == $explode[1])
                            {
                                $is_new = false;
                                $id = $explode[0];
                            } else
                            {
                                $is_new = true;
                            }
                        }
                    }
//                    $help_data_array = ['title' => $title, 'created_by' => $created_by, ];
//                    $help = Help::where('title', $help_data_array['title']);
//                    $help_id = $help->count() ? $help->first()->id : Help::create($help_data_array)->id;
//                    $help_block_data_array = ['help_id' => $help_id, 'page_id' => $page_id, 'content' => $content, 'created_by' => auth()->id(), ];
//                    if ($is_new)
//                    {
//                        $term = self::help_tag_term;
//                        $help_block = HelpBlock::create($help_block_data_array);
//                        $crc32 = hash('crc32', $help_block->id);
//                        $r[] = str_replace($matches[$match_k][0], $open . $term . '|' . $title . '|' . $help_block->id . 'h' . $crc32 . $close . $content . $open . $term . $close, "$v$open$term$close");
//                    } else
//                    {
//                        $help_block = HelpBlock::find($id);
//                        $help_block->update($help_block_data_array);
//                        $r[] = "$v$open$term$close";
//                    }

                    $help_data_array = ['title' => $title, 'created_by' => $created_by, ];
                    $help = HelpBlock::where('hamahang_help_blocks.id','=',$id)
                        ->leftJoin('hamahang_helps','help_id','=','hamahang_helps.id')->select('hamahang_helps.*');
                    if($help->count())
                    {
                        $this_help = Help::find($help->first()->id);
                        $this_help->update(
                            [
                                'title' => $title
                            ]);
                    }
                    $help_id = $help->count() ? $help->first()->id : Help::create($help_data_array)->id;
                    $help_block_data_array = ['help_id' => $help_id, 'page_id' => $page_id, 'content' => $content, 'created_by' => auth()->id(), ];
                    if ($is_new)
                    {
                        $term = self::help_tag_term;
                        $help_block = HelpBlock::create($help_block_data_array);
                        $crc32 = hash('crc32', $help_block->id);
                        $r[] = str_replace($matches[$match_k][0], $open . $term . '|' . $title . '|' . $help_block->id . 'h' . $crc32 . $close . $content . $open . $term . $close, "$v$open$term$close");
                    } else
                    {
                        $help_blockhelp_block = HelpBlock::find($id);
                        $help_blockhelp_block->update($help_block_data_array);
                        $r[] = "$v$open$term$close";
                    }
                }
            {
            }
        }
        return implode('', $r);
    }


    public static function helper_finder_new($html)
    {
        $term = self::help_tag_term;
        $open = '\{\{';
        $close = '\}\}';
        $matches = [];
//        $pattern = "$open$term\|(.+)(\|[0-9a-z]*)$close(.+)$open$term$close";
        $pattern = "$open$term(.+?)$close(.+)$open$term$close";
        $preg_match = preg_match_all("/$pattern/is", $html, $matches, PREG_SET_ORDER);
        return $preg_match ? $matches : false;
    }

    public static function helper_viewer_new($html)
    {
        $term = self::help_tag_term;
        $open = '{{';
        $close = '}}';
        $explode = explode("$open$term$close", $html);
        $r = [];
        foreach ($explode as $v)
        {
            $matches = self::helper_finder("$v$open$term$close");
            if (false == $matches)
            {
                $r[] = $v;
            } else
            {
                foreach ($matches as $match)
                {
                    $r[] = str_replace($match[0], $match[2], "$v$open$term$close");
                }
            }
        }
        return implode('', $r);
    }

    public static function helper_maker_new($html, $page_id)
    {

        $term = self::help_tag_term;
        $open = '{{';
        $close = '}}';
        $explode = explode("$open$term$close", $html);
        foreach ($explode as $v)
        {
            $is_new = false;
            $matches = self::helper_finder("$v$open$term$close");

            if (false == $matches)
            {
                $r[] = $v;
            } else
                foreach ($matches as $match_k => $match)
                {
                    $data = explode('|',$match[1]);
                    $title = trim($data[1]);
                    $code = 0;

                    if(isset($data[2]))
                        $code = trim($data[2]) != '' ? (trim($data[2])) : 0;
                    $code = deCode($code);

                    $content = trim($match[2]);
                    $created_by = auth()->id();

                    $help_data_array = ['title' => $title, 'created_by' => $created_by, 'content' => $content];
                    $crc32 = hash('crc32', $code);
                    $help = Help2::find($code);
                    if($help == null){
                        $code = Help2::create($help_data_array)->id;
                    }else{
                        $help->update($help_data_array);
                    }
                    $r[] = str_replace($matches[$match_k][0], $open . $term . '|' . $title . '|' . enCode($code) . '|' . $crc32 . $close . $content . $open . $term . $close, "$v$open$term$close");

                }
            {
            }
        }
        return implode('', $r);
    }


}
