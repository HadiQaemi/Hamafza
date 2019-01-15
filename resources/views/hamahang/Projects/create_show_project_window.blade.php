<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
<div id="tab" class="row table-bordered" style="border-bottom: none">
    <ul class="nav nav-tabs">
        <li class="active" id="define">
            <a href="#tab_t1" data-toggle="tab">تعریف</a>
        </li>
        <li>
            <a href="#tab_t2" data-toggle="tab">دسترسی</a>
        </li>
        <li style="float: left">
            <h5 id="task_type" style="color: blue"></h5>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active tab-view" id="tab_t1">
            <div class="col-xs-12">
                <div id="tab" class="table-bordered">
                        @php
                            $ProjectInfo = json_decode($ProjectInfo);
                            $project_tasks = $ProjectInfo[0];
                            $project_info = $ProjectInfo[1];
                            $pages = $ProjectInfo[2];
                            $project_keywords = $ProjectInfo[3];
                            $project_responsibles = $ProjectInfo[4];
                            $role_permission = $ProjectInfo[5];
                            $user_permission = $ProjectInfo[6];
                            $project_info = $project_info->project_info;
                            $project_info = $project_info[0];
                        @endphp
                        <div class="tab-pane active" id="t1">
                            <div class="col-xs-12 line-height-35 margin-top-20">
                                <div class="col-xs-2">{{trans('projects.title')}}</div>
                                <input type="hidden" name="edit_pid" id="edit_pid" value="{{enCode($project_info->project_id)}}" />
                                <div class="col-xs-10">
                                    <input type="text" class="col-xs-9 form-control" id="p_title" value="{{$project_info->title}}" placeholder="{{trans('projects.title')}}"/>
                                    <input type="radio" class="" name="p_type" id="p_type0" value="0" {{$project_info->type==0 ? '' : 'checked'}}/><label for="p_type0">{{trans('projects.official')}}</label>
                                    <input type="radio" class="" name="p_type" id="p_type1" value="1" {{$project_info->type==1 ? '' : 'checked'}}/><label for="p_type1">{{trans('projects.unofficial')}}</label>
                                </div>
                            </div>
                            <div class="col-xs-12 line-height-35 margin-top-20">
                                <div class="col-xs-2">{{trans('projects.describe')}}</div>
                                <div class="col-xs-10">
                                    {{--<input type="text" class="form-control" id="p_desc"/>--}}
                                    <textarea class="form-control" id="p_desc" cols="30" rows="4" placeholder="{{trans('projects.describe')}}">{{$project_info->desc}}</textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-60">
                                <div class="col-xs-2 line-height-35">{{trans('projects.top')}}</div>
                                <div class="col-xs-10">
                                    <select class="js-data-example-ajax form-control" id="page_id" name="page_id[]" multiple  data-placeholder="{{trans('projects.can_select_some_options')}}">
                                        @if(!empty($pages->pages))
                                            @foreach($pages->pages as $page_res)
                                                <option selected="selected" value="{{ $page_res->subject_id }}">{{ $page_res->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-10" style="border-top: #ccc solid 1px;padding-top: 10px">
                                <div class="col-xs-2 line-height-35">{{trans('projects.project_manager')}}</div>
                                <div class="col-xs-10">
                                    <select name="p_responsible[]" id="p_responsible" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                        @if(!empty($project_responsibles->responsibles))
                                            @foreach($project_responsibles->responsibles as $project_res)
                                                @if($project_res->permission_type == 1 || trim($project_res->permission_type) == '')
                                                    <option selected="selected" value="exist_in{{ $project_res->user_id }}">{{ $project_res->full_name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-10">
                                <div class="col-xs-2 line-height-35">{{trans('projects.project_observer')}}</div>
                                <div class="col-xs-10">
                                    <select name="p_observer[]" id="p_observer" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                        @if(!empty($project_responsibles->responsibles))
                                            @foreach($project_responsibles->responsibles as $project_res)
                                                @if($project_res->permission_type == 2)
                                                    <option selected="selected" value="exist_in{{ $project_res->user_id }}">{{ $project_res->full_name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-10">
                                <div class="col-xs-2 line-height-35">{{trans('projects.project_supervisor')}}</div>
                                <div class="col-xs-10">
                                    <select name="p_supervisor[]" id="p_supervisor" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                        @if(!empty($project_responsibles->responsibles))
                                            @foreach($project_responsibles->responsibles as $project_res)
                                                @if($project_res->permission_type == 3)
                                                    <option selected="selected" value="exist_in{{ $project_res->user_id }}">{{ $project_res->full_name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-10" style="border-top: #ccc solid 1px;padding-top: 10px">
                                <div class="col-xs-2 line-height-35">{{trans('projects.keywords')}}</div>
                                <div class="col-xs-10 nput-group pull-right">
                                    <select class="select2_auto_complete_keywords " name="p_keyword[]" id="p_keyword" data-placeholder="{{trans('projects.keywords')}}" multiple="multiple">
                                        @if(!empty($project_keywords->project_keywords))
                                            @foreach($project_keywords->project_keywords as $project_keyword)
                                                <option selected="selected" value="{{ $project_keyword->id }}">{{ $project_keyword->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="Chosen-LeftIcon"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 line-height-35 margin-top-20" style="border-top: #ccc solid 1px;padding-top: 10px">
                                <div class="col-xs-2">{{trans('projects.schedule_base')}}</div>
                                <div class="col-xs-10">
                                    <select id="p_schedule_on" class="form-control col-xs-4">
                                        <optgroup label="{{trans('projects.choose')}}">
                                            <option value="1">{{trans('projects.start_date')}}</option>
                                            <option value="2">{{trans('projects.end_date')}}</option>
                                        </optgroup>
                                    </select>
                                    <span id="schedule_massage" style="color-rendering: gray"></span>
                                </div>
                            </div>

                            <div class="col-xs-12 line-height-35 margin-top-20">
                                <div class="col-xs-2">{{trans('projects.end_date')}}</div>
                                <div class="col-xs-2 nput-group pull-right">
                                    {{--<span class="input-group-addon" id="respite_date">--}}
                                        {{--<i class="fa fa-calendar"></i>--}}
                                    {{--</span>--}}
                                    <input type="text" class="form-control DatePicker" id="start_date" name="start_date" aria-describedby="respite_date" value="{{$project_info->start_date->year.'/'.$project_info->start_date->mon.'/'.$project_info->start_date->mday}}">
                                </div>
                                <div class="col-xs-2">{{trans('projects.final_date')}}</div>
                                <div class="col-xs-2 nput-group pull-right">
                                    {{--<span class="input-group-addon" id="respite_date">--}}
                                        {{--<i class="fa fa-calendar"></i>--}}
                                    {{--</span>--}}
                                    <input type="text" class="form-control DatePicker" name="end_date" id="end_date" aria-describedby="respite_date" value="{{$project_info->end_date->year.'/'.$project_info->end_date->mon.'/'.$project_info->end_date->mday}}">
                                </div>
                            </div>
                            <div class="col-xs-12 line-height-35 margin-top-20">
                                <div class="col-xs-2">{{trans('projects.current_date')}}</div>
                                <div class="col-xs-2 nput-group pull-right">
                                    {{--<span class="input-group-addon" id="respite_date">--}}
                                    {{--<i class="fa fa-calendar"></i>--}}
                                    {{--</span>--}}
                                    <input type="text" class="form-control DatePicker" name="current_date" id="current_date" aria-describedby="respite_date" value="{{$project_info->current_date->year.'/'.$project_info->current_date->mon.'/'.$project_info->current_date->mday}}">
                                </div>
                                <div class="col-xs-2">{{trans('projects.status_date')}}</div>
                                <div class="col-xs-2 nput-group pull-right">
                                    {{--<span class="input-group-addon" id="respite_date">--}}
                                    {{--<i class="fa fa-calendar"></i>--}}
                                    {{--</span>--}}
                                    <input type="text" class="form-control DatePicker" name="state_date" id="state_date" aria-describedby="respite_date" value="{{$project_info->state_date->year.'/'.$project_info->state_date->mon.'/'.$project_info->state_date->mday}}">
                                </div>
                            </div>
                            <div class="col-xs-12 line-height-35 margin-top-20">
                                {{--<div class="col-xs-2">{{trans('projects.base_calendar')}}</div>--}}
                                {{--<div class="col-xs-2 nput-group pull-right">--}}
                                    {{--<select class="form-control" id="base_calendar">--}}
                                        {{--<option value="">{{trans('projects.choose')}}</option>--}}
                                        {{--@foreach($calendars as $calendar)--}}
                                            {{--<option value="{{ $calendar->id }}">{{ $calendar->title }}</option>--}}
                                        {{--@endforeach--}}

                                    {{--</select>--}}
                                {{--</div>--}}
                                <div class="col-xs-2">{{trans('projects.priority')}}</div>
                                <div class="col-xs-6 nput-group pull-right">
                                    <div class="pull-right">
                                        <input type="radio" name="importance" id="importance_yes" value="1" {{$project_info->importance ==1 ? 'checked' : ''}}/>
                                        <label for="importance_yes">{{ trans('tasks.important') }}</label>
                                        <input type="radio" name="importance" id="importance_no" value="0"  {{$project_info->importance ==0 ? 'checked' : ''}}/>
                                        <label for="importance_no">{{ trans('tasks.unimportant')}}</label>
                                    </div>
                                    <div class="pull-right">
                                        <input type="radio" name="immediate" id="immediate_yes" value="1" {{$project_info->immediate ==1 ? 'checked' : ''}}/>
                                        <label for="immediate_yes" >{{ trans('tasks.immediate') }}</label>
                                        <input type="radio" name="immediate" id="immediate_no" value="0"  {{$project_info->immediate ==0 ? 'checked' : ''}}/>
                                        <label for="immediate_no">{{ trans('tasks.Non-urgent') }}</label>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-xs-12 line-height-35 margin-top-20">--}}
                                {{--<div class="col-xs-2">--}}
                                    {{--<label style="line-height: 10px;" for="create_page">{{trans('projects.create_page')}}</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-2 nput-group pull-right">--}}
                                    {{--<input id="create_page" name="create_page" type="checkbox" checked>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    {{--</div>--}}
                    <div class="clearfixed"></div>
                </div>
            </div>
        </div>
        <div class="tab-pane tab-view" id="tab_t2">
            <table style="width:98%;" id="FormTable" dir="ltr">
                <tr style="direction: rtl;">
                    <td colspan="2">
                        <span style=" font-size: 14px;">{{trans('projects.view_project')}}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="users_list_project_view[]" id="users_list_project_view" multiple="multiple" class="form-control users_list_project_view">
                            @if(!empty($user_permission->user_permission))
                                @foreach($user_permission->user_permission as $user)
                                    @if($user->permission_type==1)
                                        <option selected="selected" value="{{ $user->user_id }}">{{ $user->full_name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>

                    </td>
                    <td class="col-xs-2"> {{trans('app.user')}}
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_project_view[]" id="roles_list_project_view" multiple="multiple" class="form-control roles_list_project_view">
                            @if(!empty($role_permission->role_permission))
                                @foreach($role_permission->role_permission as $role)
                                    @if($role->permission_type==1)
                                        <option selected="selected" value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="col-xs-2">{{trans('app.role')}}
                    </td>
                </tr>
                <tr style="direction: rtl;">
                    <td colspan="2">
                        <hr/>
                        <span style="font-size: 14px;">{{trans('projects.edit_view_project_tasks')}}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="users_list_project_edit_tasks[]" id="users_list_project_edit_tasks" multiple="multiple" class="form-control users_list_project_edit_tasks">
                            @if(!empty($user_permission->user_permission))
                                @foreach($user_permission->user_permission as $user)
                                    @if($user->permission_type==2)
                                        <option selected="selected" value="{{ $user->user_id }}">{{ $user->full_name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.user')}}
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_project_edit_tasks[]" id="roles_list_project_edit_tasks" multiple="multiple" class="form-control roles_list_project_edit_tasks">
                            @if(!empty($role_permission->role_permission))
                                @foreach($role_permission->role_permission as $role)
                                    @if($role->permission_type==2)
                                        <option selected="selected" value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.role')}}
                    </td>
                </tr>
                <tr style="direction: rtl;">
                    <td colspan="2">
                        <hr/>
                        <span style="font-size: 14px;">{{trans('projects.edit_view_project')}}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="users_list_project_edit[]" id="users_list_project_edit" multiple="multiple" class="form-control users_list_project_edit">
                            @if(!empty($user_permission->user_permission))
                                @foreach($user_permission->user_permission as $user)
                                    @if($user->permission_type==3)
                                        <option selected="selected" value="{{ $user->user_id }}">{{ $user->full_name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.user')}}
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_project_edit[]" id="roles_list_project_edit" multiple="multiple" class="form-control roles_list_project_edit">
                            @if(!empty($role_permission->role_permission))
                                @foreach($role_permission->role_permission as $role)
                                    @if($role->permission_type==3)
                                        <option selected="selected" value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.role')}}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="clearfixed"></div>
    <div class="space-32"></div>
    <div class="modal fade" id="confirm_modal" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:red;" id="confirm_modal_title">خطا</h4>
                </div>
                <div class="modal-body">
                    <span id="confirm_modal_massage"></span>
                </div>
                <div class="modal-footer">
                    <span style="text-align: center" id="">
                        <a class="btn btn-default" onclick="close_modal()">تایید</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
@include('hamahang.Projects.helper.inline_js_create_edit_project')