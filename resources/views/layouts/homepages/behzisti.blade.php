<!DOCTYPE html>
<html ng-app="hamafza" class="@yield('html_class')">
<head lang="en">
@php($csrf = csrf_token())
<!---------------**Meta**-------------->
    <meta name="csrf-token" content="{{ $csrf}}">
@include('layouts.helpers.common.sections.meta')
<?php
    if(session('Uname')!=null)
    {
        if(trim(session('Uname'))!='')
        {
            header("Location: ".App::make('url')->to('/').'/'.session('Uname')."/desktop");
            die();
        }
    }
?>
<!---------------**Main Style**-------------->

<!---------------**Specific Plugin Style**-------------->
@include('layouts.homepages.helpers.general.assets.style.specific_plugin_style')

<!---------------**Inline Style**-------------->
@include('layouts.homepages.helpers.general.assets.style.inline_style')
    <link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/behzisti/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/behzisti/css/bootstrap.min.css"/>

<!---------------**Main Scripts**-------------->
    @include('layouts.helpers.common.assets.script.main_scripts')
    @include('hamahang.master.alert')
    @include('hamahang.master.confirm')
    @include('layouts.homepages.helpers.general.assets.script.after_main_scripts')
    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <title>سامانه دانش
        معلولیت و ناتوانی </title>
</head>
<body>
<div class="container-fluid  h-100" style="background-color: #119b9d;">
    <div class="row height-100-vh" >
        <div class="col-2 rigth_box text-justify" style="margin-top: 1rem;" >
            <div class="rigth_box_head row justify-content-md-center">
                <p class="text-center">
                    سامانه دانش
                    <br/>
                    معلولیت و ناتوانی
                </p>
            </div>
            <div class="rigth_box_body row justify-content-md-center">
                <nav class="nav flex-column text-center linkde" >
                    <a class="nav-link" href="#">راهنما</a>
                    <a class="nav-link" href="#">ارتباط با ما</a>
                    <a class="nav-link" href="#">درباره ما</a>

                </nav>
                <div class="col-xs-12 justify-content-md-center text-center">
                    @if (auth()->check())
                        <div class="col-xs-3 margin-left-10">
                            <a href="{{App::make('url')->to('/')}}/{{session('Uname')}}/wall" class="wall">دیوار @if(session('WallNotificaton')>0)<span class="badge">{{session('WallNotificaton')}}</span>@endif</a>
                            <a href="{{App::make('url')->to('/')}}/{{session('Uname')}}/desktop" class="wall">میز کار @if(session('DesktopNotificaton')>0)<span class="badge DesktopNotificaton">{{session('DesktopNotificaton')}}</span>@endif</a>
                            @include('sections.homeright-general')
                        </div>
                    @else
                        <div class="col-xs-3 background-white margin-left-10">
                            <div class="homepage_login_div">
                                <div class="homepage_inner_login_div">
                                    <form id="homepage_form_login" name="form-login" class="form_login clearfix" method="post">
                                        {{ csrf_field() }}
                                        <div id="homepage_login_fail_request_errors" style="font-family: IranSharp; font-size: 12px; color: red; text-align: center; margin-bottom: 10px;"></div>
                                        <table style="width:100%;margin-top: 30px;">
                                            <tbody>
                                            <tr>
                                                <td style="padding: 2px;padding-left: 15px;">
                                                   <div id="homepage_username_request_errors" style="font-family: Arial; font-size: 12px; color: red"></div>
                                                    <input type="text" name="username" id="exampleInputEmail1" placeholder="نام کاربری" autofocus="" class="form-control required" style="direction: ltr; font-family: Arial;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 2px;width:100%;padding-left: 15px;">
                                                    <div id="homepage_password_request_errors" style="font-family: Arial; font-size: 12px; color: red"></div>
                                                    <input type="password" id="passwords" name="password" placeholder="رمز عبور" class="form-control required" style="direction: ltr;" autocomplete="off">
                                                </td>
                                            </tr>
                                            @if (!config('app.debug'))
                                                <tr>
                                                    <td style="padding: 2px;padding-left: 15px;">
                                                        <label>کد امنیتی</label>
                                                        <div id="captcha_code" class="form-group input-group">
                                                            <div id="homepage_captcha_request_errors" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                                                            <input type="text" name="captcha_code" class="form-control" tabindex="1" style="direction: ltr; font-family: arial;">
                                                        </div>

                                                        <div class="homepage_login_captcha_refresh captcha-refresh-style" style="">
                                                            <i style="color: black; margin-top: 9px;" class="fa fa-refresh"></i>
                                                        </div>
                                                        <div style="float: right;">
                                                            <img style="height: 34px;" class="homepage_login_captcha_image" src="{{ route('captcha', 'login') }}">
                                                        </div>
                                                        <div class="clearfixed"></div>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr style="margin-top: 20px">
                                                <td class="homepage_login" style="padding: 2px; padding-left: 15px;">

                                                    {{--<div class="forgetpas homepage_forget_password_user" data-target="#forgetpas" data-toggle="modal" data-dismiss="modal" style="display: table; margin: auto;">رمز عبور را فراموش کرده‌ام</div>--}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <div class="col-xs-12 noLeftPadding noRightPadding margin-top-15">
                                            <div class="col-xs-6 display-inline width-50-pre">
                                                <input type="button" id="btn_homepage_login_form" class="btn btn-primary pull-right" value="ورود"/>
                                            </div>
                                            <div class="col-xs-6 display-inline width-50-pre" style="padding-top: 8px;">
                                                <span class="" style="font-size: 12px;cursor: pointer;line-height: 35px">فراموشی رمز</span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-xs-12" style="margin-top: 3rem;border-top: 1px solid #a49f93;">
                    <div class="flink row">پیوند های مرتبط:</div>
                    <div class="hlink">
                        <a href="">سازمان بهزیستی</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-10 left_box h-100"  style="margin-top: 1rem;">
            <div style="background-color: rgba(33, 33, 36, 0.3);">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="margin-top: 0.4rem;padding-top: 0.6rem;">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills1" aria-selected="true">معلولان </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills2" aria-selected="false">سالمندان</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills3" aria-selected="false">کارشناسان</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills4" aria-selected="false">سازمان‌های مردم نهاد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills5" aria-selected="false">سازمان‌های مسئول</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills6" aria-selected="false">مراکز غیر دولتی</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row justify-content-md-center text-center" style="padding-top: 1rem;">
                            <div class="col-sm">
                                <a href="">
                                    <img src="theme/behzisti/img/danesh.png" class="img-fluid "  alt="Responsive image">
                                    <p class="subtitle">دانشنامه</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="">
                                    <img src="theme/behzisti/img/rul.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">قوانین و مقررات</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="">
                                    <img src="theme/behzisti/img/noghbeh.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">نخبگان معلول</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="">
                                    <img src="theme/behzisti/img/komaki.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle"> وسائل کمکی</p>
                                </a>
                            </div>


                        </div>
                        <div class="row justify-content-md-center text-center" style="padding-top: 1rem;">
                            <div class="col-sm">
                                <a href="">
                                    <img src="theme/behzisti/img/ideh.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">ایده ها</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="">
                                    <img src="theme/behzisti/img/expers.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">اشتراک تجربیات</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="">
                                    <img src="theme/behzisti/img/question.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">پرسش و پاسخ </p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="">
                                    <img src="theme/behzisti/img/socail.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle"> شبکه اجتماعی </p>
                                </a>
                            </div>


                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">bb</div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">cc</div>
                </div>

            </div>
            <div class="row footer">
                <div class="col-sm">
                    <p>
                        سامانه عمومی هم افزا مبتنی بر
                        <a href="">هم افزا</a> |
                        پشتیبانی :
                        <a href="">فناوران مدیریت علم هم افزا </a>
                    </p>
                </div>
                <div class="col-sm">
                    <nav class=" text-left">
                        <a class="" href="#">درباره ما</a> |
                        <a class="" href="#">تماس با ما</a> |
                        <a class="" href="#">معرفی</a>
                    </nav>
                </div>

            </div>
        </div>
    </div>

</div>


<!---------------**Specific Plugin Scripts**-------------->
@include('layouts.homepages.helpers.general.assets.script.specific_plugin_scripts')

<!---------------**Inline Scripts**-------------->
@include('layouts.homepages.helpers.general.assets.script.inline_scripts')

@if(session('message')!='')
    <script>
        jQuery.noticeAdd({
            text: '{{ session('message') }}',
            stay: false,
            type: '{{ session("mestype") }}'
        });
    </script>
    @endif

    @include('layouts.homepages.helpers.general.assets.script.inline_scripts')
    @include('layouts.helpers.common.sections.helpers.nav_bar.auth_modals')
    </div>
</body>