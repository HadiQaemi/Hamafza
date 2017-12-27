<script language="javascript" type="text/javascript">
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 116px; top: -3px;"><a href="{!! url('/modals/helpview?code=LmwBEEoNwME') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
    $(document).click(function () {
        $("#wordexport").off();
        $("#pdfexport").off();
        $("#wordexport").click(function () {
            var checkedVals = $('.field:checkbox:checked').map(function () {
                return this.value;
            }).get();
            var Numbers = $('#Numbers:checkbox:checked').map(function () {
                return this.value;
            }).get();
            ch = checkedVals.join(",");
            sid = '{{$sid}}';
            pid = '{{$pid}}';
            type = 2;
            if (ch == '') {
                alert("یکی از گزینه ها را انتخاب کنید");
                $(this).attr("href", "");
            }
            else {
                $(this).attr("href", "Export?type=word&sid={{$sid}}&numbers=" + Numbers + "&pid={{$pid}}&title={{$_GET['title']}}")
            }
        });
        $("#pdfexport").click(function () {
            var Numbers = $('#Numbers:checkbox:checked').map(function () {
                return this.value;
            }).get();
            var checkedVals = $('.field:checkbox:checked').map(function () {
                return this.value;
            }).get();
            ch = checkedVals.join(",");
            sid = '{{$sid}}';
            pid = '{{$pid}}';
            type = 2;
            if (ch == '') {
                alert("یکی از گزینه ها را انتخاب کنید");
                $(this).attr("href", "");
            }
            else {
                $(this).attr("href", "Export?type=pdf&sid={{$sid}}&numbers=" + Numbers + "&pid={{$pid}}&title={{$_GET['title']}}")
            }
        });
    });
</script>
<div style="padding: 5px">
    <div id="Tabs">
        {{--
        <span class="help-icon-span WindowHelpIcon">
            <a data-toggle="tooltip" data-placement="top" style="float: left;padding-left: 20px;" class="jsPanels icon-help HelpIcon" title="راهنمای اینجا" href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzarbargiri&hid=6"></a>
        </span>
        <br>
        --}}
        <p><input class="field" checked="checked" name="Numbers" id="Numbers" type="checkbox">شماره گذاری عناوین</p>
        @if (is_array($tabs))
            @foreach($tabs as $item)
                @if($item->pid==$pid)
                    <input class="field" checked="checked" name="pids" value="{{$item->pid}}" type="checkbox">{{ $item->name}}
                @else
                    <input class="field" name="pids" value="{{$item->pid}}" type="checkbox">{{ $item->name}}
                @endif
            @endforeach
        @endif
    </div>
</div>