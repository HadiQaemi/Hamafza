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
            <div class="base_tabs">
                <div id="alert_insert"></div>
                <form id="Form_edit_Organ" >
                    <div class="row-fluid">
                        <div class="form-group col-md-12">
                            <label>
                                <span class="required">*</span>
                                <span>{{ trans('app.title') }}</span>
                            </label>
                            <input name="organ_title" id="root_item_title" class="form-control" required value="{{$title}}"/>
                            <input type="hidden" name="org_id" id="org_id" class="form-control" required value="{{$org_id}}"/>
                        </div>
                        <div class="row col-lg-12">
                            <div class="form-group col-xs-1 col-md-1 col-sm-1">
                                <label for="">{{ trans('org_chart.level') }}</label>
                            </div>
                            <div class="form-group col-xs-11 col-md-11 col-sm-11">
                                <input type="radio" placeholder="{{ trans('org_chart.level') }} 1" name="organ_level" id="level1" value="1" {{$level==1 ? 'checked' : ''}}/>
                                <label for="level1">{{ trans('org_chart.level') }} 1</label>
                                <input class="margin-right-20" type="radio" placeholder="{{ trans('org_chart.level') }} 2" name="organ_level" id="level2" value="2" {{$level==2 ? 'checked' : ''}}/>
                                <label for="level2">{{ trans('org_chart.level') }} 2</label>
                                <input class="margin-right-20" type="radio" placeholder="{{ trans('org_chart.level') }} 3" name="organ_level" id="level3" value="3" {{$level==3 ? 'checked' : ''}}/>
                                <label for="level3">{{ trans('org_chart.level') }} 3</label>
                                <input class="margin-right-20" type="radio" placeholder="{{ trans('org_chart.level') }} 4" name="organ_level" id="level4" value="4" {{$level==4 ? 'checked' : ''}}/>
                                <label for="level4">{{ trans('org_chart.level') }} 4</label>
                                <input class="margin-right-20" type="radio" placeholder="{{ trans('org_chart.level') }} 5" name="organ_level" id="level5" value="5" {{$level==5 ? 'checked' : ''}}/>
                                <label for="level5">{{ trans('org_chart.level') }} 5</label>
                            </div>
                        </div>
                        {{--<div class="form-group col-md-12">--}}
                            {{--<label>--}}
                                {{--<span class="required">*</span>--}}
                                {{--<span>{{ trans('org_chart.parent') }}</span>--}}
                            {{--</label>--}}
                            {{--<select id="organ_parent" name="parent_organ" class="js-states form-control">--}}

                            {{--</select>--}}
                        {{--</div>--}}
                        <div class="form-group col-md-12">
                            <label> <span>{{ trans('app.description') }}</span></label>
                            <textarea name="organ_description" id="organ_description" class="form-control">{{$description}}</textarea>
                        </div>
                    </div>
                </form>
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
                        <select name="users_list_project_view[]" id="users_list_project_view" multiple="multiple" class="form-control select2_auto_complete_user"></select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.user')}}
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_project_view[]" id="roles_list_project_view" multiple="multiple" class="form-control select2_auto_complete_roles"></select>
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
                        <select name="users_list_project_edit_tasks[]" id="users_list_project_edit_tasks" multiple="multiple" class="form-control select2_auto_complete_user"></select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.user')}}
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_project_edit_tasks[]" id="roles_list_project_edit_tasks" multiple="multiple" class="form-control select2_auto_complete_roles"></select>
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
                        <select name="users_list_project_edit[]" id="users_list_project_edit" multiple="multiple" class="form-control select2_auto_complete_user"></select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.user')}}
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_project_edit[]" id="roles_list_project_edit" multiple="multiple" class="form-control select2_auto_complete_roles"></select>
                    </td>
                    <td class="col-xs-2"> {{trans('app.role')}}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>


