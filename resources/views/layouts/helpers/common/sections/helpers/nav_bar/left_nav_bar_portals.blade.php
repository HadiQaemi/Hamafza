@php
    if (count($subjects) >= 2)
    {
        $have_title =  $subjects['public']->count() && $subjects['private']->count() ? true : false;
    }
@endphp
@foreach ($subjects as $subject_type => $subject_items)
    @if ($subject_items->count())
        @if ($have_title)
            <div id="bookmark_' . $subject_type . '" style="color: lightgrey; font-size: 11pt; margin-bottom: 5px;">{!! $subject_types[$subject_type] !!}</div>
        @endif
        <ul class="bookmark_' . $subject_type . '">
            @foreach ($subject_items as $subject_item)
                @if ('public' == $subject_type)
                    @php ($can_view = policy_CanView($subject_item->id, 'App\Models\hamafza\Subject', '\App\Policies\SubjectPolicy', 'canView'))
                @else
                    @php ($can_view = true)
                @endif
                @if ($can_view)
                    @if (isset($subject_item->pages[0]))
                        <li id="portal_' . $subject_item->pages[0]->id . '" style="list-style: inside none square;">
                            <a rel="canonical" href="{!! url($subject_item->pages[0]->id) !!}" target="_blank">{!! $subject_item->title !!}</a>
                        </li>
                    @endif
                @endif
            @endforeach
        </ul>
    @endif
@endforeach
