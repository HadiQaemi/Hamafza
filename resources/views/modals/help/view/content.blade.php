<div class="panel-body text-decoration " id="helpviewDiv" style="top: 10px;margin:0; padding: 20px;width:100%;line-height: 16pt;height: 100%;overflow: auto" id="HelpContent">
    {!! $view !!}<br />
    <div>
        @if (@$see_alsos)
            @if (@$see_alsos->count())
                <div>این موارد را نیز ببینید:</div>
                <ul>
                    @foreach ($see_alsos as $v)
                        <li><a href="#" onclick="get_content(this, '{!! ($v->help->id == $id ? (isset($v->help2) ? enCode($v->help2->id) : '') : enCode($v->help->id)) !!}');">{!! ($v->help->id == $id ? (isset($v->help2) ? $v->help2->title : '') : $v->help->title) !!}</a></li>
                    @endforeach
                </ul>
            @endif
        @endif
    </div>
    <div class="row col-lg-11" style="border-top: 1px solid #eee;padding-top: 10px;">
        آیا این راهنما مفید بود؟
        <span class="margin-right-10"><input type="radio" name="help_status" value="yes" id="good_help" checked><label for="good_help">بله</label></span>
        <span><input type="radio" name="help_status" value="no" id="bad_help"><label for="bad_help">خیر</label></span>
    </div>
    <div class="col-xs-1" style="border-top: 1px solid #eee;padding-top: 10px;">
        <button class="btn btn-primary">ارسال</button>
    </div>
    <div class="row col-lg-12 help_comment hidden">
        <textarea class="form-control" rows="5" id="coment_help" placeholder="پیشنهاد شما برای بهتر شدن این راهنما چیست؟"></textarea>
        <br/>

    </div>
</div>

<script>
    //gsbn = new GeminiScrollbar({element: document.querySelector('#helpviewDiv'), forceGemini: true}).create();
</script>
