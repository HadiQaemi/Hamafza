<aside class="footer-top-sidebar col-xs-2">
    <img src="{{ url('theme/hamafza/index_2/img/logo.png') }}">
    <ul class="guide col-xs-12">
        <li class="steps"><img src="{{ url('theme/hamafza/index_2/img/guideicone4.png') }}"><a href="{{ url('21/1') }}">گام های آغاز</a></li>
        <li class="here"><img src="{{ url('theme/hamafza/index_2/img/guideicone3.png') }}" style="padding-right: 5%; padding-left: 5%"><a href="modals/helpview?id=21&amp;tagname=rahnamamozei&amp;hid=57&amp;pid=25">راهنمای اینجا</a></li>
        <li class="dargah"><img src="{{ url('theme/hamafza/index_2/img/guideicone2.png') }}"><a href="{{ url('/20') }}">درگاه راهنما</a></li>
    </ul>
</aside>
<div class="row col-xs-9">
    <div class="footer-top-content">
        <div class="row first">
            <div class="col-xs-12 col-md-4 tumbnail1" style="margin-left: .8%; padding-bottom: .5%">
                @if(auth()->check())
                    <div class="row">
                        <div class="inner-tumbnail1" style="margin: 1.1% 16% 1.1% 0%">

                            <p style="display: block">12</p>
                            <p style="display: block">پست های من</p>
                        </div>
                        <div class="inner-tumbnail1" style="margin: 1.1% 0 1.1% 16%; float: left;">

                            <p style="display: block">0</p>
                            <p style="display: block">وظایف جدید</p>
                            <span class="badge" style="position: absolute; left: 16%; top: 2%">6</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="inner-tumbnail1" style="margin: 0.1% 16% 1.1% 0%">

                            <p style="display: block">55</p>
                            <p style="display: block">اعلام های جدید</p>
                        </div>

                        <div class="inner-tumbnail1" style="margin: 0.1% 0 1.1% 16%; float: left;">

                            <p style="display: block">26</p>
                            <p style="display: block">امتیاز</p>
                        </div>

                    </div>
                @else
                    <form id="homepage_login_form" class="form-signin" style="margin: 3.5% 3% 3.5%">
                        <input style="height: 30px;" type="text" class="form-control" name="username" placeholder="رایانامه یا نام کاربری" required="" autofocus=""/>
                        <input style="height: 30px;" type="password" class="form-control" name="password" placeholder="رمزعبور" required=""/>
                        <div class="col-md-6">
                            <input type="text" name="captcha_code" class="form-control" style="direction: ltr; height: 30px;" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <div class="captcha-refresh-style login_captcha_refresh" style="cursor: pointer; width: 39px; height: 30px;">
                                <i style="color: black; margin-top: 10px;" class="fa fa-refresh"></i>
                            </div>
                            <div>
                                <img style="height: 30px;" class="login_captcha_image" src="{{ route('captcha', 'login') }}">
                            </div>
                        </div>
                        <button class="btn btn-success btn-block btn_homepage_login" type="button">ورود به سامانه</button>
                        <p class="homepage_modal_remember_password_form" style="margin-bottom: 0;float: right;font-size: .8em"><a href="#">رمزعبور را فراموش کرده ام</a></p>
                        <p class="homepage_modal_register_form" style="margin-bottom: 0;float: left; font-size: .8em"><a href="#">کاربر جدید هستم</a></p>
                    </form>
                @endif
            </div>
            <div class="col-xs-12 col-md-7 tumbnail2" style="padding: 0 1%">
                <div class="container-fluid">
                    @include('layouts.homepages.helpers.hamafza_2.sections.main_slider_1')
                </div>
            </div>
        </div>
        <div class="row second">
            <script type="text/javascript">
                $("[data-toggle=tooltip]").tooltip();
            </script>
            <div class="col-xs-12 col-md-4 tumbnail3" style="padding-bottom: 2px; margin-left: .8%" data-toggle="tooltip" data-placement="right" data-html="true"
                 title="تاریخ قمری <br> تاریخ میلادی <br> ساعت <br> اذان صبح <br> اذان ظهر <br> اذان مغرب <br> نیمه شب شرعی">
                <div class="text-center" style="margin-bottom: 2%;font-size: 1.2em">
                    <ul style="display: inline; padding-right: 0;">
                        <li>{{ HDate_GtoJ(date('Y-m-d'), 'l j F Y') }}</li>
                    </ul>

                    <div class="button-setting">
                        <button data-toggle="modal" data-target="#squarespaceModal" style="float: left;display: flex;"><i class="fa fa-cog" aria-hidden="true"></i></button>
                    </div>
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
                <div class="row timer">
                    <div class="time" style="font-size: 1.6em">{{ date('H:m') }}</div>
                    <p style="display: inline-block"> مانده به اذان مغرب به افق {{ 'مشهد' }}</p>
                </div>
                <form action="#" method="get" style="padding-bottom: 10.3%">
                    <input type="range" name="points" min="1" max="10" class="range-input">
                </form>
                <form action="#" method="get" class="hidden" style="padding-bottom: 10px;">
                    <input type="range" name="points" min="1" max="10" class="range-input">
                </form>
            </div>
            <div class="col-xs-12 col-md-7 tumbnail4" style="padding: 0 1%; height: 124px">
                <div class="container-fluid">
                @include('layouts.homepages.helpers.hamafza_2.sections.main_slider_2')
                <!-- End Carousel -->
                </div>
            </div>
        </div>
    </div>
</div>