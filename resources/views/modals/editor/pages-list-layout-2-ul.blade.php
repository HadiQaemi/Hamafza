@if ($is_showing_more)
    @foreach ($items as $item)
        <li>{!! $item !!}</li>
    @endforeach
@else
    @include('modals.editor.pages-list-js')
    @include('modals.editor.pages-list-css')
    <div id="pages-list-client">
        <ul>
            @foreach ($items as $item)
                <li>{!! $item !!}</li>
            @endforeach
        </ul>
    </div>
    {{--<button class="btn" onclick="pages_list_load_more();" style="background-color: #ffff88; color: red; cursor: pointer; padding: 5px 10px; margin: auto auto 25px auto; width: 100%; background-color: #ffff88; ">بارگذاری موارد بیشتر...</button>--}}
@endif
