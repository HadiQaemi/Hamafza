@extends('layouts.master')
@section('specific_plugin_style')
    @include('hamahang.Tasks.helper.priority.priority_style')
@stop
@section('content')
    {{--<style> #related_links {--}}
            {{--padding: 1px;--}}
            {{--left: 15px;--}}
            {{--position: absolute;--}}
            {{--top: -15px !important;--}}
            {{--left:27px;--}}
            {{--z-index:11;--}}
        {{--}--}}
    {{--</style>--}}
    <style>
        .hd-body{
            overflow: hidden !important;
        }
        #priority_content_area {
            margin-top: 10px;
        }
        #priority_content_area{
            margin-top: 10px !important;
        }
        #priority_content_area{
            height: 80vh;
        }
        #priority_content_area .row{
            height: 45%;
        }
        #priority_content_area .task_items{
            height: 85%;
        }
        #base_items_div{
            padding-bottom: 50px;
        }
        .task_items {
            width: 100%;
            height: 40%;
            overflow-y: scroll;
            overflow-x: hidden;
            border: 1px solid #ececec;
            direction: ltr;
        }
    </style>
    <div style="position: relative;width: 100%;">
        <div class="header_task">
            <div class="space-4"></div>
            <div class="row" style="position: relative;">
                @if(isset($filter_subject_id))
                    <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
                @endif
                <input type="hidden" value="MyAssignedTasks" name="act_form" id="act_form"/>
                @include('hamahang.Tasks.projects.project_related_pages')
                {{--@include('hamahang.Tasks.projects.my_assigned_priority_filter')--}}
            </div>
        </div>
    </div>
    <div id="base_items_div" style="margin-top: 50px;">
        @include('hamahang.Tasks.projects.priority_content')
    </div>
{{--    @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask',['function'=>'filter_tasks_priority'])--}}
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.projects.helper.priority_js')
@stop


@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop