<div class="col-xs-12 col-md-12">
    <div class="panel-body">
        <form id="create_new_process">
            <table class="table table-striped">
                <tr>
                    <td>{{ trans('app.title') }}</td>
                    <td>
                        <input type="text" class="col-xs-4 form-control" id="p_title"/>
                        <input type="radio" class="" name="p_type" value="0"/><label>{{ trans('app.official') }}</label>
                        <input type="radio" class="" name="p_type" value="1"/><label>{{ trans('app.unofficial') }}</label>
                    </td>
                </tr>
                <tr>
                    <td>{{ trans('app.top_goals') }}</td>
                    <td><input type="text" class="form-control" id="top_goals"/></td>
                </tr>
                <tr>
                    <td>صفحه</td>
                    <td>
                        <div class="col-sm-12 row" style="padding: 0;">
                            <span id="pages">
                                <div class="col-sm-12 " style="padding: 0;">
                                    <select class="select2_auto_complete_pages form-control" id="page_id" name="page_id" multiple></select>
                                    <span style="position: absolute; left: 20px; top: 10px;" class="glyphicon glyphicon-file"></span>
                                </div>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>توضیح</td>
                    <td><input type="text" class="form-control" id="p_desc"/></td>
                </tr>
                <tr>
                    <td>{{ trans('app.process_responsible') }}</td>
                    <td>
                        <div class="col-xs-5" style="padding: 0;">
                            <div class="col-sm-12 row" style="padding: 0">
                                <select name="p_responsible[]" id="p_responsible" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                    <option value=""></option>
                                </select>
                                <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                            </div>
                        </div>
                        <div class="col-xs-1">{{ trans('app.org_unit') }}</div>
                        <div class="col-xs-6" style="padding: 0;">
                            <div>
                                <div class="col-sm-12 row" style="padding: 0;">
                                    <select name="p_org_unit[]" id="p_org_unit" class="select2_auto_complete_org_unit col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                        <option value=""></option>
                                    </select>
                                    <span style="position: absolute; left: 20px; top: 10px;" class="fa fa-sitemap"></span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-120">
                        <label class="line-height-35">{{ trans('app.keywords') }}</label>
                    </td>
                    <td>
                        <div class="col-xs-12 row" style="padding: 0;">
                            <select class="select2_auto_complete_keywords" name="p_keyword[]" data-placeholder="{{trans('tasks.can_select_some_options')}}" multiple="multiple"></select>
                            <span class=" Chosen-LeftIcon"></span>
                        </div>
                        <div class="row-fluid">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-25">
                                <div class="form-inline"></div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>


<script>
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 40px; top: -3px;"><a href="{!! url('/modals/helpview?code=').enCode('294') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
    $(".select2_auto_complete_keywords").select2({
        dir: "rtl",
        width: '100%',
        tags: true,
        minimumInputLength: 2,
        insertTag: function(data, tag){
            tag.text = 'جدید: ' + tag.text;
            data.push(tag);
        },
        ajax: {
            url: "{{route('auto_complete.keywords')}}",
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
        tags: false,
        ajax: {
            url: "{{route('auto_complete.users')}}",
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
    $(".select2_auto_complete_pages").select2({
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
    $(".select2_tags").select2({
        minimumInputLength: 1,
        tags: [],
        dir: "rtl",
        width: '100%'
    });
    function CreateNewTask() {
        $('#task_details').modal({show: true});
    }
    function save_new_ptask() {

        $('#task_public').attr('action', '{{ route('hamahang.process.save_new_process_task') }}');
        $('#task_public').submit();
    }
    function SaveNewProcess(type) {
        if (0) {
            errorsFunc('فرم ناقص', '');
        }
        else {
            var sendInfo = {
                p_title: $('#p_title').val(),
                p_type: $('input[name=p_type]:checked').val(),
                p_desc: $('#p_desc').val(),
                p_responsible: $('#p_responsible').val(),
                p_keyword: $('#p_keyword').val(),
                p_page: $('#page_id').val(),
                p_org_unit: $('#p_org_unit').val(),
                save_type: $('input[name=save_type]:checked').val()

            };
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.process.save_new_process') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                    if (data.success == true) {
                        if (type == 1) {
                            if ($('input[name=save_type]:checked').val() == 0) {
                                window.location = '{{ route('ugc.desktop.hamahang.process.drafts_list1',['username',auth()->user()->Uname]) }}';
                            }
                            else if ($('input[name=save_type]:checked').val() == 1) {
                                window.location = '{{ route('ugc.desktop.hamahang.process.list',['username',auth()->user()->Uname]) }}';
                            }

                        }
                        else {

                            $('#process_form').trigger("reset");
                            $("#process_keywords").select2().reset();

                        }
                    }
                    else {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                    }

                }
            });
        }
    }
    function CheckType() {

        if ($('input[name=PermissionType]:checked').val() == 'some') {

            //$("#UserPermission" ).prop( "disabled", false );
            $("#UserPermission").removeAttr('disabled');
        }
        else {
            $("#UserPermission").attr('disabled', 'disabled');
        }
    }
</script>