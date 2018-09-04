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
                @if(isset($filter_subject_id))
                    <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
                @endif
                <input type="hidden" value="MyAssignedTasks" name="act_form" id="act_form"/>
                @include('hamahang.Tasks.MyAssignedTask.helper.task_related_pages')
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