@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
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
    </style>
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.MyTask.helper.AllList_inline_js')
@stop

@section('content')
    {{--<div style="position: absolute;top:10px; width: 250px;left:0px;">--}}
    {{--@include('hamahang.Tasks.MyTask.helper.task_related_pages')--}}
    {{--</div>--}}
    <form id="form_filter_priority" style="position: relative;top: 50px;right: 200px;z-index: 50;">
        <div class="form-inline" style="padding-right: 5px;" >
            <div class="checkbox">
                <div class="form-inline">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="form-check-input" name="official_type[]" value="0" id="official" checked>
                            <span>{{trans('tasks.official')}}</span>
                        </label>
                        <label>
                            <input type="checkbox" class="form-check-input" name="official_type[]" value="1" id="unofficial" checked>
                            <span>{{trans('tasks.unofficial')}}</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="checkbox" style="margin-right: 30px;">
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
            <div class="checkbox" style="margin-right: 30px;">
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
            <div class="checkbox hidden" style="margin-right: 35px;">
                <label>
                    <input type="checkbox" class="form-check-input" value="0" name="task_status[]" id="not_started_tasks" checked>
                    <span>{{trans('tasks.status_not_started')}}</span>
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" value="1" name="task_status[]" id="started_tasks" checked>
                    <span>{{trans('tasks.status_started')}}</span>
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="done_tasks" checked>
                    <span>{{trans('tasks.status_done')}}</span>
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" value="3" name="task_status[]" id="completed_tasks" checked>
                    <span>{{trans('tasks.status_finished')}}</span>
                </label>
                   <label>
                      <input type="checkbox" class="form-check-input" value="4" name="task_status[]" id="stoped_tasks">
                      <span>{{trans('tasks.status_suspended')}}</span>
                  </label>
              </div>
            {{--</div>--}}
        </div>
    </form>
    <div class="container-fluid noLeftPadding noRightPadding task-list-height">
        <div class="row">
            <fieldset>
                <div class="col-md-12">
                    <table id="MyTasksTable" class="{{--table-bordered--}} table dt-responsive nowrap display" style="width:100%">
                        <thead>
                        <tr>
                            <th style="text-align: right;">عنوان</th>
                            <th style="text-align: right;">مسئول</th>
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

