@extends('layouts.auth_master')
@section('scripts_plugin')
    <script type="text/javascript" src="{{URL::asset('assets/js/Jquery/jquery-3.2.1.min.js')}}"></script>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-md-offset-4 col-md-4" id="box" style="height: 300px;">
                <h2>ورود</h2>
                <div class="login_div"></div>
                <div class="inner_login_div">
                    <div id="login_fail_request_errors" style="font-family: IranSharp; font-size: 12px; color: red; text-align: center; margin-bottom: 10px;"></div>
                    <form class="form-horizontal" id="login_form" method="post" name="login_page_form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input id="login_state" type="hidden" name="login_state" value="my_login">
                        <fieldset>
                            <div id="username_request_errors" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input name="username" placeholder="نام کاربری" class="form-control" type="text" style="direction: ltr">
                                    </div>
                                </div>
                            </div>
                            <div id="password_request_errors" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input name="password" placeholder="کلمه عبور" class="form-control" type="password" autocomplete="off" style="direction: ltr">
                                    </div>
                                </div>
                            </div>
                            <div id="captcha_request_errors" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div id="captcha_request_errors"></div>
                            <div class="col-md-6">
                                <div class="form-group input-group">
                                    <span class="input-group-addon">کد امنیتی</span>
                                    <input id="form_login_captcha" type="text" name="captcha_code" class="form-control" style="direction: ltr" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="captcha-refresh-style login_captcha_refresh" style="cursor: pointer; width: 39px;">
                                    <i style="color: black; margin-top: 10px;" class="fa fa-refresh"></i>
                                </div>
                                <div>
                                    <img style="height: 34px;" class="login_captcha_image" src="{{ route('captcha', 'login') }}">
                                </div>
                            </div>
                            <div class="clearfixed"></div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="checkbox" name="remember_me"><span>مرا به خاطر بسپار</span>
                                </div>
                            </div>
                            <div class="form-group" style="float: left;">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-md btn-primary pull-right submit_login">ورود</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('inline_scripts_plugin')
    @include('layouts.helpers.auth_master.scripts.login_register_inline_js')
@stop
