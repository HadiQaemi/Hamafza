<div>
    @forelse ($items as $item)
        <div style="margin: 10px;">
            <a href="{!! url("page_edit/$item->page_id/text") !!}" target="_blank"><h1>{!! $item->subject_title !!}</h1></a>
            {!! $item->content !!}
        </div>
        <hr />
    @empty
        <div style="margin: 10px;">
            <span>موردی برای نمایش وجود ندارد.</span>
        </div>
    @endforelse
</div>