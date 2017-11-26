<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
<div class="row">
    <div class="col-xs-12">
        <div class="space-14"></div>
        <div class="col-xs-12">
            <div id="tab" class="table-bordered">
                <ul class="nav nav-tabs">
                    <li>
                           <a href="#t1" data-toggle="tab" class="active">تعریف</a>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="col-xs-12 table table-striped">
                            <tr>
                                <td class="width-120">عنوان</td>
                                <td>
                                    <input type="text" class="col-xs-4 form-control" id="p_title"/>
                                    <input type="radio" class="" name="p_type" value="0"/><label>رسمی</label>
                                    <input type="radio" class="" name="p_type" value="1"/><label>غیر رسمی</label>
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
                                            <input type="text" class="form-control DatePicker" id="start_date" name="start_date" aria-describedby="respite_date">
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
                                                    <select class="select2_auto_complete_keywords " name="p_keyword[]" data-placeholder="{{trans('tasks.can_select_some_options')}}" multiple="multiple"></select>
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
        </div>
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
                    <span id="confirm_modal_massage"></span>
                </div>
                <div class="modal-footer">
                    <span style="text-align: center" id="">
                        <a class="btn btn-default" onclick="close_modal()">تایید</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>

@include('hamahang.Projects.helper.inline_js_create_new_project')