@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/dragable.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
@stop

@section('inline_style')
    <style type="text/css">
        hr {
            margin-top: 5px;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .header_task {
            position: absolute;
            top: -9px;
            z-index: 10;
            width: 100%;
            background-color: #ffffff;
        }

        .footer_task {
            position: absolute;
            background-color: #ffffff;
            z-index: 10;
            bottom: 0px;
            padding-bottom: 10px;
            width: 100%;
        }

        .content_task {
            position: relative;
            width: 100%;
            top: 35px;
            height: 430px;
        }

        .scrlbig {
            overflow-y: hidden !important;
        }

        #master_inner_rtl_div
        {
            height: 100%;
        }
    </style>
@stop

@section('content')
    <div style="position: relative;height: 100%;width: 100%;">
        <div class="header_task">
            <div class="space-4"></div>
            <div class="row" style="position: relative;">
                @include('hamahang.Tasks.MyTask.helper.task_related_pages')
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
    <script type="text/javascript" src="{{URL::asset('assets/Packages/jquery-ui/jquery-ui.js')}}" ></script>
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.MyTask.helper.MyTasksState_inline_js')
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
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop



