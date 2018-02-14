<div class="row" style="min-height: 95vh;">
    <div class="col-md-3 login_height">
        @include('sections.homeright')
    </div>
    <div class="col-md-9 line_border">
        <div class="row">
            <div class="col-sm-12">
                <div style="border: 1px #eaeaea solid; padding: 5px; background-color: white; box-shadow: 0 0 2px #eaeaea; margin-top: 60px; margin-bottom: 10px;">
                    {!! homepage_slider() !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="contents_tab">
                    <ul class="nav nav-pills customize">
                        <li class="active" style="width: 25%; text-align: center;"><a data-toggle="pill" href="#home">کتب و نشریات</a></li>
                        <li style="width: 25%; text-align: center;margin:0px"><a data-toggle="pill" href="#menu1">پایگاه‌های علمی</a></li>
                        <li style="width: 25%; text-align: center;margin:0px"><a data-toggle="pill" href="#menu2">شبکه اجتماعی</a></li>
                        <li style="width: 25%; text-align: center;margin:0px"><a data-toggle="pill" href="#menu3">سازمان‌ها</a></li>
                    </ul>
                    <style>

                    </style>
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active menus">
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href="{{ url('/444500') }}"><img src="{{ url(App\Models\hamafza\Pages::find(444500)->subject->defimageurl) }}" /></a>
                                </div>
                                <div class="col-sm-9 tab-des">
                                    <h3>فرآیند بودجه: تنظیم، تصویب، اجرا و کنترل</h3>
                                    <p>متن نوشته شده جهت تست</p>
                                </div>
                            </div>
                        </div>
                        <div id="menu1" class="tab-pane fade menus">
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href="{{ url('/444490') }}"><img src="{{ url(App\Models\hamafza\Pages::find(444490)->subject->defimageurl) }}" /></a>
                                </div>
                                <div class="col-sm-9 tab-des">
                                    <h3>فرآیند بودجه: تنظیم، تصویب، اجرا و کنترل</h3>
                                    <p>متن نوشته شده جهت تست</p>
                                </div>
                            </div>
                        </div>
                        <div id="menu2" class="tab-pane fade menus">
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href="{{ url('/4') }}"><img src="{{ url('theme/kmkz/img/4.png') }}" /></a>
                                </div>
                                <div class="col-sm-9 tab-des">
                                    <h3>فرآیند بودجه: تنظیم، تصویب، اجرا و کنترل</h3>
                                    <p>متن نوشته شده جهت تست</p>
                                </div>
                            </div>
                        </div>
                        <div id="menu3" class="tab-pane fade menus">
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href="{{ url('/444480') }}"><img src="{{ url(App\Models\hamafza\Pages::find(444480)->subject->defimageurl) }}" /></a>
                                </div>
                                <div class="col-sm-9 tab-des">
                                    <h3>فرآیند بودجه: تنظیم، تصویب، اجرا و کنترل</h3>
                                    <p>متن نوشته شده جهت تست</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contents_tab tab_news">
                    <h2>اخبار و اطلاعیه</h2>
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="{{ url('/444510') }}"><img class="slide_image" src="{{ url(App\Models\hamafza\Pages::find(444510)->subject->defimageurl) }}" /></a>
                            <p class="change_slider"><a href="#"><</a>همه<a href="#">></a></p>
                        </div>
                        <div class="col-sm-8 tab-des">
                            <h3>آغاز بهره برداری از پروژه مشترک صدور نفت</h3>
                            <p>متن نوشته شده جهت تست میباشد.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="footer_links">{!! isset($data['links_ready']) ? $data['links_ready'] : null !!}</p>
            </div>
        </div>
    </div>
</div>
<div class="row slogan">
    <p><a href="#">پیوندها</a><span class="glyphicon glyphicon-stop"></span><a href="#">تماس با دبیرخانه</a><span class="glyphicon glyphicon-stop"></span><a href="#">پشتیبانی: فناوران مدیریت علم هم افزا</a></p>
</div>
