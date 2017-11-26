@if ($is_showing_more)
    @include('modals.editor.pages-list-layout-2-get')
@else
    <div id="pages-list-client-{!! $show_more_sign !!}" data-page="1">
        @include('modals.editor.pages-list-layout-2-get')
    </div>
    @include('modals.editor.pages-list-more')
    <div class="clear"></div>
@endif
