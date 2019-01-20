<!DOCTYPE html>
<html ng-app="hamafza" class="@yield('html_class')">
<head lang="en">
@php($csrf = csrf_token())
<!---------------**Meta**-------------->
    <meta name="csrf-token" content="{{ $csrf}}">
@include('layouts.helpers.common.sections.meta')
<?php
//if(session('Uname')!=null)
//{
//    if(trim(session('Uname'))!='')
//    {
//        header("Location: ".App::make('url')->to('/').'/'.session('Uname')."/desktop");
//        die();
//    }
//}
?>
<!---------------**Main Style**-------------->
<!---------------**Specific Plugin Style**-------------->
@include('layouts.homepages.helpers.general.assets.style.specific_plugin_style')

    <!---------------**Inline Style**-------------->
    @include('layouts.homepages.helpers.general.assets.style.inline_style')
    <link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/behzisti/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/behzisti/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

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
        body{
            text-align: right !important;
        }
        input, .input-group-addon{
            border-radius: 0px !important;
        }
        .form-control{
            font-size: 14px !important;
        }
        input[type=password]{
            padding: 10px !important;
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

    <title>سامانه دانش معلولیت و ناتوانی </title>
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
                    <a class="nav-link" href="{{App::make('url')->to('/')}}/17">راهنما</a>
                    <a class="nav-link" href="{{App::make('url')->to('/')}}/33380">ارتباط با ما</a>
                    <a class="nav-link" href="{{App::make('url')->to('/')}}/33390">درباره ما</a>

                </nav>
                <div class="col-xs-12 justify-content-md-center text-center">
                    @if (auth()->check())
                        <div class="col-xs-12 margin-left-10">
                            <a href="{{App::make('url')->to('/')}}/{{session('Uname')}}/wall" class="wall">دیوار @if(session('WallNotificaton')>0)<span class="badge">{{session('WallNotificaton')}}</span>@endif</a>
                            / <a href="{{App::make('url')->to('/')}}/{{session('Uname')}}/desktop" class="wall">صفحه اصلی @if(session('DesktopNotificaton')>0)<span class="badge DesktopNotificaton">{{session('DesktopNotificaton')}}</span>@endif</a>
                            @include('sections.homeright-general')
                        </div>
                    @else
                        <div class="col-xs-12 background-white">
                            <div class="homepage_login_div">
                                <div class="homepage_inner_login_div text-center">
                                    <form id="homepage_form_login" name="form-login" class="form_login clearfix text-center" method="post">
                                        {{ csrf_field() }}
                                        <div id="homepage_login_fail_request_errors" style="font-family: sans; font-size: 12px; color: red; text-align: center; margin-bottom: 10px;"></div>
                                        <table style="width:100%;margin-top: 30px;">
                                            <tbody>
                                            <tr>
                                                <td style="padding: 2px;">
                                                    <div id="homepage_username_request_errors" style="font-family: sans; font-size: 12px; color: red"></div>
                                                    <input type="text" name="username" id="exampleInputEmail1" placeholder="نام کاربری" autofocus="" class="form-control required" style=" font-family: sans;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 2px;width:100%;">
                                                    <div id="homepage_password_request_errors" style="font-family: sans; font-size: 12px; color: red"></div>
                                                    <input type="password" id="passwords" name="password" placeholder="رمز عبور" class="form-control required" >
                                                </td>
                                            </tr>
                                            @if (!config('app.debug'))
                                                <tr>
                                                    <td style="padding: 2px;">

                                                        <div id="captcha_code" class="form-group input-group">
                                                            <input type="text" name="captcha_code" class="form-control" placeholder="کد امنیتی" tabindex="1" style=" font-family: sans;">
                                                        </div>
                                                        <div id="captcha_code" class="form-group input-group" style="width: 150px;">
                                                            <div id="homepage_captcha_request_errors" style="font-family: sans; font-size: 12px; color: red"></div>
                                                        </div>

                                                        <div class="homepage_login_captcha_refresh captcha-refresh-style" >
                                                            <i style="color: black; margin-top: 9px;" class="fa fa-refresh"></i>
                                                        </div>
                                                        <div >
                                                            <img style="height: 34px;" class="homepage_login_captcha_image" src="{{ route('captcha', 'login') }}">
                                                        </div>
                                                        <div class="clearfixed"></div>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr style="margin-top: 20px">
                                                <td class="homepage_login" style="padding: 2px; padding-left: 15px;">

                                                    {{--<div class="forgetpas homepage_forget_password_user" data-target="#forgetpas" data-toggle="modal" data-dismiss="modal" style="display: table; margin: auto;">Ø±Ù…Ø² Ø¹Ø¨ÙˆØ± Ø±Ø§ ÙØ±Ø§Ù…ÙˆØ´ Ú©Ø±Ø¯Ù‡â€ŒØ§Ù…</div>--}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <div class="col-xs-12 margin-top-15" style="padding: 0px !important;margin: 0px !important;;">
                                            <div class="col-xs-2"></div>
                                            <div class="col-xs-8" style="padding: 0px !important;margin: 0px !important;;">
                                                <div class="col-xs-6 display-inline pull-left" style="padding: 0px !important;margin: 0px !important;;">
                                                    <span class="register btn btn-default" data-toggle="modal" data-target="#register">عضویت</span>
                                                </div>
                                                <div class="col-xs-6 display-inline pull-right" style="padding: 0px !important;margin: 0px !important;;">
                                                    <input type="button" id="btn_homepage_login_form" class="btn btn-primary" value="ورود"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-2"></div>
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
                        <a href="http://www.behzisti.ir/">سازمان بهزیستی</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-10 left_box h-100"  style="margin-top: 1rem;">
            <div style="background-color: rgba(33, 33, 36, 0.3);">

                <div class="tab-content" id="pills-tabContent">
                    <div class="" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row justify-content-md-center text-center" style="padding-top: 0.5rem;">
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/2">
                                    <img src="theme/behzisti/img/danesh.png" class="img-fluid "  alt="Responsive image">
                                    <p class="subtitle">دانشنامه</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/33310">
                                    <img src="theme/behzisti/img/rul.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">قوانین و مقررات</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/33320">
                                    <img src="theme/behzisti/img/noghbeh.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">نخبگان معلول</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/33330">
                                    <img src="theme/behzisti/img/komaki.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">  وسائل کمکی</p>
                                </a>
                            </div>


                        </div>
                        <div class="row justify-content-md-center text-center" style="padding-top: 0rem;">
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/445000">
                                    <img src="theme/behzisti/img/ideh.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">ایده ها</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/445010">
                                    <img src="theme/behzisti/img/expers.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">اشتراک تجربیات</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/6">
                                    <img src="theme/behzisti/img/question.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">پرسش و پاسخ</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/4">
                                    <img src="theme/behzisti/img/socail.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle"> شبکه اجتماعی </p>
                                </a>
                            </div>


                        </div>


                        <div class="row justify-content-md-center text-center" style="padding-top: 0rem;">
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/33340">
                                    <img src="theme/behzisti/img/expert.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">کارشناسان</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/33360">
                                    <img src="theme/behzisti/img/management.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">سازمان‌های مسئول</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/33370">
                                    <img src="theme/behzisti/img/people.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">سازمان های مردم نهاد</p>
                                </a>
                            </div>
                            <div class="col-sm">
                                <a href="{{App::make('url')->to('/')}}/33350">
                                    <img src="theme/behzisti/img/oldman.png" class="img-fluid"  alt="Responsive image">
                                    <p class="subtitle">سالمندان</p>
                                </a>
                            </div>


                        </div>

                    </div>

                </div>

            </div>
            <div class="row footer">
                <div class="col-sm">
                    <p>
                        سامانه عمومی هم افزا مبتنی بر
                        <a href="">هم افزا</a> |
                        پشتیبانی:<a href="">فناوران مدیریت علم هم افزا</a>
                    </p>
                </div>
                <div class="col-sm">
                    <nav class=" text-left">
                        <a class="" href="http://hamafza.co/106/%D8%AF%D8%B1%D8%A8%D8%A7%D8%B1%D9%87-%D9%85%D8%A7-%D9%81%D9%86%D8%A7%D9%88%D8%B1%D8%A7%D9%86-%D9%85%D8%AF%DB%8C%D8%B1%DB%8C%D8%AA-%D8%B9%D9%84%D9%85-%D9%87%D9%85-%D8%A7%D9%81%D8%B2%D8%A7/">درباره ما</a> |
                        <a class="" href="http://hamafza.co/contact-us/">تماس با ما</a> |
                        <a class="" href="http://hamafza.co/">معرفی</a>
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