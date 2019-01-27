@extends('layouts.master')
@section('specific_plugin_style')
    @include('hamahang.Tasks.helper.priority.priority_style')
@stop
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
</style>
@section('content')
    <div style="position: relative;width: 100%;">
        <div class="header_task">
            <div class="space-4"></div>
            <div class="row" style="position: relative;">
                @if(isset($filter_subject_id))
                    <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
                @endif
                <input type="hidden" value="MyTasks" name="act_form" id="act_form"/>
                @include('hamahang.Tasks.MyTask.helper.task_related_pages')
                @include('hamahang.Tasks.helper.priority.priority_filter')
            </div>
        </div>
    </div>
    <div id="base_items_div" style="margin-top: 75px;">
       @include('hamahang.Tasks.helper.priority.content')
    </div>

    @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask',['function'=>'filter_tasks_priority'])
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.helper.priority.priority_js')
@stop


@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop