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
    <div class="row col-lg-12" style="border-top: 1px solid #eee;padding-top: 10px;">
        آیا این راهنما مفید بود؟
        <span class="margin-right-10"><label for="yes">بله</label><input type="radio" id="yes"></span>
        <span><label for="no">خیر</label><input type="radio" id="no"></span>
    </div>
    <div class="row col-lg-12">
        <textarea class="form-control" rows="5" id="coment_help" placeholder="پیشنهاد شما برای بهتر شدن این راهنما چیست؟"></textarea>
    </div>
</div>

<script>
    //gsbn = new GeminiScrollbar({element: document.querySelector('#helpviewDiv'), forceGemini: true}).create();
</script>
