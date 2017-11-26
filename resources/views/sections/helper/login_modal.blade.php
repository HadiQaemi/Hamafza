<div class="modal fade" id="{{$modal_id}}" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-darkblue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">ورود</h3>
            </div>
            <style>
                input.input-validation-error {
                    border: 1px solid #e80c4d;
                }
            </style>
            <div class="modal-body modal-login">
                @if(isset($Loginprompt) && $Loginprompt!='')
                    <span style="color:red;margin-bottom: 10px;text-align: center;">{{$Loginprompt}}</span>
                @endif
                @if(isset($modal_login_message))
                    <div class="row">
                        <div style="margin:15px;font-size: 9pt;color: red;" class="gkCode10">
                            <p>برای استفاده از این ابزار، دسترسی به اطلاعات کاربری شما ضروری است؛ بنابراین ابتدا باید نام کاربری و رمز خود را وارد نمایید، تا درخواست شما قابل دریافت و اعمال باشد. </p>
                            <p>اگر عضو نیستید، تنها با ثبت «نام، نام خانوادگی و رایانامه» و انتخاب نام کاربری و رمز بلافاصله عضو خواهید شد.</p>
                        </div>
                    </div>
                @endif
                <form class="HamafzaIcon" action="{{url('login')}}" method="post" id="LoginForm">
                    <input type="hidden" name="_token" value="{{$csrf}}">
                    <div class="form-group input-group">
                        <span class="input-group-addon">نام کاربری</span>
                        <input type="text" name="usename" id="usename" class="form-control" required aria-label="Amount (to the nearest dollar)">
                        <span class="fa fa-ok form-control-feedback"></span>
                        <span class="input-group-addon">EN</span>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon">رمزعبور</span>
                        <input class="form-control password" name="password" data-toggle="password" required="required" title="" type="password">
                    </div>
                    <div class="row col-md-9 pull-left">
                        <div class="col-md-4">
                            <div data-dismiss="modal" data-toggle="modal" data-target="#forgetpas" class="help-block forgetpas">فراموشی رمز عبور</div>
                        </div>
                        <div class="col-md-4">
                            <div data-dismiss="modal" data-toggle="modal" data-target="#register" class="register">ثبت نام</div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" id="LoginButt">ورود</button>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>