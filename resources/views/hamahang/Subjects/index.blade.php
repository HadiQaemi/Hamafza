@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop

@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <div id="sucsessMsg"></div>
            <div class="loader" style="display: none"></div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#subjectsManagment" class="view_btn" data-toggle="tab">موضوعات</a></li>
                <li><a href="#addSubject" class="add_btn" data-toggle="tab">موضوع جدید</a></li>
                <li><a href="#editSubject" class="edit_btn" data-toggle="tab">ویرایش موضوع</a></li>
            </ul>
            <div class="tab-content">
                <div class="col-xs-12 tab-pane fade in active default-options" id="subjectsManagment">

                    <div class="row">
                        <div class="space-10"></div>
                        <div id="alert_subject"></div>
                        <table id="subjectsGrid" class="table table-striped table-bordered dt-responsive nowrap display" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>عنوان</th>
                                <th>توضیح</th>
                                <th>تعداد</th>
                                <th>تاریخ ثبت</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
                <div class="col-xs-12 tab-pane fade in  default-options" id="addSubject">
                    <div class="body_add" style="padding-top: 20px"></div>
                </div>
                <div class="col-xs-12 tab-pane fade in  default-options" id="editSubject">
                    <div class="body_edit" style="padding-top: 20px"></div>
                </div>


            </div>
        </div>
    </div>
    <div class="clearfixed"></div>
    </div>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::asset('assets/Packages/DataTables/datatables.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
@stop

@section('inline_scripts')
    @include('hamahang.Subjects.helper.index_inline_js')
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
