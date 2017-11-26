@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" id="manage_tab_pane">
                <li class="active"><a href="#alerts_list" data-toggle="tab">{{trans('alerts.alerts')}}</a></li>
                <li><a href="#add_new_alert" data-toggle="tab">{{trans('alerts.create_new_alert')}}</a></li>
            </ul>
            <div class="tab-content">
                <div class="col-xs-12 tab-pane fade in active default-options" id="alerts_list">
                    <div class="clearfixed"></div>
                    <table id="AlertsGrid" width="100%" class="table table-condensed table-bordered table-striped table-hover td-center-align">
                        <thead>
                        <tr>
                            <th>{{trans('alerts.row_id')}}</th>
                            <th>{{trans('alerts.name')}}</th>
                            <th>{{trans('alerts.comment')}}</th>
                            <th>{{trans('alerts.action')}}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="space-20"></div>
                </div>
                <div class="col-xs-12 tab-pane fade in default-options" id="add_new_alert">
                    <div class="clearfixed"></div>
                    <form id="create_new_alert" method="Post">
                        <table class="table">
                            <tr>
                                <td>عنوان</td>
                                <td>
                                    <input type="text" size="100" dir="rtl" id="alert_title" class="form-control required " name="name">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea class="mceEditor" name="comment"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-primary FloatLeft" type="button" id="btn_cancel_add_new_alert">لغو</button>
                                    <button class="btn btn-primary FloatLeft" type="button" id="btn_add_new_alert">تایید</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div class="space-20"></div>
                </div>
                <div class="col-xs-12 tab-pane fade in default-options" id="edit_alert">
                    <div class="clearfixed"></div>
                    <form id="edit_form_alert" method="Post">
                        <input id="edit_form_alert_id" name="alert_id" value="" hidden>
                        <table class="table">
                            <div id="alert_edit_form"></div>
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-primary FloatLeft" type="button" id="btn_cancel_edit_alert">لغو</button>
                                    <button class="btn btn-primary FloatLeft" type="button" id="btn_edit_alert">تایید</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div class="space-20"></div>
                </div>
            </div>
        </div>
        <div class="clearfixed"></div>
    </div>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/tinymce/js/tinymce/tinymce.min.js"></script>
    {{--    <script type="text/javascript" src="{{URL::asset('assets/Packages/DataTables/datatables.js')}}"></script>--}}
@stop
@section('inline_scripts')
    @include('hamahang.Alerts.helper.alerts_inline_js')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop