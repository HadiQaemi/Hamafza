<script>
    $(document).ready(function () {

        $(".jalali_date").persianDatepicker({
            autoClose: true,
            format: 'YYYY/MM/DD'
        });

        $(".province").select2({
            dir: "rtl",
            language: "fa",
            width: '100%',
            data: {!!  $provinces  !!}
        });

        $(".user_specials").select2({
            dir: "rtl",
            width: '100%',
            tags: true,
            minimumInputLength: 2,
            insertTag: function(data, tag){
                tag.text = 'جدید: ' + tag.text;
                data.push(tag);
            },
            ajax: {
                url: "{{route('auto_complete.about_user_keywords')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {term: term};
                },
                results: function (data) {
                    console.log(data);
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        @if(auth()->check())
        $(document).on("click", ".btn_new_user_to_old", function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.users.remove_user_new')}}',
                dataType: "json",
                data: {
                    item_id: {{ auth()->user()->id }}
                },
                success: function (result) {
                    if (result.success == true) {
                        location.reload();
                    }
                    else {
                        messageModal('error', 'خطا در ثبت تحصیلات جدید', result.error);
                    }
                }
            });
        });

        $(document).on("click", ".btn_edit_user_detail", function () {
            $('#user_detail_form_data').click();
            {{--var formElement = document.querySelector('#user_detail_edit_form');--}}
            {{--var avatar_data = new FormData(formElement);--}}
{{--//            save_avatar_image(formData1);--}}
            {{--var user_data = $('#user_detail_edit_form').serialize();--}}
            {{--$.ajax({--}}
                {{--type: "POST",--}}
                {{--url: '{{ route('hamahang.users.update_user_detail') }}',--}}
                {{--dataType: "json",--}}
                {{--data: user_data + '&avatar_data=' + avatar_data,--}}
                {{--success: function (result) {--}}
                    {{--if (result.success == true) {--}}
                        {{--window.location = result.user_profile_url;--}}
                    {{--}--}}
                    {{--else {--}}
                        {{--var errors = '';--}}
                        {{--for(var k in result.error) {--}}
                            {{--errors += '' +--}}
                                {{--'<li>' + result.error[k] +'</li>'--}}
                        {{--}--}}
                        {{--jQuery.noticeAdd({--}}
                            {{--text: errors,--}}
                            {{--stay: false,--}}
                            {{--type: 'error'--}}
                        {{--});--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
        });

        $(document).on("click", ".user_specials_edit", function () {
                    @if($user->specials && $user->specials->count() > 0)
            var specials =
            {!! $user->specials !!}
                for (var k in specials) {
                $("#user_specials").select2("trigger", "select", {
                    data: {id: specials[k].id, text: specials[k].title}
                });
            }
            @endif
            $('#user_special_edit').removeClass('hide');
        });

        $(document).on("click", ".btn_abort_update_user_specials", function () {
            $('#user_special_edit').addClass('hide');
        });

        $(document).on("click", ".btn_update_user_specials", function () {
            var form_data = $('#update_user_specials_form').serialize();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.users.update_user_specials')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success == true) {
                        location.reload();
                    }
                    else {
                        messageModal('error', 'خطا در ویرایش تخصص‌های کاربر', result.error);
                    }
                }
            });
        });

        $(document).on("click", ".add_new_work", function () {
            var $this = $(this);
            $('.user_work_form_div').empty();
            var user_work_form = user_work_form_generator();
            $('#user_works .inner .user_work_form_div:first').html(user_work_form);
            $(".work_province").select2({
                dir: "rtl",
                language: "fa",
                width: '100%',
                data: {!!  $provinces  !!}
            });
            $('.work_province').on('change', function () {
                var data = $(".work_province option:selected").val();
                $(".work_city").select2({
                    dir: "rtl",
                    width: '100%',
                    ajax: {
                        url: "{{ route('auto_complete.hamahang_cities') }}",
                        dataType: 'json',
                        type: "POST",
                        quietMillis: 50,
                        data: function () {
                            return {
                                province_id: data
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });
            });

            $(".jalali_date").persianDatepicker({
                autoClose: true,
                format: 'YYYY/MM/DD'
            });
        });

        $(document).on("click", ".add_new_education", function () {
            var $this = $(this);
            $('.user_education_form_div').empty();
            var user_education_form = user_educations_form_generator();
            $('#user_educations .inner .user_education_form_div:first').html(user_education_form);
            $(".education_province").select2({
                dir: "rtl",
                language: "fa",
                width: '100%',
                data: {!!  $provinces  !!}
            });
            $('.education_province').on('change', function () {
                var data = $(".education_province option:selected").val();
                $(".education_city").select2({
                    dir: "rtl",
                    width: '100%',
                    ajax: {
                        url: "{{ route('auto_complete.hamahang_cities') }}",
                        dataType: 'json',
                        type: "POST",
                        quietMillis: 50,
                        data: function () {
                            return {
                                province_id: data
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });


            });
            $(".jalali_date").persianDatepicker({
                autoClose: true,
                format: 'YYYY/MM/DD'
            });
        });

        $(document).on("click", ".edit_user_work", function () {
            $('.user_work_form_div').empty();
            var $this = $(this);
            var item_id = $this.data('item_id');
            var post = $this.data('post');
            var company = $this.data('company');
            var section = $this.data('section');
            var province = $this.data('province');
            var city = $this.data('city');
            var start_year = $this.data('start_year');
            var end_year = $this.data('end_year');
            var comment = $this.data('comment');
            var user_work_form = user_work_form_generator(item_id, post, company, section, province, city, start_year, end_year, comment);
            $this.parent().parent().find('.user_work_form_div').html(user_work_form);
            $(".work_province").select2({
                dir: "rtl",
                language: "fa",
                width: '100%',
                data: {!!  $provinces  !!}
            });
            $('.work_province').on('change', function () {
                var data = $(".work_province option:selected").val();
                $(".work_city").select2({
                    dir: "rtl",
                    width: '100%',
                    ajax: {
                        url: "{{ route('auto_complete.hamahang_cities') }}",
                        dataType: 'json',
                        type: "POST",
                        quietMillis: 50,
                        data: function () {
                            return {
                                province_id: data
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });


            });
            $(".work_province").select2("trigger", "select", {
                data: {id: province.id, text: province.name}
            });
            $(".work_city").select2("trigger", "select", {
                data: {id: city.id, text: city.name}
            });
            $(".jalali_date").persianDatepicker({
                autoClose: true,
                format: 'YYYY/MM/DD'
            });

            $('.user_work_start_year').val(start_year);
            $('.user_work_end_year').val(end_year);

        });

        $(document).on("click", ".edit_user_education", function () {
            $('.user_education_form_div').empty();
            var $this = $(this);
            var item_id = $this.data('item_id');
            var major = $this.data('major');
            var start_year = $this.data('start_year');
            var end_year = $this.data('end_year');
            var grade = $this.data('grade');
            var province = $this.data('province');
            var city = $this.data('city');
            var university = $this.data('university');
            var comment = $this.data('comment');
            var user_education_form = user_educations_form_generator(item_id, major, start_year, end_year, grade, province, city, university, comment);
            $this.parent().parent().find('.user_education_form_div').html(user_education_form);
            $(".education_province").select2({
                dir: "rtl",
                language: "fa",
                width: '100%',
                data: {!!  $provinces  !!}
            });
            $('.education_province').on('change', function () {
                var data = $(".education_province option:selected").val();
                $(".education_city").select2({
                    dir: "rtl",
                    width: '100%',
                    ajax: {
                        url: "{{ route('auto_complete.hamahang_cities') }}",
                        dataType: 'json',
                        type: "POST",
                        quietMillis: 50,
                        data: function () {
                            return {
                                province_id: data
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });


            });
            $(".education_province").select2("trigger", "select", {
                data: {id: province.id, text: province.name}
            });
            $(".education_city").select2("trigger", "select", {
                data: {id: city.id, text: city.name}
            });
            $(".jalali_date").persianDatepicker({
                autoClose: true,
                format: 'YYYY/MM/DD'
            });

            $('.user_education_start_year').val(start_year);
            $('.user_education_end_year').val(end_year);
            $('.user_education_grade').val(parseInt(grade));
        });

        $(document).on("click", ".btn_abort_user_work", function () {
            $('.user_work_form_div').empty();
        });

        $(document).on("click", ".btn_abort_user_education", function () {
            $('.user_education_form_div').empty();
        });

        $(document).on("click", ".btn_add_edit_user_work", function () {
            var form_data = $('#user_work_form').serialize();
            var $this = $(this);
            var item_id = $this.data('item_id');
            if (!item_id)
                add_new_user_work(form_data);
            else
                update_user_work(form_data);
        });

        $(document).on("click", ".btn_add_edit_user_education", function () {
            var form_data = $('#user_education_form').serialize();
            var $this = $(this);
            var item_id = $this.data('item_id');
            if (!item_id)
                add_new_user_education(form_data);
            else
                update_user_eduction(form_data);
        });

        $(document).on("click", ".delete_user_work", function () {
            var $this = $(this);
            var item_id = $this.data('item_id');
            delete_user_work(item_id);

        });

        $(document).on("click", ".delete_user_education", function () {
            var $this = $(this);
            var item_id = $this.data('item_id');
            delete_user_education(item_id);

        });

        @endif
        //        $(document).on("click", ".btn_abort_edit_user_detail", function () {
        ////            document.getElementById('user_detail_edit_form').reset();
        //            $('#user_detail_edit').addClass('hide');
        //        });

    });
    @if(auth()->check())
        $(document).on("click", ".special", function () {
            var ts = $(this);
            var id = ts.attr('id');
            if (ts.hasClass('cursor-pointer')) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.users.user_special_endorse')}}',
                    dataType: "json",
                    data: {id: id},
                    success: function (result) {
                        var isModal = ' data-toggle="modal" data-target="#user_endorse" ';
                        var text = '<span class="span_count_users" ' + isModal + '><u>' + result.count_user_special + '</u>&nbsp;نفر صحه گذاری کرده‌اند.</span>';
                        if (result.count_user_special == '0') {
                            var text = '';
                        }
                        isModal = '';
                        if (result.message == true) {
                            ts.parent().find('.special').removeClass('endorse_vote_icon');
                            ts.parent().find('.endorse_vote_count').html(text);
                        } else {
                            ts.parent().find('.special').addClass('endorse_vote_icon');
                            ts.parent().find('.endorse_vote_count').html(text);
                        }

                    }
                });

            }

        });
    @endif
    $(document).on("click", ".span_count_users", function () {
    @if(auth()->id() != null)
        $('.loader').show();
        var ts = $(this);
        var endorse_title = $(this).parent().parent().parent().find('.endorse_title').children().html();
        var id = ts.parent().parent().find('.special').attr('id');
        //console.log(id);
        //$('.endorse_title_modal').html('{{ $user->Name }}  {{ $user->Family }} ');
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.users.user_endorse')}}',
            dataType: "json",
            data: {id: id},
            success: function (result) {
                //console.log(result);
                var num = 1;
                $('.tbody_users').children().remove();
                $.each(result, function (key, value) {
                    $('.tbody_users').append('<tr style="text-align: center;">' +
                        '<td style="vertical-align: middle;">' + num + '</td>' +
                        '<td><img src="{{route('FileManager.DownloadFile',['ID',''])}}/' + value.avatar + '" style="width: 50px;height: 50px;"></td>' +
                        '<td style="vertical-align: middle; text-align: right;"><a target="_blank" href="' + value.Uname + '">' + value.Name + ' ' + value.Family + '</a></td>' +
                        '</tr>');
                    num++;
                });
                $('.loader').hide();
                //$('.tbody_users').html();
            }
        });
    @endif
    });

    @if(auth()->check())
    function user_work_form_generator(item_id, post, company, section, province, city, start_year, end_year, comment) {
        if (typeof item_id == 'undefined') {
            item_id = '';
        }
        if (typeof post == 'undefined') {
            post = '';
        }
        if (typeof company == 'undefined') {
            company = '';
        }
        if (typeof section == 'undefined') {
            section = '';
        }
        if (typeof province == 'undefined') {
            province = '';
        }
        if (typeof city == 'undefined') {
            city = '';
        }
        if (typeof start_year == 'undefined') {
            start_year = '';
        }
        if (typeof end_year == 'undefined') {
            end_year = '';
        }
        if (typeof comment == 'undefined') {
            comment = '';
        }

        var res = '' +
            '<form method="post" id="user_work_form">' +
            '   <div>' +
            '      <input id="edit_form_item_id" type="hidden" name="item_id" value="' + item_id + '">' +
            '      <input type="hidden" name="uid" value="' + {{ $user->id }} +'">' +
            '      <table class="table-striped">' +
            '         <tr>' +
            '             <td>' +
            '                 <span>سمت</span>' +
            '                 <span style="color:red">*</span>' +
            '             </td>' +
            '             <td>' +
            '                 <input name="post" value="' + post + '" class="form-control required">' +
            '             </td>' +
            '             <td>' +
            '                 <span>سازمان</span>' +
            '                 <span style="color:red">*</span>' +
            '             </td>' +
            '             <td>' +
            '                 <input name="company" type="text" value="' + company + '" class=" form-control required ui-autocomplete-input">' +
            '             </td>' +
            '         </tr>' +
            '         <tr>' +
            '             <td>' +
            '                 <span> واحد سازمانی</span>' +
            '             </td>' +
            '             <td>' +
            '                 <input name="section" value="' + section + '" class="form-control required" size="30">' +
            '             </td>' +
            '         </tr>' +
            '         <tr>' +
            '             <td>' +
            '                 <span>استان</span>' +
            '             </td>' +
            '             <td>' +
            '                 <select name="province" class="work_province form-control">' +
            '                     <option value="0">انتخاب کنید</option>' +
            '                 </select>' +
            '             </td>' +
            '             <td>' +
            '                 <span>شهر</span>' +
            '             </td>' +
            '             <td>' +
            '                 <select name="city" class="work_city form-control"></select>' +
            '             </td>' +
            '         </tr>' +
            '         <tr>' +
            '             <td>شروع</td>' +
            '             <td>' +
            '                 <input name="start_year" class="form-control jalali_date user_work_start_year" type="text" value="' + start_year + '"/>' +
            '             </td>' +
            '             <td>پایان</td>' +
            '             <td>' +
            '                 <input name="end_year" class="form-control jalali_date user_work_end_year" type="text" value="' + end_year + '"/>' +
            '             </td>' +
            '         </tr>' +
            '         <tr>' +
            '             <td colspan="4"><span>توضیح</span>' +
            '             <br>' +
            '             <textarea name="comment" class="form-control" cols="155" rows="3"' +
            '                 placeholder="ویژگیهای سازمان، ویژگیهای شغل و نقش شما در سازمان، کارهای برجسته ای که انجام داده اید و ...">' + comment + '</textarea>' +
            '             </td>' +
            '         </tr>' +
            '         <tr>' +
            '             <td colspan="4">' +
            '             <span class="FloatLeft">' +
            '                 <input type="button" data-item_id="' + item_id + '" class="btn btn-primary btn_add_edit_user_work" value="ذخیره">' +
            '                 <input type="button" class="btn  btn-default btn_abort_user_work" value="لغو">' +
            '             </span>' +
            '             </td>' +
            '         </tr>' +
            '      </table>' +
            '   </div>' +
            '</form>';
        return res;
    }

    function user_educations_form_generator(item_id, major, start_year, end_year, grade, province, city, university, comment) {
        if (typeof item_id == 'undefined') {
            item_id = '';
        }
        if (typeof major == 'undefined') {
            major = '';
        }
        if (typeof grade == 'undefined') {
            grade = '';
        }
        if (typeof province == 'undefined') {
            province = '';
        }
        if (typeof city == 'undefined') {
            city = '';
        }
        if (typeof university == 'undefined') {
            university = '';
        }
        if (typeof start_year == 'undefined') {
            start_year = '';
        }
        if (typeof end_year == 'undefined') {
            end_year = '';
        }
        if (typeof comment == 'undefined') {
            comment = '';
        }

        var res = '' +
            '<form method="post" id="user_education_form">' +
            '   <div>' +
            '   <input id="edit_form_item_id" type="hidden" name="item_id" value="' + item_id + '">' +
            '   <input type="hidden" name="uid" value="' + {{ $user->id }} +'">' +
            '      <table class="table-striped">' +
            '          <tr>' +
            '              <td>رشته تحصیلی <span style="color:red">*</span></td>' +
            '              <td>' +
            '                  <input name="major" value="' + major + '" class="form-control" size="30">' +
            '              </td>' +

            '          </tr>' +
            '          <tr>' +
            '              <td>مقطع تحصیلی <span style="color:red">*</span></td>' +
            '              <td>' +
            '                  <select class="form-control user_education_grade" name="grade">' +
            '                      <option value="1">دیپلم</option>' +
            '                      <option value="2">فوق دیپلم</option>' +
            '                      <option value="3">کارشناسی</option>' +
            '                      <option value="4">کارشناسی ارشد</option>' +
            '                      <option value="5">دکترا</option>' +
            '                      <option value="6">دکترای حرفه ای</option>' +
            '                      <option value="7">فوق دکتری</option>' +
            '                  </select>' +
            '              </td>' +
            '              <td>' +
            '                  <span>دانشگاه یا موسسه</span>' +
            '                  <span style="color:red">*</span>' +
            '              </td>' +
            '              <td>' +
            '                  <input type="text" name="university" value="' + university + '" class="form-control"/>' +
            '              </td>' +
            '          </tr>' +
            '         <tr>' +
            '             <td>' +
            '                 <span>استان</span>' +
            '             </td>' +
            '             <td>' +
            '                 <select name="province" class="education_province form-control">' +
            '                     <option value="0">انتخاب کنید</option>' +
            '                 </select>' +
            '             </td>' +
            '             <td>' +
            '                 <span>شهر</span>' +
            '             </td>' +
            '             <td>' +
            '                 <select name="city" class="education_city form-control"></select>' +
            '             </td>' +
            '         </tr>' +
            '              <td>شروع</td>' +
            '              <td>' +
            '                  <input name="start_year" class="form-control jalali_date user_education_start_year" type="text" value="' + start_year + '"/>' +
            '              </td>' +
            '              <td>پایان</td>' +
            '              <td>' +
            '                  <input name="end_year" class="form-control jalali_date user_education_end_year" type="text" value="' + end_year + '"/>' +
            '              </td>' +
            '          </tr>' +
            '          <tr>' +
            '              <td colspan="4">' +
            '                  <br>' +
            '                  <textarea name="comment" class="form-control" placeholder="عنوان پایان نامه ،&zwnj; رساله و پروژه های پژوهشی، فعالیتهای برجسته و ...">' + comment + '</textarea>' +
            '              </td>' +
            '          </tr>' +
            '          <tr height="30">' +
            '              <td colspan="4">' +
            '                  <span class="FloatLeft">' +
            '                      <input type="button" data-item_id="' + item_id + '" class="btn btn-primary btn_add_edit_user_education" value="ذخیره">' +
            '                      <input type="button" class="btn  btn-default btn_abort_user_education" value="لغو">' +
            '                  </span>' +
            '              </td>' +
            '          </tr>' +
            '      </table>' +
            '   </div>' +
            '</form>';

        $('.user_education_start_year').val(start_year);
        $('.user_education_end_year').val(end_year);

        return res;
    }

    function add_new_user_work(form_data) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.users.add_user_work')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    location.reload();
                }
                else {
                    messageModal('error', 'خطا در ثبت شغل جدید', result.error);
                }
            }
        });
    }

    function add_new_user_education(form_data) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.users.add_user_education')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    location.reload();
                }
                else {
                    messageModal('error', 'خطا در ثبت تحصیلات جدید', result.error);
                }
            }
        });
    }

    function update_user_work(form_data) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.users.update_user_work')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    location.reload();
                }
                else {
                    messageModal('error', 'خطا در ثبت شغل جدید', result.error);
                }
            }
        });
    }

    function update_user_eduction(form_data) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.users.update_user_education')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    location.reload();
                }
                else {
                    messageModal('error', 'خطا در ثبت شغل جدید', result.error);
                }
            }
        });
    }

    function delete_user_work(item_id) {
        confirmModal({
            title: 'حذف شغل',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    url: '{!! route('hamahang.users.delete_user_work')!!}',
                    type: 'POST', // Send post dat
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    async: false,
                    success: function (result) {
                        if (result.success == true) {
                            location.reload();
                        }
                        else {
                            messageModal('error', 'خطا در حذف شغل', result.error);
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    function delete_user_education(item_id) {
        confirmModal({
            title: 'حذف تحصیلات',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    url: '{!! route('hamahang.users.delete_user_education')!!}',
                    type: 'POST', // Send post dat
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    async: false,
                    success: function (result) {
                        if (result.success == true) {
                            location.reload();
                        }
                        else {
                            messageModal('error', 'خطا در حذف شغل', result.error);
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }
    @endif
</script>