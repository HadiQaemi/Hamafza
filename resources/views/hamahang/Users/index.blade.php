@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    {{--<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">--}}
@stop
@section('content')
    <div id="info_msg_area"></div>
    <div id="error_msg_area"></div>
    <div id="success_msg_area"></div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-white">

                <div class="panel-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-highlight" id="manage">
                            <li class="active">
                                <a href="#manage_tab" data-toggle="tab" class="legitRipple manage_tab_click" aria-expanded="true">
                                    <span class=""></span><span style="padding-right:10px">کاربران</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#add_tab" data-toggle="tab" class="legitRipple add_tab_click" aria-expanded="false">
                                    <span class=""></span><span style="padding-right:10px">افزودن کاربر</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#edit_tab" data-toggle="tab" class="legitRipple edit_tab_click" aria-expanded="false">
                                    <span class=""></span><span style="padding-right:10px">ویرایش کاربر</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="manage_tab">
                                <div class="space-4"></div>
                                <div class="row">
                                    <div id="error_msg_destroy_user"></div>
                                    <div id="success_msg_destroy_user"></div>
                                </div>
                                <div class="row" >

                                </div>
                                <div class="row" style="position: relative">
                                    <div id="filter_role" style="z-index: 9;position: absolute;left: 0px;width: 40%;top: 18px;min-height: 5px;">
                                        <div class="form-group">
                                            <div class="col-xs-10" style="padding: 0px">
                                                <select name="roles_filter[]" multiple="multiple" class="form-control roles_filter "></select>
                                            </div>
                                            <div class="col-xs-2">
                                                <a href="#" class="select_filter">
                                                    <i style="font-size: 17px;" class="fa fa-filter">

                                                    </i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <table class=" table table-condensed table-bordered table-striped table-hover GridDataUser" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ردیف</th>
                                            <th>نام و نام خانوادگی</th>
                                            <th>نام کاربری</th>
                                            <th>نقش</th>
                                            <th>تاریخ عضویت</th>
                                            <th>امتیاز</th>
                                            <th>وضعیت</th>
                                            <th>عملیات</th>
                                        </tr>
                                        </thead>
                                    </table>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="add_tab">
                                <div class="row">
                                    <form id="form_created_new" class="form-horizontal" action="#">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-2">
                                                    <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> نام : </label>
                                                </td>
                                                <td class="col-xs-10">
                                                    <input id="Name" name="Name" type="text" class="form-control"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-xs-2">
                                                    <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> نام خانوادگی : </label>
                                                </td>
                                                <td class="col-xs-10">
                                                    <input id="Family" name="Family" type="text" class="form-control"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-xs-2">
                                                    <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> نام کاربری : </label>
                                                </td>
                                                <td class="col-xs-10">
                                                    <input id="Uname" name="Uname" type="text" class="form-control"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-xs-2">
                                                    <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> رمز ورود : </label>
                                                </td>
                                                <td class="col-xs-10">
                                                    <input id="password" name="password" type="password" class="form-control"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-xs-2">
                                                    <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i>تکرار رمز ورود : </label>
                                                </td>
                                                <td class="col-xs-10">
                                                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-xs-2">
                                                    <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i>ادرس ایمیل : </label>
                                                </td>
                                                <td class="col-xs-9">
                                                    <div class="col-xs-8" style="padding-right: 0px;">
                                                        <input id="Email" name="Email" type="text" class="form-control"/>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <input id="Email_confirmed" name="Email_confirmed" type="checkbox"/>
                                                        <label class="control-label"></i>ایمیل تایید شده است  </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="col-xs-12">
                                                    <span style="color: blue; font-size: 14px;">اختصاص کاربر به نقش: </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-xs-2">
                                                    <label class="control-label">{{trans('menus.add_role')}}</label>
                                                </td>
                                                <td class="col-xs-10">
                                                    <select name="roles_list[]" multiple="multiple" class="form-control roles_list"></select>
                                                </td>
                                            </tr>
                                        </table>
                                       
                                        <div class="text-left">
                                            <button id="form_created_new_btn" type="button" class="btn btn-primary submit_form_btn">
                                                <i class=""></i> {{trans('acl.submit_add')}}
                                            </button>
                                        </div>
                                        <div class="text-right">
                                            <div class="col-xs-10">
                                                <div id="error_msg_add_user"></div>
                                                <div id="success_msg_add_user"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="edit_tab">
                                <div class="space-10"></div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <form id="form_edit_item" class="form-horizontal" action="#">
                                            <input id="item_id" type="hidden" name="item_id" value="">
                                            <table class="table col-xs-12">
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> نام : </label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <input id="Name_edit" name="Name" type="text" class="form-control"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> نام خانوادگی : </label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <input id="Family_edit" name="Family" type="text" class="form-control"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> نام کاربری : </label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <input id="Uname_edit" name="Uname" type="text" class="form-control"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> رمز ورود : </label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <input id="password_edit" name="password" type="password" class="form-control"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i>تکرار رمز ورود : </label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <input id="password__edit_reply" name="password_confirmation" type="password" class="form-control"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i>ادرس ایمیل : </label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <input id="Email_edit" name="Email" type="text" class="form-control"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="col-xs-12">
                                                        <span style="color: blue; font-size: 14px;">اختصاص کاربر به نقش: </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-xs-2">
                                                        <label class="control-label">{{trans('menus.add_role')}}</label>
                                                    </td>
                                                    <td class="col-xs-10">
                                                        <select name="roles_list[]" multiple="multiple" class="form-control roles_list_edit"></select>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="text-left">
                                                <button id="form_edit_btn" type="button" class="btn btn-primary submit_form_btn">
                                                    <i class=""></i> ویرایش
                                                </button>
                                            </div>
                                            <div class="text-right">
                                                <div class="col-xs-10">
                                                    <div id="error_msg_edit_user"></div>
                                                    <div id="success_msg_edit_user"></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal content-->

    <div class="modal fade" id="destroy-mmodal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" id>
                <div class="modal-header " style="background-color: #9a0808;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="color: #fff;" class="modal-title">حذف کاربر</h4>
                </div>
                <div class="modal-body">
                    <p>آیا از حذف این کاربر اطمینان دارید ؟</p>
                    <input type="text" id="id_record_for_destroy" style="display:none"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                    <button type="button" class="btn btn-info destroy_btn">تایید</button>
                </div>
            </div>

        </div>
    </div>
@stop

@section('inline_scripts')
    @include('hamahang.Users.helper.index_inline_js')
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop

