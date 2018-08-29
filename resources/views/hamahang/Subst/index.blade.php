@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" id="manage_tab_pane">
                <li class="active"><a href="#substs_list" data-toggle="tab">{{trans('subst.substs')}}</a></li>
                <li><a href="#add_new_subst" data-toggle="tab">{{trans('subst.create_new_subst')}}</a></li>
            </ul>
            <div class="tab-content">
                <div class="col-xs-12 tab-pane fade in active default-options" id="substs_list">
                    <div class="clearfixed"></div>
                    <table id="SubstsGrid" width="100%" class="table dt-responsive nowrap display text-center">
                        <thead>
                        <tr>
                            <th>{{trans('subst.row_id')}}</th>
                            <th>{{trans('subst.first')}}</th>
                            <th>{{trans('subst.second')}}</th>
                            <th>{{trans('subst.action')}}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="space-20"></div>
                </div>
                <div class="col-xs-12 tab-pane fade in default-options" id="add_new_subst">
                    <div class="clearfixed"></div>
                    <div class="space-10"></div>
                    <form id="create_new_subst" method="Post">
                        <div class="row">
                            <div class="col-xs-6">
                                {{trans('subst.first')}}
                                <input type="text" name="first" class="form-control">
                            </div>
                            <div class="col-xs-6">
                                {{trans('subst.second')}}
                                <input type="text" name="second" class="form-control">
                            </div>
                        </div>
                        <div class="space-10"></div>
                        <div class="row">
                            <div class="col-xs-4 pull-left left">
                                <button class="btn btn-primary FloatLeft" type="button" id="btn_cancel_new_subst">لغو</button>
                                <button class="btn btn-primary FloatLeft" type="button" id="btn_add_new_subst">تایید</button>
                            </div>
                        </div>
                    </form>
                    <div class="space-20"></div>
                </div>
                <div class="col-xs-12 tab-pane fade in default-options" id="edit_subst">
                    <div class="clearfixed"></div>
                    <form id="edit_form_subst" method="Post">
                        <div class="space-10"></div>
                        <input id="edit_form_subst_id" name="item_id" value="" hidden>
                        <div id="subst_edit_form"></div>
                        <div class="space-10"></div>
                        <div class="row">
                            <div class="col-xs-4 pull-left left">
                                <button class="btn btn-primary FloatLeft" type="button" id="btn_cancel_edit_subst">لغو</button>
                                <button class="btn btn-primary FloatLeft" type="button" id="btn_edit_subst">تایید</button>
                            </div>
                        </div>
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
    @include('hamahang.Subst.helper.subst_inline_js')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop