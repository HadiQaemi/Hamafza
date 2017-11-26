@if ($show_more)
    <button class="btn more_btn_normal more_btn-{!! $show_more_sign !!}" onclick="pages_list_load_more('{!! $SPLIP !!}', '{!! $show_more_sign !!}', this);">
        <span>بارگذاری موارد بیشتر ({!! $more_count !!})...</span>
    </button>
@endif
