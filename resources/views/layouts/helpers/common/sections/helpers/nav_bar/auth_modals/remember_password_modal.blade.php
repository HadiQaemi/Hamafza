<div class="modal fade" id="forgetpas" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-darkblue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">فراموشی رمز عبور</h3>
            </div>
            <div class="modal-body modal-forgetpas" style="height: 200px;">
                <div class="remember_div"></div>
                <div class="inner_remember_div">
                    <form name="modal_remember_pass_form" id="modal_remember_pass_form" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div id="remember_email_request_errors" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                        <div class="form-group input-group">
                            <span class="input-group-addon">رایانامه </span>
                            <input type="text" name="email" class="form-control" aria-label="" style="direction: ltr; font-family: Arial;">
                            <span class="input-group-addon">@</span>
                        </div>
                        <div id="remember_captcha_request_errors" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                        <div class="row">
                            <div class="col-md-12" style="padding-right: 0">
                                <div class="col-md-6" style="padding-right: 0">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">کد امنیتی</span>
                                        <input id="modal_remember_password_captcha" type="text" name="captcha_code" class="form-control" tabindex="2" style="direction: ltr; font-family: Arial;" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon remember_pass_captcha_refresh" style="cursor: pointer; width: 10px;" tabindex="3"><i class="fa fa-refresh"></i></span>
                                        <img style="height: 34px;" class="remember_pass_captcha_image" src="{{ route('captcha', 'remember_password') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12 pull-left">
                            <div class="col-md-4">
                                <div data-dismiss="modal" data-toggle="modal" data-target="#register" class="help-block register" style="cursor: pointer">ثبت نام</div>
                            </div>
                            <div class="col-md-3">
                                <div data-dismiss="modal" data-toggle="modal" data-target="#login" class="help-block login" style="cursor: pointer">ورود</div>
                            </div>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-success" id="btn_modal_send_pass">ارسال رمز</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>