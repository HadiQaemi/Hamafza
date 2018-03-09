<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-darkblue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">ورود</h3>
            </div>
            <div id="login_div">
                <div class="modal-body modal-login" style="height: 300px;">
                    <div class="clearfixed"></div>
                    <div class="login_div"></div>
                    <div class="inner_login_div">
                        <div id="modal_login_fail_request_errors" class="modal_login_error_inputs" style="font-family: IranSharp; font-size: 12px; color: red; text-align: center; margin-bottom: 10px;"></div>
                        <form name="modal_login_form" class="HamafzaIcon" id="modal_login_form" method="post">
                            <input type="hidden" name="_token" value="{{ $csrf }}">
                            <div id="username_request_errors" class="modal_login_error_inputs" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div class="form-group input-group" id="username">
                                <span class="input-group-addon">نام کاربری</span>
                                <input type="text" name="username" class="form-control" tabindex="-1" autofocus style="direction: ltr">
                                <span class="fa fa-ok form-control-feedback"></span>
                                <span class="input-group-addon">EN</span>
                            </div>
                            <div id="password_request_errors" class="modal_login_error_inputs" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div class="form-group input-group">
                                <span class="input-group-addon">رمزعبور</span>
                                <input class="form-control" id="password" name="password" data-toggle="password" required="required" title="" type="password" autocomplete="off" tabindex="0" style="direction: ltr">
                            </div>
                            @if (!config('app.debug'))
                            <div id="captcha_request_errors" class="modal_login_error_inputs" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div class="row">
                                <div class="col-md-12" style="padding-right: 0">
                                    <div class="col-md-6" style="padding-right: 0">
                                        <div id="captcha_code" class="form-group input-group">
                                            <span class="input-group-addon">کد امنیتی</span>
                                            <input id="modal_login_captcha" type="text" name="captcha_code" class="form-control" tabindex="1" style="direction: ltr; font-family: arial;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="login_captcha_refresh captcha-refresh-style" style="">
                                                <i style="color: black; margin-top: 9px;" class="fa fa-refresh"></i>
                                            </div>
                                            <div style="float: right;">
                                                <img style="height: 34px;" class="login_captcha_image" src="{{ route('captcha', 'login') }}">
                                            </div>
                                            <div class="clearfixed"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <input type="checkbox" name="remember_me"><span style="color: black; font-size: 12px;">مرا به خاطر بسپار</span>
                            </div>
							<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div data-dismiss="modal" data-toggle="modal" data-target="#forgetpas" class="help-block forgetpas" tabindex="6">فراموشی رمز عبور</div>
                                </div>
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div data-dismiss="modal" data-toggle="modal" data-target="#register" class="register" tabindex="5">ثبت نام</div>
                                </div>
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <button type="button" class="btn btn-primary" id="btn_modal_login" tabindex="2">ورود</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>