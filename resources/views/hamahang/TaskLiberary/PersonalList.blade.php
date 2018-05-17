@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
@stop

@section('content')

    <div class="container-fluid">
        <fieldset>
            <div class="row">
                <table id="PrivateLiberaryTable" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center">عنوان</th>
                        <th class="text-center">ایجاد کننده</th>
                        <th class="text-center">تاریخ ایجاد</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </fieldset>
    </div>
@stop

@section('inline_scripts')
    @include('hamahang.TaskLiberary.helper.PersonalList_inline_js')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
