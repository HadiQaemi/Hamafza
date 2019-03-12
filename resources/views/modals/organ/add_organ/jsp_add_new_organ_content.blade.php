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
                <form id="Form_Add_Organ" >
                    <div class="row col-lg-12 margin-top-20">
                        <div class="form-group col-xs-1 col-md-1 col-sm-1 line-height-35">
                            {{ trans('app.title') }}
                        </div>
                        <div class="form-group col-xs-11 col-md-11 col-sm-11">
                            <input placeholder="{{ trans('app.title') }}" name="organ_title" id="item_title" class="form-control" required placeholder=""/>
                        </div>
                    </div>
                    <div class="row col-lg-12">
                        <div class="form-group col-xs-1 col-md-1 col-sm-1 line-height-35">
                            {{ trans('org_chart.description') }}
                        </div>
                        <div class="form-group col-xs-11 col-md-11 col-sm-11">
                            <textarea placeholder="{{ trans('org_chart.description') }}" rows="4" name="organ_description" id="item_organ_description" class="form-control" required placeholder=""></textarea>
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

