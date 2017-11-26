@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
@stop

@section('content')
    <fieldset class="col-xs-12 row ">
        <legend> {{ trans('tasks.create_new_task') }} </legend>
        <form action="{{ route('hamahang.tasks.save_task') }}" class="" name="task_public" id="task_public" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="draft" id="draft" value="0"/>
            <input type="hidden" name="first_m" id="first_m" value="0"/>
            <input type="hidden" name="first_u" id="first_u" value="0"/>
            <input type="hidden" name="assigner_id" value="125"/>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    @include('hamahang.Tasks.helper.CreateNewTask.task_create')
                </div>
            </div>
            <hr>
            <input type="hidden" id="save_type" name="save_type" value="0"/>
            <button class="btn btn-info pull-left" id="save_commit" type="button" data-form_id="task_public">
                <i ></i>
                {{trans('tasks.submit')}}
            </button>
            <a onclick="save_as_draft('task_public')" class="btn btn-default pull-left" id="save_draft">
                <i ></i>
                {{trans('tasks.draft')}}
            </a>
            <a class="btn btn-default pull-left" href="{{ route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts',['username'=>$uname]) }}">نمایش پیش نویس ها</a>
        </form>
        {!! $HFM_CNT['UploadForm'] !!}
    </fieldset>
    <div class="clearfixed"></div>
    <div class="space-32"></div>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.helper.CreateNewTask.inline_js')
    {!! $HFM_CNT['JavaScripts'] !!}
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
