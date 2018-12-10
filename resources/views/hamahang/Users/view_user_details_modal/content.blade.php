@include('hamahang.Users.view_user_details_modal.helper.view_user_inline_js')
@if ($user->id == auth()->id())

    {{--    {{ dd($user->profile->province) }}--}}
    <div style="padding: 0 15px 15px 15px;">
        <div class="navbar ">
            <ul class="nav nav-tabs">
                <li class="active" id="tab_edit"><a aria-controls="art-tab-1" href="#edit_user" role="tab" data-toggle="tab">مشخصات</a></li>
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
                                    <div class="col-xs-6"><input type="text" name="name" class="form-control required" value="{{ $user->Name }} " placeholder="نام"></div>
                                    <div class="col-xs-6"><input type="text" name="family" class="form-control required" value="{{ $user->Family }}" placeholder="نام خانوادگی"></div>
                                </div>
                                <div class="col-xs-12 margin-top-10">
                                    <div class="col-xs-12">
                                        <input type="text" name="summary" class="text form-control" value="{{ $user->Summary }}" placeholder="چند واژه برای معرفی شما (مانند عناوینی که در کارت ملاقات ذکر می شود)">
                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-10">
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">تاریخ تولد</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input id="birthday" name="birthday" class="form-control jalali_date jsp_user_birth_date" type="text" value="@if(isset($user->profile)){{ $user->profile->birth_date }}@endif"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">محل تولد</div>
                                        <div class="col-xs-5 noRightPadding noLeftPadding">
                                                <select id="province" name="province" class='select2 province form-control js-example-basic-single jsp_user_detail_province'>
                                                    @if($provinces)
                                                        @foreach($provinces as $province)
                                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                        </div>
                                        <div class="col-xs-5 noRightPadding noLeftPadding">
                                            <select id="city" name="city" class='select2 form-control js-example-basic-single jsp_user_detail_city'>
                                                @if($cities)
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-10">
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">تلفن همراه</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input type="text" name="mobile" class="dir_ltr form-control" value="@if(isset($user->profile)){{ $user->profile->Mobile }} @endif">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 text-center">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-355">تلفن ثابت</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input style="width: 250px" class="dir_ltr form-control col-xs-9" type="text" value="@if(isset($user->profile)){{ $user->profile->Tel_number }}@endif" name="tel_number" size="34"
                                                   maxlength="10" placeholder="شماره تلفن">
                                            <input style="width: 100px" class="dir_ltr form-control col-xs-3" type="text" value="@if(isset($user->profile)){{ $user->profile->Tel_code }}@endif" name="tel_code" size="4" maxlength="4"
                                                   placeholder="کد شهر">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-10">
                                    <div class="col-xs-6">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">فاکس</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input style="width: 250px" class="dir_ltr form-control col-xs-9" type="text" value="@if(isset($user->profile)){{ $user->profile->Fax_number }}@endif" name="fax_number" size="34" maxlength="10" placeholder="شماره فکس">
                                            <input style="width: 100px" class="dir_ltr form-control col-xs-3" type="text" value="@if(isset($user->profile)){{ $user->profile->Fax_code  }}@endif" name="fax_code" size="4" maxlength="4" placeholder="کد شهر">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 text-center">
                                        <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">وب سایت</div>
                                        <div class="col-xs-10 noRightPadding noLeftPadding">
                                            <input type="text" name="website" class="dir_ltr form-control" value="@if(isset($user->profile)){{ $user->profile->Website }}@endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 margin-top-10">
                                    <div class="col-xs-6">
                                        <div class="pull-right line-height-35">رایانامه</div>
                                        <div class="pull-right margin-right-10">
                                            <input type="text" name="email" class="dir_ltr form-control" value="{{ isset($user->Email) ? $user->Email : '' }}" {!! 'shazand' == config('constants.IndexView') ? null : 'readonly' !!}>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="pull-right">جنسیت</div>
                                        <div class="pull-right"><label style="display:inline"><input class="gender" type="radio" @if($user->Gender =='0') checked="checked" @endif value="0" name="gender">مرد</label>
                                            <label style="display:inline"><input class="gender" type="radio" @if($user->Gender =='1') checked="checked" @endif value="1" name="gender">زن</label>
                                            <label style="display:inline"><input class="gender" type="radio" @if($user->Gender =='2' || $user->Gender =='') checked="checked" @endif value="2" name="gender">نامشخص</label></div>
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
                                    <div class="col-xs-6">
                                        <div>دیدگاه</div>
                                        <div><textarea class="form-control" rows="5" name="comment" id="comment" placeholder="دیدگاه">{{ $user->Comment }}</textarea></div>
                                    </div>
                                    <div class="col-xs-6 text-center">
                                        @if(isset($user->avatar) &&!empty($user->avatar) &&($user->avatar!=null) &&($user->avatar!=0) )
                                            <span class="fa fa-times remove_avater remove_avatar_image" style="cursor: pointer;"></span>
                                        @endif
                                        <img class="img_avatar" style="margin-bottom: 10px; width: 150px; height: 150px; position: relative;"
                                             title="@if($user->avatar_info){{ $user->avatar_info->originalName }}@endif" src="{{$user->AvatarLink}}">
                                        <div class="text-center" style="padding-right: 38%;"><input id="setting_input_file_avatar" class="form-control filestyle" type="file" name="user_avatar"></div>
                                    </div>
                                </div>
                                <input type="submit" id="user_detail_form_data" hidden>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="edit_pass" role="tabpanel" class="tab-pane">
                    <form id="user_password_edit_form">
                        <table class="table-striped col-xs-12">
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
                    data: {id: "{!! $user->profile->city->id !!}", text: "{!! $user->profile->city->name !!}"}
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
                                messageModal('error', 'خطای آپلود فایل', s.result);
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




