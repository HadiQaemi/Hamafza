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
            height: 280px;
            overflow-y: scroll;
            overflow-x: hidden;
            border: 1px solid #ececec;
            direction: ltr;
        }
        .messageBox{
            margin: 0px !important;
        }
        #related_links {
            top: 0px !important;
        }
        .radio, .checkbox{
            margin-top: 0px !important;
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
    <div class="row opacity-7" style="background: #eee">
        <form id="form_filter_priority">
            <div class="row padding-bottom-20">
                <i class="fa fa-calendar-minus-o int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <input type="text" class="form-control int-btm-brd" style="padding: 6px 20px;" id="title" name="title" placeholder="{{trans('tasks.search_title')}}" autocomplete="off">
                </div>
                <i class="fa fa-tags int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                            data-placeholder="{{trans('tasks.search_keyword_task')}}"
                            multiple="multiple"></select>
                </div>
                <i class="fa fa-users int-icon1"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_users_all_tasks" name="users[]" class="select2_auto_complete_user col-xs-12"
                            data-placeholder="{{trans('tasks.search_some_persons')}}" multiple>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row margin-top-10">
                <div class="pull-right" style="margin-top: 10px;">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input" name="official_type[]" value="0" id="official" checked>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <span>{{trans('tasks.official')}}</span>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input" name="official_type[]" value="1" id="unofficial" checked>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <span>{{trans('tasks.unofficial')}}</span>
                </div>
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                {{--<label class="container-checkmark">--}}
                {{--<input type="checkbox" checked="checked" class="form-check-input" name="task_final[]" id="task_final_1" value="1" checked>--}}
                {{--<span class="checkmark"></span>--}}
                {{--</label>--}}
                {{--</div>--}}
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                {{--<span>{{trans('tasks.final')}}</span>--}}
                {{--</div>--}}
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                {{--<label class="container-checkmark">--}}
                {{--<input type="checkbox" checked="checked" class="form-check-input" name="task_final[]" id="task_final_0" value="0">--}}
                {{--<span class="checkmark"></span>--}}
                {{--</label>--}}
                {{--</div>--}}
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                {{--<span>{{trans('tasks.draft')}}</span>--}}
                {{--</div>--}}
                {{--<div class="pull-right" style="margin-top: 10px;margin-right: 15px">--}}
                    {{--<span>{{trans('tasks.priority')}}</span>--}}
                {{--</div>--}}
                {{--<div class="checkbox pull-right margin-right-15" style="margin-top: -5px">--}}
                    {{--<label class="container-checkmark">--}}
                        {{--<input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="3" name="task_important_immediate[]" checked>--}}
                        {{--<span class="checkmark" style="background: red;" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.immediate')}}"></span>--}}
                    {{--</label>--}}
                    {{--<label class="container-checkmark">--}}
                        {{--<input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="1" name="task_important_immediate[]" checked>--}}
                        {{--<span class="checkmark" style="background: #ce8923" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.non-immediate')}}"></span>--}}
                    {{--</label>--}}
                {{--</div>--}}
                {{--<div class="checkbox pull-right margin-right-10">--}}
                    {{--<label class="container-checkmark">--}}
                        {{--<input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="2" name="task_important_immediate[]" checked>--}}
                        {{--<span class="checkmark" style="background: #caca2b" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.immediate')}}"></span>--}}
                    {{--</label>--}}
                    {{--<label class="container-checkmark">--}}
                        {{--<input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="0" name="task_important_immediate[]" checked>--}}
                        {{--<span class="checkmark" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.non-immediate')}}"></span>--}}
                    {{--</label>--}}
                {{--</div>--}}

                <div class="checkbox pull-right margin-right-20">
                    <div class="pull-right">
                        <span style="margin-top: 10px;display: block;">{{trans('tasks.stage')}}</span>
                    </div>
                    <div class="checkboxVertical draft pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.draft')}}">
                        <input type="checkbox" class="form-check-input" value="10" name="task_status[]" id="draft_tasks" />
                        <label for="draft_tasks" class="draft"></label>
                    </div>
                    <div class="checkboxVertical not_started pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_not_started')}}">
                        <input type="checkbox" class="form-check-input" value="0" name="task_status[]" id="not_started_tasks" checked/>
                        <label for="not_started_tasks" class="not_started"></label>
                    </div>
                    <div class="checkboxVertical started pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_started')}}">
                        <input type="checkbox" class="form-check-input" value="1" name="task_status[]" id="started_tasks" checked/>
                        <label for="started_tasks" class="started"></label>
                    </div>
                    <div class="checkboxVertical done pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_done')}}">
                        <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="done_tasks"/>
                        <label for="done_tasks" class="done"></label>
                    </div>
                    <div class="checkboxVertical completed pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_finished')}}">
                        <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="completed_tasks"/>
                        <label for="completed_tasks" class="completed"></label>
                    </div>
                    <div class="checkboxVertical pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_suspended')}}">
                        <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="stoped_tasks"/>
                        <label for="stoped_tasks"></label>
                    </div>
                </div>
            </div>

            @if(isset($filter_subject_id))
                <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
            @endif
            {{--</div>--}}
        </form>
    </div>
    <fieldset id="fieldset_info" class="hidden">
        <div class="col-xs-12"><i class="fa fa-arrow-left pointer" id="BackToProjects" style="margin-top: 10px;"></i></div>
        <div id="ProjectInfoList"></div>
    </fieldset>
    <fieldset id="fieldset">
        <div id="base_items_div">
            @include('hamahang.Tasks.projects.priority_content')
        </div>
    </fieldset>
{{--    @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask',['function'=>'filter_tasks_priority'])--}}
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.projects.helper.priority_js')
@stop


@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop