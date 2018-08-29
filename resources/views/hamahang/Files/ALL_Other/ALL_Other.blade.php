@extends('layouts.master')
@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <div class="row">
                <div class="space-10"></div>
                <div id="alert_subject"></div>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#pages" data-toggle="tab">{{trans('page_access.pages')}}</a></li>
                    <li><a href="#pages_access" data-toggle="tab">{{trans('page_access.total_access')}}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="col-xs-12 tab-pane fade in active default-options" id="pages">
                        <table id="fileCreated_ME_RecieveGrid" class="table dt-responsive nowrap display text-center" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>عنوان</th>
                                <th>نوع</th>
                                <th>بازدید</th>
                                <th>پسند</th>
                                <th>دنبال</th>
                                <th>ثبت</th>
                                <th>آخرین ویرایش</th>
                                <th>ویرایش دسترسی</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-xs-12 tab-pane fade in default-options" id="pages_access">
                        <div class="space-10"></div>
                        <div class="attach_loader"></div>
                        <form id="subjects_roles_form">
                            <table class="table dt-responsive nowrap display text-center">
                                <tr>
                                    <td class="col-md-1">
                                        <label>{{trans('page_access.add_role')}}</label>
                                    </td>
                                    <td class="col-md-3 btn_holder" style="vertical-align: middle">
                                        <select id="roles_list" class="select" name="role_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>
                                    </td>
                                    <td class="col-md-3 btn_holder" style="vertical-align: middle">
                                        <button type="button" id="add_subjects_roles_view" value="save" class="btn btn-primary">
                                            <span>{{trans('page_access.add_show_permission')}}</span>
                                        </button>
                                        <button type="button" id="add_subjects_roles_edit" value="save" class="btn btn-primary">
                                            <span>{{trans('page_access.add_edit_permission')}}</span>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <div class="space-10"></div>
                        <div class="detach_loader"></div>
                        <form id="subjects_roles_form_detach">
                            <table class="table dt-responsive nowrap display text-center">
                                <tr>
                                    <td class="col-md-1">
                                        <label>{{trans('page_access.remove_role')}}</label>
                                    </td>
                                    <td class="col-md-3 btn_holder" style="vertical-align: middle">
                                        <select id="detach_roles_list" class="select" name="role_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>
                                    </td>
                                    <td class="col-md-3 btn_holder" style="vertical-align: middle">
                                        <button type="button" id="delete_subjects_roles_view" value="save" class="btn btn-primary">
                                            <span>{{trans('page_access.delete_show_permission')}}</span>
                                        </button>
                                        <button type="button" id="delete_subjects_roles_edit" value="save" class="btn btn-primary">
                                            <span>{{trans('page_access.delete_edit_permission')}}</span>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfixed"></div>

    <div id="subject_role_loader_modal" class="role_modal fade hide" role="dialog">
        <div class="role_modal-dialog">



        </div>
    </div>
@stop

@section('inline_scripts')
    @include('hamahang.Files.ALL_Other.helper.ALL_Other_inline_js')
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
