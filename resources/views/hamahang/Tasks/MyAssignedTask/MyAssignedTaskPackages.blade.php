@extends('layouts.master')

@section('csrf_token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title')
    TODO supply a title
@stop
<style>
    .hd-body{
        overflow: hidden !important;
    }
</style>
@section('content')

    <div style="position: absolute;top:10px; width: 250px;left:0px;">
        @include('hamahang.Tasks.MyAssignedTask.helper.task_related_pages')
    </div>
    <div class="row opacity-7" style="margin-top: -10px;background: #eee">
        <form id="form_filter_priority">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 padding-bottom-20">
                <label class="pointer">
                    <input type="radio" name="package_type" value="persons" checked>
                    <span>{{trans('tasks.persons')}}</span>
                </label>
                <label class="pointer">
                    <input type="radio" name="package_type" value="pages">
                    <span>{{trans('tasks.page')}}</span>
                </label>
                <label class="pointer">
                    <input type="radio" name="package_type" value="keywords">
                    <span>{{trans('tasks.keywords')}}</span>
                </label>
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
                {{--<div class="pull-right" style="margin-top: 10px;">--}}
                    {{--<label class="container-checkmark">--}}
                        {{--<input type="checkbox" checked="checked" class="form-check-input" name="task_final[]" value="1" checked>--}}
                        {{--<span class="checkmark"></span>--}}
                    {{--</label>--}}
                {{--</div>--}}
                {{--<div class="pull-right" style="margin-top: 10px;">--}}
                    {{--<span>{{trans('tasks.final')}}</span>--}}
                {{--</div>--}}
                {{--<div class="pull-right" style="margin-top: 10px;">--}}
                    {{--<label class="container-checkmark">--}}
                        {{--<input type="checkbox" checked="checked" class="form-check-input" name="task_final[]" value="0" checked>--}}
                        {{--<span class="checkmark"></span>--}}
                    {{--</label>--}}
                {{--</div>--}}
                {{--<div class="pull-right" style="margin-top: 10px;">--}}
                    {{--<span>{{trans('tasks.draft')}}</span>--}}
                {{--</div>--}}
                <div class="pull-right" style="margin-top: 10px;margin-right: 15px">
                    <span>{{trans('tasks.priority')}}</span>
                </div>
                <div class="checkbox pull-right margin-right-15" style="margin-top: -5px">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="3" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: red;" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.immediate')}}"></span>
                    </label>
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="2" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: #ce8923" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.non-immediate')}}"></span>
                    </label>
                </div>
                <div class="checkbox pull-right margin-right-10">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="1" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: #caca2b" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.immediate')}}"></span>
                    </label>
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="0" name="task_important_immediate[]" checked>
                        <span class="checkmark" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.non-immediate')}}"></span>
                    </label>
                </div>

                <div class="checkbox pull-right margin-right-20">
                    <div class="pull-right">
                        <span style="margin-top: 10px;display: block;">{{trans('tasks.stage')}}</span>
                    </div>
                    <div class="checkboxVertical draft pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.draft')}}">
                        <input type="checkbox" class="form-check-input" value="10" name="task_status[]" id="draft_tasks" />
                        <label for="draft_tasks" class="draft"></label>
                    </div>
                    <div class="checkboxVertical pull-right margin-right-10">
                        <input type="checkbox" class="form-check-input not_started" value="0" name="task_status[]" id="not_started_tasks" data-toggle="tooltip" title="{{trans('tasks.status_not_started')}}" checked/>
                        <label for="not_started_tasks" class="not_started" data-toggle="tooltip" title="{{trans('tasks.status_not_started')}}"></label>
                    </div>
                    <div class="checkboxVertical pull-right margin-right-10">
                        <input type="checkbox" class="form-check-input started" value="1" name="task_status[]" id="started_tasks" data-toggle="tooltip" title="{{trans('tasks.status_started')}}" checked/>
                        <label for="started_tasks" class="started" data-toggle="tooltip" title="{{trans('tasks.status_started')}}"></label>
                    </div>
                    <div class="checkboxVertical pull-right margin-right-10">
                        <input type="checkbox" class="form-check-input done" value="2" name="task_status[]" data-toggle="tooltip" title="{{trans('tasks.status_done')}}" id="done_tasks"/>
                        <label for="done_tasks" class="done" data-toggle="tooltip" title="{{trans('tasks.status_done')}}"></label>
                    </div>
                    <div class="checkboxVertical pull-right margin-right-10">
                        <input type="checkbox" class="form-check-input completed" value="3" name="task_status[]" data-toggle="tooltip" title="{{trans('tasks.status_finished')}}" id="completed_tasks"/>
                        <label for="completed_tasks" class="completed" data-toggle="tooltip" title="{{trans('tasks.status_finished')}}"></label>
                    </div>
                    <div class="checkboxVertical pull-right margin-right-10">
                        <input type="checkbox" class="form-check-input" value="4" name="task_status[]" data-toggle="tooltip" title="{{trans('tasks.status_suspended')}}" id="stoped_tasks"/>
                        <label for="stoped_tasks" data-toggle="tooltip" title="{{trans('tasks.status_suspended')}}"></label>
                    </div>
                </div>
            </div>

            @if(isset($filter_subject_id))
                <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
            @endif
        </form>
    </div>
    <div id="base_items_div">

    </div>



@section('inline_scripts')
    @include('hamahang.Tasks.MyAssignedTask.helper.MyAssignedTasksPackages_2_inline_js')
@stop

@stop

@section('specific_plugin_scripts')
    <script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/js_tree/dist/jstree.min.js')}}"></script>
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.MyAssignedTask.helper.MyAssignedTaskPackages_inline_js')
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop


