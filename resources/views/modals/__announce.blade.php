<script>
    $("#naghlclick").click(function () {
        if ($(this).attr("val") == '1') {
            $("#naghl").show();
            $(this).attr("val", '0');
            $(this).removeClass("glyphicon-triangle-left");
            $(this).addClass("glyphicon-triangle-bottom");
            $("#naghallow").val("1");


        }
        else {
            $("#naghl").hide();
            $(this).attr("val", '1');
            $(this).removeClass("glyphicon-triangle-bottom");
            $(this).addClass("glyphicon-triangle-left");
            $("#naghallow").val("0");

        }
    });
</script>

<span class="help-icon-span">

<a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzaryaddasht&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top"
   data-toggle="tooltip">
</a></span>

<br>
<p></p>
<form id="announce_send" name="announce_send" method="post" action="{{ route('hamafza.announce_send') }}">
    <input type="hidden" name="pid" id="pid" value="{{$pid}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

    <table width="100%" cellspacing="5" cellpadding="0" border="0" id="contactform" class="table">
        <tr>
            <td style="width:100px;border-top: none;">
                عنوان
            </td>
            <td style="border-top: none;">
                <input type="hidden" value="OK" name="highlight">

                <input type="text" class="form-control" id="title" name="title">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="checkbox" name="moarefi" checked="">
                درباره:
                <strong>{{$title}}</strong>
                @if($type=='subject')
                    <input type="hidden" name='sid' value='{{$sid}}'>
                    <input type="hidden" name='pid' value='{{$pid}}'>
                @endif
                <input type="hidden" name='type' value='{{$type}}'>

            </td>

        </tr>
        @if($select!='')
            <input type="hidden" name="naghallow" id="naghallow" value="1">

            <tr style="border-top: none;">
                <td style="border-top: none;">
                    نقل قول
                </td>
                <td style="border-top: none;">
                    <textarea class="form-control" id="select" name="select">{{$select}}</textarea>
                    <div>
                        نقل قول

                        <input type="radio" name="naghl" value="1" checked> مستقیم

                        <input type="radio" name="naghl" value="0"> غیر مستقیم

                        <span style="margin-right: 20px;">
                شماره صفحه سند
                <input type="text" class="form-control" id="bookpage" name="bookpage" style="width:60px; display: inline;"> 

            </span>
                        <br>
                        @if($alamat=='true')
                            <input type="checkbox" name="alamat" checked="">
                        @else
                            <input type="checkbox" name="alamat">
                        @endif
                        علامت گذاری شود
                    </div>
                </td>
            </tr>
        @else
            <input type="hidden" name="naghallow" id="naghallow" value="0">
            <tr>
                <td style="border-top: none;">
                    <span style="cursor: pointer" id="naghlclick" class="glyphicon glyphicon-triangle-left" val="1"><span style="font-family: 'IranSharp'">نقل قول  </span></span>
                </td>
                <td style="border-top: none;">
                    <div id="naghl" style="display: none;">


                        <!--<pres dir="ltr" class="xdebug-var-dump">-->
                        <textarea class="form-control" id="select" name="select"></textarea>
                        <!--</pres>-->

                        <div>
                            نقل قول

                            <input type="radio" name="naghl" value="1" checked> مستقیم

                            <input type="radio" name="naghl" value="0"> غیر مستقیم
                            <span style="margin-right: 20px;">
                            شماره صفحه سند
                            <input type="text" class="form-control" id="bookpage" name="bookpage" style="width:60px; display: inline;"> 

                        </span>

                            <br>
                            @if($alamat=='true')
                                <input type="checkbox" name="alamat" checked="">
                            @else
                                <input type="checkbox" name="alamat">
                            @endif
                            علامت گذاری شود
                        </div>
                    </div>
                </td>
            </tr>

        @endif


        <tr>
            <td>
                یادداشت
            </td>

            <td>
                <textarea class="form-control" id="comment" name="comment"></textarea>
            </td>
        </tr>

        <tr>
            <td>
                کلیدواژه
            </td>

            <td>
                @include('sections.tags')

            </td>
        </tr>

        <tr>
            <td colspan="2" dir="rtl">
                <input type="submit" class="btn btn-primary FloatLeft" value="تایید" name="announce_add" id="submit">
            </td>
        </tr>

    </table>
</form>