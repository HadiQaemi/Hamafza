<div class="panel-body text-decoration " id="helpviewDiv" style="top: 10px;margin:0; padding: 20px;width:100%;line-height: 16pt;height: 100%;overflow: auto" id="HelpContent">
    {!! $view !!}<br />
    <div>
        @if (@$see_alsos)
            @if (@$see_alsos->count())
                <div>این موارد را نیز ببینید:</div>
                @foreach ($see_alsos as $v)
                    <a href="#" onclick="get_content(this, '{!! enCode($v->id) !!}');">{!! $v->title !!}</a>
                    <br />
                @endforeach
            @endif
        @endif
    </div>
    <br />
</div>

<script>
    //gsbn = new GeminiScrollbar({element: document.querySelector('#helpviewDiv'), forceGemini: true}).create();
</script>
