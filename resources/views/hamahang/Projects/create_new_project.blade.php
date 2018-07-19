@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
@stop
@section('content')
    <div class="col-xs-12 row">
        <div class="space-14"></div>
        <fieldset>
            <legend>پروژه</legend>
            <div class="col-xs-12">
                <div id="tab" class="table-bordered">
                    <ul class="nav nav-tabs">
                        <li>
                            <a href="#t1" data-toggle="tab" class="active">تعریف</a>
                        </li>
                        <li>
                            <a href="#t2" data-toggle="tab">دسترسی</a>
                        </li>
                        <li>
                            <a href="#t3" data-toggle="tab">وضعیت</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="t1">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="col-xs-12 table table-striped">
                                        <tr>
                                            <td class="width-120">عنوان</td>
                                            <td>
                                                <input type="text" class="col-xs-4 form-control" id="p_title"/>
                                                <label for="p_type0">رسمی</label><input type="radio" class="" name="p_type" id="p_type0" value="0"/>
                                                <label for="p_type1">غیر رسمی</label><input type="radio" class="" name="p_type" id="p_type1" value="1"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">اهداف بالادستی</td>
                                            <td><input type="text" class="form-control" id="p_top_goals"/></td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">صفحه</td>
                                            <td>
                                                <div class="col-sm-12 row">
                                                    <span id="pages">
                                                        <div class="col-sm-12 row">
                                                            <select class="js-data-example-ajax form-control" id="page_id" name="page_id" multiple></select>
                                                            <span style="position: absolute; left: 20px; top: 10px;" class="glyphicon glyphicon-file"></span>
                                                        </div>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">توضیح</td>
                                            <td><input type="text" class="form-control" id="p_desc"/></td>
                                        </tr>
                                        <tr>
                                            <td>مدیر پروژه</td>
                                            <td>
                                                <div class="col-xs-5">
                                                    <div class="col-sm-12 row">
                                                        <select name="p_responsible[]" id="p_responsible" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                            <option value=""></option>
                                                        </select>
                                                        <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-2">واحد سازمانی</div>
                                                <div>
                                                    <div class="col-sm-5 row">
                                                        <select name="p_org_unit[]" id="p_org_unit" class="select2_auto_complete_org_unit col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                            <option value=""></option>
                                                        </select>
                                                        <span style="position: absolute; left: 20px; top: 10px;" class="fa fa-sitemap"></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>زمانبندی بر اساس</td>
                                            <td>
                                                <select id="p_schedule_on" class="form-control col-xs-4">
                                                    <optgroup label="انتخاب کنید">
                                                        <option value="1">تاریخ شروع پروژه</option>
                                                        <option value="2">تاریخ پایان پروژه</option>
                                                    </optgroup>
                                                </select>
                                                <span id="schedule_massage" style="color-rendering: gray"></span>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="col-xs-12 table table-striped">
                                        <tr>
                                            <td class="width-120">تاریخ آغاز</td>
                                            <td>
                                                <div>
                                                    <div class="input-group pull-right">
                                                        <span class="input-group-addon" id="respite_date">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" class="form-control DatePicker" id="start_date" name="start_date"
                                                               aria-describedby="respite_date">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="width-120">تاریخ پایان</td>
                                            <td>
                                                <div class="input-group pull-right">
                                                    <span class="input-group-addon" id="respite_date">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                    <input type="text" class="form-control DatePicker" name="end_date" id="end_date" aria-describedby="respite_date">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">تاریخ جاری</td>
                                            <td>
                                                <div class="input-group pull-right">
                                                    <span class="input-group-addon" id="respite_date">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                    <input type="text" class="form-control DatePicker" name="current_date" id="current_date" aria-describedby="respite_date">
                                                </div>
                                            </td>
                                            <td class="width-120">تاریخ وضعیت</td>
                                            <td>
                                                <div class="input-group pull-right">
                                                    <span class="input-group-addon" id="respite_date">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                    <input type="text" class="form-control DatePicker" name="state_date" id="state_date" aria-describedby="respite_date">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width-120"><h6>تقویم پایه</h6></td>
                                            <td>
                                                <select class="form-control" id="base_calendar">
                                                    <option value="">انتخاب کنید ...</option>
                                                    @foreach($calendars as $calendar)
                                                        <option value="{{ $calendar->id }}">{{ $calendar->title }}</option>
                                                    @endforeach

                                                </select>
                                            </td>
                                            <td class="width-120">اولویت</td>
                                            <td><input type="text" class="form-control col-xs-4" id="p_priority"/></td>
                                        </tr>
                                        <tr>
                                            <td class="width-120">
                                                <label class="line-height-35">کلیدواژه ها</label>
                                            </td>
                                            <td colspan="7">
                                                <div class="row-fluid">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-25">
                                                        <div class="form-inline">
                                                            <div class="col-xs-12 row">
                                                                <select class="select2_auto_complete_keywords " name="p_keyword[]" data-placeholder="{{trans('tasks.select_some_keywords')}}" multiple="multiple"></select>
                                                                <span class="Chosen-LeftIcon"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="clearfixed"></div>
                            </div>
                        </div>
                        <div class="tab-pane" style="padding-top: 8px" id="t2">
                            <table class="table table-default">
                                <tr>
                                    <td class="col-xs-2">
                                        <h6>دسترسی ویرایش</h6>
                                    </td>
                                    <td class="col-xs-3">
                                        <input type="radio" value="all" id="ModifyPermissionType1" name="ModifyPermissionType" onclick="CheckType()"/><label>همه کاربران</label>
                                        <input type="radio" value="some" id="ModifyPermissionType2" name="ModifyPermissionType" onclick="CheckType()"/><label>کاربران مجاز </label>
                                    </td>
                                    <td class="col-xs-7">
                                        <div class="col-sm-7 row">
                                            <select id="ModifyPermissionUsers"
                                                    name="ModifyPermissionUsers[]"
                                                    class="chosen-rtl col-xs-12 "
                                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                <option value=""></option>
                                            </select>
                                            <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-default">
                                <tr>
                                    <td class="col-xs-2">
                                        <h6>دسترسی مشاهده</h6>
                                    </td>
                                    <td class="col-xs-3">
                                        <input type="radio" value="all" id="ObservationPermissionType1" name="ObservationPermissionType" onclick="CheckType()"/><label>همه کاربران</label>
                                        <input type="radio" value="some" id="ObservationPermissionType2" name="ObservationPermissionType" onclick="CheckType()"/><label>کاربران مجاز </label>
                                    </td>
                                    <td class="col-xs-7">
                                        <div class="col-sm-7 row">
                                            <select id="ObservationPermissionUsers"
                                                    name="ObservationPermissionUsers[]"
                                                    class="chosen-rtl col-xs-12 "
                                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                <option value=""></option>
                                            </select>
                                            <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane" style="padding-top: 8px" id="t3">
                            <table class="table table-bordered" style="text-align: center;">
                                <thead>
                                <th></th>
                                <th>شروع</th>
                                <th>پایان</th>
                                <th>مدت</th>
                                <th>ساعت کار</th>
                                <th>هزینه</th>
                                </thead>
                                <tr>
                                    <td>خط مبنا</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>واقعی</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>پیشرفت</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>باقیمانده</td>
                                    <td colspan="2"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>وضعیت</td>
                                    <td colspan="2"></td>
                                    <td><span style="background-color: red">بحرانی</span></td>
                                    <td></td>
                                    <td><span style="background-color: yellow">هشدار</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="col-xs-12">
                    <div class="pull-left">
                        <input type="radio" name="save_type" value="11"/>
                        <label>پیش نویس</label>
                        <input type="radio" name="save_type" value="22"/>
                        <label>نهایی</label>
                        <a class="btn btn-info">تایید و ثبت پروژه جدید</a>
                        <a class="btn btn-info" onclick="CheckForm()">تایید</a>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="clearfixed"></div>
    <div class="space-32"></div>
    <div class="modal fade" id="confirm_modal" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:red;" id="confirm_modal_title">خطا</h4>
                </div>
                <div class="modal-body">
                    <span id="confirm_modal_massage">آیا از حذف این بسته کاری اطمینان دارید ؟</span>
                </div>
                <div class="modal-footer">
                    <span style="text-align: center" id="">
                        <a class="btn btn-default" onclick="close_modal()">تایید</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
@stop

@section('inline_scripts')
    @include('hamahang.Projects.helper.inline_js_create_new_project')
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop