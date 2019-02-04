@include('hamahang.Users.view_user_details_modal.helper.view_user_inline_js')
@if ($user->id == auth()->id())

{{--        {{ dd($user->profile->City,$user->profile->Province) }}--}}
    <div style="padding: 0 15px 15px 15px;">
        <div class="navbar ">
            <ul class="nav nav-tabs">
                <li class="active" id="tab_edit"><a aria-controls="art-tab-1" href="#edit_user" role="tab" data-toggle="tab">مشخصات</a></li>
                <li id="tab_pic"><a aria-controls="art-tab-1" href="#edit_pic" role="tab" data-toggle="tab">تصویر</a></li>
                <li id="tab_pass"><a aria-controls="art-tab-2" href="#edit_pass" role="tab" data-toggle="tab">تغییر رمز عبور</a></li>
            </ul>
        </div>
        <div class="user_edit_jspanel_content">
            <div class="tab-content">
                <div id="edit_user" role="tabpanel" class="tab-pane active">
                    <div id="user_detail_edit">
                        <div id="edit_user_detail" style="padding: 10px 10px 10px 32px;">
                            <form id="user_detail_edit_form" enctype="multipart/form-data" method="post" action="{{ route('hamahang.users.update_user_detail') }}">
                                {!! csrf_field() !!}
                                <div class="col-xs-12">
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">نام</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input type="text" name="name" class="form-control required" value="{{ $user->Name }} " placeholder="نام">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">نام‌خانوادگی</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input type="text" name="family" class="form-control required" value="{{ $user->Family }}" placeholder="نام خانوادگی">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-10" style="border-bottom: 1px solid #eee;padding-bottom: 10px">
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">تاریخ تولد</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input id="birthday" name="birthday" class="form-control jalali_date jsp_user_birth_date" type="text" value="@if(isset($user->profile)){{ $user->profile->birth_date }}@endif"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">محل تولد</div>
                                        <div class="col-xs-10 noLeftPadding noRightPadding">
                                            <select id="province" name="province" class='select2 province form-control js-example-basic-single jsp_user_detail_province pull-right' style="width: 50%">
                                                @if($provinces)
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province->id }}" @if($province->id==isset($user->profile->Province) ? $user->profile->Province : '') selected="selected" @endif>{{ $province->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <select id="city" name="city" class='select2 form-control js-example-basic-single jsp_user_detail_city pull-left' style="width: 49%">
                                                @if($cities)
                                                    @foreach($cities as $city)
                                                        <option value="{{ isset($city->id) ? $city->id : '' }}" @if($city->id==(isset($user->profile->City) ? $user->profile->City : '')) selected="selected" @endif>{{ $city->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-20">
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">تلفن همراه</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input type="text" name="mobile" class="dir_ltr form-control" value="@if(isset($user->profile)){{ $user->profile->Mobile }} @endif">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">وب سایت</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input type="text" name="website" class="dir_ltr form-control" value="@if(isset($user->profile)){{ $user->profile->Website }}@endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-10">
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">فاکس</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input style="width: 79%" class="pull-right form-control" type="text" value="@if(isset($user->profile)){{ $user->profile->Fax_number }}@endif" name="fax_number" size="34" maxlength="10" placeholder="شماره فکس">
                                            <input style="width: 20%" class="pull-left form-control" type="text" value="@if(isset($user->profile)){{ $user->profile->Fax_code  }}@endif" name="fax_code" size="4" maxlength="4" placeholder="کد شهر">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">تلفن ثابت</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input style="width: 79%" class="pull-right form-control" type="text" value="@if(isset($user->profile)){{ $user->profile->Tel_number }}@endif" name="tel_number" size="10"
                                                   maxlength="10" placeholder="شماره تلفن">
                                            <input style="width: 20%" class="pull-left form-control" type="text" value="@if(isset($user->profile)){{ $user->profile->Tel_code }}@endif" name="tel_code" size="4" maxlength="4"
                                                   placeholder="کد شهر">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-10" style="border-bottom: 1px solid #eee;padding-bottom: 10px">
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">رایانامه</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input type="text" name="email" class="dir_ltr form-control" value="{{ isset($user->Email) ? $user->Email : '' }}" {!! 'shazand' == config('constants.IndexView') ? null : 'readonly' !!}>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">جنسیت</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding line-height-35">
                                            <label style="display:inline"><input class="gender" type="radio" @if($user->Gender =='2' || $user->Gender =='') checked="checked" @endif value="2" name="gender">نامشخص</label>
                                            <label style="display:inline"><input class="gender" type="radio" @if($user->Gender =='0') checked="checked" @endif value="0" name="gender">مرد</label>
                                            <label style="display:inline"><input class="gender" type="radio" @if($user->Gender =='1') checked="checked" @endif value="1" name="gender">زن</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-10">
                                    <div class="col-xs-6">
                                        @if ('kmkz' == config('constants.DefIndexView'))
                                            <div class="pull-right line-height-35">سازمان مربوطه</div>
                                            <div class="pull-right margin-right-10">
                                                <input type="text" name="relevant_organization" class="dir_ltr form-control" value="{{ isset($profile->relevant_organization) ? $profile->relevant_organization : '' }}">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-xs-6">

                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-10">
                                    <div class="col-xs-1">معرفی اجمالی</div>
                                    <div class="col-xs-11">
                                        <input type="text" name="summary" class="text form-control" value="{{ $user->Summary }}" placeholder="چند واژه برای معرفی شما (مانند عناوینی که در کارت ملاقات ذکر می شود)">
                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-10">
                                    <div class="col-xs-1">
                                        <div>دیدگاه</div>
                                    </div>
                                    <div class="col-xs-11">
                                        <input type="text" name="comment" class="text form-control" id="comment" placeholder="دیدگاه" value="{{ isset($user->profile->Comment) ? $user->profile->Comment : '' }}">
                                    </div>
                                </div>
                                {{--<div class="col-xs-12 margin-top-10">--}}
                                    {{----}}
                                    {{--<div class="col-xs-6 text-center">--}}
                                        {{--@if(isset($user->avatar) &&!empty($user->avatar) &&($user->avatar!=null) &&($user->avatar!=0) )--}}
                                            {{--<span class="fa fa-times remove_avater remove_avatar_image" style="cursor: pointer;"></span>--}}
                                        {{--@endif--}}
                                        {{--<img class="img_avatar" style="margin-bottom: 10px; width: 150px; height: 150px; position: relative;"--}}
                                             {{--title="@if($user->avatar_info){{ $user->avatar_info->originalName }}@endif" src="{{$user->AvatarLink}}">--}}
                                        {{--<div class="text-center" style="padding-right: 38%;"><input id="setting_input_file_avatar" class="form-control filestyle" type="file" name="user_avatar"></div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <input type="submit" id="user_detail_form_data" hidden>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="edit_pass" role="tabpanel" class="tab-pane">
                    <form id="user_password_edit_form">
                        <table class="col-xs-12">
                            <tbody>
                            <tr>
                                <td class="table_td_title">کلمه عبور فعلی</td>
                                <td>
                                    <input type="password" name="pass_now" class="form-control required" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="table_td_title">کلمه عبور جدید</td>
                                <td>
                                    <input type="password" name="pass_new" class="form-control required" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="table_td_title">تکرارکلمه عبور</td>
                                <td>
                                    <input type="password" name="pass_repeat" class="text form-control">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div id="edit_pic" role="tabpanel" class="tab-pane">
                    {{--<div class="col-xs-12 margin-top-10">--}}

                        {{--<div class="col-xs-6 text-center">--}}
                            {{--@if(isset($user->avatar) &&!empty($user->avatar) &&($user->avatar!=null) &&($user->avatar!=0) )--}}
                                {{--<span class="fa fa-times remove_avater remove_avatar_image" style="cursor: pointer;"></span>--}}
                            {{--@endif--}}
                            {{--<img class="img_avatar" style="margin-bottom: 10px; width: 150px; height: 150px; position: relative;"--}}
                            {{--title="@if($user->avatar_info){{ $user->avatar_info->originalName }}@endif" src="{{$user->AvatarLink}}">--}}
                            {{--<div class="text-center" style="padding-right: 38%;"><input id="setting_input_file_avatar" class="form-control filestyle" type="file" name="user_avatar"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <style>
                        .remove_avater{
                            color: red;
                            font-size: 17px;
                            cursor: pointer;
                        }
                    </style>
                    <div class="show_avatar_image" style="width:300px; margin: 10px auto">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding-top:6px;" >
                                @if(isset($user->avatar) &&!empty($user->avatar) &&($user->avatar!=null) &&($user->avatar!=0) )
                                    <span class="fa fa-times remove_avater remove_avatar_image"></span>
                                @endif
                                <img class="img_avatar" style="width: 100%; height: 100%; position: relative;cursor: pointer; cursor:{{URL('img/pen_edit.png')}}"  title="@if($user->avatar_info){{ $user->avatar_info->originalName }}@endif" src="{{$user->AvatarLink}}">
                            </div>
                            <div class="panel-footer">
                                <input type="hidden" class="avatar_image_id" value="@if($user->avatar_info){{ $user->avatar_info->id }}@endif">
                                <span style="font-size: 11px;">{{ trans('profile.avatar_title') }}:</span> <span value="">
                                    @if(isset($user->avatar) &&!empty($user->avatar) &&($user->avatar!=null) &&($user->avatar!=0) )
                                        @if($user->avatar_info){{ $user->avatar_info->originalName }}@else تصویر پیش‌فرض @endif
                                    @else {{ trans('profile.no_select_picture') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <center>
                            @if(isset($user->avatar) &&!empty($user->avatar) &&($user->avatar!=null) &&($user->avatar!=0) )
                                <button type="button" class="btn btn-primary remove_avatar_image">{{ trans('profile.delete_profile') }}</button>
                            @else
                                <button type="button" id="footer_selec_avatar" class="btn btn-primary select_file">{{ trans('profile.select_file') }}</button>
                            @endif
                        </center>
                    </div>

                    <div class="upload_form" style="width:300px; margin: 10px auto">

                        <div class="panel panel-default ">
                            <div class="panel-body">
                                <h5 style="padding-bottom: 10px">{{ trans('profile.select_new_avatar_image') }}</h5>
                                <form method="Post" enctype="multipart/form-data" id="avatar_form" action="#">
                                    <input id="input_file_avatar" class="form-control filestyle" type="file" name="avatar">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $(":file").filestyle({
                buttonText: "انتخاب تصویر نمایه",
                input: false,
                iconName: "fa fa-image"
            });
            @if(isset($user->profile) && isset($user->profile->birth_date))
                $('.jsp_user_birth_date').val("{!! $user->profile->birth_date !!}");
            @endif

            @if(isset($user->profile) && isset($user->profile->province) && isset($user->profile->city))
                $(".jsp_user_detail_province").select2("trigger", "select", {
                    data: {id: "{!! $user->profile->province->id !!}", text: "{!! $user->profile->province->name !!}"}
                });

                $(".jsp_user_detail_city").select2("trigger", "select", {
                    data: {id: "{!! $user->profile->city !!}", text: "{!! $user->profile->city->name !!}"}
                });
            @endif

        });

        $(document).on("click", ".remove_avatar_image", function () {
            confirmModal({
                title: 'حذف تصویر آواتار',
                message: 'آیا از حذف تصویر آواتارتان مطمئن هستید؟',
                onConfirm: function () {
                    $.ajax({
                        url: '{{ route('hamahang.users.remove_avatar') }}',
                        type: 'post',
//                    data: form_data,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        async: false,
                        success: function (s) {
                            if (s.success == true) {
                                // $('.show_avatar_image').hide();
                                // $('.btn_save_avatar').show();
                                //$('.upload_form').show();
                                location.reload();
                                $(':file').filestyle({
                                    buttonName: 'انتخاب فایل'
                                });

                            }
                            else {
                                // messageModal('error', 'خطای آپلود فایل', s.result);
                            }
                        }
                    });
                },
                afterConfirm: 'close'
            });
        });



        {{--$(document).on("click", ".btn_edit_user_detail", function () {--}}
        {{--alert(1);--}}
        {{--var formElement = document.querySelector('#setting_avatar_form');--}}
        {{--var formData1 = new FormData(formElement);--}}
        {{--save_avatar_image(formData1);--}}
        {{--});--}}

        {{--function save_avatar_image(form_data) {--}}
        {{--$.ajax({--}}
        {{--url: '{{ route('hamahang.users.save_avatar') }}',--}}
        {{--type: 'post',--}}
        {{--data: form_data,--}}
        {{--contentType: false,--}}
        {{--processData: false,--}}
        {{--dataType: "json",--}}
        {{--async: false,--}}
        {{--success: function (s) {--}}
        {{--if (s.success == true) {--}}

        {{--$('.show_avatar_image img').attr('src', '{{route('FileManager.DownloadFile',['ID', '' ])}}/' + s.img_id);--}}
        {{--$('.upload_form').hide();--}}
        {{--$('.show_avatar_image').show();--}}
        {{--$(":file").filestyle('clear');--}}
        {{--$('.btn_save_avatar').hide();--}}
        {{--location.reload();--}}
        {{--}--}}
        {{--else {--}}
        {{--messageModal('error', 'خطای آپلود فایل', s.result);--}}
        {{--}--}}
        {{--}--}}
        {{--});--}}
        {{--}--}}
    </script>

    @include('modals.helper.avatar.inline_js.user_avatar_inline_js')
@endif




