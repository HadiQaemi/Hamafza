@if (auth()->check() && auth()->user()->hasRole('administrator'))
    <script language="javascript" type="text/javascript">
        $('.delete_button').click(function ()
        {
            $('.jsglyph-close').click();
            $.ajax
            ({
                type: 'post',
                url: '{{ route('hamafza.delete_subject') }}',
                dataType: 'json',
                data: ({'sid': '{{ $sid }}', 'type': $(this).attr('id')}),
                success: function(response)
                {
                    jQuery.noticeAdd({text: response[0], stay: false, type: 'success'});
                    window.location.href = response[2] ? '{!! route('page.desktop.index', auth()->user()->Uname) !!}' : '';
                }
            });

        });
    </script>
    <br />
    <span class="help-icon-span WindowHelpIcon">
        <a href="{{ url('/modals/helpview?id=17&tagname=abzarhazf&hid=6') }}" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a>
    </span>
    <br>
    <div style="padding: 0 15px; min-height: 150px;">
        @if ($archived)
            <span>شما در حال بازبینی صفحه حذف شده هستید، می توانید آن را <strong style="color: red;">حذف نهایی</strong> یا <strong style="color: green;">بازگردانی</strong> کنید.</span>
            <div style="margin-top: 15px;">
                <a id="delete" class="btn btn-danger delete_button">حذف نهایی</a>
                <a id="restore" class="btn btn-success delete_button">بازگردانی از سطل بازیافت</a>
            </div>
        @else
            <span>شما در حال انتقال این صفحه به <strong style="color: orange;">سطل بازیافت</strong> هستید.</span>
            <div style="margin-top: 15px;">
                <a id="recycle" class="btn btn-warning delete_button">انتقال به سطل بازیافت</a>
            </div>
        @endif
    </div>
@else
    <span>کاربر ناشناس</span>
@endif
