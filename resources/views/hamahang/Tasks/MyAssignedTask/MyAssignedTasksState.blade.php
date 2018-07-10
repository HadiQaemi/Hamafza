@extends('layouts.master')
@section('csrf_token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('specific_plugin_style')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{URL::to('assets/css/dragable.css')}}">
    <link type="text/css" rel="stylesheet"
          href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
    <style type="text/css">

        hr {
            margin-top: 5px;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-right: 10px;
        }
        .header_task{
            position:absolute;
            top:-9px;
            z-index:100;
            width: 100%;
            background-color: #ffffff;
        }
        .footer_task{
            position:absolute;
            background-color: #ffffff;
            z-index:100;
            bottom:22px;
            height: 43px;
            padding-bottom: 10px;
            width:100%;
        }
        .content_task{
            position: relative;
            width: 100%;
            top: 35px;
            padding-top: 20px;
        }
        .state_container {
        }
        .scrlbig{
            overflow-y: hidden !important;
        }
        .panel-light{
            height: 450px;
        }
        .row{
            height: 46px !important;
        }
    </style>
@stop
@section('content')
    <div style="position: relative;height: 430px;width: 100%;">
        <div class="header_task">
            <div class="space-4"></div>
            <div class="row" style="position: relative;">
             @include('hamahang.Tasks.MyAssignedTask.helper.task_related_pages')
             @include('hamahang.Tasks.MyTask.helper.MyTasksState.task_filter')
            </div>
            <hr>
        </div>
        <div class="content_task">
            <div class="base_list_task">
                <div id="base_items" style="direction: rtl;">
                    {!! $MyTasksInState !!}
                </div>
            </div>
        </div>
        <div class="footer_task">
            @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask')
        </div>

    </div>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
    <script src="{{URL::asset('assets/Packages/jquery-ui/jquery-ui.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.MyAssignedTask.helper.MyAssignedTasksState_inline_js')
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop

<script>
    function allowDrop(ev) {
        ev.preventDefault();
    }
    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data));
    }
    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }
</script>
