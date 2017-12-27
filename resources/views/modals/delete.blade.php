@if (auth()->check() && auth()->user()->hasRole('administrator'))
    <script language="javascript" type="text/javascript">
        $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute;left: 116px;top: -3px;"><a href="{{App::make('url')->to('/')}}/modals/helpview?code=CRIRhYzJI3k" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
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
