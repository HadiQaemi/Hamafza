<div class="homepage_login_div">
    <div class="homepage_inner_login_div">
        <div id="homepage_login_fail_request_errors" style="font-family: IranSharp; font-size: 12px; color: red; text-align: center; margin-bottom: 10px;"></div>
            <form id="homepage_form_login" name="form-login" class="form_login clearfix" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" name="username" id="username" autofocus="" class="form-control required" placeholder="رایانامه یا نام کاربری">
                    <div id="homepage_username_request_errors" style="font-family: Arial; font-size: 12px; color: red"></div>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control required" placeholder="رمز عبور" id="pwd">
                    <div id="homepage_password_request_errors" style="font-family: Arial; font-size: 12px; color: red"></div>
                </div>
				@if (!config('app.debug'))
                    <div class="form-group">
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
                    </div>
                @endif
                <div class="form-group homepage_login">
                    <input type="button" id="btn_homepage_login_form" class="btn btn-default login_btn blue-btn" value="ورود به سامانه" />
                </div>
                <center>
                    <span class="homepage_register_user btn btn-default login_btn gray-btn" style="cursor: pointer;">کاربر جدید هستم</span>
                    <span class="homepage_forget_password_user" style="cursor: pointer;">رمز عبور را فراموش کرده‌ام</span>
                    <br />
                    <br />
                    <span></span><a class="sub_login" href="#">راهنما</a></span>
                </center>
            </form>
    </div>
</div>
