@extends('layouts.auth_master')
<script type="text/javascript" src="{{URL::asset('assets/js/Jquery/jquery-3.2.1.min.js')}}"></script>
@section('content')
    <div class="container-fluid" style="padding-top: 0;">
        <div class="row-fluid">
            <div class="col-md-offset-3 col-md-6" id="box" style="">
                <h2>ثبت نام</h2>
                <div class="register_div"></div>
                <div class="inner_register_div">
                    <div>
                        <form name="register_login_form" class="form-horizontal" id="register_form" autocomplete="off" method="post">
                            {{ csrf_field() }}
                            <fieldset>
                                {{--<code style="line-height: 200%; font-family: IranSharp; font-size: 10px; color: orange;"> نام کاربری تنها می‌تواند ترکیبی از حروف و اعداد باشد. کاراکترهای '_' و '.' به جز اول نام کاربری مجاز می‌باشند.</code>--}}
                                <div class="form-group" style="margin-bottom: 0;">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input name="username" id="form_username_input" placeholder="{{trans('auth.username')}}" class="form-control" type="text" value="" autocomplete="off" style="direction: ltr;">
                                        </div>
                                    </div>
                                </div>
                                <div id="username_request_errors" class="register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                                <div class="form-group" style="margin-bottom: 0; margin-top: 10px;">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                            <input name="email" id="form_email_input" placeholder="{{trans('auth.email')}}" class="form-control" type="text" value="" style="direction: ltr;">
                                        </div>
                                    </div>
                                </div>
                                <div id="email_request_errors" class="register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                                <div class="form-group" style="margin-bottom: 0; margin-top: 10px;">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                            <input name="password" id="form_password_input" placeholder="{{trans('auth.password')}}" class="form-control" type="password" autocomplete="off" value="" style="direction: ltr;">
                                        </div>
                                    </div>
                                </div>
                                <div id="password_request_errors" class="register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                                <div id="re_password_request_errors" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                                <div class="form-group" style="margin-bottom: 0; margin-top: 10px;">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-repeat"></i></span>
                                            <input name="password_confirmation" placeholder="{{trans('auth.re_password')}}" class="form-control" type="password" autocomplete="off" style="direction: ltr;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0; margin-top: 10px;">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            <input name="name" id="form_name_input" placeholder="{{trans('auth.name')}}" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div id="name_request_errors" class="register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                                <div class="form-group" style="margin-bottom: 0; margin-top: 10px;">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            <input name="family" id="form_family_input" placeholder="{{trans('auth.family')}}" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div id="family_request_errors" class="register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                                <div class="col-md-6">
                                    <div class="form-group input-group" style="margin-bottom: 0; margin-top: 10px;">
                                        <span class="input-group-addon">کد امنیتی</span>
                                        <input id="form_register_captcha" type="text" name="captcha_code" class="form-control" style="direction: ltr; font-family: Arial;" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <div class="captcha-refresh-style register_captcha_refresh" style="cursor: pointer; width: 39px;">
                                        <i style="color: black; margin-top: 10px;" class="fa fa-refresh"></i>
                                    </div>
                                    <div>
                                        <img style="height: 34px;" class="register_captcha_image" src="{{ route('captcha', 'register') }}">
                                    </div>
                                </div>
                                <div class="clearfixed"></div>
                                <div class="form-group" style="float: left;">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-md btn-primary pull-right submit_register">{{trans('auth.register')}}</button>
                                    </div>
                                </div>
                                <div id="captcha_request_errors" class="register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@include('layouts.helpers.auth_master.scripts.login_register_inline_js')