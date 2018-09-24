<style>
    ::-webkit-scrollbar {width: 8px}
    ::-webkit-scrollbar-track {background: #ccc;}
    ::-webkit-scrollbar-thumb {background: #999;}
</style>
<style>
    #page4_pane2_content{
        overflow-y: scroll !important;
        height: 520px !important;
    }
    .thumb{
        display: none !important;
    }

</style>
@php
    $r = '';
    if ($in_pages && ($for_title || $for_content))
    {
        $r .= '<div id="search_page_" style="color: lightgrey; font-size: 11pt; margin-bottom: 5px;">صفحات</div>';
        $r2 = '<div id="search_page_" style="color: lightgrey; font-size: 11pt; margin-bottom: 5px;">صفحات</div>';
        if ($in_pages && $for_title && $searchs['pages']['title']->count())
        {
            $r .= '<ul class="search_page_">';
            foreach ($searchs['pages']['title'] as $search_item)
            {
                $title = $search_item->title;
                preg_match('/^.{1,150}\s/s', $search_item->title, $match);
                if(isset($match[0]))
                    $title = trim($match[0])== $search_item->title ? $match[0] : $match[0].'... ';
                $r .=
                '
                <li id="search_page_' . $search_item->id . '" style="list-style: inside none square;">
                    <a rel="canonical" href="' . url("/{$search_item->pages[0]->id}") . '?s='.$term.'" target="_blank" style="color: white;">' . ($title ? : '[بدون عنوان]') . '</a>
                </li>
                ';
            }
            $r .= '</ul>';
        }
        if ($in_pages && $for_content && $searchs['pages']['content']->count())
        {
            $r .= '<ul class="search_page_">';
            foreach ($searchs['pages']['content'] as $search_item)
            {
                $title = $search_item->subject->title;
                preg_match('/^.{1,150}\s/s', $search_item->subject->title, $match);
                if(isset($match[0]))
                    $title = trim($match[0])== $search_item->subject->title ? $match[0] : $match[0].'... ';
                $r .=
                '
                <li id="search_page_' . $search_item->id . '" style="list-style: inside none square;">
                    <a rel="canonical" href="' . url("/{$search_item->id}") . '?s='.$term.'" target="_blank" style="color: white;">' . "{$title} ({$search_item->tab_name})" . '</a>
                </li>
                ';
            }
            $r .= '</ul>';
        }
    }
    if ($in_posts && $searchs['posts']->count())
    {
        $r .= '<div id="search_post_" style="color: lightgrey; font-size: 11pt; margin-bottom: 5px;">پست&zwnj;ها</div>';
        $r .= '<ul class="search_post_">';
        foreach ($searchs['posts'] as $search_item)
        {
            $title = $search_item->subject->title;
            preg_match('/^.{1,150}\s/s', $search_item->subject->title, $match);
            if(isset($match[0]))
                $title = trim($match[0])== $search_item->subject->title ? $match[0] : $match[0].'... ';
            $r .=
            '
            <li id="search_post_' . $search_item->id . '" style="list-style: inside none square;">
                <a rel="canonical" href="' . url("/$search_item->sid/forum#$search_item->id") . '" target="_blank" style="color: white;">' . ($title ? : '[بدون عنوان]') . '</a>
            </li>
            ';
        }
        $r .= '</ul>';
    }
    $r = trim($r)!=$r2 ? $r : 'موردی جهت نمایش موجود نیست.<br />';
    echo ($r);
@endphp