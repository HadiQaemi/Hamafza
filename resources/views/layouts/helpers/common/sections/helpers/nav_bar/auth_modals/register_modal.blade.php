<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-darkblue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">ثبت نام</h3>
            </div>
            <div class="modal-body modal-register" style="height: 500px;">
                <div class="register_div"></div>
                <div class="inner_register_div" style="overflow-y: auto; overflow-x: hidden; direction: rtl;">
                    <div style="">
                        <form name="modal_register_form" class="HamafzaIcon" id="modal_register_form" method="post">
                            {{ csrf_field() }}
                            {{--<code style="font-family: IranSharp; font-size: 10px; color: orange;"> نام کاربری تنها می‌تواند ترکیبی از حروف و اعداد باشد. کاراکترهای '_' و '.' به جز اول نام کاربری مجاز می‌باشند.</code>--}}
                            <div class="form-group input-group" style="margin-bottom: 0;">
                                <span class="input-group-addon">نام کاربری</span>
                                <input type="text" class="form-control" id="modal_username_input" name="username" placeholder="فقط حروف انگلیسی" style="direction: ltr; font-family: Arial;">
                                <span class="input-group-addon">EN</span>
                            </div>
                            <div id="reg_username_request_errors" class="modal_register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue;"></div>
                            <div class="form-group input-group" style="margin-bottom: 0; margin-top: 12px;">
                                <span class="input-group-addon">رایانامه </span>
                                <input type="text" class="form-control" id="modal_email_input" name="email" style="font-family: Arial;direction: ltr">
                                <span class="input-group-addon">@</span>
                            </div>
                            <div id="reg_email_request_errors" class="modal_register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue;"></div>
                            <div class="form-group input-group" style="margin-bottom: 0; margin-top: 12px;">
                                <span class="input-group-addon ">رمزعبور</span>
                                <input type="password" class="form-control" id="modal_password_input" name="password" data-toggle="password" autocomplete="off" style="direction: ltr;">
                            </div>
                            <div id="reg_password_request_errors" class="modal_register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue;"></div>
                            <div id="reg_re_password_request_errors" class="modal_register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                            <div class="form-group input-group" style="margin-bottom: 0; margin-top: 12px;">
                                <span class="input-group-addon">تکرار رمزعبور</span>
                                <input type="password" class="form-control" name="password_confirmation" data-toggle="password" autocomplete="off" style="direction: ltr;">
                            </div>
                            <div class="form-group input-group" style="margin-bottom: 0; margin-top: 12px;">
                                <span class="input-group-addon">نام </span>
                                <input type="text" class="form-control" id="modal_name_input" name="name">
                                <span class="input-group-addon icon-a-b"></span>
                            </div>
                            <div id="reg_name_request_errors" class="modal_register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                            <div class="form-group input-group" style="margin-bottom: 0; margin-top: 12px;">
                                <span class="input-group-addon"> نام خانوادگی </span>
                                <input type="text" class="form-control" id="modal_family_input" name="family">
                                <span class="input-group-addon icon-a-b"></span>
                            </div>
                            <div id="reg_family_request_errors" class="modal_register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                            @if ('kmkz' == config('constants.DefIndexView'))
                            <div class="form-group input-group" style="margin-bottom: 0; margin-top: 12px;">
                                <span class="input-group-addon"> سازمان مربوطه </span>
                                <input type="text" class="form-control" id="modal_relevant_organization_input" name="relevant_organization">
                                <span class="input-group-addon icon-a-b"></span>
                            </div>
                            @endif
                            <div id="reg_relevant_organization_request_errors" class="modal_register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                            @if (!config('app.debug'))
                            <div class="row">
                                <div class="col-md-12" style="padding-right: 0">
                                    <div class="col-md-6" style="padding-right: 0">
                                        <div class="form-group input-group" style="margin-bottom: 0;  margin-top: 12px;">
                                            <span class="input-group-addon">کد امنیتی</span>
                                            <input id="modal_register_captcha" type="text" name="captcha_code" class="form-control" style="font-family: Arial;direction: ltr">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row" style="margin-top: 12px;">
                                            <div class="captcha-refresh-style register_captcha_refresh">
                                                <i style="color: black; margin-top: 9px;" class="fa fa-refresh register_captcha_refresh"></i>
                                            </div>
                                            <div>
                                                <img style="height: 34px;" class="register_captcha_image" src="{{ route('captcha', 'register') }}">
                                            </div>
                                        </div>
                                        <div class="clearfixed"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="reg_captcha_request_errors" class="modal_register_error_inputs" style="font-family: IranSharp; font-size: 12px; color: blue"></div>
                            @endif
                            <div class="row col-md-9 pull-left" style="margin-top: 12px;">
                                <div class="col-md-4">
                                    <div data-dismiss="modal" data-toggle="modal" data-target="#forgetpas" class="help-block forgetpas">فراموشی رمز عبور</div>
                                </div>
                                <div class="col-md-3">
                                    <div data-dismiss="modal" data-toggle="modal" data-target="#login" class="login">ورود</div>
                                </div>
                                <div class="col-md-5">
                                    <button type="button" class="btn btn-success" id="btn_modal_register">ثبت کاربر جدید</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>