<div id="loginWmessage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-darkblue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">ورود</h3>
            </div>
            <div id="uru_login_div">
                <div class="modal-body modal-login" >
                    <div style="margin:15px;font-size: 9pt;color: red;" class="gkCode10">
                        <p>برای استفاده از این ابزار، دسترسی به اطلاعات کاربری شما ضروری است؛ بنابراین ابتدا باید نام کاربری و رمز خود را وارد نمایید، تا درخواست شما قابل دریافت و
                            اعمال باشد. </p>
                        <p>اگر عضو نیستید، تنها با ثبت «نام، نام خانوادگی و رایانامه» و انتخاب نام کاربری و رمز بلافاصله عضو خواهید شد.</p>
                    </div>
                    @if(isset($Loginprompt) && $Loginprompt!='')
                        <span style="color:red;margin-bottom: 10px;text-align: cenetr;">{{$Loginprompt}}</span>
                    @endif
                    <div class="clearfixed"></div>
                    <div class="uru_login_div"></div>
                    <div class="uru_inner_login_div">
                        <div id="uru_modal_login_fail_request_errors" class="uru_modal_login_error_inputs" style="font-family: IranSharp; font-size: 12px; color: red; text-align: center; margin-bottom: 10px;"></div>
                        <form name="uru_modal_login_form" class="HamafzaIcon" id="uru_modal_login_form" method="post">
                            <input type="hidden" name="_token" value="{{ $csrf }}">
                            <div id="uru_username_request_errors" class="uru_modal_login_error_inputs" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div class="form-group input-group" id="username">
                                <span class="input-group-addon">نام کاربری</span>
                                <input type="text" name="username" class="form-control" autofocus style="direction: ltr" tabindex="1">
                                <span class="fa fa-ok form-control-feedback"></span>
                                <span class="input-group-addon">EN</span>
                            </div>
                            <div id="uru_password_request_errors" class="uru_modal_login_error_inputs" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div class="form-group input-group">
                                <span class="input-group-addon">رمزعبور</span>
                                <input class="form-control" name="password" data-toggle="password" required="required" title="" type="password" autocomplete="off" style="direction: ltr" tabindex="2">
                            </div>
                            <div id="uru_captcha_request_errors" class="uru_modal_login_error_inputs" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                            <div class="row">
                                <div class="col-md-12" style="padding-right: 0">
                                    <div class="col-md-6" style="padding-right: 0">
                                        <div id="uru_captcha_code" class="form-group input-group">
                                            <span class="input-group-addon">کد امنیتی</span>
                                            <input id="uru_modal_login_captcha" type="text" name="captcha_code" class="form-control" style="direction: ltr; font-family: arial;" autocomplete="off" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="uru_login_captcha_refresh captcha-refresh-style" style="">
                                                <i style="color: black; margin-top: 9px;" class="fa fa-refresh"></i>
                                            </div>
                                            <div style="float: right;">
                                                <img style="height: 34px;" class="uru_login_captcha_image" src="{{ route('captcha', 'login') }}">
                                            </div>
                                            <div class="clearfixed"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember_me"><span style="color: black; font-size: 12px;">مرا به خاطر بسپار</span>
                            </div>
                            <div class="row col-md-9 pull-left">
                                <div class="col-md-4">
                                    <div data-dismiss="modal" data-toggle="modal" data-target="#forgetpas" class="help-block forgetpas" tabindex="6">فراموشی رمز عبور</div>
                                </div>
                                <div class="col-md-4">
                                    <div data-dismiss="modal" data-toggle="modal" data-target="#register" class="register" tabindex="5">ثبت نام</div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary" id="uru_btn_modal_login" tabindex="2">ورود</button>
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