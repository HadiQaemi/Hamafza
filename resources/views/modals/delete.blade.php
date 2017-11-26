@if(auth()->check() && auth()->user()->hasRole('administrator'))
    <script language="javascript" type="text/javascript">
        $('.delbtn').click(function () {
            sid ={{$sid}};
            type = $(this).attr("id");
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.delete_subject') }}',
                dataType: 'html',
                data: ({sid: sid, type: type}),
                success: function (theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                    location.reload();
                }
            });

        });</script>
    <br>
    <span class="help-icon-span WindowHelpIcon">
<a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzarhazf&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top"
   data-toggle="tooltip">
</a>
</span>
    <br>
    <div style="padding: 5px;min-height:150px;">
        @if($SubjectArchive=='0')
            <span class="FloatLeft">
        <a id="del" class="delbtn btn btn-primary"> انتقال به سطل بازیافت </a>
    </span>
        @elseif($SubjectArchive=='1')
            <span class="FloatLeft">
        <a id="finaldel" class="delbtn btn btn-primary">حذف نهایی</a>
        <a id="restore" class="delbtn btn btn-primary">بازگردانی از سطل بازیافت</a>
    </span>
        @endif
    </div>

@else
    کاربر ناشناس
@endif
