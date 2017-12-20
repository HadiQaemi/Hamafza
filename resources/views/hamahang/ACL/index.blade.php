@extends('layouts.master')

@section('specific_plugin_style')
{{--    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">--}}
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/js/uniform.min.js')}}"></script>
    {{--<script type="text/javascript" src="{{URL::to('assets/js/form_checkboxes_radios.js.js')}}"></script>--}}
@stop

@section('content')
    <!-- Role and Permissions Add Modal -->
    <div id="modal_add_new_role" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info-300">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">افزودن نقش جدید <span id="modal_add_title"></span></h6>
                </div>

                <div class="modal-body">
                    <form id="form_add_role" class="form-horizontal" action="#" method="post">
                        <table class="table">
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-xs-2">{{trans('auth.name')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_add_name" name="name" type="text" class="form-control">
                                </td>
                                </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-2 control-label">{{trans('acl.display_name')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_add_display_name" name="display_name" type="text" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-2 control-label">{{trans('app.description')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_add_description" name="description" type="text" class="form-control">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">{{ trans('acl.submit_cancel') }}</button>
                    <button type="button" class="btn bg-info-300 btn_add_new_role">{{ trans('acl.submit_add_only') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Role and Permissions Add Modal -->

    <!-- Role and Permissions Add Modal -->
    <div id="modal_add_new_permission" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info-300">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">افزودن مجوز جدید <span id="modal_add_title"></span></h6>
                </div>

                <div class="modal-body">
                    <form id="form_add_permission" class="form-horizontal" action="#" method="post">
                        <table class="table">
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-xs-2">{{trans('auth.name')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_add_name" name="name" type="text" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-2 control-label">{{trans('acl.display_name')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_add_display_name" name="display_name" type="text" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-2 control-label">{{trans('app.description')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_add_description" name="description" type="text" class="form-control">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">{{ trans('acl.submit_cancel') }}</button>
                    <button type="button" class="btn bg-info-300 btn_add_new_permission">{{ trans('acl.submit_add') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Role and Permissions Add Modal -->

    <!-- Category Add Modal -->
    <div id="modal_add_new_category" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info-300">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">افزودن دسته‌بندی مجوز جدید <span id="modal_add_title"></span></h6>
                </div>
                <div class="modal-body">
                    <form id="form_add_category" class="form-horizontal" action="#" method="post">
                        <div class="row">
                            <table class="table">
                                <tr>
                                    <td class="col-xs-2">
                                        <span class="col-lg-3 control-label">{{trans('acl.parent')}}</span>
                                    </td>
                                    <td class="col-xs-10">
                                        <select id="" class="select modal_parent_list" name="parent_id">
                                            <option value="0">{{trans('acl.no_parent')}}</option>
                                            {{--@foreach($cats as $cat)--}}
                                                {{--<option value="{{ $cat->id }}">{{ $cat->title }}</option>--}}
                                            {{--@endforeach--}}
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <span class="col-lg-3 control-label">{{trans('app.title')}}</span>
                                    </td>
                                    <td class="col-xs-10">
                                        <input id="modal_add_" name="title" type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <span class="col-lg-3 control-label">{{trans('app.description')}}</span>
                                    </td>
                                    <td class="col-xs-10">
                                        <input id="modal_add_description" name="description" type="text" class="form-control">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">{{ trans('acl.submit_cancel') }}</button>
                    <button type="button" class="btn bg-info-300 btn_add_new_category">{{ trans('acl.submit_add') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Category Add Modal -->

    <!-- Role Edit Modal -->
    <div id="modal_edit_role" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning-300">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title"> ویرایش نقش <span id="modal_edit_role_title"></span></h6>
                </div>
                <div class="modal-body">
                    <form id="form_edit_role" class="form-horizontal" action="#" method="post">
                        <input id="edit_form_role_id" type="hidden" name="item_id" value="">
                        <table class="table">
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-3 control-label">{{trans('auth.name')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_edit_role_name" name="name" type="text" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-3 control-label">{{trans('acl.display_name')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_edit_role_display_name" name="display_name" type="text" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-3 control-label">{{trans('app.description')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_edit_role_description" name="description" type="text" class="form-control">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">{{ trans('acl.submit_cancel') }}</button>
                    <button type="button" class="btn bg-warning-300 btn_edit_role">{{ trans('acl.submit_edit') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Role Edit Modal -->

    <!-- Permissions Edit Modal -->
    <div id="modal_edit_permission" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning-300">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title"> ویرایش نقش <span id="modal_edit_role_title"></span></h6>
                </div>
                <div class="modal-body">
                    <form id="form_edit_permission" class="form-horizontal" action="#" method="post">
                        <input id="edit_form_permission_id" type="hidden" name="item_id" value="">
                        <table class="table">
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-3 control-label">{{trans('auth.name')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_edit_permission_name" name="name" type="text" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-3 control-label">{{trans('acl.display_name')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_edit_permission_display_name" name="display_name" type="text" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-3 control-label">{{trans('app.description')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_edit_permission_description" name="description" type="text" class="form-control">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">{{ trans('acl.submit_cancel') }}</button>
                    <button type="button" class="btn bg-warning-300 btn_edit_permission">{{ trans('acl.submit_edit') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Permissions Edit Modal -->

    <!-- Category Edit Modal -->
    <div id="modal_edit_cat_item" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning-300">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title modal_edit_cat_title">ویرایش دسته‌بندی <span id=""></span></h6>
                </div>
                <div class="modal-body">
                    <form id="form_edit_cat_item" class="form-horizontal" action="#" method="post">
                        <input id="edit_cat_id" type="hidden" name="item_id" value="">
                        <table class="table">
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-3 control-label">{{trans('acl.parent')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <select id="" class="select modal_parent_list" name="parent_id">
                                        <option value="0">{{trans('acl.no_parent')}}</option>
                                        {{--@foreach($cats as $cat)--}}
                                        {{--<option value="{{ $cat->id }}">{{ $cat->title }}</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-3 control-label">{{trans('app.title')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="" name="title" type="text" class="form-control modal_edit_cat_title">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <span class="col-lg-3 control-label">{{trans('app.description')}}</span>
                                </td>
                                <td class="col-xs-10">
                                    <input id="modal_edit_cat_description" name="description" type="text" class="form-control">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">{{ trans('acl.submit_cancel') }}</button>
                    <button type="button" class="btn bg-warning-300 btn_edit_cat_item">{{ trans('acl.submit_edit') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Category Edit Modal -->

    <!-- Manage Role User Modal -->
    <div id="modal_manage_role_users" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info-400">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title modal_manage_cat_title">کاربران - با نقش: <span id="modal_manage_role_users_role_title"></span></h6>
                </div>
                <div class="modal-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-highlight" id="manage_role_users">
                            <li class="active">
                                <a href="#users_list_tab" data-toggle="tab" class="legitRipple" aria-expanded="true">
                                    <span class=""></span>
                                    {{trans('acl.users_list')}}
                                </a>
                            </li>
                            <li class="">
                                <a href="#add_user_role_tab" data-toggle="tab" class="legitRipple" aria-expanded="false">
                                    <span ></span>
                                    {{trans('acl.add_user_to_role')}}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="users_list_tab">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table id="roleUserGrid" class="table" width="100%">
                                            <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>{{trans('access.id')}}</th>
                                                <th>{{trans('app.user_name')}}</th>
                                                <th>{{trans('app.name')}}</th>
                                                <th>{{trans('app.family')}}</th>
                                                <th>{{trans('auth.email')}}</th>
                                                <th>{{trans('app.reg_date')}}</th>
                                                <th>{{trans('app.action')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="add_user_role_tab">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <form id="form_add_role_user" class="form-horizontal" action="#" method="post">
                                            <input id="attach_role_users" type="hidden" name="item_id" value="">
                                            <table class="table">

                                                <tr>
                                                    <td class="col-xs-2">
                                                        <span class="col-lg-3 control-label">{{trans('tools.users')}}</span>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <select name="user_edits[]" data-placeholder="{{ trans('acl.select_user') }}" multiple="multiple" class="modal_users_list" class="select-size-xs">
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                    <div class="text-left">
                                        <button data-form_id="form_created_new" type="button" class="btn bg-grey-300 cancel_modal_manage_role_users">{{trans('acl.submit_cancel')}} </button>
                                        <button data-form_id="form_created_new" type="button" class="btn btn-primary add_user_to_role_btn"> {{trans('acl.submit_add')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-link" data-dismiss="modal">{{ trans('acl.submit_cancel') }}</button>--}}
                    {{--<button type="button" class="btn bg-warning-300 btn_edit_cat_item">{{ trans('acl.submit_edit') }}</button>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- Manage Role User Modal -->

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-highlight" id="manage_tab_pane">
                            <li class="active">
                                <a href="#roles_tab" data-toggle="tab" class="legitRipple roles_tab" aria-expanded="true">
                                    <span class=""></span>
                                    {{trans('acl.manage_roles')}}
                                </a>
                            </li>
                            <li class="">
                                <a href="#permissions_tab" data-toggle="tab" class="legitRipple permissions_tab" aria-expanded="false">
                                    <span class=""></span>
                                    {{trans('acl.manage_permissions')}}
                                </a>
                            </li>
                            <li class="">
                                <a href="#acl_cats_tab" data-toggle="tab" class="legitRipple acl_cats_tab" aria-expanded="false">
                                    <span class=""></span>
                                    {{trans('acl.manage_permissions_categories')}}
                                </a>
                            </li>
                            <li class="">
                                <a href="#acl_user_permissions_tab" data-toggle="tab" class="legitRipple acl_user_permissions_tab" aria-expanded="false">
                                    <span class=""></span>
                                    {{trans('acl.manage_users_permissions')}}
                                </a>
                            </li>
                            {{--<li class="">--}}
                            {{--<a href="#acl_cats_manage_tab_pan" data-toggle="tab" id="acl_cats_manage_tab" class="legitRipple" aria-expanded="false">--}}
                            {{--<span class="fa fa-list-alt"></span>--}}
                            {{--{{trans('backend.manage_permissions_categories_manage')}}--}}
                            {{--</a>--}}
                            {{--</li>--}}
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="roles_tab">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table id="Roles_Grid" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{trans('access.row')}}</th>
                                                <th>{{trans('auth.name')}}</th>
                                                <th>{{trans('acl.display_name')}}</th>
                                                <th>{{trans('acl.users_count')}}</th>
                                                <th>{{trans('acl.permissions_count')}}</th>
                                                <th>{{trans('app.action')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="permissions_tab">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table id="Permissions_Grid" class="table table-bordered table-striped" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{trans('access.row')}}</th>
                                                <th>{{trans('auth.name')}}</th>
                                                <th>{{trans('acl.display_name')}}</th>
                                                <th>{{trans('app.action')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="acl_cats_tab">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table id="Categories_Grid" class="table table-bordered table-striped" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{trans('access.row')}}</th>
                                                <th>{{trans('app.title')}}</th>
                                                <th>{{trans('app.description')}}</th>
                                                <th>{{trans('acl.parent')}}</th>
                                                <th>{{trans('app.action')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="acl_cats_manage_tab_pan">
                                <div class="row">
                                    <div class="col-xs-12" id="role_permissions"></div>
                                </div>
                                <div class="text-left">
                                    <button data-form_id="form_created_new" type="button" class="btn bg-grey-300 cancel_form_btn cancel_role_permissions_form_btn">{{trans('acl.submit_cancel')}} </button>
                                    <button data-form_id="form_created_new" type="button" class="btn btn-primary hide set_role_permissions_form_btn"> {{trans('acl.submit_add')}}</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="acl_user_permissions_tab">
                                <div class="space-10"></div>
                                <div class="row">
                                    <div class="col-xs-12" id="users_permissions">
                                        <form id="form_add_role_user" class="form-horizontal" action="#">
                                            <input id="attach_role_users" type="hidden" name="item_id" value="">
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{trans('acl.find_user')}}</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <select name="users_name" data-placeholder="{{ trans('acl.select_user') }}" class="modal_users_list modal_users_list_user_permission select-size-xs"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12" id="user_permissions"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12" id="list_user_permissions"></div>
                                </div>
                                <div class="text-left">
                                    <button data-form_id="form_created_new" type="button" class="btn bg-grey-300 cancel_form_btn cancel_user_permissions_form_btn">{{trans('acl.submit_cancel')}} </button>
                                    <button data-form_id="form_created_new" type="button" class="btn btn-primary hide set_user_permissions_form_btn"> {{trans('acl.submit_add')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('inline_scripts')
    @include('hamahang.ACL.helper.uac_inline_js')
@stop
@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
