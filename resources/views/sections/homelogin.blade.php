<center>
    <div class="homepage_login_div">
        <div class="homepage_inner_login_div">
            <div id="homepage_login_fail_request_errors" style="font-family: IranSharp; font-size: 12px; color: red; text-align: center; margin-bottom: 10px;"></div>
            <form id="homepage_form_login" name="form-login" class="form_login clearfix" method="post">
                {{ csrf_field() }}
                <table style="">
                    <tbody>
                    <tr>
                        <td style="padding: 2px;padding-left: 15px;">
                            <label>رایانامه یا نام کاربری</label>
                            <span style=""></span>
                            <div id="homepage_username_request_errors" style="font-family: Arial; font-size: 12px; color: red"></div>
                            <input type="text" name="username" id="username" autofocus="" class="form-control required" style="direction: ltr; font-family: Arial;" tabindex="1">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 2px;width:100%;padding-left: 15px;">
                            <label>رمز عبور</label>
                            <div id="homepage_password_request_errors" style="font-family: Arial; font-size: 12px; color: red"></div>
                            <input type="password" id="password" name="password" class="form-control required" style="direction: ltr;" autocomplete="off" tabindex="2">
                        </td>
                    </tr>
                    @if (!config('app.debug'))
                    <tr>
                        <td style="padding: 2px;padding-left: 15px;">
                            <label>کد امنیتی</label>
                            <div id="captcha_code" class="form-group input-group">
                                <div id="homepage_captcha_request_errors" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                                <input type="text" name="captcha_code" class="form-control" style="direction: ltr; font-family: arial;" autocomplete="off" tabindex="3">
                            </div>

                            <div class="homepage_login_captcha_refresh captcha-refresh-style" style="">
                                <i style="color: black; margin-top: 9px;" class="fa fa-refresh"></i>
                            </div>
                            <div style="float: right;width: 180px;">
                                <img style="height: 34px;" class="homepage_login_captcha_image" src="{{ route('captcha', 'login') }}">
                            </div>
                            <div class="clearfixed"></div>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td class="homepage_login" style="padding: 2px; padding-left: 15px;">
                            <input type="button" id="btn_homepage_login_form" class="btn btn-primary" value="ورود به سامانه" style="margin:20px 0 10px 0;"/>
                            <div style="text-align: center; margin-bottom: 10px;">
                                <span class="homepage_register_user" style="cursor: pointer; color: green;">کاربر جدید هستم</span>
                            </div>
                            <div style="text-align: center">
                                <span class="homepage_forget_password_user" style="cursor: pointer;">رمز عبور را فراموش کرده‌ام</span>
                                {{--<a href="#">lhljhkj</a>--}}
                            </div>
                            {{--<div class="forgetpas homepage_forget_password_user" data-target="#forgetpas" data-toggle="modal" data-dismiss="modal" style="display: table; margin: auto;">رمز عبور را فراموش کرده‌ام</div>--}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

</center>

<script>
    $('.homepage_login_captcha_image,.login_captcha_image').attr('src', '{{ route('captcha', 'login') }}' + '?' + Math.random());
</script>