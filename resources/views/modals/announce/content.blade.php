<form id="announce_send" name="announce_send" method="post" action="{{ route('hamafza.announce_send') }}">
    <input type="hidden" name="pid" id="pid" value="{{$pid}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <table width="100%" cellspacing="5" cellpadding="0" border="0" id="contactform" class="table">
        <tr>
            <td style="width:100px;border-top: none;">
                <span>عنوان</span>
            </td>
            <td style="border-top: none;">
                <input type="hidden" value="OK" name="highlight">
                <input type="text" class="form-control" id="title" name="title">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="checkbox" name="moarefi" checked="">
                <span>درباره:</span>
                <strong>{{$title}}</strong>
                @if($type=='subject')
                    <input type="hidden" name='sid' value='{{$sid}}'>
                    <input type="hidden" name='pid' value='{{$pid}}'>
                @endif
                <input type="hidden" name='type' value='{{$type}}'>
            </td>
        </tr>
        @if($sel!='')
            <input type="hidden" name="naghallow" id="naghallow" value="1">
            <tr style="border-top: none;">
                <td style="border-top: none;">
                    <span>نقل قول</span>
                </td>
                <td style="border-top: none;">
                    <textarea class="form-control" id="select" name="select">{{$sel}}</textarea>
                    <div>
                        <span> نقل قول</span>
                        <input type="radio" name="naghl" value="1" checked> مستقیم
                        <input type="radio" name="naghl" value="0"> غیر مستقیم
                        <span style="margin-right: 20px;">
                            <span> شماره صفحه سند</span>
                            <input type="text" class="form-control" id="bookpage" name="bookpage" style="width:60px; display: inline;">

                        </span>
                        <br>
                        @if(isset($alamat)&& $alamat=='true')
                            <input type="checkbox" name="alamat" checked="">
                        @else
                            <input type="checkbox" name="alamat">
                        @endif
                        <span>علامت گذاری شود</span>
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
                            <span>نقل قول</span>
                            <input type="radio" name="naghl" value="1" checked> مستقیم
                            <input type="radio" name="naghl" value="0"> غیر مستقیم
                            <span style="margin-right: 20px;">
                                <span>شماره صفحه سند</span>
                                <input type="text" class="form-control" id="bookpage" name="bookpage" style="width:60px; display: inline;">
                            </span>
                            <br>
                            @if(isset($alamat)&& $alamat=='true')
                                <input type="checkbox" name="alamat" checked="">
                            @else
                                <input type="checkbox" name="alamat">
                            @endif
                            <span>علامت گذاری شود</span>
                        </div>
                    </div>
                </td>
            </tr>
        @endif
        <tr>
            <td>
                <span>یادداشت</span>
            </td>
            <td>
                <textarea class="form-control" id="comment" name="comment"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <span>کلیدواژه</span>
            </td>

            <td>
                @include('sections.tags')
            </td>
        </tr>
    </table>
</form>

@include('modals.announce.helper.inline_js')