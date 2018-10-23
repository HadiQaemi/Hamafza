<div>
    <div class="modal-body modal-login">
        @if(isset($Loginprompt) && $Loginprompt!='')
            <span style="color:red;margin-bottom: 10px;text-align: center;">{{$Loginprompt}}</span>
        @endif
        {{ Form::open(array('action' => 'SSO@Login',  'id' => 'LoginForm','class' => 'form','data-toggle'=>'validator')) }}
        <div class="form-group input-group">
            <span class="input-group-addon">نام کاربری</span>
            <input type="text" name="usename" id="usename" class="form-control" required aria-label="Amount (to the nearest dollar)">
            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
            <span class="input-group-addon">EN</span>
        </div>
        <div class="form-group input-group">
            <span class="input-group-addon">رمزعبور</span>
            <input class="form-control" name="passwordhid" data-toggle="password" required="required" title="" type="password" autocomplete="off">
        </div>

        <input type="hidden" name="password" id="passwordhid">
        {{ Form::close() }}
        <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div data-dismiss="modal" data-toggle="modal" data-target="#forgetpas" class="help-block forgetpas">فراموشی رمز عبور</div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div data-dismiss="modal" data-toggle="modal" data-target="#register" class="register">ثبت نام</div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <button class="btn btn-primary" id="LoginButt">ورود</button>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>