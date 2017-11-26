@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('modal_content')
    @include('hamahang.Access.helper.Index.modals.modal_add_roles')
    @include('hamahang.Access.helper.Index.modals.modal_add_permission')
    @include('hamahang.Access.helper.Index.modals.modal_user_role_relation')
    @include('hamahang.Access.helper.Index.modals.modal_permission_role_relation')
    @include('hamahang.Access.helper.Index.modals.modal_users_from_roles')
@stop
@section('content')
    <div><h4> {{ trans('access.access_management') }} </h4></div>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#roles">{{ trans('access.role_naghsh') }}</a></li>
        <li><a data-toggle="tab" href="#permissions">{{ trans('access.permission_dastrasi') }}</a></li>
        <li><a data-toggle="tab" href="#role-user">{{ trans('access.user_role') }}</a></li>
        <li><a data-toggle="tab" href="#role-permission">{{ trans('access.access_role') }}</a></li>
        <li><a data-toggle="tab" href="#role-permission-edit">{{ trans('access.access_role_permission') }}</a></li>
    </ul>
    <div class="tab-content">
        <div id="roles" class="tab-pane fade in active">
            <div class="row-fluid">
                <div class="space-10"></div>
                <table id="rolesGrid" class="table table-striped table-bordered dt-responsive nowrap display">
                    <thead>
                    <tr>
                        <th>{{ trans('access.row') }} </th>
                        <th>{{ trans('access.title') }}</th>
                        <th>{{ trans('access.showable_title') }}</th>
                        <th>{{ trans('access.usersCount') }}</th>
                        <th>{{ trans('access.permissionCount') }}</th>
                        <th>{{ trans('access.action') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div id="permissions" class="tab-pane fade in ">
            <div class="row-fluid">
                <table width="100%" id="permissionGrid" class="table col-xs-12 table-striped table-bordered dt-responsive nowrap display">
                    <thead>
                    <tr>
                        <th>{{ trans('access.row') }} </th>
                        <th>{{ trans('access.title') }}</th>
                        <th>{{ trans('access.showable_title') }}</th>
                        <th>{{ trans('access.action') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div id="role-user" class="tab-pane fade in ">
            <div class="row-fluid">
                <button style="margin:16px;" class="btn btn-default btn-success pull-left  add-user-role">{{ trans('access.set_role_user') }}</button>
                <table width="100%" id="userRoleGrid" class="table col-xs-12 table-striped table-bordered dt-responsive nowrap display">
                    <thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <select name="user_search" style="margin-right: 10px;"></select>
                        </td>
                        <td>
                            <select name="role_search" class="pull-right" style="margin-right: 10px;">
                                <option value="-1">
                                    {{ trans('access.choose') }}
                                </option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-default btn-success refresh">{{trans('app.reset')}}</button>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('access.row') }} </th>
                        <th></th>
                        <th></th>
                        <th>{{ trans('access.username') }}</th>
                        <th>{{ trans('access.role') }}</th>
                        <th>{{ trans('access.action') }}</th>
                    </tr>
                    </thead>
                <!--<tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <select name="user_search" style="margin-right: 10px;"></select>
                        </td>
                        <td>
                            <select name="role_search" class="pull-right" style="margin-right: 10px;">
                                <option value="-1">
                                    {{ trans('access.choose') }}
                                </option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-default btn-success refresh">{{trans('app.reset')}}</button>
                        </td>
                    </tr>
                    </tfoot>-->
                </table>
            </div>
        </div>
        <div id="role-permission" class="tab-pane fade in ">
            <div class="row-fluid">
                <button style="margin:16px;" class="btn btn-default btn-success pull-left  add-permission-role">{{ trans('access.set_access_role') }}</button>
                <table width="100%" id="permissionRoleGrid" class="table col-xs-12 table-striped table-bordered dt-responsive nowrap display">
                    <thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <select name="permission_search" style="margin-right: 10px;">
                                <option value="-1">
                                    {{ trans('access.choose') }}
                                </option>
                            </select>
                        </td>
                        <td>
                            <select name="role_search" class="pull-right" style="margin-right: 10px;">
                                <option value="-1">
                                    {{ trans('access.choose') }}
                                </option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-default btn-success refresh">{{trans('app.reset')}}</button>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>{{ trans('access.role') }} </th>
                        <th>
                            {{ trans('access.access') }}
                        </th>
                        <th>
                            {{ trans('access.role') }}
                        </th>
                        <th>{{ trans('access.action') }}</th>
                    </tr>
                    </thead>
<!--
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <select name="permission_search" style="margin-right: 10px;">
                                <option value="-1">
                                    {{ trans('access.choose') }}
                                </option>
                            </select>
                        </td>
                        <td>
                            <select name="role_search" class="pull-right" style="margin-right: 10px;">
                                <option value="-1">
                                    {{ trans('access.choose') }}
                                </option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-default btn-success refresh">{{trans('app.reset')}}</button>
                        </td>
                    </tr>
                    </tfoot>
-->
                </table>
            </div>
        </div>
        <div id="role-permission-edit" class="tab-pane fade in ">
            <div class="col-md-12" style="margin: 5px 2px;">
                <div class="col-md-2">{{trans('access.role')}}</div>
                <div class="col-md-10">
                    <select name="roles" class="pull-right" style="margin-right: 10px;"></select>
                </div>
            </div>
            <div class="col-md-12 permission_list" style="margin: 5px 2px;">
                <div class="col-md-4 fist-row" style="border-right: 3px solid"></div>
                <div class="col-md-4 second-row" style="border-right: 3px solid"></div>
                <div class="col-md-4 third-row" style="border-right: 3px solid"></div>
            </div>
            <div>
                <button type="button" name="saveRolePermission" id="saveRolePermission" value="save" class="btn btn-info pull-left" style="margin: 5px;" type="button">
                    <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                    <span>ذخیره</span>
                </button>
            </div>
            <div class="clearfixed"></div>
        </div>
        <input type="hidden" name="role_id" value=""/>
    </div>
@stop

@section('inline_scripts')
    @include('hamahang.Access.helper.Index.JS.inlineJS')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
