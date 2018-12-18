<script>
    $(".select2_auto_complete_keywords").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: true,
        ajax: {
            url: "{{route('auto_complete.keywords')}}",
            dataType: "json",
            type: "POST",
            quietMillis: 150,
            data: function (term) {
                return {
                    term: term
                };
            },
            results: function (data) {
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
    $(".select2_auto_complete_org_unit").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: false,
        ajax: {
            url: "{{route('auto_complete.organs')}}",
            dataType: "json",
            type: "POST",
            quietMillis: 150,
            data: function (term) {
                return {
                    term: term
                };
            },
            results: function (data) {
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
    $(".select2_auto_complete_user").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: true,
        ajax: {
            url: "{{route('auto_complete.users_new')}}",
            dataType: "json",
            type: "POST",
            quietMillis: 150,
            data: function (term) {
                return {
                    term: term
                };
            },
            results: function (data) {
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
    $(".js-data-example-ajax").select2({
        minimumInputLength: 1,
        tags: false,
        dir: "rtl",
        width: '100%',
        ajax: {
            url: "{{ route('auto_complete.pages') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            results: function (data) {
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

    $('#p_schedule_on').on('change', function () {
        var val = $('#p_schedule_on').val();
        if (val == 1) {
            $('#schedule_massage').html('وظایف هرچه زودتر آغاز شوند');
            $('#end_date').attr('disabled', 'disabled');
            $('#start_date').attr('disabled', false);
        }
        if (val == 2) {

            $('#schedule_massage').html('وظایف تا حد امکان دیرتر آغاز شوند');
            $('#end_date').attr('disabled', false);
            $('#start_date').attr('disabled', 'disabled');
        }
    })
    function CheckForm() {

//        if (($('input[name=save_type]:checked').val() == 11 || $('input[name=save_type]:checked').val() == 22) && $('#base_calendar').val() != '') {
        if(1){
        SaveNewProject();
        }
        else {
            {
                var TxtAlert = '';
                if (!($('input[name=save_type]:checked').val() == 11 || $('input[name=save_type]:checked').val() == 22))
                    TxtAlert += '* نوع ذخیره مشخص نشده است' + '<br/>';
                if (!$('#base_calendar').val() != '')
                    TxtAlert += '* نوع زمانبندی مشخص نشده است';
                $('#confirm_modal_massage').html(TxtAlert);
                $('#confirm_modal').modal({show: true});
            }
        }
    }

    function SaveNewProject() {
        var create_page = 'no';
        if ($('input[name="create_page"]:checked').length)
            create_page = 'yes';
        var sendInfo = {
            p_title: $('#p_title').val(),
            p_type: $('input[name=p_type]:checked').val(),
            p_top_goals: $('#p_top_goals').val(),
            p_page: $('#p_page').val(),
            p_about: $('#p_about').val(),
            p_desc: $('#p_desc').val(),
            p_responsible: $('#p_responsible').val(),
            p_observer: $('#p_observer').val(),
            p_supervisor: $('#p_supervisor').val(),
            users_list_project_view: $('#users_list_project_view').val(),
            roles_list_project_view: $('#roles_list_project_view').val(),
            create_new_project: $('#create_new_project').attr('id'),
            users_list_project_edit_tasks: $('#users_list_project_edit_tasks').val(),
            roles_list_project_edit_tasks: $('#roles_list_project_edit_tasks').val(),
            users_list_project_edit: $('#users_list_project_edit').val(),
            roles_list_project_edit: $('#roles_list_project_edit').val(),
            p_org_unit: $('#p_org_unit').val(),
            p_keyword: $('#p_keyword').val(),
            p_schedule_on: $('#p_schedule_on').val(),
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
            current_date: $('#current_date').val(),
            state_date: $('#state_date').val(),
            base_calendar: $('#base_calendar').val(),
            create_page: create_page,
            p_priority: $('#p_priority').val(),
            p_page: $('#page_id').val(),
            modify_permission_type: $('input[name=ModifyPermissionType]:checked').val(),
            ModifyPermissionUsers: $('#ModifyPermissionUsers').val(),
            observation_permission_type: $('input[name=ObservationPermissionType]:checked').val(),
            importance: $('input[name=importance]:checked').val(),
            immediate: $('input[name=immediate]:checked').val(),
            ObservationPermissionUsers: $('#ObservationPermissionUsers').val(),
            save_type: $('input[name=save_type]:checked').val(),
        };
        {{--confirmModal({--}}
            {{--title: '{{trans('projects.create_new_project')}}',--}}
            {{--message: '{{trans('projects.are_you_sure_to_create_new_project')}}',--}}
            {{--onConfirm: function () {--}}
                $.ajax({
                    url: '{!! route('hamahang.project.edit_project')!!}',
                    type: 'POST', // Send post dat
                    data: sendInfo,
                    async: false,
                    success: function (s) {
                        res = JSON.parse(s);
                        if (res.success == true) {
                            if(res.type == 'create_page'){
                                window.location.href = "{{url('/')}}/page_edit/" + res.pid + "/text";
                            }else{
{{--                                messageModal('success', '{{trans('projects.project')}}', {0: '{{trans('projects.project_created_successfully')}}'});--}}
                                window.ProjectList.ajax.reload();
                            }
                            {{--messageModal('success', '{{trans('projects.project')}}', {0: '{{trans('projects.project_created_successfully')}}'});--}}
                            //location.reload();
                        }else{
                            messageModal('error', '{{trans('app.operation_is_failed')}}', res.error);
                        }
                    }
                });
        //     },
        //     afterConfirm: 'close'
        // });

        {{--$.ajaxSetup({--}}
        {{--headers: {--}}
        {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--}--}}
        {{--});--}}

        {{--$.ajax({--}}
        {{--type: "POST",--}}
        {{--url: '{{ route('hamahang.project.save_new_project') }}',--}}
        {{--dataType: "json",--}}
        {{--data: sendInfo,--}}
        {{--success: function (data) {--}}

        {{--console.log(data);--}}
        {{--if(data.success == true)--}}
        {{--{--}}
        {{--messageModal('success','{{trans('app.operation_is_success')}}',data.message);--}}
        {{--window.location = "{{ route('ugc.desktop.hamahang.project.list',['username'=>auth()->user()->Uname]) }}";--}}
        {{--}--}}
        {{--else--}}
        {{--{--}}
        {{--messageModal('error','{{trans('app.operation_is_failed')}}',data.error);--}}
        {{--}--}}

        {{--}--}}
        {{--});--}}

    }
    (function ($) {
        $(".DatePicker").persianDatepicker({
            observer: true,
            autoClose: true,
            //position: 'right',
            format: 'YYYY-MM-DD'
        });

        {{--$('#ModifyPermissionUsers').ajaxChosen({--}}
            {{--dataType: 'json',--}}
            {{--type: 'POST',--}}
            {{--url: "{{ route('auto_complete.users') }}"--}}
        {{--});--}}
        {{--$('#ObservationPermissionUsers').ajaxChosen({--}}
            {{--dataType: 'json',--}}
            {{--type: 'POST',--}}
            {{--url: "{{ route('auto_complete.users') }}"--}}
        {{--});--}}
    })(jQuery);
    $(".users_list_project_view").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.users') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                console.log(data);
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

    $(".roles_list_project_view").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.roles') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                console.log(data);
                var a = true;
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
    $(".roles_list_project_view").html('<option selected="selected" value="3">public عمومی</option>');

    $(".users_list_project_edit_tasks").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.users') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

    $(".roles_list_project_edit_tasks").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.roles') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                console.log(data);
                var a = true;
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

    $(".users_list_project_edit").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.users') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

    $(".roles_list_project_edit").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.roles') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                console.log(data);
                var a = true;
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
    $(".roles_list_project_edit").html('<option selected="selected" value="1">administrator مدیر ارشد</option>');
    $(".roles_list_project_edit_tasks").html('<option selected="selected" value="1">administrator مدیر ارشد</option>');
</script>