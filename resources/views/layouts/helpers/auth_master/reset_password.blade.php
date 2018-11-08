@extends('layouts.auth_master')
<script type="text/javascript" src="{{URL::asset('assets/js/Jquery/jquery-3.2.1.min.js')}}"></script>
@section('content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-md-offset-4 col-md-4" id="box">
                <h2>ورود</h2>
                <form name="reset_password_form" class="form-horizontal" id="remember_password_form" method="post">
                    <div class="remember_password_div"></div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="username" value="{{ $username }}">
                    <fieldset>
                        <div class="inner_remember_password_div">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input name="username" placeholder="نام کاربری" class="form-control" type="text" value="{{ $username }}" readonly style="direction: ltr;">
                                    </div>
                                </div>
                            </div>
                            <div id="remember_password_request_errors" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input name="password" placeholder="کلمه عبور" class="form-control" type="password" autocomplete="off" style="direction: ltr;">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input name="password_confirmation" placeholder="تکرار کلمه عبور" class="form-control" type="password" autocomplete="off" style="direction: ltr;">
                                    </div>
                                </div>
                            </div>
                            <div id="remember_captcha_request_errors" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div class="col-md-6">
                                <div class="form-group input-group">
                                    <span class="input-group-addon">کد امنیتی</span>
                                    <input id="form_remember_password_captcha" type="text" name="captcha_code" class="form-control" style="direction: ltr; font-family: Arial;" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-right: 80px;">
                                <div class="form-group input-group">
                                    <span class="input-group-addon remember_password_captcha_refresh" style="cursor: pointer; width: 10px;"><i class="fa fa-refresh"></i></span>
                                    <img style="height: 34px;" class="remember_password_captcha_image" src="{{ route('captcha', 'remember_password') }}">
                                </div>
                            </div>
                            <div class="form-group" style="float: left;">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-md btn-danger pull-right submit_remember_password">تغییر کلمه عبور</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@stop

@include('layouts.helpers.auth_master.scripts.login_register_inline_js')
