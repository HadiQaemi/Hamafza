<script>
    function doThis() {
        if ($('#user_pass').val() != $('#user_conf').val()) {
            alert('کلمه عبور وتکرار آن یکی نیستند');
             jQuery.noticeAdd({
                text: 'کلمه عبور وتکرار آن یکی نیستند',
                stay: false,
                type: 'error'
            });
            return false;
        }
        return true;
    }

</script>
<div class="guran-sooreh-list">
    <div class="navbar navbar-default">
        <ul class="nav nav-tabs">
            <li class="active"><a aria-controls="sooreh-tab-1" href="#sooreh-tab-1" role="tab" data-toggle="tab">فهرست مشخصات</a></li>
            <li><a aria-controls="sooreh-tab-2" href="#sooreh-tab-2" role="tab" data-toggle="tab">نام کاربری و رمز</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="sooreh-tab-1" role="tabpanel" class="tab-pane active">
            {{ Form::open(array('url'=>App::make('url')->to('/').'/user_settings','files'=>true)) }}
            <table class="table">
                <tbody class="ui-sortable">
                    <tr>
                        <td>نام * </td>            
                        <td dir="rtl">
                            <input type="hidden" name="type" value="username">
                            <input type="text" size="50" dir="rtl" id="user_name" class="form-control" value="{{Session::get('Name')}}" name="user_name"></td>

                    </tr>
                    <tr>
                        <td>نام خانوادگی *</td>            
                        <td dir="rtl"><input type="text" size="50" dir="rtl" id="user_family" class="form-control" value="{{Session::get('Family')}}" name="user_family"></td>

                    </tr>
                    <tr>
                        <td>معرفی اجمالی *</td>            
                        <td dir="rtl"><input type="text" size="50" dir="rtl" id="user_summary" class="form-control" value="{{Session::get('Summary')}}" name="user_summary"></td>

                    </tr>
                    <tr>
                        <td>تصویر</td>
                        <td dir="rtl">
                            <img style="width: 120px; height: auto;margin: 5px;" alt="" src="{{Session::get('pic')}}">
                            <label><input type="checkbox" id="delpic" name="delpic">بدون عکس</label>
                            <span class="btn btn-default btn-file">
                                انتخاب فایل  <input type="file" onchange="FileName(this);" id="user_pic" name="user_pic">
                            </span>
                            <span style="display: none;" class="descr"> عنوان فایل <input value="" style="width:200px" class="form-control" name="uppic"></span>
                        </td>              
                    </tr>

                    <tr>
                        <td colspan="6"><input type="submit" value="تایید" class="btn btn-primary" name="user_setting"></td>
                    </tr>    
                </tbody>
            </table>

            </form>
        </div>
        <div id="sooreh-tab-2" role="tabpanel" class="tab-pane">
            {{ Form::open(array('url'=>App::make('url')->to('/').'/user_settings','files'=>true,'id'=>'identicalForm','onsubmit'=>'return doThis()')) }}
            <table id="sortable2" class="table">
                <tbody class="tavle" style="">

                    <tr style="">
                        <td>نام کاربری * </td>            
                        <td dir="rtl"><input disabled="" type="text" size="50" dir="rtl" id="user_uname" class="form-control" value="{{Session::get('Uname')}}" name="user_uname"></td>
                <input type="hidden" name="type" value="password">
                <input type="hidden" name="user_unames" value="{{Session::get('Uname')}}">

                </tr>
                <tr style="">
                    <td>رایانامه یا نام کاربری * </td>            
                    <td dir="rtl"><input disabled="" type="text" size="50" dir="rtl" id="user_mail" class="form-control" value="{{Session::get('email')}}" name="user_mail"></td>

                </tr>
                <tr style="">
                    <td>رمز عبور جدید</td>
                    <td><input type="password" size="50" dir="rtl" id="user_pass" class="form-control" autocomplete="off" value="" name="user_pass"></td>
                </tr>
                <tr style="">
                    <td>تکرار رمز عبور جدید</td>
                    <td><input type="password" size="50" dir="rtl" id="user_conf" class="form-control" autocomplete="off" value="" name="user_conf"></td>
                </tr>
                <tr style="">
                    <td colspan="6"><input type="submit" value="تایید" class="btn btn-primary" name="user_setting_Acoount"></td>
                </tr>    
                </tbody>
            </table>
            </form>
        </div>
    </div>

</div>