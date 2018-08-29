@extends('layouts.master')
@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <div class="row">
                <div class="space-10"></div>
                <div id="alert_subject"></div>
                <table id="fileCreated_ME_RecieveGrid" class="table dt-responsive nowrap display text-center" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>عنوان</th>
                            <th>نوع</th>
                            <th>بازدید</th>
                            <th>پسند</th>
                            <th>دنبال</th>
                            <th>ثبت</th>
                            <th>ویرایش</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="clearfixed"></div>
@stop

@section('inline_scripts')
    @include('hamahang.Files.like_ME.helper.like_ME_inline_js')
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
