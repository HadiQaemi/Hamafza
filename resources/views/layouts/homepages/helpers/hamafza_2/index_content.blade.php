<aside class="footer-top-sidebar col-xs-2">
    <img src="{{ url('theme/hamafza/index_2/img/logo.png') }}">
    <ul class="guide col-xs-12">
        <li class="here"><img src="{{ url('theme/hamafza/index_2/img/guideicone3.png') }}" style="padding-right: 5%; padding-left: 5%">
            {{--<a href="modals/helpview?id=21&amp;tagname=rahnamamozei&amp;hid=57&amp;pid=25">راهنمای اینجا</a>--}}
            <a class="jsPanels " title="راهنمای اینجا" href="{{App::make('url')->to('/')}}/modals/helpview?id=21&amp;tagname=rahnamamozei&amp;hid=57&amp;pid=25">راهنمای اینجا</a>
            {{--<a style="margin-left: 10px; font-family: naskh; color:#555;" class="jsPanels" title=" راهنمای اینجا" href="modals/helpview?id=21&amp;tagname=rahnamamozei&amp;hid=57&amp;pid=25">--}}
        </li>
        <li class="steps"><img src="{{ url('theme/hamafza/index_2/img/guideicone4.png') }}"><a href="{{ url('21') }}">گام های آغاز</a></li>
        <li class="dargah"><img src="{{ url('theme/hamafza/index_2/img/guideicone2.png') }}"><a href="{{ url('/20') }}">درگاه راهنما</a></li>
    </ul>
</aside>
<style>
    #cities{
        background-color: #fff;
        border: 1px solid #EEE;
        border-radius: 5px;
        font-size: 10pt !important;
        color: #151313;
        padding: 0px 10px;
        height: 30px;
    }
    .list-azan{
        display: none;
    }
    #azanazan{
        display: none;
    }
    .city-list{
        background-color: transparent !important;
        color: #fff !important;
        margin-top: 10px;
    }
    .tooltip.top .tooltip-inner {
        text-align: right;
    }

</style>
<div class="row col-xs-9">
    <div class="footer-top-content">
        <div class="row first">
            <div class="col-xs-12 col-md-4 tumbnail1" style="height: 208px;margin-left: .8%; padding-bottom: .5%">
                @if(auth()->check())
                    <div class="row">
                        <div class="inner-tumbnail1" style="margin: 1.1% 16% 1.1% 0%">

                            <p style="display: block">{{$dashboard['Eghdam']}}</p>
                            <p style="display: block">
                                <a href="{{ auth()->user()->Uname }}/desktop/Tasks/MyTasks/list" style="font-size: small;color:#FFF;">
                                    وظایف من
                                </a>
                            </p>
                        </div>
                        <div class="inner-tumbnail1" style="margin: 1.1% 0 1.1% 16%; float: left;">

                            <p style="display: block">{{$dashboard['Email']}}</p>
                            <p style="display: block">
                                <a href="{{ auth()->user()->Uname }}/desktop/tickets/inbox" style="font-size: small;color:#FFF;">پیام‌های من</a>
                            </p>
                            {{--<span class="badge" style="position: absolute; left: 16%; top: 2%">{{$dashboard['Email']}}</span>--}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="inner-tumbnail1" style="margin: 0.1% 16% 1.1% 0%">

                            <p style="display: block">{{$dashboard['User']}}</p>
                            <p style="display: block">
                                <a href="{{ auth()->user()->Uname }}/desktop/showgroups" style="font-size: small;color:#FFF;">
                                    گروه‌های من
                                </a>
                            </p>
                        </div>

                        <div class="inner-tumbnail1" style="margin: 0.1% 0 1.1% 16%; float: left;">

                            <p style="display: block">{{$dashboard['Post']}}</p>
                            <p style="display: block">
                                <a href="{{ auth()->user()->Uname }}/desktop/files/Created_ME" style="font-size: small;color:#FFF;">
                                   مطالب من
                                </a>
                            </p>
                        </div>

                    </div>
                @else
                    <form id="homepage_login_form" class="form-signin" style="margin: 3.5% 3% 3.5%">
                        {{ csrf_field() }}
                        <input style="height: 30px;" type="text" class="form-control" name="username" placeholder="رایانامه یا نام کاربری" required="" autofocus=""/>
                        <div id="username_request_errors_ham2" class="error-login"></div>
                        <input style="height: 30px;" type="password" class="form-control" name="password" placeholder="رمزعبور" required=""/>
                        <div id="password_request_errors_ham2" class="error-login"></div>
                        <div id="login_fail_request_errors_ham2" class="error-login"></div>
                        <div class="col-md-6 noRightPadding noLeftPadding">
                            <input type="text" name="captcha_code" class="form-control" style="direction: ltr; height: 30px;" autocomplete="off" placeholder="کد امنیتی را وارد نمایید">
                            <div id="captcha_request_errors_ham2" class="error-login"></div>
                        </div>
                        <div class="col-md-6 noLeftPadding noRightPadding">
                            <div class="col-md-7 noLeftPadding noRightPadding">
                                <img style="height: 30px;" class="login_captcha_image" src="{{ route('captcha', 'login') }}">
                            </div>
                            <div class="captcha-refresh-style login_captcha_refresh pull-left noLeftPadding noRightPadding" style="cursor: pointer; width: 39px; height: 30px;margin-right: 15px;border-radius: 5px;">
                                <i style="color: black; margin-top: 10px;" class="fa fa-refresh"></i>
                            </div>
                        </div>
                        <button class="btn btn-success btn-block btn_homepage_login" type="button">ورود به سامانه</button>
                        <p class="homepage_modal_remember_password_form" style="margin-bottom: 0;float: right;font-size: 1em"><a href="#">رمزعبور را فراموش کرده ام</a></p>
                        <p class="homepage_modal_register_form" style="margin-bottom: 0;float: left; font-size: 1em"><a href="#">کاربر جدید هستم</a></p>
                    </form>
                @endif
            </div>
            <div class="col-xs-12 col-md-7 tumbnail2" style="height: 208px;padding: 0 1%">
                <div class="container-fluid">
                    @include('layouts.homepages.helpers.hamafza_2.sections.main_slider_1')
                </div>
            </div>
        </div>
        <div class="row second">
            <div class="col-xs-12 col-md-4 tumbnail3" style="height:135px;padding-bottom: 2px; margin-left: .8%;" data-toggle="tooltip" data-placement="right" data-html="true" id="azan_daiily"
                 title="Morning_prayerSunriseNoon_noonsunsetevening_prayer" old-title="Morning_prayerSunriseNoon_noonsunsetevening_prayer">
                <div class="text-center" style="margin-bottom: 2%;font-size: 1.2em">
                    <ul style="display: inline; padding-right: 0;">
                        <li>{{ HDate_GtoJ(date('Y-m-d'), 'l j F Y') }}</li>
                    </ul>
                    {{--<div class="button-setting">--}}
                        {{--<button data-toggle="modal" data-target="#squarespaceModal" style="float: left;display: flex;"><i class="fa fa-cog" aria-hidden="true"></i></button>--}}
                    {{--</div>--}}
                    <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">آدرس</h3>
                                </div>
                                <div class="modal-body">
                                    <!-- content goes here -->
                                    <div class="col-xs-4">
                                        <select name="someName">
                                            <option value="value 1">انتخاب کشور</option>
                                            <option value="value 2">ایران</option>
                                            <option value="value 3">آلمان</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <select name="someName">
                                            <option value="value 1">انتخاب استان</option>
                                            <option value="value 2">خراسان</option>
                                            <option value="value 3">مازندران</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <select name="someName">
                                            <option value="value 1">انتخاب شهر</option>
                                            <option value="value 2">مشهد</option>
                                            <option value="value 3">رامسر</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal" role="button">بستن</button>
                                        </div>
                                        <div class="btn-group btn-delete hidden" role="group">
                                            <button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal" role="button">پاک کردن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row timer col-xs-12 noRightPadding noLeftPadding">
                    <div class="time col-xs-12" style="font-size: 1.6em;">
                        <div class="col-xs-3">{{ date('H:m') }}</div>
                        <div id="reminder" class="col-xs-9 noLeftPadding noRightPadding"></div>
                    </div>
                    @php
                        $date = HDate_GtoJ(time(), "m/d", true);
                        list ($m, $d) = explode('/', $date);
                        $jat = (int) !((6 == (int) $m && 31 == (int) $m) || $m > 6);
                    @endphp

                    <div style="text-align: center;" class="col-xs-12">
                        <div class="OghatHome">
                            <div>
                                <script type="text/javascript" language="javascript" src="{{ url('/theme/Scripts/oghat.js') }}"></script>
                                <script language="javascript">
                                    var CurrentDate = new Date();
                                    var JAT = {!! $jat !!};
                                    function pz() {};
                                    init();
                                    document.getElementById('cities').selectedIndex = 27;
                                    coord();
                                    main();
                                </script>
                            </div>
                        </div>
                    </div>

                </div>
                <form action="#" method="get" class="hidden" style="padding-bottom: 10.3%">
                    <input type="range" name="points" min="1" max="10" class="range-input">
                </form>
                <form action="#" method="get" class="hidden" style="padding-bottom: 10px;">
                    <input type="range" name="points" min="1" max="10" class="range-input">
                </form>
            </div>
            <div class="col-xs-12 col-md-7 tumbnail4" style="height:135px;padding: 0 1%;">
                <div class="container-fluid">
                @include('layouts.homepages.helpers.hamafza_2.sections.main_slider_2')
                <!-- End Carousel -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // $('.OghatHome').html($('#select_city').html());
</script>
