@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('content')
    <div id="info_msg_area"></div>
    <div id="error_msg_area"></div>
    <div id="success_msg_area"></div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-white">
                {{--<div class="panel-heading">--}}
                    {{--<h6 class="panel-title">--}}
                        {{--<a href="{{ route('UGC.desktop.Hamahang.menus.index',['username'=>$username]) }}">{{trans('menus.menus')}}</a>--}}
                        {{--<label style="font-size: 14px;">--}}
                            {{--{{' / ' . $menu->title }}--}}
                        {{--</label>--}}
                    {{--</h6>--}}
                {{--</div>--}}
                <div class="panel-body">
                    @if(Laratrust::can('posts.hamahang.menus.get_menu_items') || Laratrust::can('posts.hamahang.menus.store_menu_item'))
                        <div class="tabbable">
                            <ul class="nav nav-tabs nav-tabs-highlight" id="manage">
                                @permission('posts.hamahang.menus.get_menu_items')
                                <li class="active">
                                    <a href="#manage_tab" data-toggle="tab" class="legitRipple" aria-expanded="true">
                                        <span class=""></span>
                                        {{trans('menus.manage_menu_items')}}
                                    </a>
                                </li>
                                @endpermission

                                @permission('posts.hamahang.menus.store_menu_item')
                                <li class="">
                                    <a href="#add_tab" data-toggle="tab" class="legitRipple" aria-expanded="false">
                                        <span ></span>
                                        {{trans('menus.add_a_new_menu_item')}}
                                    </a>
                                </li>
                                @endpermission
                            </ul>
                            <div class="tab-content">
                                @permission('posts.hamahang.menus.get_menu_items')
                                <div class="tab-pane fade active in" id="manage_tab">
                                    <div class="space-4"></div>
                                    <div class="row">
                                        <table class="col-md-6 " style="    position: absolute;left: 0px;top: 74px;">
                                            <tr>
                                                <td class="col-xs-3">
                                                    <label class="">{{trans('menus.select_parent')}}</label>
                                                </td>
                                                <td class="col-xs-8">
                                                    <select id="filter_parent_id" data-placeholder="{{trans('menus.parent')}}" class="form-control select" name="parent">
                                                        <option value="-1">نمایش همه</option>
                                                        <option value="0">نمایش ریشه</option>
                                                        <hr>
                                                        @foreach($menu_items as $menu_item)
                                                            <option value="{{ $menu_item->id }}">{{ $menu_item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="col-xs-1"></td>
                                            </tr>
                                        </table>


                                        <table id="MenuItemsGridData" class=" table table-condensed table-bordered table-striped table-hover" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{trans('access.row')}}</th>
                                                <th>{{trans('menus.order')}}</th>
                                                <th>{{trans('app.title')}}</th>
                                                <th>{{trans('app.description')}}</th>
                                                <th>{{trans('menus.show_status')}}</th>
                                                <th>{{trans('app.action')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                @endpermission
                                <div class="tab-pane fade" id="add_tab">
                                    <div class="row">
                                        <form id="form_created_new" class="form-horizontal" action="#">
                                            <input id="menu_id" type="hidden" name="menu_id" value="{{ $menu->id }}">
                                            {{--                                            <input id="has_route_variables" type="hidden" name="has_route_variables" value="{{ $menu->id }}">--}}
                                            <table class="table col-xs-12">
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label">{{trans('acl.parent')}}</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <select id="parent_list" class="select2 parent_list" name="parent">
                                                            <option value="0">{{trans('acl.no_parent')}}</option>
                                                            @foreach($menu_items as $menu_item)
                                                                <option value="{{ $menu_item->id }}">{{ $menu_item->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label">{{trans('menus.menu_title')}}</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <input name="title" type="text"
                                                               class="form-control"
                                                               placeholder="{{trans('menus.menu_title')}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label">{{trans('menus.menu_description')}}</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <input name="description" type="text"
                                                               class="form-control added_date"
                                                               placeholder="{{trans('menus.menu_description')}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2 link_type">
                                                        <label class=" control-label">{{trans('menus.link_type')}}</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="link_type" value="0" disabled>{{trans('menus.internal')}}<br>
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="link_type" value="1" checked>{{trans('menus.external')}}<br>
                                                        </label>
                                                    </td>
                                                </tr>
                                                {{--<tr class="route_variables">--}}
                                                {{--<td class="col-xs-2">--}}
                                                {{--<label class="control-label">{{trans('menus.route_variables')}}</label>--}}

                                                {{--</td>--}}
                                                {{--<td class="col-xs-10">--}}
                                                {{--<div id="route_variables"></div>--}}
                                                {{--</td>--}}
                                                {{--</tr>--}}
                                                <tr class="route_name_div">
                                                    <td class="col-xs-2">
                                                        <label class="control-label">{{trans('menus.link_address')}}</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <input name="link_address" id="route_name"
                                                               class="form-control link_address" value=""
                                                               placeholder="{{trans('menus.link_address')}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label">{{trans('menus.link_opening_type')}}</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="target" value="_blank" checked>{{trans('menus.open_in_new_window')}}<br>
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="target" value="_self">{{trans('menus.open_in_current_window')}}<br>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label">{{trans('menus.show_status')}}</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <label>
                                                            <input name="status"
                                                                   type="checkbox"
                                                                   class="switchery" checked="checked">
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label">{{trans('menus.icon')}}</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <input name="icon" id=""
                                                               class="form-control" value=""
                                                               placeholder="{{trans('menus.icon')}}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="col-xs-2">
                                                        <span style="color: blue; font-size: 14px;">مجوز ها: </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label">کاربر</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <select name="users_list[]" id="add_new_users_list" multiple="multiple" data-placeholder="{{ trans('menus.select_user') }}" class="select-size-xs users_list"></select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label">نقش</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <select name="roles_list[]" multiple="multiple" class="form-control roles_list"></select>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="text-left">
                                                <button data-form_id="form_created_new" type="button"
                                                        class="btn bg-grey-300 cancel_form_btn">{{trans('acl.submit_cancel')}} </button>
                                                <button data-form_id="form_created_new" type="button"
                                                        class="btn btn-primary submit_form_btn">
                                                    <i ></i> تایید
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="edit_tab">
                                    <div class="space-10"></div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <form id="form_edit_item" class="form-horizontal" action="#" method="post">
                                                <input id="edit_form_item_id" type="hidden" name="item_id" value="">
                                                <input id="edit_menu_id" type="hidden" name="menu_id" value="{{ $menu->id }}">
                                                <table class="table col-xs-12">
                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <label class="control-label">{{trans('acl.parent')}}</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <select id="edit_form_item_parent" class="select2 parent_list" name="parent">
                                                                <option value="0">{{trans('acl.no_parent')}}</option>
                                                                @foreach($menu_items as $menu_item)
                                                                    <option value="{{ $menu_item->id }}">{{ $menu_item->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <label class="control-label">{{trans('menus.menu_title')}}</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <input id="edit_form_item_title" name="title" type="text"
                                                                   class="form-control"
                                                                   placeholder="{{trans('menus.menu_title')}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <label class="control-label">{{trans('menus.menu_description')}}</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <input id="edit_form_item_description" name="description" type="text"
                                                                   class="form-control added_date"
                                                                   placeholder="{{trans('menus.menu_description')}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-xs-2 edit_form_item_link_type">
                                                            <label class=" control-label">{{trans('menus.link_type')}}</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <label class="radio-inline">
                                                                <input type="radio" name="link_type" value="0" disabled>{{trans('menus.internal')}}<br>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="link_type" value="1" checked>{{trans('menus.external')}}<br>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    {{--<tr class="route_variables">--}}
                                                    {{--<td class="col-xs-2">--}}
                                                    {{--<label class="control-label">{{trans('menus.route_variables')}}</label>--}}

                                                    {{--</td>--}}
                                                    {{--<td class="col-xs-10">--}}
                                                    {{--<div id="route_variables"></div>--}}
                                                    {{--</td>--}}
                                                    {{--</tr>--}}
                                                    <tr class="route_name_div">
                                                        <td class="col-xs-2">
                                                            <label class="control-label">{{trans('menus.link_address')}}</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <input name="link_address" id="edit_form_item_url"
                                                                   class="form-control link_address" value=""
                                                                   placeholder="{{trans('menus.link_address')}}" style="direction: ltr;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <label class="control-label">{{trans('menus.link_opening_type')}}</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <label class="edit_radio-inline">
                                                                <input type="radio" id="edit_form_item_blank" name="target" value="_blank">{{trans('menus.open_in_new_window')}}<br>
                                                            </label>
                                                            <label class="edit_radio-inline">
                                                                <input type="radio" id="edit_form_item_self" name="target" value="_self">{{trans('menus.open_in_current_window')}}<br>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <label class="control-label">{{trans('menus.show_status')}}</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <label>
                                                                <input id="edit_form_item_status" name="status"
                                                                       type="checkbox"
                                                                       class="switchery" checked="checked">
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <label class="control-label">{{trans('menus.icon')}}</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <input id="edit_form_item_icon" name="icon"
                                                                   class="form-control" value=""
                                                                   placeholder="{{trans('menus.icon')}}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <span style="color: blue; font-size: 14px;">مجوز ها: </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <label class="control-label">کاربر</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <select name="users_list[]" id="edit_users_list" multiple="multiple" data-placeholder="{{ trans('menus.select_user') }}" class="select-size-xs users_list"></select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <label class="control-label">نقش</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <select name="roles_list[]" multiple="multiple" id="edit_roles_list" class="form-control roles_list"></select>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="text-left">
                                                    <button data-form_id="form_created_new" type="button"
                                                            class="btn bg-grey-300 cancel_form_btn">{{trans('acl.submit_cancel')}} </button>
                                                    <button data-form_id="form_edit_item" type="button"
                                                            class="btn btn-primary submit_form_btn">
                                                        <i ></i> تایید
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="permission_tab">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <form id="form_permission_item" class="form-horizontal" action="#">
                                                <input id="permission_form_item_id" type="hidden" name="item_id" value="">

                                                <span style="color: blue; font-size: 14px;" id="menu_item_name">ثبت مجوزهای: </span>
                                                <table class="table col-xs-12">
                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <label class="control-label">{{trans('menus.add_user')}}</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <select name="users_list[]" id="users_list" multiple="multiple" data-placeholder="{{ trans('menus.select_user') }}" class="select-size-xs users_list"></select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-xs-2">
                                                            <label class="control-label">{{trans('menus.add_role')}}</label>
                                                        </td>
                                                        <td class="col-xs-10">
                                                            <select name="roles_list[]" id="permissions_roles_list" multiple="multiple" class="form-control roles_list"></select>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <div class="text-right">
                                                            <button data-form_id="form_edit_item" type="button" class="btn bg-grey-300 cancel_form_permission_btn">
                                                                {{trans('acl.submit_cancel')}} </button>
                                                            <button data-form_id="form_edit_item" type="button" class="btn btn-primary submit_form_permission_btn">
                                                                <i ></i> {{trans('acl.submit_edit')}}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div style="text-align: center">
                            <span style="color: red;">{{ trans('menus.access_forbidden') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@stop

@section('inline_scripts')
    @include('hamahang.Menus.helper.menu_items_inline_js')
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
