@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" id="manage_tab_pane">
                <li class="active"><a href="#relations_list" data-toggle="tab">{{trans('relations.relations')}}</a></li>
                <li><a href="#add_new_relation" data-toggle="tab">{{trans('relations.create_new_relation')}}</a></li>
            </ul>
            <div class="tab-content">
                <div class="col-xs-12 tab-pane fade in active default-options" id="relations_list">
                    <div class="clearfixed"></div>
                    <table id="RelationsGrid" width="100%" class="table table-condensed table-bordered table-striped table-hover td-center-align">
                        <thead>
                        <tr>
                            <th>{{trans('relations.row_id')}}</th>
                            <th>{{trans('relations.name')}}</th>
                            <th>{{trans('relations.direct_name')}}</th>
                            <th>{{trans('relations.inverse_name')}}</th>
                            <th>{{trans('relations.navigation')}}</th>
                            <th>{{trans('relations.action')}}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="space-20"></div>
                </div>
                <div class="col-xs-12 tab-pane fade in default-options" id="add_new_relation">
                    <div class="clearfixed"></div>
                    <form id="create_new_relation" method="Post">
                        <table class="table">
                            <tr>
                                <td class="table-active">نام</td>
                                <td>
                                    <input type="text" class="form-control col-xs-8" name="name">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;border:none;" class="table-active">نام حالت مستقیم</td>
                                <td style="text-align: right;border:none;">
                                    <input type="text" class="form-control col-xs-8" name="directname">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;border:none;">نام حالت معکوس</td>
                                <td style="text-align: right;border:none;">
                                    <input type="text" class="form-control" name="Inversename">
                                </td>
                            </tr>
                            <tr>
                                <td>عنوان دریچه ناوبری</td>
                                <td>
                                    <input type="text" class="form-control" name="dariche">
                                </td>
                            </tr>
                            <tr>
                                <td>عنوان دریچه ناوبری حالت معکوس</td>
                                <td>
                                    <input type="text" class="form-control" name="dariche_inver">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;border:none;" class="table-active">حالت نمایش</td>
                                <td style="text-align: right;border:none;">
                                    <select class="form-control col-xs-4" name="direction">
                                        <option value="0" selected="true">مستقیم</option>
                                        <option value="1">معکوس</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-default FloatLeft" id="btn_cancel_new_relation">لغو</button>
                                    <button type="button" class="btn btn-primary FloatLeft" id="btn_new_relation">تایید</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div class="space-20"></div>
                </div>
                <div class="col-xs-12 tab-pane fade in default-options" id="edit_relation">
                    <div class="clearfixed"></div>
                    <form id="edit_form_relation" method="Post">
                        <input id="edit_form_relation_id" name="relation_id" value="" hidden>
                        <table class="table">
                            <tr>
                                <td class="table-active">نام</td>
                                <td>
                                    <input type="text" id="edit_form_name" class="form-control col-xs-8" name="name">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;border:none;" class="table-active">نام حالت مستقیم</td>
                                <td style="text-align: right;border:none;">
                                    <input type="text" id="edit_form_directname" class="form-control col-xs-8" name="directname">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;border:none;">نام حالت معکوس</td>
                                <td style="text-align: right;border:none;">
                                    <input type="text" id="edit_form_Inversename" class="form-control" name="Inversename">
                                </td>
                            </tr>
                            <tr>
                                <td>عنوان دریچه ناوبری</td>
                                <td>
                                    <input type="text" id="edit_form_dariche" class="form-control" name="dariche">
                                </td>
                            </tr>
                            <tr>
                                <td>عنوان دریچه ناوبری حالت معکوس</td>
                                <td>
                                    <input type="text" id="edit_form_dariche_inver" class="form-control" name="dariche_inver">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;border:none;" class="table-active">حالت نمایش</td>
                                <td style="text-align: right;border:none;">
                                    <select class="form-control col-xs-4" name="direction">
                                        <option value="0" id="edit_form_direct" selected="true">مستقیم</option>
                                        <option value="1" id="edit_form_indirect">معکوس</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-default FloatLeft" id="btn_cancel_edit_relation">لغو</button>
                                    <button type="button" class="btn btn-primary FloatLeft" id="btn_edit_relation">تایید</button>
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
    {{--    <script type="text/javascript" src="{{URL::asset('assets/Packages/DataTables/datatables.js')}}"></script>--}}
@stop
@section('inline_scripts')
    @include('hamahang.Relations.helper.relations_inline_js')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop