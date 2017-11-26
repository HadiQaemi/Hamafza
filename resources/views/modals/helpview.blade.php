<div class="panel-body text-decoration " id="helpviewDiv" style="top: 10px;margin: 10px;width:98%;line-height: 16pt;height: 310px;overflow: auto" id="HelpContent"> 
    {!!$view!!}
</div>
<div class="row" style="height: 60px;">
    <div  class="col-md-12">
        <div  class="panel panel-light">
            <hr>

            <div style="color:#898989">
                آیا این راهنما مفید بود؟
                <input style="margin-right: 10px; margin-left: 5px;" type="radio" class="Clicks" name="okhelp" value="1" checked="">بلی
                <input style="margin-right: 10px; margin-left: 5px;" type="radio" class="Clicks" name="okhelp" value="0">خیر
                <textarea id="helpcomment" name="helpcomment" class="form-control" style="margin: 10px;display: none;" placeholder="پیشنهاد شما برای بهترشدن این راهنما چیست؟"></textarea>
                <br>
                <input type="submit" class="btn btn-primary FloatLeft" value="ارسال " id="submitHelp" name="submit">
                <br>
            </div>
            <hr>
            <center>
                <table align="center" class="panel-light">
                    <tr>
                        <td>
                            <a style="margin-left: 2px;color:#898989;" href="{{App::make('url')->to('/')}}/21">
                                گام‌های آغاز</a>

                        </td>
                        <td>
                            <div class="Footicon icon-2-3" style="color: #9498A0;margin-top: -1px;"></div>

                            <a style="margin-left:2px;color:#898989;" href="{{App::make('url')->to('/')}}/17">
                                راهنمای کامل نرم افزار</a>

                        </td>
                        <td>
                            <div class="Footicon icon-2-3" style="color: #9498A0;margin-top: -1px;"></div>
                            <a style="margin-left: 2px;color:#898989;" href="{{App::make('url')->to('/')}}/20">
                                درگاه راهنما</a>
                        </td>
                        <td>
                            <div class="Footicon icon-2-3" style="color: #9498A0;margin-top: -1px;"></div>

                            <a style="margin-left:2px;color:#898989;" href="{{App::make('url')->to('/')}}/51">
                                پرسش های متداول
                            </a>

                        </td> 
                    </tr>
                </table>
            </center>
            <style>
                .image  {
                    -webkit-transition: all 1s ease; /* Safari and Chrome */
                    -moz-transition: all 1s ease; /* Firefox */
                    -ms-transition: all 1s ease; /* IE 9 */
                    -o-transition: all 1s ease; /* Opera */
                    transition: all 1s ease;
                    width: 50px;
                }

                .image:hover  {
                    -webkit-transform:scale(1.25); /* Safari and Chrome */
                    -moz-transform:scale(1.25); /* Firefox */
                    -ms-transform:scale(1.25); /* IE 9 */
                    -o-transform:scale(1.25); /* Opera */
                    transform:scale(1.25);
                }
            </style> 
        </div>


    </div>

</div>
<script>

    $(document).ready(function()
    {
        var scrolled = 0;
        var sels = false;

        $(".Clicks").click(function()
        {
            var pas = $(this).val();
            if (pas == '0') {
                sels = true;
                scrolled = scrolled + 500;
                $("#helpcomment").show();
                $(".jsPanel-content").animate({
                    scrollTop: scrolled
                });
                $("#helpviewDiv").css('height', '210px');

            }
            else {
                if (sels) {
                    $("#helpcomment").hide();
                    $("#helpviewDiv").css('height', '310');
                }


            }
        });
    });
    function HelpFire(pid, tagname) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamafza.pop_help') }}',
            dataType: 'html',
            data: ({tagname: tagname, pid: pid}),
            success: function(theResponse) {
                jQuery('#helpviewDiv').html("<p></p>");
                jQuery('#helpviewDiv').append(theResponse);
                $(".fancybox-inner").scrollTop(0);
                jQuery('#helpviewDiv').scrollTop(0);
            }
        });
    }

</script>
