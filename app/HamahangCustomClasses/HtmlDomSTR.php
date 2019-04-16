<?php

namespace App\HamahangCustomClasses;
use \Htmldom;

class HtmlDomSTR extends Htmldom
{
    public function __construct($type='str',$str=null, $lowercase=true, $forceTagsClosed=true, $target_charset=DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT, $defaultSpanText=DEFAULT_SPAN_TEXT)
    {
        if ($str)
        {
            if ($type!='str' && (preg_match("/^(http|https):\/\//i",$str) || is_file($str)))
            {
                $this->load_file($str);
            }
            else
            {
                ini_set('memory_limit', '-1');
                $this->load($str, $lowercase, $stripRN, $defaultBRText, $defaultSpanText);
            }
        }
        // Forcing tags to be closed implies that we don't trust the html, but it can lead to parsing errors if we SHOULD trust the html.
        if (!$forceTagsClosed) {
            $this->optional_closing_array=array();
        }
        $this->_target_charset = $target_charset;
    }
}