<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
<div id="tab" class="row table-bordered" style="border-bottom: none">
    <ul class="nav nav-tabs">
        <li class="active" id="define">
            <a href="#tab_t1" data-toggle="tab">عمومی</a>
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
            <div class="col-xs-12 line-height-35 margin-top-20">
                <div class="col-xs-2"><label>{{trans('projects.title')}}</label></div>
                <div class="col-xs-10">
                    <input type="text" class="col-xs-9 form-control" id="p_title" placeholder="{{trans('projects.title')}}"/>
                    <input type="radio" class="" name="p_type" id="p_type0" value="0" checked/><label for="p_type0">{{trans('projects.official')}}</label>
                    <input type="radio" class="" name="p_type" id="p_type1" value="1"/><label for="p_type1">{{trans('projects.unofficial')}}</label>
                </div>
            </div>
            {{--<div class="col-xs-12 line-height-35 margin-top-20">--}}
                {{--<div class="col-xs-2">{{trans('projects.top_purpose')}}</div>--}}
                {{--<div class="col-xs-10">--}}
                    {{--<input type="text" class="form-control" id="p_top_goals"/>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="col-xs-12 line-height-35 margin-top-20">
                <div class="col-xs-2"><label>{{trans('projects.describe')}}</label></div>
                <div class="col-xs-10">
                    {{--<input type="text" class="form-control" id="p_desc"/>--}}
                    <textarea class="form-control" id="p_desc" cols="30" rows="4" placeholder="{{trans('projects.describe')}}"></textarea>
                </div>
            </div>
            <div class="col-xs-12 margin-top-60" style="border-top: #ccc solid 1px;padding-top: 10px">
                <div class="col-xs-2 line-height-35"><label>{{trans('projects.project_manager')}}</label></div>
                <div class="col-xs-10">
                    <select name="p_responsible[]" id="p_responsible" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                        <option value=""></option>
                    </select>
                    {{--<div class="col-xs-2 line-height-35">{{trans('projects.organizational_unit')}}</label></div>--}}
                    {{--<div class="col-sm-5 noPadding">--}}
                        {{--<select name="p_org_unit[]" id="p_org_unit" class="select2_auto_complete_org_unit col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>--}}
                            {{--<option value=""></option>--}}
                        {{--</select>--}}
                        {{--<span style="position: absolute; left: 20px; top: 10px;" class="fa fa-sitemap"></span>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="col-xs-12 margin-top-10">
                <div class="col-xs-2 line-height-35"><label>{{trans('projects.project_observer')}}</label></div>
                <div class="col-xs-10">
                    <select name="p_observer[]" id="p_observer" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                        <option value=""></option>
                    </select>
                    {{--<div class="col-xs-2 line-height-35">{{trans('projects.organizational_unit')}}</label></div>--}}
                    {{--<div class="col-sm-5 noPadding">--}}
                    {{--<select name="p_org_unit[]" id="p_org_unit" class="select2_auto_complete_org_unit col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>--}}
                    {{--<option value=""></option>--}}
                    {{--</select>--}}
                    {{--<span style="position: absolute; left: 20px; top: 10px;" class="fa fa-sitemap"></span>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="col-xs-12 margin-top-10">
                <div class="col-xs-2 line-height-35"><label>{{trans('projects.project_supervisor')}}</label></div>
                <div class="col-xs-10">
                    <select name="p_supervisor[]" id="p_supervisor" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                        <option value=""></option>
                    </select>
                    {{--<div class="col-xs-2 line-height-35">{{trans('projects.organizational_unit')}}</label></div>--}}
                    {{--<div class="col-sm-5 noPadding">--}}
                    {{--<select name="p_org_unit[]" id="p_org_unit" class="select2_auto_complete_org_unit col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>--}}
                    {{--<option value=""></option>--}}
                    {{--</select>--}}
                    {{--<span style="position: absolute; left: 20px; top: 10px;" class="fa fa-sitemap"></span>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="col-xs-12 margin-top-10" style="border-top: #ccc solid 1px;padding-top: 10px">
                <div class="col-xs-2 line-height-35"><label>{{trans('projects.keywords')}}</label></div>
                <div class="col-xs-10 nput-group pull-right">
                    <select class="select2_auto_complete_keywords " name="p_keyword[]" id="p_keyword" data-placeholder="{{trans('projects.keywords')}}" multiple="multiple"></select>
                    <span class="Chosen-LeftIcon"></span>
                </div>
            </div>
            <div class="col-xs-12 margin-top-10">
                <div class="col-xs-2 line-height-35"><label>{{trans('projects.page')}}</label></div>
                <div class="col-xs-10">
                    <select class="js-data-example-ajax form-control" id="page_id" name="page_id[]" multiple  data-placeholder="{{trans('projects.can_select_some_options')}}"></select>
                    {{--<span style="position: absolute; left: 20px; top: 10px;" class="glyphicon glyphicon-file"></span>--}}
                </div>
            </div>
            <div class="col-xs-12 line-height-35 margin-top-20" style="border-top: #ccc solid 1px;padding-top: 10px">
                <div class="col-xs-2"><label>{{trans('projects.schedule_base')}}</label></div>
                <div class="col-xs-10">
                    <select id="p_schedule_on" class="form-control col-xs-4">
                        <optgroup label="{{trans('projects.choose')}}">
                            <option value="1"><label>{{trans('projects.start_date')}}</label></option>
                            <option value="2"><label>{{trans('projects.end_date')}}</label></option>
                        </optgroup>
                    </select>
                    <span id="schedule_massage" style=""></span>
                </div>
            </div>
            <div class="col-xs-12 line-height-35 margin-top-20">
                <div class="col-xs-2"><label>{{trans('projects.start_date')}}</label></div>
                <div class="col-xs-2 nput-group pull-right">
                    {{--<span class="input-group-addon" id="respite_date">--}}
                        {{--<i class="fa fa-calendar"></i>--}}
                    {{--</span>--}}
                    <input type="text" class="form-control DatePicker" id="start_date" name="start_date" aria-describedby="respite_date">
                </div>
                <div class="col-xs-2"><label>{{trans('projects.final_date')}}</label></div>
                <div class="col-xs-2 nput-group pull-right">
                    {{--<span class="input-group-addon" id="respite_date">--}}
                        {{--<i class="fa fa-calendar"></i>--}}
                    {{--</span>--}}
                    <input type="text" class="form-control DatePicker" name="end_date" id="end_date" aria-describedby="respite_date">
                </div>
            </div>
            <div class="col-xs-12 line-height-35 margin-top-20">
                <div class="col-xs-2"><label>{{trans('projects.current_date')}}</label></div>
                <div class="col-xs-2 nput-group pull-right">
                    {{--<span class="input-group-addon" id="respite_date">--}}
                    {{--<i class="fa fa-calendar"></i>--}}
                    {{--</span>--}}
                    <input type="text" class="form-control DatePicker" name="current_date" id="current_date" aria-describedby="respite_date">
                </div>
                <div class="col-xs-2"><label>{{trans('projects.status_date')}}</label></div>
                <div class="col-xs-2 nput-group pull-right">
                    {{--<span class="input-group-addon" id="respite_date">--}}
                    {{--<i class="fa fa-calendar"></i>--}}
                    {{--</span>--}}
                    <input type="text" class="form-control DatePicker" name="state_date" id="state_date" aria-describedby="respite_date">
                </div>
            </div>
            <div class="col-xs-12 line-height-35 margin-top-20">
                {{--<div class="col-xs-1"><label>{{trans('projects.base_calendar')}}</label></div>--}}
                {{--<div class="col-xs-2 nput-group pull-right">--}}
                    {{--<select class="form-control" id="base_calendar">--}}
                        {{--<option value=""><label>{{trans('projects.choose')}}</label></option>--}}
                        {{--@foreach($calendars as $calendar)--}}
                            {{--<option value="{{ $calendar->id }}"><label>{{ $calendar->title }}</label></option>--}}
                        {{--@endforeach--}}

                    {{--</select>--}}
                {{--</div>--}}
                <div class="col-xs-2"><label>{{trans('projects.priority')}}</label></div>
                <div class="col-xs-6 nput-group pull-right">
                    <div class="pull-right">
                        <input type="radio" name="importance" id="importance_yes" value="1"/>
                        <label for="importance_yes">{{ trans('tasks.important') }}</label>
                        <input type="radio" name="importance" id="importance_no" value="0" checked/>
                        <label for="importance_no">{{ trans('tasks.unimportant')}}</label>
                    </div>
                    <div class="pull-right">
                        <input type="radio" name="immediate" id="immediate_yes" value="1"/>
                        <label for="immediate_yes" >{{ trans('tasks.immediate') }}</label>
                        <input type="radio" name="immediate" id="immediate_no" value="0" checked/>
                        <label for="immediate_no">{{ trans('tasks.Non-urgent') }}</label>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 line-height-35 margin-top-20">
                <div class="col-xs-2">
                    <label style="line-height: 10px;" for="create_page">{{trans('projects.create_page')}}</label>
                </div>
                <div class="col-xs-2 nput-group pull-right">
                    <input id="create_page" name="create_page" type="checkbox" checked>
                </div>
            </div>
        </div>
        <div class="tab-pane tab-view" id="tab_t2">
            <table style="width:98%;" id="FormTable" dir="ltr">
                <tr style="direction: rtl;">
                    <td colspan="2">
                        <span style=" font-size: 14px;"><label>{{trans('projects.view_project')}}</label></span>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="users_list_project_view[]" id="users_list_project_view" multiple="multiple" class="form-control users_list_project_view"></select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.user')}}
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_project_view[]" id="roles_list_project_view" multiple="multiple" class="form-control roles_list_project_view"></select>
                    </td>
                    <td class="col-xs-2">{{trans('app.role')}}
                    </td>
                </tr>
                <tr style="direction: rtl;">
                    <td colspan="2">
                        <hr/>
                        <span style="font-size: 14px;"><label>{{trans('projects.edit_view_project_tasks')}}</label></span>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="users_list_project_edit_tasks[]" id="users_list_project_edit_tasks" multiple="multiple" class="form-control users_list_project_edit_tasks"></select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.user')}}
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_project_edit_tasks[]" id="roles_list_project_edit_tasks" multiple="multiple" class="form-control roles_list_project_edit_tasks"></select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.role')}}
                    </td>
                </tr>
                <tr style="direction: rtl;">
                    <td colspan="2">
                        <hr/>
                        <span style="font-size: 14px;"><label>{{trans('projects.edit_view_project')}}</label></span>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="users_list_project_edit[]" id="users_list_project_edit" multiple="multiple" class="form-control users_list_project_edit"></select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.user')}}
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_project_edit[]" id="roles_list_project_edit" multiple="multiple" class="form-control roles_list_project_edit"></select>
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
                    <h4 class="modal-title" style="color:red;" id="confirm_modal_title"><label>{{trans('app.error')}}</label></h4>
                </div>
                <div class="modal-body">
                    <span id="confirm_modal_massage"></span>
                </div>
                <div class="modal-footer">
                    <span style="text-align: center" id="">
                        <a class="btn btn-default" onclick="close_modal()"><label>{{trans('app.confirm')}}</label></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>

@include('hamahang.Projects.helper.inline_js_create_new_project')