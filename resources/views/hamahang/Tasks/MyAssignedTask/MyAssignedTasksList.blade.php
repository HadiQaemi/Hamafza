@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop
<style>
    .hd-body{
        overflow: hidden !important;
    }
</style>
@section('content')
    <div style="position: absolute;top:10px; width: 250px;left:0px;">
        @include('hamahang.Tasks.MyAssignedTask.helper.task_related_pages')
    </div>
    <div class="row opacity-7" style="margin-top: -10px;background: #eee">
        <form id="form_filter_priority">
            <div class="row padding-bottom-20">
                <i class="fa fa-calendar-minus-o int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <input type="text" class="form-control int-btm-brd" style="padding: 6px 20px;" id="title" name="title" placeholder="{{trans('tasks.search_title')}}" autocomplete="off">
                </div>
                <i class="fa fa-tags int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                            data-placeholder="{{trans('tasks.search_keyword_task')}}"
                            multiple="multiple"></select>
                </div>
                <i class="fa fa-users int-icon1"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_users_all_tasks" name="users[]" class="select2_auto_complete_user col-xs-12"
                            data-placeholder="{{trans('tasks.search_some_persons')}}" multiple>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row margin-top-10">
                <div class="pull-right" style="margin-top: 10px;">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input" name="official_type[]" value="0" id="official" checked>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <span>{{trans('tasks.official')}}</span>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input" name="official_type[]" value="1" id="unofficial" checked>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <span>{{trans('tasks.unofficial')}}</span>
                </div>
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                    {{--<label class="container-checkmark">--}}
                        {{--<input type="checkbox" checked="checked" class="form-check-input" name="task_final[]" id="task_final_1" value="1" checked>--}}
                        {{--<span class="checkmark"></span>--}}
                    {{--</label>--}}
                {{--</div>--}}
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                    {{--<span>{{trans('tasks.final')}}</span>--}}
                {{--</div>--}}
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                    {{--<label class="container-checkmark">--}}
                        {{--<input type="checkbox" checked="checked" class="form-check-input" name="task_final[]" id="task_final_0" value="0">--}}
                        {{--<span class="checkmark"></span>--}}
                    {{--</label>--}}
                {{--</div>--}}
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                    {{--<span>{{trans('tasks.draft')}}</span>--}}
                {{--</div>--}}
                <div class="pull-right" style="margin-top: 10px;margin-right: 15px">
                    <span>{{trans('tasks.priority')}}</span>
                </div>
                <div class="checkbox pull-right margin-right-15" style="margin-top: -5px">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="3" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: red;" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.immediate')}}"></span>
                    </label>
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="2" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: #ce8923" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.non-immediate')}}"></span>
                    </label>
                </div>
                <div class="checkbox pull-right margin-right-10">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="1" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: #caca2b" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.immediate')}}"></span>
                    </label>
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="0" name="task_important_immediate[]" checked>
                        <span class="checkmark" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.non-immediate')}}"></span>
                    </label>
                </div>

                <div class="checkbox pull-right margin-right-20">
                    <div class="pull-right">
                        <span style="margin-top: 10px;display: block;">{{trans('tasks.stage')}}</span>
                    </div>
                    <div class="checkboxVertical draft pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.draft')}}">
                        <input type="checkbox" class="form-check-input draft_tasks" value="10" name="draft_tasks" id="draft_tasks" />
                        <label for="draft_tasks" class="draft"></label>
                    </div>
                    <div class="checkboxVertical not_started pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_not_started')}}">
                        <input type="checkbox" class="form-check-input" value="0" name="task_status[]" id="not_started_tasks" checked/>
                        <label for="not_started_tasks" class="not_started"></label>
                    </div>
                    <div class="checkboxVertical started pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_started')}}">
                        <input type="checkbox" class="form-check-input" value="1" name="task_status[]" id="started_tasks" checked/>
                        <label for="started_tasks" class="started"></label>
                    </div>
                    <div class="checkboxVertical done pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_done')}}">
                        <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="done_tasks"/>
                        <label for="done_tasks" class="done"></label>
                    </div>
                    <div class="checkboxVertical completed pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_finished')}}">
                        <input type="checkbox" class="form-check-input" value="3" name="task_status[]" id="completed_tasks"/>
                        <label for="completed_tasks" class="completed"></label>
                    </div>
                    <div class="checkboxVertical pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_suspended')}}">
                        <input type="checkbox" class="form-check-input" value="4" name="task_status[]" id="stoped_tasks"/>
                        <label for="stoped_tasks"></label>
                    </div>
                </div>
            </div>

            @if(isset($filter_subject_id))
                <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
            @endif
            {{--</div>--}}
        </form>
    </div>

    <div class="container-fluid noLeftPadding noRightPadding task-list-height" id="base_items_div">
        {{--<a class="task_info" data-t_id="42">تست</a>--}}
        <fieldset>
            <div class="row">
                <table id="MyAssignedTasksTable" class="table dt-responsive nowrap display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="text-align: right;">عنوان</th>
                        <th style="text-align: right;">مسئول انجام</th>
                        <th style="text-align: right;">زمان ایجاد</th>
                        <th style="text-align: right;">اولویت</th>
                        <th style="text-align: right;">مهلت</th>
                        <th style="text-align: right;">وضعیت</th>
                        <th style="text-align: right;" class="table-no-sort"></th>
                        {{--<th style="text-align: right;">کتابخانه</th>--}}
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="col-xs-12 no-task-div {{Auth::user()->MyAssignedTasksCount() > 0 ? 'has-task' : '' }} hidden">
                <div class="message text-center"></div>
                <div class="no-task-div-buttons">
                    <a class="jsPanels btn btn-primary" href="{{url('/modals/CreateNewTask?resid='.auth()->id())}}" title="وظیفه جدید">ایجاد وظیفه جدید</a>
                </div>
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
                                                    <td>مهلت</td>
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
                                                                <input type="radio" class="form-control" name="importance" id="importance_1" value="1"/>
                                                                <label for="importance_1">مهم</label>
                                                                <input type="radio" class="form-control" name="importance" id="importance_0" value="0"/>
                                                                <label for="importance_0">غیرمهم</label>
                                                            </span>
                                                            <span style="">|</span>
                                                            <span style="background-color: #eeeeee">
                                                                <input type="radio" class="form-control" name="immediate" id="immediate_1" value="1"/>
                                                                <label for="">فوری</label>
                                                                <input type="radio" class="form-control" name="immediate" id="immediate_0" value="0"/>
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
    @include('hamahang.Tasks.MyAssignedTask.helper.MyAssignedTasksList_inline_js')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
