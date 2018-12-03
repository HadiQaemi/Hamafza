@forelse ($keywords as $keyword_type => $keyword_items)
    @if ($keyword_items->count())
        <div id="keyword_{{$keyword_type}}" style="color: lightgrey; font-size: 11pt; margin-bottom: 5px;">{!! $keyword_types[$keyword_type] !!}</div>
        <ul class="keyword_{{$keyword_type}}">
            @php ($r = null)
            @foreach ($keyword_items as $keyword_item)
                @php
                    if($keyword_type != 'special')
                    {
                        $title = $keyword_item->title;
                        //preg_match('/^.{1,60}\s/s', $keyword_item->title, $match);
                        //if(isset($match[0]))
                            //$title = trim($match[0])== $keyword_item->title ? $match[0] : $match[0].'... ';
                    }
                    switch ($keyword_type)
                    {
                        case 'special':
                        {
                            $r .=
                            '
                            <li id="keyword_' . $keyword_item->id . '" style="list-style: inside none square; margin-bottom: 5px;">
                                <a rel="canonical" href="' . url($keyword_item->Uname) . '" target="_blank"><i class="fa fa-eercast padding-left-10"></i>' . $keyword_item->FullName . '</a>
                            </li>
                            ';
                            break;
                        }
                        case 'subject':
                        {
                            if (isset($keyword_item->pages[0]))
                            {
                                $r .=
                                '
                                <li id="keyword_' . $keyword_item->id . '" style="list-style: inside none square; margin-bottom: 5px;">
                                    <a rel="canonical" href="' . url($keyword_item->pages[0]->id) . '" target="_blank" title="'. $keyword_item->title .'"><i class="fa fa-eercast padding-left-10"></i>' . $title . '</a>
                                </li>
                                ';
                            }
                            break;
                        }
                        case 'enquiry_pages':
                        {
                            if ($keyword_item->subject)
                            {
                                if (20 == $keyword_item->subject->kind)
                                {
                                    $r .=
                                    '
                                    <li id="keyword_' . $keyword_item->id . '" style="list-style: inside none square; margin-bottom: 5px;">
                                        <a rel="canonical" href="' . url("{$keyword_item->sid}0/enquiry/$keyword_item->id") . '" title="'. $keyword_item->title .'"><i class="fa fa-eercast padding-left-10"></i>' . $title . '</a>
                                    </li>
                                    ';
                                }
                            }
                            break;
                        }
                    }
                @endphp
            @endforeach
            {!! $r !!}
        </ul>
    @endif
@empty
    موردی جهت نمایش موجود نیست.<br />
@endforelse
