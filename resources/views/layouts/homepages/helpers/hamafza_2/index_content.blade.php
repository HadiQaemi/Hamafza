<aside class="footer-top-sidebar col-xs-2">
    <img src="{{ url('theme/hamafza/index_2/img/logo.png') }}">
    <ul class="guide col-xs-12">
        <li class="here"><img src="{{ url('theme/hamafza/index_2/img/guideicone3.png') }}" style="padding-right: 5%; padding-left: 5%">
            {{--<a href="modals/helpview?id=21&amp;tagname=rahnamamozei&amp;hid=57&amp;pid=25">راهنمای اینجا</a>--}}
            {{--<a class="jsPanels " title="راهنمای اینجا" href="{{App::make('url')->to('/')}}/modals/helpview?id=21&amp;tagname=rahnamamozei&amp;hid=57&amp;pid=25">راهنمای اینجا</a>--}}
            <a class="jsPanels " title="راهنمای اینجا" href="{!! url('/modals/helpview?code=').enCode(26) !!}">راهنمای اینجا</a>
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
    .modal-body .OghatHome .select_city{
        color: #000;
    }
    span.OghatHome{
        font-size: 8pt !important;
        direction: ltr !important;
        float: right !important;
        margin-top: -20px !important;
        margin-right: 14px;
    }
</style>
<div class="row col-xs-9">
    <div class="footer-top-content">
        <div class="row first">
            <div class="col-xs-12 col-md-4 tumbnail1" style="height: 208px;margin-left: .8%; padding-bottom: .5%">
                @if(auth()->check())
                    @php
                        $auth_user = auth()->user();
                    @endphp
                    <div class="row">
                        <div class="inner-tumbnail1" style="margin: 1.1% 16% 1.1% 0%">
                            <p style="display: block;font-size: 23px">
                                <a href="{{ auth()->user()->Uname }}/desktop/Tasks/MyTasks/list" style="font-size: 23px;color:#FFF;">{{$dashboard['Eghdam']}}</a>
                            </p>
                            <p style="display: block">
                                <a href="{{ auth()->user()->Uname }}/desktop/Tasks/MyTasks/list" style="font-size: 13px;color:#FFF;">وظایف من</a>
                            </p>
                        </div>
                        <div class="inner-tumbnail1" style="margin: 1.1% 0 1.1% 16%; float: left;">
                            <p style="display: block;font-size: 23px">
                                <a href="{{route('ugc.desktop.hamahang.calendar.index',['username'=>$auth_user->Uname])}}" style="font-size: 23px;color:#FFF;">0</a>
                            </p>
                            <p style="display: block">
                                <a href="{{route('ugc.desktop.hamahang.calendar.index',['username'=>$auth_user->Uname])}}" style="font-size: 13px;color:#FFF;">برنامه امروز</a>
                            </p>
                            {{--<span class="badge" style="position: absolute; left: 16%; top: 2%">{{$dashboard['Email']}}</span>--}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="inner-tumbnail1" style="margin: 0.1% 16% 1.1% 0%">
                            <p style="display: block;font-size: 23px">
                                <a href="{{ auth()->user()->Uname }}/desktop/tickets/inbox" style="font-size: 23px;color:#FFF;">{{$dashboard['Email']}}</a>
                            </p>
                            <p style="display: block">
                                <a href="{{ auth()->user()->Uname }}/desktop/tickets/inbox" style="font-size: 13px;color:#FFF;">پیام‌های من</a>
                            </p>
                        </div>
                        <div class="inner-tumbnail1" style="margin: 0.1% 0 1.1% 16%; float: left;">
                            <p style="display: block;font-size: 23px">0</p>
                            <p style="display: block">
                                <a href="#" style="font-size: 13px;color:#FFF;">یادآوری‌ها</a>
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
        @php
            $date = HDate_GtoJ(time(), "m/d", true);
            list ($m, $d) = explode('/', $date);
            $jat = (int) !((6 == (int) $m && 31 == (int) $m) || $m > 6);
        @endphp
        <div class="row second">
            <div class="col-xs-12 col-md-4 tumbnail3" style="height:135px;padding-bottom: 2px; margin-left: .8%;" data-toggle="tooltip" data-placement="right" data-html="true" id="azan_daiily"
                 titletitle="Morning_prayerSunriseNoon_noonsunsetevening_prayer" old-title="Morning_prayerSunriseNoon_noonsunsetevening_prayer">
                <div class="text-center" style="margin-bottom: 2%;font-size: 1.2em">
                    <div class="col-xs-12 color-white oghat-date">
                        {{ HDate_GtoJ(date('Y-m-d'), 'l j F Y') }}
                    </div>
                    <div class="col-xs-12 color-white oghat-hour">
                        {{ date('H:i:s') }}
                    </div>
                    <div class="button-setting">
                        <button data-toggle="modal" data-target="#squarespaceModal" style="float: left;display: flex;"><i class="fa fa-cog" aria-hidden="true"></i></button>
                    </div>
                    <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">افق</h3>
                                </div>
                                <div class="modal-body">
                                    <div class="OghatHome">
                                        <div>
                                            <script type="text/javascript" language="javascript" src="{{ url('/theme/Scripts/oghat.js') }}"></script>
                                            <script language="javascript">
                                                var CurrentDate = new Date();
                                                var JAT = {!! $jat !!};
                                                function pz() {};
                                                init();
                                                document.getElementById('cities').selectedIndex = 12;
                                                coord();
                                                main();
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row timer col-xs-12 noLeftPadding text-center" style="margin: 0px auto;">
                    <div class="time col-xs-12" style="font-size: 13px;">
                        <div class="col-xs-12">
                            <span id="reminder" class=""></span>
                            <span class="mainOghat">
                                <span class="OghatHome">
                                    <span>
                                        <script type="text/javascript" language="javascript" src="{{ url('/theme/Scripts/oghat.js') }}"></script>
                                        <script language="javascript">
                                            var CurrentDate = new Date();
                                            var JAT = {!! $jat !!};
                                            function pz() {};
                                            init();
                                            document.getElementById('cities').selectedIndex = 12;
                                            coord();
                                            main();
                                        </script>
                                    </span>
                                </span>
                            </span>
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
