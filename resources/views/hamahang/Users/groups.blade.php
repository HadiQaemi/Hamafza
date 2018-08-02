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
@include('hamahang.Users.helper.groups_inline_js')
@stop

@section('content')
<div style="position: absolute;top:10px; width: 250px;left:0px;">
  
</div>
<form id="form_filter_priority" style="position: relative;top: 50px;right: 200px;z-index: 50;">
    <div class="form-inline" style="padding-right: 5px;" >
        <div class="checkbox">
            <div class="form-inline">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="form-check-input" name="types[]" value="0" id="isgroup" checked>
                        <span>{{trans('گروه ها')}}</span>
                    </label>
                    <label>
                        <input type="checkbox" class="form-check-input" name="types[]" value="1" id="isChannel" checked>
                        <span>{{trans('کانال ها')}}</span>
                    </label>
                </div>
            </div>
        </div>
        {{--</div>--}}
    </div>
</form>
<div class="container-fluid">
    <div class="row">
        <fieldset>
            <div class="col-md-12">
                <table id="MyTasksTable" class="{{--table-bordered--}} table dt-responsive nowrap display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align: right;">نام گروه</th>
                            <th style="text-align: right;">تاریخ ایجاد</th>
                            <th style="text-align: right;">تعداد اعضا</th>
                            <th style="text-align: right;">تعداد پست ها</th>
                            <th style="text-align: right;">حذف</th> 
                        </tr>
                    </thead>
                </table>
            </div>
        </fieldset>
    </div>
</div>
@stop
@include('sections.tabs')

@section('position_right_col_3')
@include('sections.desktop_menu')
@stop

