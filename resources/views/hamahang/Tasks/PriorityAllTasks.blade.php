@extends('layouts.master')
@section('specific_plugin_style')
    @include('hamahang.Tasks.helper.priority.priority_style')
@stop
@section('content')
    <style>
        .hd-body{
            overflow: hidden !important;
        }

        #priority_content_area{
            margin-top: 75px !important;
        }
        #priority_content_area{
            height: 75vh;
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
    </style>
    <div style="position: relative;">
        <div class="header_task">
            <div class="space-4"></div>
            <div class="row" style="position: relative;">
                @if(isset($filter_subject_id))
                    <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
                @endif
                <input type="hidden" value="MyTasks" name="act_form" id="act_form"/>
                @include('hamahang.Tasks.MyTask.helper.task_related_pages_to_all_tasks')
                @include('hamahang.Tasks.helper.priority.priority_filter')
            </div>
        </div>
    </div>
    @include('hamahang.Tasks.helper.priority.ContentAllTask')

    @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask',['function'=>'filter_tasks_priority'])
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.helper.priority.all_task_priority_js')
@stop


@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop