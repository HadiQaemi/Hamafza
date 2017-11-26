<?php

namespace App\HamafzaServiceClasses;

use App\Models\Hamahang\Help;
use App\Models\Hamahang\HelpBlock;

include ('PageClassExtend1.php');

class PageClass extends PageClassExtend1
{

    public static function helper_finder($html)
    {
        $matches = [];
        $preg_match = preg_match_all('/\[help\|(.+)(\|[0-9a-z]*)\](.+|[^\[help;\]])\[help;\]/i', $html, $matches, PREG_SET_ORDER);
        return $preg_match ? $matches : false;
    }

    public static function helper_viewer($html)
    {
        $matches = self::helper_finder($html);
        if (false !== $matches)
        {
            foreach ($matches as $match)
            {
                $html = str_replace($match[0], $match[3], $html);
            }
        }
        return $html;
    }

    public static function helper_maker($html, $page_id)
    {
        $is_new = false;
        $matches = self::helper_finder($html);
        if (false !== $matches)
        {
            foreach ($matches as $match_k => $match)
            {
                //$whole = trim($match[0]);
                $title = trim($match[1]);
                $code = trim($match[2]);
                $content = trim($match[3]);
                $created_by = auth()->id();
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
                $help_data_array = ['title' => $title, 'created_by' => $created_by, ];
                $help = Help::where('title', $help_data_array['title']);
                $help_id = $help->count() ? $help->first()->id : Help::create($help_data_array)->id;
                $help_block_data_array = ['help_id' => $help_id, 'page_id' => $page_id, 'content' => $content, 'created_by' => auth()->id(), ];
                if ($is_new)
                {
                    $help_block = HelpBlock::create($help_block_data_array);
                    $crc32 = hash('crc32', $help_block->id);
                    $html = str_replace($matches[$match_k][0], "[help|$title|{$help_block->id}h$crc32]{$content}[help;]", $html);
                } else
                {
                    $help_block = HelpBlock::find($id);
                    $help_block->update($help_block_data_array);
                }
            }
        }
        return $html;
    }

}
