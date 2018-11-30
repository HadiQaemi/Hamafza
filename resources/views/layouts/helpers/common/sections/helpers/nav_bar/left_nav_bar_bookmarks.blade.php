@foreach ($bookmarks as $bookmark_type => $bookmark_items)
    @if ($bookmark_items->count())
        <div id="bookmark_{!! $bookmark_type !!}" style="color: lightgrey; font-size: 11pt; margin-bottom: 5px;">{!! $bookmark_types[$bookmark_type] !!}</div>
        <ul class="bookmark_{!! $bookmark_type !!}">
            @foreach ($bookmark_items as $bookmark_item)
                <li id="bookmark_{!! $bookmark_item->id !!}" style="list-style: inside none square;">
                    <a rel="canonical" href="{!! url("/bookmarks/view/$bookmark_item->id") !!}" target="_blank">{!! (trim($bookmark_item->pretitle)!='' ? '<span>'.$bookmark_item->pretitle.':</span> ' : '').$bookmark_item->title !!}</a>
                    <span class="help-icon-span icon-hazv HazfBookmark" data-bookmark-id="{!! $bookmark_item->id !!}"></span>
                </li>
            @endforeach
        </ul>
    @else
        @php ($empty[$bookmark_type] = true)
    @endif
@endforeach
@if ($empty['user'] && $empty['page'] && $empty['group'] && $empty['channel'])
    تا کنون در صفحه‌ای چوب الف نگذاشته‌اید.
    <br/>
    با استفاده از ابزار چوب الف، می‌توانید فهرستی از صفحات مورد نظرتان را در اینجا قرار دهید،
    <br/>
    برای این کار روی ابزار چوب الف (که در نوار ابزارها قرار دارد) در صفحه مورد نظر کلیک نمایید.
@endif