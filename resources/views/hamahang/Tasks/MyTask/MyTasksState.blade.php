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
        .scrlbig {
            overflow-y: hidden !important;
        }

        #master_inner_rtl_div
        {
            height: 100%;
        }
         .hd-body{
             overflow: hidden !important;
         }
        #priority_content_area {
            margin-top: 10px;
        }
        #priority_content_area{
            margin-top: 10px !important;
        }
    </style>
@stop

@section('content')
    <div style="position: relative;">
        <div class="">
            <div class="space-4"></div>
            <div class="row" style="position: relative;">
                @if(isset($filter_subject_id))
                    <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
                @endif
                @include('hamahang.Tasks.MyTask.helper.task_related_pages')
                @include('hamahang.Tasks.MyTask.helper.MyTasksState.task_filter')
            </div>
        </div>

        <div class="base_items" id="base_items_div">
            <div id="base_items" style="direction: rtl;">
                {!! $MyTasksInState !!}
            </div>
        </div>
        {{--<div class="footer_task">--}}
            @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask')
        {{--</div>--}}
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



