<div class="container-fluid">
    <section class="content-right col-xs-12 col-md-6 no-padding" style=" margin-top: 70px;">
        <div id="MainSlider" class="carousel slide col-md-12" data-ride="carousel">

            <!-- Wrapper for slides -->
            <div class="carousel-inner ">

                @include('layouts.homepages.helpers.itrac.sections.slider')

            </div><!-- End Carousel Inner -->

        </div>
        <section class="main-content">
            <div id="form-content" class="col-xs-4">
                <div class=" panel-login" ng-controller="loginController">
                    @if(Session::has('Login') && Session::get('Login')=='TRUE')
                        <?php $uname = Session::get('Uname'); ?>
                        <div style="font-size:9pt;">
                            <div class="HomeItemDiv">
                                <div class="icons2">
                                    <span style="color:#2093d4 !important;font-size: 12pt;" class="icon-pooshe"></span>
                                </div>
                                <div style="display: inline;">
                                    <a href="{{$uname}}/desktop/user_measures?tt=ME" style=";color:#555;">
                                        @if($dashboard['Eghdam']>0)
                                            {{$dashboard['Eghdam']}}  وظیفه جدید دارید.
                                        @else
                                            وظیفه جدیدی ندارید
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="HomeItemDiv">
                                <div class="icons2">
                                    <span style="color:#42ff00 !important;font-size: 12pt; " class="icon-tamasbama"></span>
                                </div>
                                <div style="display: inline;">
                                    <a href="{{$uname}}/desktop/inbox" style=";color:#555;">
                                        @if($dashboard['Email']>0)
                                            {{$dashboard['Email']}}  پیام جدید دارید.
                                        @else
                                            پیام جدیدی ندارید
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="HomeItemDiv">
                                <div class="icons2">
                                    <span style="font-size: 12pt;" class="icon-4"></span>
                                </div>
                                <div style="display: inline;">
                                    <a href="{{$uname}}/desktop/followed" style=";color:#555;">
                                        @if($dashboard['Group']>0)
                                            عضو {{$dashboard['Group']}} گروه بوده
                                        @else
                                            عضو هیچ گروهی نمی باشید
                                        @endif

                                        @if($dashboard['User']>0)
                                            و با {{$dashboard['User']}} کاربر مرتبط هستید.
                                        @else
                                            و با هیچ کاربری مرتبط نیستید.
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="HomeItemDiv">
                                <div class="icons2">
                                    <span style="color:#fd9f19 !important;font-size: 12pt;" class="icon-mataleb"></span>
                                </div>
                                <div style="display: inline;">
                                    <a href="{{$uname}}/desktop/Files/Created_ME" style=";color:#555;">
                                        @if($dashboard['Post']>0)
                                            {{$dashboard['Post']}} مطلب نوشته اید،
                                        @else
                                            تا کنون مطلبی ننوشته اید
                                        @endif
                                        @if($dashboard['Page']>0)
                                            و {{$dashboard['Page']}} صفحه ایجاد کرده‌اید.
                                        @else
                                            و هیچ صفحه ای ایجاد نکرده اید
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        @include('sections.homelogin')
                    @endif
                </div>
            </div>
            <div class="main-content-left col-xs-8">
                <div class="row">
                    <div class="col-xs-3 no-padding" style="padding:0 0 0 5px">
                        <div class="thumbnail" style="margin-left: 0; background: #CCFF9A;width: 100%">
                            <a href="#">
                                <img src="{{App::make('url')->to('/')}}/theme/itrak/img/thumbnail1.png" alt="دانشنامه">
                                <div class="caption">
                                    <a href="{{Config::get('constants.PreCode')}}-2"><p>دانشنامه</p></a>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-3 no-padding" style="padding: 0 0 0 5px;">
                        <div class="thumbnail" style="background: #FFCCCB;width: 100%">
                            <a href="#">
                                <img src="{{App::make('url')->to('/')}}/theme/itrak/img/thumbnail2.png" alt="کتابخانه">
                                <div class="caption">
                                    <a href="{{Config::get('constants.PreCode')}}-3"><p>اسناد</p></a>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-3 no-padding" style="padding: 0 0 0 0px;">
                        <div class="thumbnail" style="background: #E8C95D;width: 100%">
                            <a href="#">
                                <img src="{{App::make('url')->to('/')}}/theme/itrak/img/thumbnail3.png" alt="پژوهش">
                                <div class="caption">
                                    <a href="{{Config::get('constants.PreCode')}}-4"><p style="padding: 0;">شبکه اجتماعی</p></a>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-3 no-padding" style="padding: 0 5px 0 0px;">
                        <div class="thumbnail" style="background: #99CDFF">
                            <a href="#">
                                <img src="{{App::make('url')->to('/')}}/theme/itrak/img/thumbnail4.png" alt="اتاق فکر">
                                <div class="caption">
                                    <a href="{{Config::get('constants.PreCode')}}-33410"><p>اخبار</p></a>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 4%">
                    <h3><span>واحدهای ستادی</span></h3>
                </div>
                <div class="row" style="margin-bottom: 4%">
                    <a href="{{Config::get('constants.PreCode')}}-451670">
                        <button class="btn col-xs-6" style="padding: 0 1% 0 0"><p class="one">واحد منابع انسانی</p></button>
                    </a>
                    <a href="{{Config::get('constants.PreCode')}}-451700">
                        <button class="btn col-xs-6" style="padding: 0 0 0 1%"><p class="two">واحد بازرگانی</p></button>
                    </a>
                </div>
                <div class="row" style="margin-bottom: 4%">
                    <a href="{{Config::get('constants.PreCode')}}-451720">
                        <button class="btn col-xs-6" style="padding: 0 1% 0 0"><p class="one">واحد تحقیق و توسعه</p></button>
                    </a>
                    <a href="{{Config::get('constants.PreCode')}}-451680">
                        <button class="btn col-xs-6" style="padding: 0 0 0 1%"><p class="two">واحد فروش</p></button>
                    </a>
                </div>
                <div class="row" style="margin-bottom: 4%">
                    <a href="{{Config::get('constants.PreCode')}}-451710">
                        <button class="btn col-xs-6" style="padding: 0 1% 0 0"><p class="one">واحد تضمین کیفیت</p></button>
                    </a>
                    <a href="{{Config::get('constants.PreCode')}}-451680">
                        <button class="btn col-xs-6" style="padding: 0 0 0 1%"><p class="two">واحد مالی</p></button>
                    </a>
                </div>
            </div>
        </section>


    </section>
    <section class="content-left col-xs-12 col-md-6" style="float: left;margin-top: 70px; ">
        <table class="table">
            <tr>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img1.png">
                    <a href="{{Config::get('constants.PreCode')}}-33230">آزمایشگاه کالیبراسیون و اندازه گیری</a>
                </td>
                <td style="width:5px;"></td>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img4.png">
                    <a href="{{Config::get('constants.PreCode')}}-33240">آزمایشگاه خودرو و همولوگیشن</a>
                </td>
            </tr>
            <tr>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img7.png">
                    <a href="{{Config::get('constants.PreCode')}}-33250">آزمایشگاه مکانیزم‌ها</a>
                </td>
                <td style="width:5px;"></td>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img5.png">
                    <a href="{{Config::get('constants.PreCode')}}-33260">آزمایشگاه متالورژی</a>
                </td>
            </tr>
            <tr>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img8.png">
                    <a href="{{Config::get('constants.PreCode')}}-33270">آزمایشگاه CNG</a>
                </td>
                <td style="width:5px;"></td>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img3.png">
                    <a href="{{Config::get('constants.PreCode')}}-33280">آزمایشگاه EMC</a>
                </td>
            </tr>
            <tr>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img4.png">
                    <a href="{{Config::get('constants.PreCode')}}-33290">آزمایشگاه مکانیک پایه</a>
                </td>
                <td style="width:5px;"></td>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img9.png">
                    <a href="{{Config::get('constants.PreCode')}}-33300">آزمایشگاه شیمی</a>
                </td>
            </tr>
            <tr>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img8.png">
                    <a href="{{Config::get('constants.PreCode')}}-33310">آزمایشگاه پلیمر و نساجی</a>
                </td>
                <td style="width:5px;"></td>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img1.png">
                    <a href="{{Config::get('constants.PreCode')}}-33320">آزمایشگاه ماشین الکتریکی</a>
                </td>
            </tr>
            <tr>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img2.png">
                    <a href="{{Config::get('constants.PreCode')}}-33330">آزمایشگاه مهندسی موتور</a>
                </td>
                <td style="width:5px;"></td>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img9.png">
                    <a href="{{Config::get('constants.PreCode')}}-33340">آزمایشگاه سوخت رسانی و سیالات</a>
                </td>
            </tr>
            <tr>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img3.png">
                    <a href="{{Config::get('constants.PreCode')}}-33350">آزمایشگاه شرایط محیطی</a>
                </td>
                <td style="width:5px;"></td>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img7.png">
                    <a href="{{Config::get('constants.PreCode')}}-33360">آزمایشگاه برق و الکتریک</a>
                </td>
            </tr>
            <tr>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img7.png">
                    <a href="{{Config::get('constants.PreCode')}}-33370">آزمایشگاه نور سنجی</a>
                </td>
                <td style="width:5px;"></td>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img4.png">
                    <a href="{{Config::get('constants.PreCode')}}-33380">آزمایشگاه ویبرو آکوستیک</a>
                </td>
            </tr>
            <tr>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img6.png">
                    <a href="{{Config::get('constants.PreCode')}}-33390">آزمایشگاه رنگ و فرآورده های نفتی</a>
                </td>
                <td style="width:5px;"></td>
                <td style=" border:none ;border-bottom: 2px solid #658ece;">
                    <img src="{{App::make('url')->to('/')}}/theme/itrak/Img/img2.png">
                    <a href="33400">آزمایشگاه ارتعاش و خستگی</a>
                </td>
            </tr>
        </table>
    </section>
</div>