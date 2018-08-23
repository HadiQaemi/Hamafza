@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
@stop

@section('content')
    <form id="form_filter_type" style="position: relative;top: 50px;right: 200px;z-index: 50;">
        <div class="form-inline" style="padding-right: 5px;" >
            <div class="checkbox">
                <div class="form-inline">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="form-check-input" name="types[]" value="private" id="private" checked>
                            <span>{{trans('tasks.private')}}</span>
                        </label>
                        <label>
                            <input type="checkbox" class="form-check-input" name="types[]" value="public" id="public" checked>
                            <span>{{trans('tasks.public')}}</span>
                        </label>
                    </div>
                </div>
            </div>
            {{--</div>--}}
        </div>
    </form>
    <div class="container-fluid">
        <fieldset>
            <div class="row">
                {{--<table id="GeneralLiberaryTable" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">--}}
                <table id="GeneralLiberaryTable" class="table dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
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
    @include('hamahang.TaskLiberary.helper.GeneralLiberary_inline_js')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
