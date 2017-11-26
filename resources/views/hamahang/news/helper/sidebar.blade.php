<div>
    <div class="panel-heading panel-heading-darkblue">
        {{ trans('enquiry.keywords') }}
        {{--
        <div class="pull-left"><input type="checkbox" class="no_empty" id="no_empty" onclick="fill_grid()" checked="checked" /><label for="no_empty">{{ trans('enquiry.keywords_no_empty') }}</label></div>
        --}}
    </div>
    <div class="panel panel-light panel-list padding-remove">
        <div class="panel-body new-list">
            <input type="text" id="keyword_search" placeholder="غربال..." />
            <table width="100%" class="table" style="margin: 0px; padding: 0px;">
                <thead>
                    <th style="width: 80%;">{{trans('tools.title')}}</th>
                    <th style="width: 20%; text-align: center;">{{trans('tools.count')}}</th>
                </thead>
            </table>
            <div style="direction: rtl; max-height: 300px; overflow-y: auto;" id="keyword_content">
                <table id="Keyword_Grid" width="100%" class="table table-hover">
                    @if ($keywords)
                        @foreach ($keywords as $keyword)
                            <tr>
                                <td style="width: 90%;">
                                    <a href="#" class="h-tag" data-tagid="{!! $keyword->id !!}" data-tagtitle="{!! $keyword->title !!}" style="margin: 0; padding: 0;">
                                        {!! $keyword->title !!}
                                    </a>
                                </td>
                                <td style="width: 10%; text-align: center;">
                                    {!! $keyword->subjects_count !!}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
        <center><img src="{!! url('/img/ajax-loading.gif') !!}" style="margin: 5px; visibility: hidden;" id="keyword_loading" /></center>
    </div>
</div>
