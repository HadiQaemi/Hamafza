@extends('layouts.master')
@section('specific_plugin_style')
    @include('hamahang.Tasks.helper.priority.priority_style')
@stop
@section('content')
    <style> #related_links {
            padding: 1px;
            left: 15px;
            position: absolute;
            top: -15px !important;
            left:27px;
            z-index:11;
        }</style>
    <div style="position: relative;height: 100%;width: 100%;">
        <div class="header_task">
            <div class="space-4"></div>
            <div class="row" style="position: relative;">
                @include('hamahang.Tasks.MyTask.helper.task_related_pages')
                @include('hamahang.Tasks.helper.priority.priority_filter')
            </div>
        </div>
    </div>
    @include('hamahang.Tasks.helper.priority.content')

    @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask',['function'=>'filter_tasks_priority'])
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.helper.priority.priority_js')
@stop


@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop