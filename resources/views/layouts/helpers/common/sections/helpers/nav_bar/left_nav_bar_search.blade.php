@php
    $r = null;
    if ($in_pages && ($for_title || $for_content))
    {
        $r .= '<div id="search_page_" style="color: lightgrey; font-size: 11pt; margin-bottom: 5px;">صفحات</div>';
        if ($in_pages && $for_title && $searchs['pages']['title']->count())
        {
            $r .= '<ul class="search_page_">';
            foreach ($searchs['pages']['title'] as $search_item)
            {
                $r .=
                '
                <li id="search_page_' . $search_item->id . '" style="list-style: inside none square;">
                    <a rel="canonical" href="' . url("/{$search_item->pages[0]->id}") . '" target="_blank" style="color: white;">' . ($search_item->title ? : '[بدون عنوان]') . '</a>
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
                $r .=
                '
                <li id="search_page_' . $search_item->id . '" style="list-style: inside none square;">
                    <a rel="canonical" href="' . url("/{$search_item->id}") . '" target="_blank" style="color: white;">' . "{$search_item->subject->title} ({$search_item->tab_name})" . '</a>
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
            $r .=
            '
            <li id="search_post_' . $search_item->id . '" style="list-style: inside none square;">
                <a rel="canonical" href="' . url("/$search_item->sid/forum#$search_item->id") . '" target="_blank" style="color: white;">' . ($search_item->title ? : '[بدون عنوان]') . '</a>
            </li>
            ';
        }
        $r .= '</ul>';
    }
    $r = $r ? $r : 'موردی جهت نمایش موجود نیست.<br />';
    echo ($r);
@endphp