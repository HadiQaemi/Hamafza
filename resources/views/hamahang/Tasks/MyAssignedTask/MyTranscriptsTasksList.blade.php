@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
@stop

@section('content')
    <div style="position: absolute;top:10px; width: 250px;left:0px;">
        {{--@include('hamahang.Tasks.MyAssignedTask.helper.task_related_pages')--}}
    </div>
    <div class="row">
        <div class="pull-right search-task-keywords">
            <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                    data-placeholder="{{trans('tasks.search_keyword_task')}}"
                    multiple="multiple"></select>
        </div>
        <form id="form_filter_priority" class="my-task-list-priority">
            <div class="pull-right priority-part">
                <label>
                    <input type="checkbox" class="form-check-input" name="official_type[]" value="0" id="official" checked>
                    <span>{{trans('tasks.official')}}</span>
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" name="official_type[]" value="1" id="unofficial" checked>
                    <span>{{trans('tasks.unofficial')}}</span>
                </label>
            </div>
            <div class="pull-right priority-part">
                <label>
                    {{--<input type="checkbox" class="form-check-input" value="0" name="task_important[]" id="not_started_tasks" checked>--}}
                    <input type="checkbox" class="form-check-input" value="1" name="task_important[]" checked>
                    <span>{{trans('tasks.important')}}</span>
                </label>
                <label>
                    {{--<input type="checkbox" class="form-check-input" value="1" name="task_important[]" id="not_started_tasks" checked>--}}
                    <input type="checkbox" class="form-check-input" value="0" name="task_important[]" checked>
                    <span>{{trans('tasks.non-important')}}</span>
                </label>
            </div>
            <div class="pull-right priority-part">
                <label>
                    {{--<input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" id="not_started_tasks" checked>--}}
                    <input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" checked>
                    <span>{{trans('tasks.immediate')}}</span>
                </label>
                <label>
                    {{--<input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" id="not_started_tasks" checked>--}}
                    <input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" checked>
                    <span>{{trans('tasks.non-immediate')}}</span>
                </label>
            </div>
            @if(isset($filter_subject_id))
                <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
            @endif
            {{--<div class="checkbox" style="margin-right: 35px;">--}}
            {{--<label>--}}
            {{--<input type="checkbox" class="form-check-input" value="0" name="task_status[]" id="not_started_tasks" checked>--}}
            {{--<span>{{trans('tasks.status_not_started')}}</span>--}}
            {{--</label>--}}
            {{--<label>--}}
            {{--<input type="checkbox" class="form-check-input" value="1" name="task_status[]" id="started_tasks" checked>--}}
            {{--<span>{{trans('tasks.status_started')}}</span>--}}
            {{--</label>--}}
            {{--<label>--}}
            {{--<input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="done_tasks" checked>--}}
            {{--<span>{{trans('tasks.status_done')}}</span>--}}
            {{--</label>--}}
            {{--<label>--}}
            {{--<input type="checkbox" class="form-check-input" value="3" name="task_status[]" id="completed_tasks" checked>--}}
            {{--<span>{{trans('tasks.status_finished')}}</span>--}}
            {{--</label>--}}
            {{--   <label>--}}
            {{--<input type="checkbox" class="form-check-input" value="4" name="task_status[]" id="stoped_tasks">--}}
            {{--<span>{{trans('tasks.status_suspended')}}</span>--}}
            {{--</label>--}}
            {{--</div>--}}
            {{--</div>--}}
        </form>
    </div>
    <div class="container-fluid noLeftPadding noRightPadding task-list-height">
        {{--<a class="task_info" data-t_id="42">تست</a>--}}
        <fieldset>
            <div class="row">
                <table id="MyAssignedTasksTable" class="table dt-responsive nowrap display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="text-align: right;">عنوان</th>
                        <th style="text-align: right;">مسئول انجام</th>
                        <th style="text-align: right;">اولویت</th>
                        <th style="text-align: right;">مهلت</th>
                        <th style="text-align: right;">وضعیت</th>
                        {{--<th style="text-align: right;">عملیات</th>--}}
                        {{--<th style="text-align: right;">کتابخانه</th>--}}
                    </tr>
                    </thead>
                </table>
            </div>
        </fieldset>
    </div>
    @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask')
    <div class="modal fade" id="task_details" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title" style="color: #bbb"> نمایش اطلاعات وظیفه : <span style="color: #222" id="taskTitle"></span></h5>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="select_task" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">پنجره انتخاب وظایف</h4>
                </div>
                <div class="modal-body">
                    <div id="tabs" class="container" style="width: 95%">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab1" data-toggle="tab" class="active">انتخاب وظایف</a>
                            </li>
                            <li>
                                <a href="#tab2" data-toggle="tab">ایجاد وظیفه جدید</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" style="padding-top: 8px" id="tab1">
                                <div class="col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                        <span>   انتخاب وظایف</span>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row row-fluid">
                                                <div class="col-xs-3" style="border-left: 1px solid gainsboro ">
                                                    <div>
                                                        <p>انتخاب شده ها : </p><span id="selected_tasks_count">0</span>
                                                    </div>
                                                    <hr/>
                                                    <div>
                                                        <a onclick="refresh_data(1)" class="">همه</a><br/>
                                                        <a onclick="refresh_data(2)" class="">وظایف {{trans('tasks.status_started')}}</a><br/>
                                                        <a onclick="refresh_data(3)" class="">وظایف {{trans('tasks.status_not_started')}}</a><br/>
                                                        <a onclick="refresh_data(11)" class="">مهم و فوری</a><br/>
                                                        <a onclick="refresh_data(22)" class="">مهم و غیرفوری</a><br/>
                                                        <a onclick="refresh_data(33)" class="">فوری و غیرمهم</a><br/>
                                                        <a onclick="refresh_data(44)" class="">غیرفوری و غیرمهم</a><br/>
                                                    </div>
                                                    <hr/>
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <h6>کلمات کلیدی : </h6>
                                                            <select onchange="" id="keywords" name="keywords[]" class="col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-9">
                                                    <div class="row-fluid">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table id="MyTasksGrid" class="table table-condensed table-hover table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                            <th data-column-id="id" data-type="numeric" data-identifier="true">شماره وظیفه</th>
                                                                            <th data-column-id="title">نام وظیفه</th>
                                                                            <th data-column-id="ass_id">پسوند</th>
                                                                            <th data-column-id="link" data-formatter="link" data-sortable="false">عملیات</th>
                                                                        </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="pull-left"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane " style="padding-top: 8px" id="tab2">
                                <div class="row">
                                    <div class="row">
                                        <form action="user_tasks" method="POST" id="add_task_form">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <table class="table table-default">
                                                <tr>
                                                    <td>عنوان وظیفه</td>
                                                    <td>
                                                        <input type="text" class="form-control " placeholder="عنوان وظیفه" name='task_title' id="new_task_title"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>مسئول انجام</td>
                                                    <td>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class=""></i>
                                                            </span>
                                                            <select id="states-multi-select-users" name="users[]" class="col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>مهلت انجام</td>
                                                    <td>
                                                        <div class="col-xs-12">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                                <input type="text" class="DatePicker form-control" style="width: 25px" dir="rtl" id="DatePicker" name='respite_date'/>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>اهمیت فوریت</td>
                                                    <td>
                                                        <div class="form-inline" id="t_radio" style="">
                                                            <span style="background-color: #eeeeee;">
                                                                <input type="radio" class="form-control" name="importance" id="importance" value="1"/>
                                                                <label for="">مهم</label>
                                                                <input type="radio" class="form-control" name="importance" id="importance" value="0"/>
                                                                <label for="">غیرمهم</label>
                                                            </span>
                                                            <span style="">|</span>
                                                            <span style="background-color: #eeeeee">
                                                                <input type="radio" class="form-control" name="immediate" id="immediate" value="1"/>
                                                                <label for="">فوری</label>
                                                                <input type="radio" class="form-control" name="immediate" id="immediate" value="0"/>
                                                                <label for="">غیرفوری</label>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <div class="pull-left" style="text-align: left;">
                                                            <a class="btn btn-default" id="btn_add_task" onclick="SaveNewTask()">تائید</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                                <div class="clearfixed"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('filemanager.cancel')}}</button>
                    <a class="btn btn-default" onclick="add_task_childs()">ثبت وظایف انتخاب شده</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="remove_confirm_modal" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:red;">هشدار</h4>
                </div>
                <div class="modal-body">
                    <span id="modal_massage">آیا از حذف این بسته کاری اطمینان دارید ؟</span>
                </div>
                <div class="modal-footer">
                    <span id="confirm_results"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm_modal" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:red;" id="confirm_modal_title">هشدار</h4>
                </div>
                <div class="modal-body">
                    <span id="confirm_modal_massage">آیا اطمینان دارید ؟</span>
                </div>
                <div class="modal-footer">
                    <span id="confirm_results">
                        <a class="btn btn-default" onclick="close_modal()">انصراف</a>
                        <a class="btn btn-info" id="confirm_ok" onclick="">تایید</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change_statuts_err" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" color="red">تغییر وضعیت انجام نشد</h4>
                    <h6>موارد زیر مانع از تغییر وضعیت شد : </h6>
                </div>
                <div class="modal-body">
                    <div>
                        <ul id="errors"></ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">تایید</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.MyAssignedTask.helper.MyTranscriptsTasksList_inline_js')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop