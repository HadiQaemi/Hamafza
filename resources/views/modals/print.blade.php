<script language="javascript" type="text/javascript">
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 116px; top: -3px;"><a href="{!! url('/modals/helpview?code=tULNPfudM0A') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
    var change = false;
            function printDiv(divID) {
            if (change){
            var checkedVals = $('.field:checkbox:checked').map(function() {
            return this.value;
            }).get();
                    ch = checkedVals.join(",");
                    sid = {{$sid}};
                    pid = {{$pid}};
                    type = 2;
                    if (ch == '')
                    alert("یکی از گزینه ها را انتخاب کنید");
                    else {
                    $.ajax({
                    type: "POST",
                            url: '{{ route('print_subject') }}',
                            dataType: 'html',
                            data: ({sid: sid, pid: pid, type: type, ch: ch}),
                            success: function(theResponse) {
                            $("#PrintView").html(theResponse);
                                    var divElements = $(divID).html();
                                    var oldPage = document.body.innerHTML;
                                    document.body.innerHTML =
                                    "<html><head><title></title></head><body>" +
                                    divElements + "</body>";
                                    window.print();
                                    document.body.innerHTML = oldPage;
                            }
                    });
                    }
            }
            else{
            var divElements = $(divID).html();
                    var oldPage = document.body.innerHTML;
                    document.body.innerHTML =
                    "<html><head><title></title></head><body>" +
                    divElements + "</body>";
                    window.print();
                    document.body.innerHTML = oldPage;
            }

            }
    $('.field').click(function()
    {
    change = true;
    });
            $("#PrevBtn").click(function()
    {

    var checkedVals = $('.field:checkbox:checked').map(function() {
    return this.value;
    }).get();
            ch = checkedVals.join(",");
            sid = {{$sid}};
            pid = {{$pid}};
            type = 2;
            if (ch == '')
            alert("یکی از گزینه ها را انتخاب کنید");
            else {
            $.ajax({
            type: "POST",
                    url: '{{ route('print_subject') }}',
                    dataType: 'html',
                    data: ({sid: sid, pid: pid, type: type, ch: ch}),
                    success: function(theResponse) {
                    $("#PrintView").html(theResponse);
                    }
            });
            }
    });</script>
<br>

<div style="padding: 5px">
    <div id="Tabs" class="Box">
        @if (is_array($tabs))
        @foreach($tabs as $item)
        @if($item->pid==$pid)
                <input class="field" checked="checked" name="pids" value="{{$item->pid}}" type="checkbox">{{ $item->name}}
        @else
                      <input class="field" name="pids" value="{{$item->pid}}" type="checkbox">{{ $item->name}}

        @endif

        @endforeach
        @endif
        <span class="FloatLeft">
            <input type="submit" id="printBtn" name="announce_add" value="چاپ" class="btn btn-primary" onclick="printDiv('#PrintView')">
            <input type="submit" id="PrevBtn" name="announce_add" value="پیش نمایش"   class="btn btn-primary">
        </span>
    </div>

    <div id="PrintView">
        {!!$print!!}
    </div>

</div>