@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop

@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <div id="sucsessMsg"></div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#menusManagment" data-toggle="tab">{{ trans('menus.manage_menus') }}</a></li>
                <li><a href="#menutypeManagement" data-toggle="tab">{{ trans('menus.manage_all_kinds_of_menu') }}</a></li>
                <li><a href="#menuRoleAcces" data-toggle="tab">{{ trans('menus.manage_access_menu_role') }}</a></li>
                <li><a href="#menuUserAccess" data-toggle="tab">{{ trans('menus.manage_access_menu_and_users') }}</a></li>
            </ul>
            <div class="tab-content">
                <div class="col-xs-12 tab-pane fade in active default-options" id="menusManagment">

                    <div class="row">
                        <div class="space-10"></div>

                        <table id="menusGrid" class="table table-striped table-bordered dt-responsive nowrap display">
                            <thead>
                            <tr>
                                <th>{{ trans('app.id') }}</th>
                                <th><input name="select_all" value="1" type="checkbox"></th>
                                <th>{{ trans('app.title') }}</th>
                                <th>{{ trans('menus.order') }}</th>
                                <th>{{ trans('menus.menu_type') }}</th>
                                <th>{{ trans('menus.menu_type_id') }}</th>
                                <th>{{ trans('menus.is_parent') }}</th>
                                <th>{{ trans('menus.is_parent_id') }}</th>

                                <th>{{ trans('app.action') }}</th>

                            </tr>
                            </thead>
                            <tfoot>
                            <tr>


                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="2">
                                    <select name="menu_type_search" style="margin-right: 10px;">
                                        <option value="-1">{{ trans('menus.choose_a_menu') }}</option>
                                    </select>
                                </td>
                                <td colspan="2">
                                    <select name="parent_id_search" class="pull-right" style="margin-right: 10px;">


                                    </select>
                                    <butto class="btn btn-default btn-info menu_refresh">{{ trans('menus.resetting') }}</butto>
                                </td>
                                <td>

                                </td>


                            </tr>
                            </tfoot>
                        </table>
                        <div style="margin: 5px 0px ;font-weight: 800;"> {{ trans('menus.add_permission') }}</div>
                        <table class="col-md-12 table" id="add-collection-menus">
                            <tr>
                                <td class="col-md-1">{{trans('menus.role')}}</td>
                                <td class="col-md-4">
                                    <select name="roles">

                                    </select>
                                </td>
                                <td class="col-md-1">{{trans('menus.user')}}</td>
                                <td class="col-md-4">
                                    <select name="users">

                                    </select>
                                </td>
                                <td class="col-md-2">
                                    <button class="btn btn-default btn-xs btn-success pull-left add-menu-access">
                                        <i ></i>
                                        اضافه نمودن
                                    </button>
                                </td>
                            </tr>
                        </table>
                        @include('hamahang.Menus.helper.Index.modals.modal_add_menu')

                    </div>
                </div>
                <div class="col-xs-12 tab-pane fade in  default-options" id="menutypeManagement">
                    <div id="menTypeMsg"></div>
                    <div>
                        <form id="menyTypeForm" class="col-xs-12 tab-pane fade in active default-options">


                            <div  style="margin-bottom: 4px" class="  col-xs-12">

                                    <div class="col-xs-2">{{ trans('app.title') }}</div>
                                    <div class="col-xs-7"><input type="text" class="form-control col-xs-8" name="title"></div>

                                    <div class=" mtype_btn col-xs-3">
                                        <button type="button" id="add-menu-type" value="save" class="btn btn-info pull-left" type="button">
                                            <i class="glyphicon  glyphicon-save-file bigger-125 pull-left"></i>
                                            <span>{{ trans('app.register') }}</span>
                                        </button>
                                    </div>
                                <div class="clearfixed"></div>
                                <hr class="hr-2">

                            </div>
                            <input type="hidden" name="edit_id" value="0"/>
                        </form>
                    </div>
                    <div>
                        <table id="menuTypesGrid" width="100%" class="table table-striped table-bordered dt-responsive nowrap display">
                            <thead>
                            <tr>
                                <th>{{ trans('app.id') }}</th>
                                <th>{{ trans('app.title') }}</th>
                                <th>{{ trans('app.action') }}</th>
                            </tr>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xs-12 tab-pane fade in  default-options" id="menuRoleAcces">
                    <div id="menRoleMsg"></div>
                    <div>
                        <form id="menuRoleForm" class="col-xs-12 tab-pane fade in active default-options">


                            <div class=" col-xs-12">

                                <div class="col-xs-1">{{ trans('menus.menu') }}</div>
                                <div class="col-xs-4"><select name="menus">
                                        <option value="-1">{{ trans('menus.choose_a_menu') }}</option>
                                    </select></div>

                                <div class="col-xs-1">{{ trans('menus.role') }})</div>
                                <div class="col-xs-3"><select name="roles">
                                        <option value="-1">{{ trans('menus.choose_a_role') }}</option>
                                    </select></div>

                                <div class="col-xs-3 btn_holder">
                                    <button type="button" id="add-menu-role" value="save" class="btn btn-info pull-left" type="button">
                                        <i class="glyphicon  glyphicon-save-file bigger-125 pull-left"></i>
                                        <span>{{ trans('app.register') }}</span>
                                    </button>
                                </div>

                            </div>
                            <input type="hidden" name="edit_id" value="0"/>
                        </form>
                    </div>
                    <hr class="hr-2">

                    <table id="menuRolesGrid" width="100%" class="table table-striped table-bordered dt-responsive nowrap display">
                        <thead>
                        <tr>
                            <th>{{ trans('app.id') }}</th>
                            <th></th>
                            <th></th>
                            <th>{{ trans('menus.menu') }}</th>
                            <th>{{ trans('app.role') }}</th>
                            <th>{{ trans('app.action') }}</th>
                        </tr>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="col-xs-12 tab-pane fade in  default-options" id="menuUserAccess">
                    <div id="menuUserMsg"></div>
                    <div>
                        <form id="menuUserForm" class="col-xs-12 tab-pane fade in active default-options">


                            <div class=" col-xs-12">

                                <div class="col-xs-1"> {{ trans('menus.menu') }}</div>
                                <div class="col-xs-4"><select name="menus">
                                        <option value="-1">{{ trans('menus.choose_a_menu') }}</option>
                                    </select></div>
                                <div class="col-xs-1"> {{ trans('app.user') }}</div>
                                <div class="col-xs-3"><select name="users">

                                    </select></div>

                                <div class="btn_holder">
                                    <button type="button" id="add-menu-user" value="save" class="btn btn-info pull-left" type="button">
                                        <i class="glyphicon  glyphicon-save-file bigger-125 pull-left"></i>
                                        <span>{{ trans('app.register') }}</span>
                                    </button>
                                </div>

                            </div>
                            <input type="hidden" name="edit_id" value="0"/>
                        </form>
                        <hr class="hr-2">
                    </div>

                    <table id="menuUsersGrid" width="100%" class="table table-striped table-bordered dt-responsive nowrap display">
                        <thead>
                        <tr>
                            <th>{{ trans('app.id') }}</th>
                            <th></th>
                            <th></th>
                            <th>{{ trans('menus.menu') }}</th>
                            <th>{{ trans('menus.user') }}</th>
                            <th>{{ trans('app.action') }}</th>
                        </tr>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="clearfixed"></div>
    </div>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::asset('assets/Packages/DataTables/datatables.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    {!! $HFM_CalendarEvent['JavaScripts'] !!}
@stop

@section('inline_scripts')
    @include('hamahang.Menus.helper.Index.JS.inlinJS')
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
