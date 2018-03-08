@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    {{--<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">--}}
@stop
@section('modal_content')
    {{--    @include('hamahang.Tools.helper.Index.modals.modal_new_tool')--}}
@stop
@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <div id="sucsessMsg"></div><!--<button name="rSubMenuBtn" id="rSubMenuBtn">ttttt</button>-->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#toolsGroup" data-toggle="tab">{{trans('tools.menu_tool_group')}}</a></li>
                <li><a href="#toolsItems" data-toggle="tab">{{trans('tools.menu_tools_item')}}</a></li>
                {{--                <li><a href="#groupsRoles" data-toggle="tab">{{trans('tools.menu_group_roles')}}</a></li>--}}
                {{--                <li><a href="#groupsUsers" data-toggle="tab">{{trans('tools.menu_group_uses')}}</a></li>--}}
                <li><a href="#toolsRoles" data-toggle="tab">{{trans('tools.menu_tools_roles')}}</a></li>
                <li><a href="#toolsUsers" data-toggle="tab">{{trans('tools.menu_tools_uses')}}</a></li>
            </ul>
            <div class="tab-content">
                <div id="toolsMsg"></div>
                <div class="col-xs-12 tab-pane fade in active default-options" id="toolsGroup">
                    {{--<div class="space-4"></div>--}}
                    <div>
                        {{--<form id="toolsGroup-form">--}}
                        {{--<table class="col-md-12 table table-condensed table-bordered table-striped table-hover td-center-align">--}}
                        {{--<tr>--}}
                        {{--<td class="col-md-2">{{trans('tools.title')}}</td>--}}
                        {{--<td class="col-md-7"><input type="text" name="name" class="form-control"></td>--}}
                        {{--<td class="col-md-3 btn_holder" style="vertical-align: middle">--}}
                        {{--<button type="button" id="add-tools-group" value="save" class="btn btn-primary pull-left" type="button">--}}
                        {{--<i class="fa fa-save bigger-125"></i>--}}
                        {{--<span>{{trans('app.register')}}</span>--}}
                        {{--</button>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--</table>--}}
                        {{--<input type="hidden" name="edit-id" value="">--}}
                        {{--</form>--}}
                    </div>
                    <div id="menTypeMsg"></div>
                    <div class="clearfixed"></div>
                    {{--<hr class="hr-4" style="margin-bottom: 20px;">--}}
                    <table id="toolsGroupGrid" width="100%" class="table table-condensed table-bordered table-striped table-hover td-center-align">
                        <thead>
                        <tr>
                            <th>{{trans('tools.row_id')}}</th>
                            <th>{{trans('tools.order')}}</th>
                            <th>{{trans('tools.title')}}</th>
                            <th>{{trans('tools.visible')}}</th>
                            <th>{{trans('tools.action')}}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="space-20"></div>
                    <div class="row">
                        <div class="col-xs-8 pull-right">
                            <a href="{{ route('modals.add_tool_group') }}" class="jsPanels btn btn-primary fa fa-plus" title="افزودن دسته"></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 tab-pane fade in  default-options" id="toolsItems">
                    {{--<div class="space-4"></div>--}}
                    {{--<button type="button" id="add-tools-items" value="save" class="btn btn-primary pull-left" type="button">--}}
                    {{--<i class="fa  fa-plus-circle bigger-125"></i>--}}
                    {{--<span>{{trans('tools.new_tools')}}</span>--}}
                    {{--</button>--}}
                    <table id="toolsGrid" style="width: 100%;" class="col-xs-12 table table-condensed table-bordered table-striped table-hover td-center-align">
                        <thead>
                        <tr>
                            <th>{{trans('tools.row_id')}}</th>
                            <th>{{trans('tools.order')}}</th>
                            <th>{{trans('tools.title')}}</th>
                            <th>{{trans('tools.parent')}}</th>
                            <th>{{trans('tools.visible')}}</th>
                            <th>{{trans('tools.action')}}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="space-4"></div>
                    <div class="row">
                        <div class="col-xs-8 pull-right">
                            <a href="{{ route('modals.add_edit_tools') }}" class="jsPanels btn btn-primary fa fa-plus" title="افزودن ابزار"></a>
                        </div>
                    </div>
                    <div class="space-4"></div>
                </div>
                <div class="col-xs-12 tab-pane fade in  default-options" id="groupsRoles">
                    <div class="space-4"></div>
                    <form id="group-roles-form">
                        <table class="table table-condensed table-bordered table-striped table-hover td-center-align">
                            <tr>
                                <td class="col-md-1">
                                    <label>{{trans('tools.group')}}</label>
                                </td>
                                <td class="col-md-4">

                                </td>
                                <td class="col-md-1">
                                    <label>{{trans('tools.roles')}}</label>
                                </td>
                                <td class="col-md-3">
                                    <select name="roles">
                                        <option></option>
                                    </select>
                                </td>
                                <td class="col-md-3 btn_holder" style="vertical-align: middle">
                                    <button type="button" id="add-group-roles" value="save" class="btn btn-primary" type="button">
                                        {{--<i class="fa fa-save bigger-125 "></i>--}}
                                        <span>{{trans('app.save')}}</span>
                                    </button>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="edit_id" value=""/>
                    </form>
                    <div class="clearfixed"></div>
                    <hr class="hr-4" style="margin-bottom: 20px;">
                    <table id="groupsRolesGrid" style="width: 100%;" class="col-xs-12 table table-condensed table-bordered table-striped table-hover td-center-align">
                        <thead>
                        <th>{{trans('tools.row_id')}}</th>
                        <th>{{trans('tools.group')}}</th>
                        <th>{{trans('tools.roles')}}</th>
                        <th>{{trans('tools.action')}}</th>
                        </thead>
                        </thead>
                    </table>
                </div>
                <div class="col-xs-12 tab-pane fade in  default-options" id="toolsRoles">
                    {{--<div class="space-4"></div>--}}
                    {{--<form id="tools_roles_form">--}}
                    {{--<table class="table table-condensed table-bordered table-striped table-hover td-center-align">--}}
                    {{--<tr>--}}
                    {{--<td class="col-md-1">--}}
                    {{--<label>{{trans('tools.tools')}}</label>--}}
                    {{--</td>--}}
                    {{--<td class="col-md-4">--}}
                    {{--<select id="tools_list" class="select" name="tools_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>--}}
                    {{--</td>--}}
                    {{--<td class="col-md-1">--}}
                    {{--<label>{{trans('tools.roles')}}</label>--}}
                    {{--</td>--}}
                    {{--<td class="col-md-3">--}}
                    {{--<select id="roles_list" class="select" name="tools_role_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>--}}
                    {{--</td>--}}
                    {{--<td class="col-md-3 btn_holder" style="vertical-align: middle">--}}
                    {{--<button type="button" id="add_tools_roles" value="save" name="roles_list" class="btn btn-primary" type="button">--}}
                    {{--<i class="fa fa-save bigger-125 "></i>--}}
                    {{--<span>{{trans('app.save')}}</span>--}}
                    {{--</button>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    {{--</table>--}}
                    {{--</form>--}}
                    {{--<hr class="hr-4" style="margin-bottom: 20px;">--}}
                    <form id="tools_roles_filter_form" style="width: 75.2%;position: absolute;right: 23%;top: 12px;">
                        <table class="td-center-align">
                            <tr>
                                <td class="col-md-1">
                                    <label><i class="fa fa-filter"></i> {{trans('tools.tool')}}</label>
                                </td>
                                <td class="col-md-4">
                                    <select id="datatables_tools_list" class="select" name="datatables_tools_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>
                                </td>
                                <td class="col-md-1">
                                    <label><i class="fa fa-filter"></i> {{trans('tools.roles')}}</label>
                                </td>
                                <td class="col-md-3">
                                    <select id="datatables_roles_list" class="select" name="datatables_role_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div class="clearfixed"></div>
                    <table id="toolsRolesGrid" class="col-xs-12 table table-condensed table-bordered table-striped table-hover td-center-align" style="width: 100%;">
                        <thead>
                        <th>{{trans('tools.row_id')}}</th>
                        <th>{{trans('tools.tools')}}</th>
                        <th>{{trans('tools.roles')}}</th>
                        <th>{{trans('tools.action')}}</th>
                        </thead>
                        </thead>
                    </table>
                    <div class="space-4"></div>
                    <div class="row">
                        <div class="col-xs-8 pull-right">
                            <a href="{{ route('modals.add_roles_tools') }}" class="jsPanels btn btn-primary fa fa-plus"></a>
                        </div>
                    </div>
                    <div class="space-4"></div>
                </div>
                <div id="toolsUsers" class="col-xs-12 tab-pane fade in  default-options">
                    {{--<div class="space-4"></div>--}}
                    {{--<form id="tools_users_form">--}}
                    {{--<table class="table table-condensed table-bordered table-striped table-hover td-center-align">--}}
                    {{--<tr>--}}
                    {{--<td class="col-md-1">--}}
                    {{--<label>{{trans('tools.tools')}}</label>--}}
                    {{--</td>--}}
                    {{--<td class="col-md-4">--}}
                    {{--<select id="tools_user_tools_list" class="select" name="datatables_tools_user_tools_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>--}}
                    {{--</td>--}}
                    {{--<td class="col-md-1">--}}
                    {{--<label>{{trans('tools.users')}}</label>--}}
                    {{--</td>--}}
                    {{--<td class="col-md-3">--}}
                    {{--<select id="tools_user_users_list" class="select" name="datatables_tools_user_user_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>--}}
                    {{--</td>--}}
                    {{--<td class="col-md-3 btn_holder" style="vertical-align: middle">--}}
                    {{--<button type="button" id="add_tools_users" value="save" name="roles_list" class="btn btn-primary" type="button">--}}
                    {{--<i class="fa fa-save bigger-125 "></i>--}}
                    {{--<span>{{trans('app.save')}}</span>--}}
                    {{--</button>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    {{--</table>--}}
                    {{--</form>--}}
                    {{--<hr class="hr-4" style="margin-bottom: 20px;">--}}
                    <form id="tools_users_form" style="width: 75.2%;position: absolute;right: 23%;top: 12px;">
                        <table class="td-center-align">
                            <tr>
                                <td class="col-md-1">
                                    <label><i class="fa fa-filter"></i> {{trans('tools.tool')}}</label>
                                </td>
                                <td class="col-md-4">
                                    <select id="datatables_tools_user_tools_list" class="select" name="tools_user_tools_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>
                                </td>
                                <td class="col-md-1">
                                    <label><i class="fa fa-filter"></i> {{trans('tools.users')}}</label>
                                </td>
                                <td class="col-md-3">
                                    <select id="datatables_tools_user_users_list" class="select" name="tools_user_user_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="edit_id" value=""/>
                    </form>
                    <div class="clearfixed"></div>
                    <table id="toolsUserGrid" class="col-xs-12 table table-condensed table-bordered table-striped table-hover td-center-align" style="width: 100%;">
                        <thead>
                        <th>{{trans('tools.row_id')}}</th>
                        <th>{{trans('tools.tools')}}</th>
                        <th>{{trans('tools.users')}}</th>
                        <th>{{trans('tools.action')}}</th>
                        </thead>
                        </thead>
                    </table>
                    <div class="space-4"></div>
                    <div class="row">
                        <div class="col-xs-8 pull-right">
                            <a href="{{ route('modals.add_users_tools') }}" class="jsPanels btn btn-primary fa fa-plus"></a>
                        </div>
                    </div>
                    <div class="space-4"></div>
                </div>
            </div>
        </div>
        <div class="clearfixed"></div>
    </div>
@stop
@section('specific_plugin_scripts')
    {{--    <script type="text/javascript" src="{{URL::asset('assets/Packages/DataTables/datatables.js')}}"></script>--}}
@stop
@section('inline_scripts')
    @include('hamahang.Tools.helper.Index.JS.tools_inline_js')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop