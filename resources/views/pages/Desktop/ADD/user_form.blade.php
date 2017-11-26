@extends('layouts.master')
@section('content')
    <div class="panel-body text-decoration">
        <div class='text-content'>
            <form action="{{ route('hamafza.user_save') }}" method="post" enctype="multipart/form-data" name="form" id="form_content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <table class="table">
                    <tbody>
                    <tr>
                        <td width="20%"><span style="color:red">*</span>نام</td>
                        <td width="80%" style="text-align: right;direction: rtl;">
                            <input required name="user_name" type="text" value="" class="form-control required" id="user_name" dir="rtl" size="50"/>
                        </td>
                    </tr>
                    <tr>
                        <td><span style="color:red">*</span>نام خانوادگی</td>
                        <td style="text-align: right;direction: rtl;">
                            <input required name="user_family" type="text" value="" class="form-control required" id="user_family" dir="rtl" size="50"/>
                        </td>
                    </tr>
                    <tr>
                        <td>معرفی</td>
                        <td style="text-align: right;direction: rtl;">
                            <input name="user_summary" type="text" placeholder="چند واژه برای معرفی شما (مانند عناوینی که در کارت ملاقات ذکر می شود)" value="" class="form-control" id="user_summary" dir="rtl" style="width:600px" size="100"/>
                        </td>
                    </tr>
                    <tr>
                        <td>دیدگاه ها و ایده های اصلی</td>
                        <td colspan="1" style="text-align: right;direction: rtl;">
                            <textarea placeholder="دیدگاه ها و ایده های اصلی" id="comment" name="comment" rows="5" cols="20" style="width: 97%" class="form-control"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>تصویر</td>
                        <td dir="rtl">
                            <span class="btn btn-default btn-file">
                    انتخاب فایل <input type="file" name="user_pic" id="user_pic" onchange="FileName(this);">
                            </span>
                            <span class="descr" style="display: none;"> عنوان فایل <input name="ftitle[1]" class="form-control" style="width:200px" value=""/></span>
                        </td>
                    </tr>
                    <tr>
                        <td>جنسیت</td>
                        <td dir="rtl">
                            <label style="display:inline"><input name="user_gender" type="radio" value="0"/>مرد</label>
                            <label style="display:inline"><input name="user_gender" type="radio" value="1"/>زن</label>
                        </td>
                    </tr>
                    <tr>
                        <td>تاریخ تولد</td>
                        <td><input type="text" maxlength="3" size="8" name="user_byear" class="form-control" style="width: 100px; display: inline; "></td>
                    </tr>
                    <tr>
                        <td> شماره تلفن همراه</td>
                        <td dir="rtl"><input name="user_mobile" type="text" value="" class="form-control" id="user_mobile" dir="rtl" size="50"/></td>
                    </tr>
                    <tr>
                        <td>تلفن ثابت</td>
                        <td dir="rtl">
                            <input type="text" maxlength="10" size="34" name="tel_number" value="" class="form-control" style="width: 150px; display: inline; ">&nbsp;
                            <input type="text" maxlength="4" size="4" name="tel_code" value="">
                        </td>                                                                                                                                      </td>
                    </tr>
                    <tr>
                        <td>فاکس</td>
                        <td dir="rtl">
                            <input type="text" maxlength="10" size="34" name="fax_number" value="" class="form-control" style="width: 150px; display: inline; ">&nbsp;
                            <input type="text" maxlength="4" size="4" name="fax_code" value="" class="form-control" style="width: 50px; display: inline; ">
                        </td>
                    </tr>
                    <tr>
                        <td>آدرس وب سایت</td>
                        <td dir="rtl"><input name="user_website" type="text" value="" class="form-control" id="user_website" dir="rtl" size="50"/></td>
                    </tr>
                    <tr>
                        <td><span style="color:red">*</span> نام کاربری</td>
                        <td dir="rtl"><input name="user_Uname" required type="text" value="" class="form-control required" id="user_Uname" dir="rtl" size="50"/></td>
                    </tr>
                    <tr>
                        <td><span style="color:red">*</span>رایانامه</td>
                        <td dir="rtl"><input name="user_mail" required type="text" value="" class="form-control required email" id="user_mail" dir="rtl" size="50"/></td>
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
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td dir="rtl">
                            <button class="btn btn-primary FloatLeft" type="submit">تایید</button>
                            <input name="news_date" type="hidden" id="news_date" value=""/>
                            <input type="hidden" name="work" id="work" value="0"/>
                            <input type="hidden" name="nid" id="nid" value=""/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop

