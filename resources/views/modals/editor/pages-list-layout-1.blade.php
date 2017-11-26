@php ($seperator = '&nbsp;●&nbsp;')
@if ($is_showing_more)
    &nbsp;{!! $seperator !!} {!! implode($seperator, $items) !!}
@else
    <div id="pages-list-client-{!! $show_more_sign !!}" data-page="1">
        {!! implode($seperator, $items) !!}
    </div>
    @include('modals.editor.pages-list-more')
@endif
