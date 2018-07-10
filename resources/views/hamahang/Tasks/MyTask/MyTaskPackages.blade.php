@extends('layouts.master')

@section('page_title')
    TODO supply a title
@stop

@section('specific_plugin_style')
    <!--<link rel="stylesheet" href="{{URL::to('assets/css/dragable.css')}}">-->
    <!--<link rel="stylesheet" href="{{URL::to('assets/Packages/js_tree/dist/themes/default/style.css')}}" />-->
    <!--<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">-->

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
        label {}
        #datepicker {
            border: 1px solid #000000;

        }
        p.ui-state-hover {
            font-weight: normal;
        }

        p.ui-widget-header {
            text-align: center;
            font-weight: normal;
        }
        strong.ui-state-error {
            display: block;
            padding: 3px;
            text-align: center;
        }
        #related_links{
            position: absolute !important;
            top: 5px !important;
            width: 250px !important;
            left: 34px !important;
        }
    </style>
@stop


@section('content')
    @include('hamahang.Tasks.MyTask.helper.task_related_pages')
    <div id="packages" class="col-xs-12">
        <fieldset>
            <legend>بسته های کاری وظایف من</legend>
            @php ($x=1)
            @foreach($packages as $package)
                @if($x%4==1)
                    <div class="row">
                        @endif
                        <div class="col-xs-3">
                            <div class="panel panel-default">
                                <div class="panel-heading well-sm">
                                    <span>{{ $package->title }}</span>
                                    <span class="pull-left" style="font-size: 14px"><i class="fa fa-remove cursor-pointer" onclick="RemovePackage({{ $package->id.',"'.$package->title.'"' }})"></i><i class="fa fa-edit cursor-pointer"
                                        onclick="ModifyPackage({{ $package->id }},'{{ $package->title }}')"></i>
                                    </span>
                                </div>
                                <div id="package{{ $package->id }}" class="panel-body">
                                    <ul>
                                        @foreach($package->tasks as $task)
                                            <li><a class="task_info cursor-pointer" data-t_id = "{{ $task->id }}" >{{ $task->title }}</a><span class="pull-left"><i class="fa fa-remove cursor-pointer" onclick="RemoveFromPackage({{ $task->package_id.",".$task->utpid.",'".$task->title."'"
                                             }})"></i>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="panel-footer">
                                    <div>
                                        <a onclick="show_select_tasks_window_modal(0 , {{ $package->id }},0)" class="cursor-pointer"><i class="cursor-pointer"></i> پنجره انتخاب وظایف </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        @if($x%4==0)
                    </div>
                @endif
                @php ($x++)
            @endforeach
            <div class="col-xs-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a class="btn btn-default btn-block" onclick="new_package()">ایجاد بسته کاری جدید</a>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="clearfixed"></div>
    <div class="modal fade" id="new_package" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">تعریف بسته کاری جدید</h4>
                </div>
                <div class="modal-body">
                    <label for="name">عنوان :</label>
                    <input type="text" name="packagetitle" id="packagetitle" class="text ui-widget-content ui-corner-all">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{trans('filemanager.cancel')}}</button>
                    <button id="NewTaskPackageSubmitBtn" name="upload_files" value="save" class="btn btn-info"
                            type="button">
                        <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                        <span>ثبت</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="remove_confirm_modal" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:red;">هشدار</h4>
                </div>
                <div class="modal-body">
                  <span id="modal_massage">آیا از حذف این بسته کاری اطمینان دارید ؟</span>
                </div>
                <div class="modal-footer">
                    <span id="confirm_results"></span>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modify_package" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:red;">تغییر نام بسته کاری</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>نام فعلی : </td>
                            <td><h6 style="color: green;"><span id="current_package_name"></span> </h6> </td>
                        </tr>
                        <tr>
                            <td>نام جدید : </td>
                            <td><input class="form-control col-xs-6" id="nTitle"/></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-info pull-left" onclick="ChangePackageTitle(1)">تغییر</a>
                    <a class="btn btn-default pull-left" style="margin-left: 3px" onclick="ChangePackageTitle(0)">انصراف</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('specific_plugin_scripts')
    <script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>

@stop

@section('inline_scripts')
    @include('hamahang.Tasks.MyTask.helper.MyTaskPackages_inline_js')
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')

@stop


