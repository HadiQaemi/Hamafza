@extends('layouts.master')
@section('specific_plugin_style')
@stop

@section('content')
    <div class="row">
        <div class="space-14"></div>
        <fieldset>
            <legend>{{ trans('process.new_process') }}</legend>
            <div class="col-xs-12" style="padding: 5px;">
                <div class="panel">
                    {{--<div class="panel panel-heading">--}}
                    {{--<span style="font-size: 14px;margin-top: 5px"><i class="fa fa-plus"></i> ایجاد فرآیند جدید</span>--}}
                    {{--</div>--}}
                    <div class="panel-body">
                        <form id="process_form">
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
                                                <select class="select2_auto_complete_pages form-control" id="page_id"
                                                        name="page_id" multiple>

											</select>
                                                <span style="position: absolute; left: 20px; top: 10px;"
                                                      class="glyphicon glyphicon-file"></span>
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
                                            <div >
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
                                                <div class="form-inline">

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </form>
                    </div>
                </div>

                <div class="col-xs-12">
                    <span class="pull-left">
                        <input type="radio" id="save_type" name="save_type" value="0"/>
                        <label>{{ trans('app.draft') }}</label>
                        <input type="radio" id="save_type" name="save_type" value="1"/>
                        <label>{{ trans('app.finally') }}</label>
                        <a class="btn btn-info" onclick="SaveNewProcess(2)">{{ trans('process.submit_and_create_new_process') }}</a>
                        <a class="btn btn-info" onclick="SaveNewProcess(1)">{{ trans('app.confirm') }}</a>
                    </span>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="modal fade" id="task_details" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title" style="color: #bbb">{{ trans('process.show_task_draft_info') }} : <span
                                style="color: #222" id="taskTitle"></span></h5>
                </div>
                <div class="modal-body">
                    <!---------------->
                    <div id="tab" class="container table-bordered" style="width: 95%">
                        <ul class="nav nav-tabs">
                            <li>
                                <a href="#tab1" data-toggle="tab" class="active">{{ trans('app.information') }}</a>
                            </li>
                            <li><a href="#tab3" data-toggle="tab">{{ trans('app.attachments') }}</a>
                            </li>


                            <li style="float: left">
                                <h5 id="task_type" style="color: blue"></h5>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" style="padding-top: 8px" id="tab1">
                                <form action="{{ route('hamahang.tasks.save_drafts') }}" class=""
                                      name="task_public" id="task_public" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="draft" id="draft" value="0"/>
                                    <input type="hidden" name="first_m" id="first_m" value="0"/>
                                    <input type="hidden" name="first_u" id="first_u" value="0"/>
                                    <input type="hidden" name="assigner_id" value="125"/>
                                    <input type="hidden" name="current_task_id" id="current_task_id" value=""/>
                                    <table class="table table-striped col-xs-12">
                                        <tr>
                                            <td class="width-120">
                                                <label class="line-height-35">{{ trans('app.title') }}</label>
                                            </td>
                                            <td>
                                                <div class="row-fluid">
                                                    <div class="col-sm-7 row">
                                                        <input type="text" class="form-control" name="title"
                                                               id="title"/>
                                                    </div>
                                                    <div class="col-sm-5 line-height-35">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <input type="radio" name="type" value="0" checked/>
                                                                <label for="r1">{{ trans('app.official') }}</label>
                                                                <input type="radio" name="type" value="1"/>
                                                                <label for="r2">{{ trans('app.unofficial') }}</label>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">
                                                <label class="line-height-35">{{ trans('app.description') }}</label>
                                            </td>
                                            <td>
                                                <div class="row-fluid">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 line-height-35">
                                                        <input type="text" class="form-control row" name="task_desc"
                                                               id="desc"/>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">
                                                <label class="line-height-35">{{ trans('tasks.deadline') }}</label>
                                            </td>
                                            <td>
                                                <div class="row-fluid">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                                                        <div class=" row">
                                                            <div class="col-sm-6 col-xs-12">
                                                                <label class="line-height-30 pull-right">{{ trans('app.date') }}</label>
                                                                <div class="input-group pull-right">
                                <span class="input-group-addon" id="respite_date">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                                                    <input type="text" class="form-control DatePicker"
                                                                           id="rpDate" name="respite_date"
                                                                           aria-describedby="respite_date">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-xs-12">
                                                                <label class="line-height-30">{{ trans('app.time') }}</label>
                                                                <div class="input-group">
                                <span class="input-group-addon" id="respite_time">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                                                    <input type="text" class="form-control TimePicker"
                                                                           name="respite_time"
                                                                           aria-describedby="respite_time">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">
                                                <label class="line-height-35">{{ trans('app.importance') }} / {{ trans('app.priority') }}</label>
                                            </td>
                                            <td>
                                                <div class="row-fluid">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <label> {{ trans('app.importance') }}:</label>
                                                                <span class="input-group"
                                                                      style="background-color: #eeeeee;">
                                <input type="radio" name="importance" value="1" checked/>
                                <label>{{ trans('app.important') }}</label>
                                <input type="radio" name="importance" value="0"/>
                                <label>{{ trans('app.non_important') }}</label>
                            </span>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label> {{ trans('tasks.urgency') }}:</label>
                                                                <span class="input-group"
                                                                      style="background-color: #eeeeee">
                                <input type="radio" name="immediate" value="1"/>
                                <label>{{ trans('tasks.immediate') }}</label>
                                <input type="radio" name="immediate" value="0"/>
                                <label>{{ trans('tasks.Non-urgent') }}</label>
                            </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">
                                                <label class="line-height-35">{{ trans('app.responsible') }}</label>
                                            </td>
                                            <td>
                                                <div class="row-fluid">
                                                    <div class="col-sm-7 row">
                                                    <span id="users">
                                                        <div class="col-sm-7 row">
                                                <select id="p_task_users"
                                                        name="p_task_users[]"
                                                        class="select2_auto_complete_user col-xs-12"
                                                        data-placeholder="{{trans('tasks.select_some_options')}}"
                                                        multiple>
                                                    <option value=""></option>
                                                </select>
                                                <span style="position: absolute; left: 20px; top: 10px;"
                                                      class=""></span>
                                            </div>
                                                    </span>
                                                    </div>
                                                    <div class="col-sm-5 line-height-35">
                                                        <input type="radio" name="assign_type" id="use_type1" value="1"
                                                               checked/>
                                                        <label for="use_type1">{{ trans('tasks.collective') }}</label>
                                                        <input type="radio" name="assign_type" id="use_type2"
                                                               value="2"/>
                                                        <label for="use_type2">{{ trans('tasks.individual') }}</label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">
                                                <label class="line-height-35">{{ trans('tasks.transcript_to') }}</label>
                                            </td>
                                            <td>
                                                <div class="row-fluid">
                                                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row">
                                                   <span id="transcripts">

                                                    <span id="">
                                                        <div class="col-sm-7 row">
                                                <select id="p_task_transcripts"
                                                        name="p_task_transcripts[]"
                                                        class="select2_auto_complete_user col-xs-12"
                                                        data-placeholder="{{trans('tasks.select_some_options')}}"
                                                        multiple>
                                                    <option value=""></option>
                                                </select>
                                                <span style="position: absolute; left: 20px; top: 10px;"
                                                      class=""></span>
                                            </div>
                                                    </span>

                                                   </span>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 smaller-90 line-height-35">
                                                        <input type="checkbox" name="report_on_cr" id="report-type1"/>
                                                        <label for="">{{ trans('tasks.report_on_task_creation') }}</label>

                                                        <input type="checkbox" name="report_on_co" id="report-type2"/>
                                                        <label for="">{{ trans('tasks.report_on_task_completion') }}</label>
                                                        {{--<input type="checkbox" name="report_to_manager" id="report-type3"/>--}}
                                                        {{--<label for="">اطلاع به مسئولان</label>--}}
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">
                                                <label class="line-height-35">{{ trans('app.keywords') }}</label>
                                            </td>
                                            <td>
                                                <div class="row-fluid">
                                                    <div class="select2_tags col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-25">
                                                        <div class="form-inline">
                                                            <input type="text" class="col-xs-12" id="p_task_keywords"
                                                                   name="p_task_keywords[]" multiple/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <div class="row-fluid">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                                                        <div class="form-inline">
                                                            <input type="checkbox" class="form-control"
                                                                   name="end_on_assigner_accept"
                                                                   id="end_on_assigner_accept"/>
                                                            <label for="date">{{ trans('tasks.modal_task_details_assignor_accept_or_ended') }}</label>

                                                            <input type="checkbox" class="form-control"
                                                                   name="transferable" id="transferable"/>
                                                            <label for="date">{{ trans('tasks.modal_task_details_assignor_to_another') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                            <span class="pull-left">
                                            <a class="btn btn-default" onclick="CancelModify()">{{ trans('app.cancel') }}</a>
                                            <a class="btn btn-info" onclick="save_new_ptask()">{{ trans('app.submit') }}</a>
                                            </span>
                                            </td>
                                        </tr>
                                    </table>



                                </form>
                            </div>

                            <div class="tab-pane" id="tab3">
                                <div class="row-fluid">
                                    <h5>
                                        <div class="hr dotted"></div>
                                    </h5>
                                    <div class="row-fluid">
                                        {{--{!!  $HFM_TaskDrafts['Buttons']['TaskDrafts'] !!}--}}
                                        {{--{!!  $HFM_TaskDrafts['ShowResultArea']['TaskDrafts'] !!}--}}
                                        <div class="col-xs-2">
                                            <a id="" class="btn btn-info pull-left" onclick="SaveNewFiles()">
                                                <i ></i>
                                                <span>{{ trans('tasks.add_attachments') }}</span>
                                            </a>
                                        </div>
                                        <div class="clearfixed"></div>
                                    </div>
                                    <h1>
                                        <div class="hr hr-double dotted"></div>
                                    </h1>
                                </div>
                                <div class="hr"></div>
                                <div class="row-fluid">
                                    <table id="draft_files_grid"
                                           class="table table-striped table-bordered dt-responsive nowrap display"
                                           style="text-align: center" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">{{ trans('app.id') }}</th>
                                            <th class="text-center">{{ trans('app.title') }}</th>
                                            <th class="text-center">{{ trans('app.file_type') }}</th>
                                            <th class="text-center">{{ trans('app.file_size') }}</th>
                                            <th class="text-center">{{ trans('app.operations') }}</th>
                                            {{--<th>دانلود</th>--}}
                                            {{--<th>عملیات</th>--}}
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                <span class="pull-left">
                                            <a class="btn btn-default" onclick="CancelModify()">{{ trans('app.cancel') }}</a>
                                            </span>

                            </div>

                        </div>
                    </div>

                    <!---------------->
                </div>

            </div>
        </div>
    </div>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script>
        $(".select2_auto_complete_keywords").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: true,
            ajax: {
                url: "{{route('auto_complete.keywords',['username'=>$uname])}}",
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
                url: "{{ route('auto_complete.pages',['username'=>$uname]) }}",
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
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

                        if(data.success == true)
                        {
                                if (type == 1) {
                                if($('input[name=save_type]:checked').val() == 0) {
                                    window.location = '{{ route('ugc.desktop.hamahang.process.drafts_list1',['username'=>$uname]) }}';
                                }
                                else if($('input[name=save_type]:checked').val() == 1)
                                {
                                    window.location = '{{ route('ugc.desktop.hamahang.process.list',['username'=>$uname]) }}';
                                }

                            }
                            else {

                                $('#process_form').trigger("reset");
                                $("#process_keywords").select2().reset();

                            }
                        }
                        else
                        {
                            messageModal('error','{{trans('app.operation_is_failed')}}',data.error);
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
                s
            }
        }

    </script>

@stop


@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop