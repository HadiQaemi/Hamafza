<form action="{{ route('hamafza.user_save') }}" method="post" enctype="multipart/form-data" name="form" id="form_content">
    <center>مشخصات کاربر</center>
    <table class="table">
        <tbody>
        <tr>
            <td width="20%"><span style="color:red">*</span>نام</td>
            <td width="80%" style="text-align: right;direction: rtl;"><input name="user_name" type="text" value="{{$user_add->Name}}" class="form-control required" id="user_name" dir="rtl" size="50"/></td>
        </tr>
        <tr>
            <td><span style="color:red">*</span>نام خانوادگی</td>
            <td style="text-align: right;direction: rtl;"><input name="user_family" type="text" value="{{$user_add->Family}}" class="form-control required" id="user_family" dir="rtl" size="50"/></td>
        </tr>
        <tr>
            <td>معرفی</td>
            <td style="text-align: right;direction: rtl;"><input name="user_summary" type="text" placeholder="چند واژه برای معرفی شما (مانند عناوینی که در کارت ملاقات ذکر می شود)" value="{{$user_add->Summary}}" class="form-control" id="user_summary" dir="rtl" style="width:600px" size="100"/></td>
        </tr>
        <tr>
            <td>دیدگاه ها و ایده های اصلی</td>
            <td colspan="1" style="text-align: right;direction: rtl;"><textarea placeholder="دیدگاه ها و ایده های اصلی" id="comment" name="comment" rows="5" cols="20" style="width: 97%" class="form-control">{{$user_add->Comment}}</textarea></td>
        </tr>
        <tr>
            <td>تصویر</td>
            <td dir="rtl">
                <?php
                $pics = 'pics/user/Users.png';
                $uids = $user_add->id;
                if (trim($user_add->Pic) != '' && file_exists('pics/user/' . $uids . '-' . $user_add->Pic))
                    $pics = 'pics/user/' . $uids . '-' . $user_add->Pic;
                else if (trim($user_add->Pic) != '' && file_exists('pics/user/' . $user_add->Pic))
                    $pics = 'pics/user/' . $user_add->Pic;
                ?>
                <img src="{{App::make('url')->to('/')}}/{{$pics}}" width="100px;">
                @if($pics!='pics/user/Users.png')
                    <input type="hidden" name="old_pic" value="{{$user_add->Pic}}">
                    <label><input type="checkbox" id="delpic" name="delpic">بدون عکس</label>
                @endif
                <br> <br>
                <span class="btn btn-default btn-file">
                        انتخاب فایل <input type="file" name="user_pic" id="user_pic" onchange="FileName(this);">
                    </span></span>
                <span class="descr" style="display: none;"> عنوان فایل <input name="ftitle[1]" class="form-control" style="width:200px" value=""/></span>
            </td>
        </tr>
        <tr>
            <td>جنسیت</td>
            <td dir="rtl"><label style="display:inline"><input name="user_gender" type="radio" value="0" @if( $user_add->Gender == 'مرد')  checked @endif />مرد</label>
                <label style="display:inline"><input name="user_gender" type="radio" value="1" @if( $user_add->Gender == 'زن')  checked @endif />زن</label>
                <label style="display:inline"><input name="user_gender" type="radio" value="" @if( $user_add->Gender != 'زن' && $user_add->Gender != 'مرد')  checked @endif />نامشخص</label>
            </td>
        </tr>
        <tr>
            <td>تاریخ تولد</td>
            <td><input type="text" maxlength="3" size="8" name="user_byear" class="form-control" style="width: 100px; display: inline; "></td>
        </tr>
        <tr>
            <td> شماره تلفن همراه</td>
            <td dir="rtl">
                <input name="user_mobile" size="34" type="text" value="<?php echo(isset($user_add->user_mobile) ? $user_add->user_mobile : '') ?>" class="form-control" id="user_mobile" dir="rtl" style="width: 150px; display: inline; "/>
            </td>
        </tr>
        <tr>
            <td>تلفن ثابت</td>
            <td dir="rtl">
                <input type="text" maxlength="10" size="34" name="tel_number" value="<?php echo(isset($user_add->tel_number) ? $user_add->tel_number : '') ?> " class="form-control" style="width: 150px; display: inline; ">&nbsp;
                <input type="text" maxlength="4" size="4" name="tel_code" value="<?php echo(isset($user_add->tel_code) ? $user_add->tel_code : '') ?> " class="form-control" style="width: 50px; display: inline; "></td>
        </tr>
        <tr>
            <td>فاکس</td>
            <td dir="rtl">
                <input type="text" maxlength="10" size="34" name="fax_number" value="<?php echo(isset($user_add->fax_number) ? $user_add->fax_number : '') ?> " class="form-control" style="width: 150px; display: inline; ">
                <input type="text" maxlength="4" size="4" name="fax_code" value="<?php echo(isset($user_add->fax_code) ? $user_add->fax_code : '') ?> " class="form-control" style="width: 50px; display: inline; ">
            </td>
        </tr>
        <tr>
            <td>آدرس وب سایت</td>
            <td dir="rtl"><input name="user_website" type="text" value="<?php echo(isset($user_add->user_website) ? $user_add->user_website : '') ?>" class="form-control" id="user_website" dir="rtl" size="50"/></td>
        </tr>
        <tr>
            <td><span style="color:red">*</span> نام کاربری</td>
            <td dir="rtl">
                <input name="user_Uname" type="text" value="<?php echo(isset($user_add->UName) ? $user_add->UName : '') ?>" <?php echo(isset($user_add->UName) ? ' disabled' : '') ?> class="form-control required" id="user_Uname" dir="rtl" size="50"/>
            </td>
        </tr>
        <tr>
            <td><span style="color:red">*</span>رایانامه</td>
            <td dir="rtl"><input name="user_mail" type="text" value="<?php echo(isset($user_add->Email) ? $user_add->Email : '') ?>" class="form-control required email" id="user_mail" dir="rtl" size="50"/></td>
        </tr>
        <tr>
            <td>کلمه عبور</td>
            <td dir="rtl"><input name="user_pass" type="password" value="" autocomplete="off" class="form-control  " id="user_pass" dir="rtl" size="50"/></td>
        </tr>
        <tr>
            <td>تایید کلمه عبور</td>
            <td dir="rtl"><input name="user_conf" type="password" value="" autocomplete="off" class="form-control " id="user_conf" dir="rtl" size="50"/></td>
        </tr>
        <tr>
            <td>گروه دسترسی</td>
            <td align="right">
                <select dir="rtl" id="secgroup" class="form-control valid" name="secgroup">
                    <option value="0">هیچکدام</option>
                    @foreach($SecGroup as $item)
                        <option value="{{$item->id}}" @if($user_add->SecGroups==$item->id) selected @endif>{{$item->name}} </option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td dir="rtl">
                <button class="btn btn-primary FloatLeft" type="submit">تایید</button>
                <input name="news_date" type="hidden" id="news_date" value="<?php echo gmdate("Y-m-d H:i:s", time() + 12600) ?>"/>
                <input type="hidden" name="work" id="work" value="{{$user_id}}"/>
                <input type="hidden" name="nid" id="nid" value="<?php echo(isset($user_add->nid) ? $user_add->nid : '') ?>"/>
            </td>
        </tr>
        </tbody>
    </table>
</form>