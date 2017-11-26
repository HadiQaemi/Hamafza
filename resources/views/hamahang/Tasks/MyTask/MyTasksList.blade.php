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
    @include('hamahang.Tasks.MyTask.helper.MyTasksList_inline_js')
@stop

@section('content')
    <div style="position: absolute;top:10px; width: 250px;left:0px;">
    @include('hamahang.Tasks.MyTask.helper.task_related_pages')
    </div>
    <div class="container-fluid">
        <div class="row">
            <fieldset>
                <div class="col-md-12">
                    <table id="MyTasksTable" class="table table-striped {{--table-bordered--}} dt-responsive nowrap display" style="text-align: center" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">نوع</th>
                            <th class="text-center">عنوان</th>
                            <th class="text-center">واگذارنده</th>
                            <th class="text-center">اولویت</th>
                            <th class="text-center">مهلت</th>
                            <th class="text-center">وضعیت</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>
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

