@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/dragable.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
@stop
@section('inline_style')
    <style type="text/css">
        .state_container {}
        hr {
            margin-top: 5px;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-right: 10px;
        }
        .gray_background {
            background-color: #eeeeee;
            margin-right: 3px;
            padding: 3px;
            padding-right: 5px;
        }
        #t_radio label {
            margin-left: 15px;
        }
        #datepicker {
            border: 1px solid #000000;
        }
    </style>
@stop

@section('content')
    @include('hamahang.Tasks.MyTask.helper.task_related_pages')
    @include('hamahang.Tasks.MyTask.helper.MyTasksState.task_filter')
    <div class="row-fluid" style="background-color: white">
        <fieldset>

            {{-- <div class="container col-xs-12" style="margin-top: 25px;">
                <div class="row-fluid">
                    <div class="form-inline col-xs-6" style="font-size: 10px;">
                        <input type="text" class="form-control" placeholder="عنوان وظیفه ..." name="task_title" id="task_title"/>
                        <input type="checkbox" class="form-control" name="official" id="official" checked/>
                        <label>رسمی</label>
                        <input type="checkbox" class="form-control" name="individual" id="individual" checked/>
                        <label>غیر رسمی</label>
                        <input type="number" class="form-control " placeholder="مهلت" style="width: 60px;" name="respite" id="respite"/>
                    </div>
                    <div class="form-inline col-xs-6" style="font-size: 10px;">
                        <input type="checkbox" class="form-control" name="" id="not_started_tasks" checked/>
                        <label>{{trans('tasks.status_not_started')}}</label>
                        <input type="checkbox" class="form-control" name="" id="started_tasks" checked/>
                        <label>{{trans('tasks.status_started')}}</label>
                        <input type="checkbox" class="form-control" name="" id="done_tasks"/>
                        <label>{{trans('tasks.status_done')}}</label>
                        <input type="checkbox" class="form-control" name="" id="completed_tasks"/>
                        <label>{{trans('tasks.status_finished')}}</label>
                        <input type="checkbox" class="form-control" name="" id="stoped_tasks"/>
                        <label>متوقف</label>
                    </div>
                </div>--}}
                <div class="clearfixed"></div>
                <div class="row-fluid">
                    <div class="col-xs-6">
                        <div class="panel panel-default ">
                            <div class="panel-heading text-center">فوری و مهم</div>
                            <div class="panel-body firstContent psize" level="1" id="firstContent">
                                <div class="row-fluid " level="1" id="type1_tasks"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">مهم و غیرفوری</div>
                            <div class="panel-body secendContent psize" level="2" id="secendContent">
                                <div class="row-fluid " level="2" id="type2_tasks"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="col-xs-6">
                        <div class="panel panel-default ">
                            <div class="panel-heading text-center">فوری و غیرمهم</div>
                            <div class="panel-body thirdContent psize" level="3" id="thirdContent">
                                <div class="row-fluid " level="3" id="type3_tasks"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">غیرمهم و غیرفوری</div>
                            <div class="panel-body fourthContent psize " level="4" id="fourthContent">
                                <div class="row-fluid" level="4" id="type4_tasks"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfixed"></div>

        </fieldset>
    </div>
    <div class="clearfixed"></div>
    @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask')
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/jquery-ui/jquery-ui.js')}}"></script>
@stop

@section('inline_scripts')
    @include('hamahang.Tasks.MyTask.helper.MyTasksPriority_inline_js')
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop