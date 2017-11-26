<br />
@forelse ($contents as $content)
    @php ($content->page = $content->pages->first())
    <table class="table table_news">
        <tr>
            <td class="col-sm-2" rowspan="3">
                <a href="{!! url($content->page->id) !!}" target="_blank">
                    <img src="{!! $content->def_image_url !!}" style="border: lightgrey solid 1px; height: 150px; padding: 2px; width: 150px;" />
                </a>
            </td>
            <td class="col-sm-10">
                <div style="font-size: 18px;">
                    <a href="{!! url($content->page->id) !!}" target="_blank">
                        {!! $content->title !!}
                    </a>
                    @if ($content->is_owner)
                        <a class="pull-left" href="{!! url("page_edit/{$content->page->id}/text") !!}" target="_blank"><i class="fa fa-pencil"></i></a>
                    @endif
                </div>
                <div style="text-align: justify; margin: 20px 0;">
                    {!! $content->page->description !!}<br />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                @foreach ($content->keywords as $keyword)
                    <a href="#" class="h-tag" data-tagid="{!! $keyword->id !!}" data-tagtitle="{!! $keyword->title !!}"><span class="h-span-keyword"><i class="fa fa-tag" aria-hidden="true"></i> {!! $keyword->title !!}</span></a>
                @endforeach
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {!! "{$content->jalali_reg_date_name} {$content->owner->small_avatar}{$content->owner->full_name}" !!}
            </td>
        </tr>
    </table>
    <hr />
@empty
    <div style="padding: 10px;">{{ trans('news.no_content') }}</div>
@endforelse
