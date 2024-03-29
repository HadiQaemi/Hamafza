@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop
@section('inline_style')
    <style>
        td.details-control:before {
            content: '+';
            cursor: pointer;
        }
        tr.shown td.details-control:before {
            content: '-';
        }
        .dataTable td{
            text-align: right !important;
        }
    </style>
@stop
<style>
    .hd-body{
        overflow: hidden !important;
    }
</style>
@section('inline_scripts')
    @include('hamahang.Tasks.MyTask.helper.AllList_inline_js')
@stop

@section('content')
    <div style="position: absolute;top:10px; width: 250px;left:0px;">
        @include('hamahang.Tasks.MyTask.helper.task_related_pages_to_all_tasks')
    </div>
    <div class="row opacity-7" style="margin-top: -10px;background: #eee">
        <form id="form_filter_priority">
            <div class="row padding-bottom-20 opacity-7">
                <i class="fa fa-calendar-minus-o int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <input type="text" value="{{(Session::get('AllTaskTitle')) ? Session::get('AllTaskTitle') : ''}}" class="form-control int-btm-brd" style="padding: 6px 20px;" id="title" name="title" placeholder="{{trans('tasks.search_title')}}" autocomplete="off">
                </div>
                <i class="fa fa-tags int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                            data-placeholder="{{trans('tasks.search_keyword_task')}}" multiple="multiple">
                        @if(Session::exists('AllTaskTaskKeywords'))
                            @foreach(Session::get('AllTaskTaskKeywords')  as $key => $value)
                                @foreach($value  as $index => $option)
                                    <option value="{{$index}}" selected>{{$option}}</option>
                                @endforeach
                            @endforeach
                        @endif
                    </select>
                </div>
                <i class="fa fa-users int-icon1"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_users_all_tasks" name="users[]" class="select2_auto_complete_user col-xs-12"
                            data-placeholder="{{trans('tasks.search_some_persons')}}" multiple>
                        @if(Session::exists('AllTaskTaskUsers'))
                            @foreach(Session::get('AllTaskTaskUsers')  as $key => $value)
                                @foreach($value  as $index => $option)
                                    <option value="{{$index}}" selected>{{$option}}</option>
                                @endforeach
                            @endforeach
                        @endif
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
                    <div class="checkboxVertical done pull-right margin-right-10 background-gray" data-toggle="tooltip" title="{{trans('tasks.status_done')}}">
                        <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="done_tasks"/>
                        <label for="done_tasks" class="done background-gray"></label>
                    </div>
                    <div class="checkboxVertical completed pull-right margin-right-10 background-gray" data-toggle="tooltip" title="{{trans('tasks.status_finished')}}">
                        <input type="checkbox" class="form-check-input" value="3" name="task_status[]" id="completed_tasks"/>
                        <label for="completed_tasks" class="completed background-gray"></label>
                    </div>
                    <div class="checkboxVertical pull-right margin-right-10 background-gray" data-toggle="tooltip" title="{{trans('tasks.status_suspended')}}">
                        <input type="checkbox" class="form-check-input" value="4" name="task_status[]" id="stoped_tasks"/>
                        <label for="stoped_tasks" class="background-gray"></label>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container-fluid noLeftPadding noRightPadding task-list-height" id="base_items_div">
        <div class="row">
            <fieldset>
                <div class="col-md-12">
                    <table id="MyTasksTable" class="{{--table-bordered--}} table dt-responsive nowrap display" style="width:100%">
                        <thead>
                        <tr>
                            <th style="text-align: right;">عنوان</th>
                            <th style="text-align: right;">واگذارنده</th>
                            <th style="text-align: right;">مسئول</th>
                            <th style="text-align: right;">زمان ارجاع</th>
                            <th style="text-align: right;">اولویت</th>
                            <th style="text-align: right;">مهلت</th>
                            <th style="text-align: right;">وضعیت</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>
    @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask')
    <div class="modal fade" id="new_package" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">تعریف بسته کاری جدید</h4>
                </div>
                <div class="modal-body">
                    <label for="name">عنوان :</label>
                    <input type="text" name="packagetitle" id="packagetitle" class="text ui-widget-content ui-corner-all">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('filemanager.cancel')}}</button>
                    <button id="ANP" name="ANP" value="save" class="btn btn-info" type="button" onclick="AddNewPackage()">
                        <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                        <span>ثبت</span>
                    </button>
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
                    <span id="confirm_modal_massage">آیا از حذف این بسته کاری اطمینان دارید ؟</span>
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
                    <h4 class="modal-title" color="red">خطای تغییر وضعیت</h4>
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
@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop

