@extends('layouts.master')
@section('specific_plugin_style')
    <!--<link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">-->
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="space-14"></div>
            <fieldset>
                {{--<legend>لیست فرایند ها</legend>--}}
                <div class="col-md-12">

                    <table id="ProcessList" class="table dt-responsive nowrap display dataTable no-footer"
                           style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>عنوان</th>
                            <th>وضعیت</th>
                            <th>موجودیت ها</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </fieldset>
        </div>
        <div class="row">
            <a class="btn btn-primary fa fa-plus jsPanels margin-bottom-30" href="/modals/CreateNewProcess?uid={{Session::get('uid')}}&sid=0" title="{{trans('projects.create_new_project')}}"></a>
        </div>
    </div>

    <div class="modal fade" id="process_details" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">نمایش اطلاعات فرایند : <span id="process_title"></span></h4>
                </div>
                <div class="modal-body">
                    <div id="tab" class="container table-bordered" style="width: 95%">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#t1" data-toggle="tab">اطلاعات</a>
                            </li>
                            <li>
                                <a href="#t2" id="modal_tab_2" data-toggle="tab"> وظایف مرتبط</a>
                            </li>
                            <li><a href="#t3" data-toggle="tab">دسترسی مشاهده</a>
                            </li>
                            <li><a href="#t4" data-toggle="tab">دسترسی ویرایش</a>
                            </li>
                            <li><a href="#t5" id="modal_tab_5" data-toggle="tab">وظیفه جدید</a>
                            </li>
                            <li><a href="#t6" id="modal_tab_6" data-toggle="tab">گزارش</a>
                            </li>
                            <li><a href="#t7" id="modal_tab_7" data-toggle="tab">روابط</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="t1" style="padding-top: 8px">
                                <table class="table table-bordered col-md-12">
                                    <tr>
                                        <td class="col-md-2">
                                            <label for="task_title">عنوان</label>
                                        </td>
                                        <td class="col-md-10">
                                            <input type="text" disabled id="process_title_input"
                                                   name="process_title_input"
                                                   class="form-control"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2">
                                            <label for="">نوع</label>
                                        </td>
                                        <td class="col-md-10">
                                            <span id="process_type"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2">
                                            <label>مسئول</label>
                                        </td>
                                        <td class="col-md-10">
                                            <span id="process_responsibe">

                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2">
                                            <label>صفحه</label>
                                        </td>
                                        <td class="col-md-10">
                                            <select class="select2_pages" id="process_pages" name="process_pages"
                                                    multiple>

                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2">
                                            <label>تعداد مراحل</label>
                                        </td>
                                        <td class="col-md-10">
                                            <span id="levels_count"></span>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2">
                                            <label for="task_title">توضیحات</label>
                                        </td>
                                        <td class="col-md-10">
                                            <span class="form-control" style="" id="description"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2">
                                            <label>کلمات کلیدی</label>
                                        </td>
                                        <td class="col-md-10">
                                            <span id="process_keywords"></span>
                                        </td>
                                    </tr>
                                </table>
                                <div class="row" style="padding-bottom: 3px">
                                    <a class="btn btn-info pull-left" onclick="modify_info()"><span class="">ذخیره تغییرات  <i
                                                    class=""></i></span></a>
                                </div>

                            </div>
                            <div class="tab-pane" id="t2" style="padding-top: 8px">
                                <table class="table col-xs-12">
                                    <tr>
                                        <td class="pull-left">
                                            <a class="cursor-pointer" onclick="CreateNewTask()"><span
                                                        class=""></span>ایجاد وظیفه جدید</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pull-left">
                                           <span id="select_task_window_span">

                                           </span>
                                        </td>
                                    </tr>
                                </table>
                                <table id="ProcessTaskTable"
                                       class="table table-striped table-bordered dt-responsive nowrap display"
                                       style="text-align: center" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">شناسه</th>
                                        <th class="text-center">عنوان</th>
                                        <th class="text-center">مسئول</th>
                                        <th class="text-center">وظایف مرحله بعد</th>
                                        <th class="text-center">عملیات</th>
                                        <th class="text-center">کتابخانه</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane" id="t3">
                                <br/>
                                <table id="user_with_observation_permission"
                                       class="table table-striped table-bordered dt-responsive nowrap display"
                                       style="text-align: center" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">شناسه</th>
                                        <th class="text-center">عنوان</th>
                                        <th class="text-center">کاربران مجاز (مشاهده)</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane" id="t4" style="padding-top: 8px">
                                <table id="user_with_edit_permission"
                                       class="table table-striped table-bordered dt-responsive nowrap display"
                                       style="text-align: center" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">شناسه</th>
                                        <th class="text-center">عنوان</th>
                                        <th class="text-center">کاربران مجاز (ویرایش)</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane" id="t5" style="padding-top: 8px">


                                <!---------------->
                                <div id="tab" class="container table-bordered" style="width: 95%">
                                    <ul class="nav nav-tabs">
                                        <li>
                                            <a href="#tab1" data-toggle="tab" class="active">اطلاعات</a>
                                        </li>
                                        <li><a href="#tab3" data-toggle="tab">ضمائم</a>
                                        </li>


                                        <li style="float: left">
                                            <h5 id="task_type" style="color: blue"></h5>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane active" style="padding-top: 8px" id="tab1">
                                            <form action="{{ route('hamahang.tasks.save_drafts') }}"
                                                  class="" name="task_public" id="task_public" method="post"
                                                  enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <input type="hidden" name="draft" id="draft" value="0"/>
                                                <input type="hidden" name="process_id" id="process_id" value=""/>
                                                <input type="hidden" name="first_m" id="first_m" value="0"/>
                                                <input type="hidden" name="first_u" id="first_u" value="0"/>
                                                <input type="hidden" name="assigner_id" value="125"/>
                                                <input type="hidden" name="current_task_id" id="current_task_id"
                                                       value=""/>
                                                <table class="table table-striped col-xs-12">
                                                    <tr>
                                                        <td class="width-120">
                                                            <label class="line-height-35">عنوان</label>
                                                        </td>
                                                        <td>
                                                            <div class="row-fluid">
                                                                <div class="col-sm-7 row">
                                                                    <input type="text" class="form-control" name="title"
                                                                           id="title"/>
                                                                </div>
                                                                <div class="col-sm-5 line-height-35">
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <input type="radio" name="type" value="0"
                                                                                   checked/>
                                                                            <label for="r1">رسمی</label>
                                                                            <input type="radio" name="type" value="1"/>
                                                                            <label for="r2">غیر رسمی</label>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="width-120">
                                                            <label class="line-height-35">توضیح</label>
                                                        </td>
                                                        <td>
                                                            <div class="row-fluid">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 line-height-35">
                                                                    <input type="text" class="form-control row"
                                                                           name="task_desc" id="desc"/>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="width-120">
                                                            <label class="line-height-35">مهلت انجام</label>
                                                        </td>
                                                        <td>
                                                            <div class="row-fluid">
                                                                <div class="row-fluid">
                                                                    <div class="col-sm-12 col-xs-12 form-inline">
                                                                        <input class="form-control col-xs-1 pull-right"
                                                                               style="width: 55px" name="duration_day"
                                                                               id="duration_day"/>
                                                                        <label class="pull-right">روز</label>
                                                                        <input class="form-control col-xs-1 pull-right"
                                                                               style="width: 55px" name="duration_hour"
                                                                               id="duration_hour" value="00" disabled/>
                                                                        <label class="pull-right">ساعت</label>
                                                                        <input class="form-control col-xs-1 pull-right"
                                                                               style="width: 55px" name="duration_min"
                                                                               id="duration_min" value="00" disabled/>
                                                                        <label class="pull-right">دقیقه</label>
                                                                        <input class="form-control col-xs-1 pull-right"
                                                                               style="width: 55px" name="duration_sec"
                                                                               id="duration_sec" value="00" disabled/>
                                                                        <label class="pull-right">ثانیه</label>
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="width-120">
                                                            <label class="line-height-35">اهمیت / فوریت</label>
                                                        </td>
                                                        <td>
                                                            <div class="row-fluid">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                                                                    <div class="row">
                                                                        <div class="col-xs-6">
                                                                            <label>اهمیت:</label>
                                                                            <span class="input-group"
                                                                                  style="background-color: #eeeeee;">
                                <input type="radio" name="importance" value="1" checked/>
                                <label>مهم</label>
                                <input type="radio" name="importance" value="0"/>
                                <label>غیرمهم</label>
                            </span>
                                                                        </div>
                                                                        <div class="col-xs-6">
                                                                            <label>فوریت:</label>
                                                                            <span class="input-group"
                                                                                  style="background-color: #eeeeee">
                                <input type="radio" name="immediate" value="1"/>
                                <label>فوری</label>
                                <input type="radio" name="immediate" value="0"/>
                                <label>غیرفوری</label>
                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="width-120">
                                                            <label class="line-height-35">مسئول</label>
                                                        </td>
                                                        <td>
                                                            <div class="row-fluid">
                                                                <div class="col-sm-8 row">
                                                    <span id="users">
                                                        <div class="col-sm-12 row">
                                                <select id="p_task_users"
                                                        name="p_task_users[]"
                                                        class="select2_users col-xs-12"
                                                        data-placeholder="{{trans('tasks.select_some_options')}}"
                                                        multiple>
                                                    <option value=""></option>
                                                </select>
                                                <span style="position: absolute; left: 20px; top: 10px;"
                                                      class=""></span>
                                            </div>
                                                    </span>
                                                                </div>
                                                                <div class="col-sm-4 line-height-35">
                                                                    <input type="radio" name="assign_type"
                                                                           id="use_type1" value="1" checked/>
                                                                    <label for="use_type1">جمعی</label>
                                                                    <input type="radio" name="assign_type"
                                                                           id="use_type2" value="2"/>
                                                                    <label for="use_type2">فردی</label>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="width-120">
                                                            <label class="line-height-35">رونوشت به</label>
                                                        </td>
                                                        <td>
                                                            <div class="row-fluid">
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 row">
                                                   <span id="transcripts">

                                                    <span id="">
                                                        <div class="col-sm-12 row">
                                                <select id="p_task_transcripts"
                                                        name="p_task_transcripts[]"
                                                        class="select2_users col-xs-12"
                                                        data-placeholder="{{trans('tasks.select_some_options')}}"
                                                        multiple>
                                                    <option value=""></option>
                                                </select>
                                                <span style="position: absolute; left: 20px; top: 10px;"
                                                      class=""></span>
                                            </div>
                                                    </span>

                                                   </span>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 smaller-90 line-height-35">
                                                                    <input type="checkbox" name="report_on_cr"
                                                                           id="report-type1"/>
                                                                    <label for="">در هنگام ایجاد وظیفه</label>

                                                                    <input type="checkbox" name="report_on_co"
                                                                           id="report-type2"/>
                                                                    <label for="">گزارش پایان وظیفه</label>
                                                                    {{--<input type="checkbox" name="report_to_manager" id="report-type3"/>--}}
                                                                    {{--<label for="">اطلاع به مسئولان</label>--}}
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="width-120">
                                                            <label class="line-height-35">کلیدواژه ها</label>
                                                        </td>
                                                        <td>
                                                            <div class="row-fluid">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-25">
                                                                    <div class="col-xs-12 row">
                                                                        <select class="select2_keywords "
                                                                                id="p_task_keywords"
                                                                                name="p_task_keywords[]"
                                                                                data-placeholder="{{trans('tasks.can_select_some_options')}}"
                                                                                multiple="multiple"></select>
                                                                        <span class="Chosen-LeftIcon"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <div class="row-fluid">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                                                                    <div class="form-inline">
                                                                        {{--<input type="checkbox" class="form-control"--}}
                                                                        {{--name="end_on_assigner_accept"--}}
                                                                        {{--id="end_on_assigner_accept"/>--}}
                                                                        {{--<label for="date">پایان یافتن با تایید واگذار--}}
                                                                        {{--کننده</label>--}}

                                                                        <input type="checkbox" class="form-control"
                                                                               name="transferable" id="transferable"/>
                                                                        <label for="date">امکان واگذاری به فرد
                                                                            دیگر</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                            <span class="pull-left">
                                            <a class="btn btn-default" onclick="CancelModify()">انصراف</a>
                                            <a class="btn btn-info" onclick="save_new_ptask()">ثبت</a>
                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <input type="hidden" id="save_type" name="save_type" value="0"/>

                                            </form>
                                        </div>

                                        <div class="tab-pane" id="tab3">
                                            <div class="row-fluid">
                                                <h5>
                                                    <div class="hr dotted"></div>
                                                </h5>
                                                <div class="row-fluid">
                                                    {{--{!!  $attach_files['Buttons']['new_process_task'] !!}--}}
                                                    {{--{!!  $attach_files['ShowResultArea']['new_process_task'] !!}--}}
                                                    <div class="col-xs-2">
                                                        <a id="" class="btn btn-info pull-left"
                                                           onclick="SaveNewFiles()">
                                                            <i ></i>
                                                            <span>افزودن ضمائم</span>
                                                        </a>
                                                    </div>
                                                    <div class="clearfixed"></div>
                                                </div>
                                                <h1>
                                                    <div class="hr hr-double dotted"></div>
                                                </h1>
                                            </div>
                                            <div class="hr"></div>
                                            <div class="row-fluid">
                                                <table id="draft_files_grid"
                                                       class="table table-striped table-bordered dt-responsive nowrap display"
                                                       style="text-align: center" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">شناسه</th>
                                                        <th class="text-center">عنوان</th>
                                                        <th class="text-center">نوع فایل</th>
                                                        <th class="text-center">حجم فایل</th>
                                                        <th class="text-center">عملیات</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                            <span class="pull-left">
                                            <a class="btn btn-default" onclick="CancelModify()">انصراف</a>
                                            </span>

                                        </div>

                                    </div>
                                </div>

                                <!---------------->


                            </div>
                            <div class="tab-pane" id="t6" style="padding-top: 8px">
                                <table class="table table-stripped">
                                    <tr>
                                        <td>گزارش</td>
                                        <td>

                                            <table class="table" dir="">
                                                <tr>
                                                    <td><span class="">از تاریخ :  </span><input class="form-control"/>
                                                    </td>
                                                    <td>
                                                        <span class="">ساعت :  </span>
                                                        <div class="input-group">
                                                            <input type="text" class="DatePicker form-control "
                                                                   dir="rtl" id="DatePicker" name='respite_date_start'/>
                                                            <span class="input-group-addon">
                                                 <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                        <span>
                                           <span class="">تا تاریخ :  </span><input class="form-control"/>
                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="">ساعت :  </span>
                                                        <div class="input-group">
                                                            <input type="text" class="DatePicker form-control "
                                                                   dir="rtl" id="DatePicker" name='respite_date_end'/>
                                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>پیشرفت کل : <input type="text" id="progress_amount"
                                                                                class="form-control"/></div>
                                                    </td>
                                                    <td>
                                                        <div>مدت : <input type="text" id="duration"
                                                                          class="form-control"/></div>
                                                    </td>
                                                    <td>
                                                        <div>واریانس : <input type="text" id="variance"
                                                                              class="form-control"/></div>
                                                    </td>
                                                    <td>
                                                        <div>ورودی ها : <input type="text" id="" class="form-control"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>خروجی ها : <input type="text" class="form-control"/></div>
                                                    </td>
                                                </tr>
                                            </table>

                                            <div class="row-fluid">




<span>

    </span>
                                            </div>
                                            <div class="row-fluid">

                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="t7" style="padding-top: 8px">
                                <div class="panel panel-default">
                                    <div class="">
                                        {{ trans('process.create_new_relation') }}
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-default">
                                            <tr>
                                                <td>{{ trans('process.relation_title') }}</td>
                                                <td>
                                                    <input class="form-control" type="text" id="relation_title"/>
                                                </td>
                                                <td>
                                                    <a class="btn btn-default"
                                                       id="add_new_relation">{{ trans('process.create') }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="">
                                    <table class="table table-striped" id="process_relations">
                                        <tr>
                                            <thead>
                                            <th>{{ trans('process.row_number') }}</th>
                                            <th>{{ trans('process.relation_title') }}</th>
                                            <th>{{ trans('process.first_task') }}</th>
                                            <th>{{ trans('process.seccond_tasks') }}</th>
                                            </thead>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="process_task_info_modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">مشاهده جزئیات وظیفه : <span id=""></span></h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="panel panel-info">
                            <div class="panel-heading">افزودن وظیفه مرحله بعدی</div>
                            <div class="panel-body">
                                <div class="row">
                                    <table class="col-md-12">
                                        <tr>
                                            <td>
                                                <div class="col-md-12">
                                                    <select id="next_tasks"
                                                            name="next_tasks[]"
                                                            class="col-md-12"
                                                            data-placeholder="{{trans('tasks.select_some_options')}}"
                                                            multiple>
                                                        <option value=""></option>
                                                    </select>
                                                    <span style=" position: absolute; left: 20px; top: 10px;"
                                                          class=""></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="display: table;">
                                                    <a class="btn btn-info " style="vertical-align: middle"
                                                       onclick="add_next_task()">تایید</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row-fluid">
                                    <table id="process_task_next_tasks"
                                           class="table table-striped table-bordered dt-responsive nowrap display"
                                           style="text-align: center" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">شناسه</th>
                                            <th class="text-center">عنوان</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{trans('filemanager.cancel')}}</button>
                    <button id="ANP" name="ANP" value="save" class="btn btn-info"
                            type="button" onclick="AddNewPackage()">
                        <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                        <span>ثبت</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_permitted_users" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: midnightblue;color: white;">
                    <span style="font-size: 14px">لیست کاربران مجاز دسترسی وظیفه : <span style=""
                                                                                         id="current_edit_process_task_title"></span></span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <tr class="col-md-12">
                            <td class="">
                                <div class="col-md-6">
                                    <select id="ModifyEditPermittedUsers"
                                            name="ModifyEditPermittedUsers[]"
                                            class="select2_users col-md-12 "
                                            data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                        <option value=""></option>
                                    </select>

                                    <span style="position: absolute; left: 20px; top: 10px;"
                                          class=""></span>
                                </div>
                            </td>

                            <td class="">
                                <a class="btn btn-default" onclick="add_employee_to_permitted_edit()"><i
                                            class=""></i> افزودن</a>
                            </td>
                        </tr>
                        </table>
                    </div>
                    <br/>
                    <table id="edit_permitted_users_table"
                           class="table table-striped table-bordered dt-responsive nowrap display"
                           style="text-align: center" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">نام فرد</th>
                            <th class="text-center">حذف</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer" style="background-color: midnightblue">
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="observation_permitted_users" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: midnightblue;color: white;">
                    <span style="font-size: 14px">لیست کاربران مجاز دسترسی وظیفه : <span style=""
                                                                                         id="current_observation_process_task_title"></span></span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <tr class="col-md-12">
                            <td class="">
                                <div class="col-md-6">
                                    <select id="ModifyObservationPermittedUsers"
                                            name="ModifyObservationPermittedUsers[]"
                                            class="select2_users col-md-12 "
                                            data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                        <option value=""></option>
                                    </select>

                                    <span style="position: absolute; left: 20px; top: 10px;"
                                          class=""></span>
                                </div>
                            </td>

                            <td class="">
                                <a class="btn btn-default" onclick="add_employee_to_permitted_observation()"><i
                                            class=""></i> افزودن</a>
                            </td>
                        </tr>
                        </table>
                    </div>
                    <br/>
                    <table id="observation_permitted_users_table"
                           class="table table-striped table-bordered dt-responsive nowrap display"
                           style="text-align: center" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">نام فرد</th>
                            <th class="text-center">حذف</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer" style="background-color: midnightblue">
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    {{--@include('hamahang.Tasks.helper.SelectTaskWindow.select_task_window_modal')--}}
    {!! $attach_files['UploadForm']  !!}
@stop

@section('specific_plugin_scripts')
    @include('hamahang.Tasks.helper.SelectTaskWindow.select_task_window_js')
    <script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}" type="text/javascript"></script>
    <script src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}" type="text/javascript"></script>
@stop

@section('inline_scripts')
    {!! $attach_files['JavaScripts'] !!}
    <script>
        var t2_default;
        var current_tab = '';
        var current_id = '';
        var r;
        var prev_id = '';
        function modify_info() {
            var sendInfo = {
                pages: $('#process_pages').val(),
                process_id: current_id
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.ModifyProcessInfo') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                }
            });
        }
        $(document).ready(function () {
            $('#add_new_relation').click(function () {

                var sendInfo = {
                    title: $('#relation_title').val(),
                    p_id: current_id
                };
                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.process.add_new_relation') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {

                    }
                });

            });
            window.table_chart_grid3 = $('#grid3').DataTable();
            window.process_task_table = $('#ProcessTaskTable').DataTable();
            window.process_task_edit_permissions = $('#user_with_edit_permission').DataTable();
            window.process_task_Observation_permissions = $('#user_with_observation_permission').DataTable();
            window.edit_permitted_users = $('#edit_permitted_users_table').DataTable();
            window.observation_permitted_users = $('#observation_permitted_users_table').DataTable();
            window.process_task_next_tasks = $('#process_task_next_tasks').DataTable();
            var href_link = "{{ route('ugc.desktop.hamahang.process.show_process_entity',['username'=>$uname,'name' => ''])}}";
            var send_info = {
                @if(isset($filter_subject_id))
                subject_id: '{{ $filter_subject_id }}'
                @endif
            }
            LangJson_DataTables = window.LangJson_DataTables;
            LangJson_DataTables.emptyTable = '{{trans('projects.no_process_inserted')}}';
            window.ProcessList = $('#ProcessList').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.process.fetch_list') }}",
                    "type": "POST",
                    "data": send_info
                },
                "autoWidth": false,
                "processing": true,
                "language": window.LangJson_DataTables,
                "serverside": true,
                columns: [

                    {"data": "id"},
                    {"data": "title"},
                    {
                        "data": "status",
                        "mRender": function (data, type, full) {
                            //console.log(full.status);
                            if (full.status == 1) {
                                return '<span style="color: limegreen">معتبر</sapn>';
                            }
                            else
                                return '<span style="color: indianred">نامعتبر     </sapn><a class="btn btn-default pull-left" style="padding: 1px;font-size: 5px;background-color: #FFCCFF" onclick="check_process_status(' + full.id + ')">اعتبارسنجی</a>';
                        }
                    },
                    {
                        "data": "entity_id",
                        "mRender": function (data, type, full) {
                            //console.log(full.status);
                            if (full.status == 0) {
                                var set_disabled = 'disabled="disabled"';
                            }
                            else
                                var set_disabled = '';
                            return '<a class="disabled cls3" ' + set_disabled + ' style="margin: 2px" onclick="create_new_entity(' + full.id + ')" href="#">ثبت موجودیت جدید</a> | ' +
                                '<a class="cls3" style="margin: 2px"  href="' + href_link + '/' + full.c_id + '"><span>نمایش موجودیت ها</span></a>';
                        }
                    },
                    {
                        "data": "task_id",
                        "mRender": function (data, type, full) {
                            // var id = full.id;
                            return "<a class='cls3' style='margin: 2px' onclick='process_info(" + full.id + ",\"" + full.title + "\")' href=\"#\"><i class=''>ویرایش</i></a>|<a \
                            class='cls3' style='margin: 2px' onclick='add_task(" + full.id + ")' href=\"#\"><i class=''>افزودن</i></a>";

                        }
                    }
                ]
            });
        });
        $('#jstree_demo_div').jstree({
            "checkbox": {
                "keep_selected_style": false
            },
            "plugins": ["checkbox"]
        });
        $(".select2_keywords").select2({
            minimumInputLength: 1,
            dir: "rtl",
            width: "100%",
            tags: true
        });
        $("#p_org_unit").select2({
            minimumInputLength: 1,
            tags: false,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('hamahang.project.user_orgs') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $(".select2_users").select2({
            minimumInputLength: 1,
            tags: false,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('auto_complete.users',['username'=>$uname]) }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $(".select2_pages").select2({
            minimumInputLength: 1,
            tags: false,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('auto_complete.pages') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        function refresh_process_list() {
            window.ProcessList.destroy();
            var href_link = "{{ route('ugc.desktop.hamahang.process.show_process_entity',['username'=>$uname,'name'=>''])}}";
            window.ProcessList = $('#ProcessList').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.process.fetch_list') }}",
                    "type": "POST"
                    @if(isset($filter_subject_id))
                    , "data": {"subject_id": "{{ $filter_subject_id }}"}
                    @endif
                },
                "autoWidth": false,
                "processing": true,
                "language": window.LangJson_DataTables,
                "serverside": true,
                columns: [
                    {"data": "id"},
                    {"data": "title"},
                    {
                        "data": "status",
                        "mRender": function (data, type, full) {
                            //console.log(full.status);
                            if (full.status == 1) {
                                return '<span style="color: limegreen">معتبر</sapn>';
                            }
                            else
                                return '<span style="color: indianred">نامعتبر </sapn><a class="btn btn-default pull-left" style="padding: 1px;font-size: 5px;background-color: #FFCCFF" onclick="check_process_status(' + full.id + ')">اعتبارسنجی</a>';
                        }
                    },
                    {
                        "data": "entity_id",
                        "mRender": function (data, type, full) {
                            //console.log(full.status);
                            if (full.status == 0) {
                                var set_disabled = 'disabled="disabled"';
                            }
                            else
                                var set_disabled = '';
                            return '<a class="disabled cls3" ' + set_disabled + ' style="margin: 2px" onclick="create_new_entity(' + full.id + ')" href="#">ثبت موجودیت جدید</a> | ' +
                                '<a class="cls3" style="margin: 2px"  href="' + href_link + '/' + full.c_id + '"><span>نمایش موجودیت ها</span></a>';
                        }
                    },
                    {
                        "data": "task_id",
                        "mRender": function (data, type, full) {
                            // var id = full.id;

                            return "<a class='cls3' style='margin: 2px' onclick='process_info(" + full.id + ",\"" + full.title + "\")' href=\"#\"><i class='t'>ویرایش</i></a>|<a \
                            class='cls3' style='margin: 2px' onclick='add_task(" + full.id + ")' href=\"#\"><i class=''>افزودن</i></a>";

                        }
                    }
                ]
            });
        }
        function check_process_status(id) {
            var sendInfo = {
                process_id: id
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.process_validation') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
                    console.log(data);
                    if (data == 'ok') {
                        refresh_process_list();
                        alert('فرآیند معتبر می باشد')
                    }
                    else {
                        alert('فرآیند معتبر نیست')
                    }

                }
            });
        }
        function show_process_entity(id) {
            $('#show_process_entities').submit();
        }
        function create_new_entity(id) {
            var sendInfo = {
                process_id: id
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.create_new_process_entity') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
                    if (data == 1) {
                        alert('موجودیت جدید با موفقیت ایجاد شد')
                    }
                    else {
                        alert('فرآیند معتبر نیست')
                    }

                }
            });
        }
        function CreateNewTask() {
            $('#modal_tab_5').trigger('click');
        }
        function save_new_ptask() {
                    {{--$('#process_id').val(current_id);--}}
                    {{--$('#task_public').attr('action', '{{ route('hamahang.process.save_new_process_task',['username'=>$uname]) }}');--}}
                    {{--$('#task_public').submit();--}}
            var sendInfo = {
                    process_id: current_id,
                    title: $('#title').val(),
                    type: $('input[name=type]:checked').val(),
                    task_desc: $('#desc').val(),
                    duration_day: $('#duration_day').val(),
                    duration_hour: $('#duration_hour').val(),
                    duration_min: $('#duration_min').val(),
                    duration_sec: $('#duration_sec').val(),
                    immediate: $('input[name=immediate]:checked').val(),
                    importance: $('input[name=importance]:checked').val(),
                    assign_type: $('input[name=assign_type]:checked').val(),
                    p_task_users: $('#p_task_users').val(),
                    p_task_transcripts: $('#p_task_transcripts').val(),
                    report_on_cr: $("#report-type1").prop("checked") ? 1 : 0,
                    report_on_co: $('#report-type2').prop("checked") ? 1 : 0,
                    p_task_keywords: $('#p_task_keywords').val(),
                    //end_on_assigner_accept: $('#end_on_assigner_accept').prop("checked") ? 1 : 0,
                    transferable: $('#transferable').prop("checked") ? 1 : 0

                };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.save_new_process_task') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                    //$('.tab-pane a[href="#t2"]').tab('show');
                    $('#modal_tab_2').trigger('click');
                    ShowProcessTasks(current_id);
                }
            });
        }
        function add_employee_to_permitted_edit() {
            var sendInfo = {
                users: $('#ModifyEditPermittedUsers').val(),
                tid: current_process_task_id,
                permission: 1
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.add_task_permission') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                    refresh_edit_permitted_users_table(current_process_task_id);
                }
            });
        }
        function add_employee_to_permitted_observation() {
            var sendInfo = {
                users: $('#ModifyObservationPermittedUsers').val(),
                tid: current_process_task_id,
                permission: 0
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.add_task_permission') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
                    refresh_observation_permitted_users_table(current_process_task_id);
                }
            });
        }
        function remove_edit_permission(id) {
            // alert(id);
            var sendInfo = {
                id: id
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.remove_permission') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                    refresh_edit_permitted_users_table(current_process_task_id);
                }
            });
        }
        function remove_observation_permission(id) {
            var sendInfo = {
                users: id
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.remove_permission') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
                    refresh_observation_permitted_users_table(current_process_task_id);
                }
            });
        }
        function refresh_edit_permitted_users_table(id) {
            window.edit_permitted_users.destroy();
            window.edit_permitted_users = $('#edit_permitted_users_table').DataTable({
                "dom": window.CommonDom_DataTables,
                "autoWidth": false,
                "language": window.LangJson_DataTables,
                "processing": true,
                columns: [
                    {"data": "id"},
                    {"data": "name"}//,
//                    {"data": "employee_name"},
                    , {
                        "data": "task_id",
                        "mRender": function (data, type, full) {
                            return "<a class='cls3' style='margin: 2px' onclick='remove_edit_permission(" + full.id + ")' href=\"#\"><i class='fa fa-remove'></i></a>";
                        }
                    }
                ]
            });
        }
        function refresh_observation_permitted_users_table(id) {
            window.observation_permitted_users.destroy();
            window.observation_permitted_users = $('#observation_permitted_users_table').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.process.process_task_observation_permitted_users',['id'=>'' ]) }}" + "/" + id,
                    "type": "POST"
                },
                "autoWidth": false,
                "language": window.LangJson_DataTables,
                "processing": true,

                columns: [
                    {"data": "id"},
                    {"data": "name"}//,
//                    {"data": "employee_name"},
                    , {
                        "data": "task_id",
                        "mRender": function (data, type, full) {

                            return "<a class='cls3' style='margin: 2px' onclick='remove_observation_permission(" + full.id + ")' href=\"#\"><i class='fa fa-remove'></i></a>";

                        }
                    }
                ]
            });
        }
        function show_observation_permitted_users(id, title) {
            current_process_task_id = id;
            $('#current_observation_process_task_title').html(title);
            refresh_observation_permitted_users_table(current_process_task_id);
            $('#observation_permitted_users').modal({show: true});
        }
        function observation_permitted_users() {
            current_process_task_id = id;
            $('#current_observation_process_task_title').html(title);
            refresh_observation_permitted_users_table(current_process_task_id);
            $('#observation_permitted_users').modal({show: true});
        }
        function show_edit_permitted_users(id, title) {
            current_process_task_id = id;
            $('#current_edit_process_task_title').html(title);
            refresh_edit_permitted_users_table(current_process_task_id);
            $('#edit_permitted_users').modal({show: true});
        }
        function add_next_task(id) {
            var sendInfo = {
                tasks: $('#next_tasks').val(),
                tid: current_process_task_id,
                pid: current_id
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.add_next_task') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                    ShowTaskNextTasks(current_process_task_id);
                    ShowProcessTasks(current_id);
                    setTimeout(function () {
                        refresh_process_list();
                    }, 1000)
                }
            });
        }
        var current_process_task_id = 0;
        function remove_process_task_relation(id, r_id) {
            var sendInfo = {
                r_id: r_id
            };
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.process.remove_process_task_relation') }}',
                dataType: "json",
                data: sendInfo,
                success: function () {
                    ShowTaskNextTasks(current_process_task_id);
                    ShowProcessTasks(current_id);
                    setTimeout(function () {
                        refresh_process_list();
                    }, 1000)
                }
            });
        }
        function add_task_to_process() {
            if (selectedrow.length > 0) {
                var sendInfo = {
                    s_arr: selectedrow,
                    pid: current_process
                };
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.project.add_project_task') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function () {
                    }
                });
            }
            $('#select_tasks').modal('hide');
            setTimeout(function () {
                location.reload();
            }, 1000)
        }
        $('.nav-tabs a').click(function (e) {
            current_tab = $($(this).attr('href')).index();
        });
        function ShowTaskNextTasks(id) {
            window.process_task_next_tasks.destroy();
            window.process_task_next_tasks = $('#process_task_next_tasks').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.process.fetch_process_task_next_tasks',['id'=>'' ]) }}" + "/" + id,
                    "type": "POST"
                },
                "autoWidth": false,
                "language": window.LangJson_DataTables,
                "processing": true,
                columns: [
                    {"data": "id"},
                    {"data": "title"},
                    {
                        "data": "task_id",
                        "mRender": function (data, type, full) {
                            return "<a class='cls3' style='margin: 2px' onclick='remove_process_task_relation(" + full.id + "," + full.r_id + ")' href=\"#\"><i class='fa fa-remove'></i></a>";
                        }
                    }

//
                ]
            });
        }
        function ShowProcessTasks(id) {
            window.process_task_table.destroy();
            window.process_task_table = $('#ProcessTaskTable').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.process.tasks',['id'=>'' ]) }}" + "/" + id,
                    "type": "POST"
                },
                "autoWidth": false,
                "language": window.LangJson_DataTables,
                "processing": true,

                columns: [
                    {"data": "id"},
                    {"data": "title"},
                    {"data": "employee_name"},
                    {
                        "data": "next_tasks",
                        "mRender": function (data, type, full) {
                            var next_tasks = '<ul>';
                            $.each(data, function (key, value) {

                                next_tasks += "<li style='background-color: lightgrey;margin-bottom: 1px;font-size: 12px;'>" + value.title + "</li>"


                            });
                            next_tasks += '</ul>';
                            return next_tasks;

                        }
                    },
                    {
                        "data": "task_id",
                        "mRender": function (data, type, full) {

                            return "<a class='cls3' style='margin: 2px' onclick='process_task_info(" + full.id + ",\"" + full.title + "\")' href=\"#\"><i class='fa fa-retweet'></i></a><a \
                            class='cls3' style='margin: 2px' onclick='remove_task(" + full.id + ")' href=\"#\"><i class='fa fa-remove'></i></a>";

                        }
                    },
                    {
                        "data": "library",
                        "mRender": function (data, type, full) {
                            if (full.library == 0) {
                                return "<a class='cls3' style='margin: 2px' onclick='save_as_library_task(" + full.id + ",\"" + id + "\")' href=\"#\"><i class=''> درج در کتابخانه</i></a>";
                            }
                            else {
                                return "<span class='cls3' style='margin: 2px;color: green;'><i class='fa fa-check'>کتابخانه ای</i></span>";
                            }

                        }
                    }

//
                ]
            });
        }
        function save_as_library_task(id, pid) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var sendInfo = {
                task_id: id,
                task_type: 2
            };
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.tasks.my_assigned_tasks.save_as_library_task') }}',
                dataType: "json",
                data: sendInfo,
                success: function () {

                    ShowProcessTasks(pid);

                }
            });

        }
        function change_permitted_to_observation(id, val) {

            var sendInfo = {
                tid: id,
                val: val
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.change_process_task_observation_permission_group_type') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                }


            });

        }
        function change_permitted_to_edit(id, val) {

            var sendInfo = {
                tid: id,
                val: val
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.change_process_task_edit_permission_group_type') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                }


            });

        }
        function ShowProcessTaskEditPermissions(id) {

            window.process_task_edit_permissions.destroy();
            window.process_task_edit_permissions = $('#user_with_edit_permission').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.process.process_tasks',['id'=>'/' ]) }}" + "/" + id,
                    "type": "POST"
                },
                "autoWidth": false,
                "pageLength": 5,
                "language": window.LangJson_DataTables,
                "processing": true,
                columns: [
                    {
                        "data": "id",
                        "width": "20%"
                    },
                    {
                        "data": "title",
                        "width": "30%"
                    }//,
//                    {"data": "employee_name"},
                    , {
                        "data": "task_id",
                        "mRender": function (data, type, full) {
                            var checked1e = '';
                            var checked2e = '';
                            var checked3e = '';
                            switch (full.pe_type) {
                                case 1: {
                                    checked1e = 'checked';
                                    break;
                                }
                                case 2: {
                                    checked2e = 'checked';
                                    break;
                                }
                                case 3: {
                                    checked3e = 'checked';
                                    break;
                                }
                            }
                            return "<input name='perm_e_type" + full.id + "' type='radio' class='form-control'  onclick='change_permitted_to_edit(" + full.id + ",1)' " + checked1e + "/><span>همه</span>" +
                                "<input name='perm_e_type" + full.id + "' type='radio' class='form-control'  onclick='change_permitted_to_edit(" + full.id + ",2)' " + checked2e + "/><span>مسئول</span>" +
                                "<input name='perm_e_type" + full.id + "' type='radio' class='form-control' onclick='change_permitted_to_edit(" + full.id + ",3)' " + checked3e + "/><span>کاربران مجاز</span>" +
                                "<a class='cls3' style='margin: 2px' onclick='show_edit_permitted_users(" + full.id + ",\"" + full.title + "\")' href=\"#\" disabled> (تعیین)";

                        }
                    }

//
                ]
            });
            var t = window.process_task_edit_permissions;
            t.on('order.dt search.dt', function () {

                t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

        }
        function ShowProcessTaskObservationPermissions(id) {

            window.process_task_Observation_permissions.destroy();
            window.process_task_Observation_permissions = $('#user_with_observation_permission').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.process.process_tasks',['id'=>'' ]) }}" + "/" + id,
                    "type": "POST"
                },
                "autoWidth": false,
                "pageLength": 5,
                "language": window.LangJson_DataTables,
                "processing": true,
                columns: [
                    {
                        "data": "id",
                        "width": "20%"
                    },
                    {
                        "data": "title",
                        "width": "30%"
                    }//,
//                    {"data": "employee_name"},
                    , {
                        "data": "task_id",
                        "mRender": function (data, type, full) {
                            console.log(full.po);
                            var checked1o = '';
                            var checked2o = '';
                            var checked3o = '';
                            switch (full.po_type) {
                                case 1: {
                                    checked1o = 'checked';
                                    break;
                                }
                                case 2: {
                                    checked2o = 'checked';
                                    break;
                                }
                                case 3: {
                                    checked3o = 'checked';
                                    break;
                                }
                            }
                            return "<input name='perm_type" + full.id + "' type='radio' class='form-control'  onclick='change_permitted_to_observation(" + full.id + ",1)' " + checked1o + "/><span>همه</span>" +
                                "<input name='perm_type" + full.id + "' type='radio' class='form-control'  onclick='change_permitted_to_observation(" + full.id + ",2)' " + checked2o + "/><span>مسئول</span>" +
                                "<input name='perm_type" + full.id + "' type='radio' class='form-control' onclick='change_permitted_to_observation(" + full.id + ",3)' " + checked3o + "/><span>کاربران مجاز</span>" +
                                "<a class='cls3' style='margin: 2px' onclick='show_observation_permitted_users(" + full.id + ",\"" + full.title + "\")' href=\"#\" disabled>   ( تعیین )</a>";

                        }
                    }
                ]
            });
            var t = window.process_task_Observation_permissions;
            t.on('order.dt search.dt', function () {

                t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

        }
        function process_task_info(id, title) {

            current_process_task_id = id;
            ShowTaskNextTasks(id);
            $("#next_tasks").select2({
                minimumInputLength: 1,
                tags: false,
                dir: "rtl",
                width: '100%',
                ajax: {
                    url: "{{ route('hamahang.process.search_process_task',['id'=>'' ]) }}" + "/" + current_process_task_id,
                    dataType: 'json',
                    type: "POST",
                    quietMillis: 50,
                    data: function (term) {
                        return {
                            term: term
                        };
                    },
                    results: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
            $('#process_task_info_modal').modal({show: true});
        }
        function process_info(id, title) {
            var select_task_function = '' +
                '<a class="cursor-pointer" onclick="show_select_tasks_window_modal(200,current_id)">' +
                '   <span class=""></span>کتابخانه وظایف' +
                '</a>';
            $('#select_task_window_span').html(select_task_function);
            $('#t2').html(t2_default);
            $('#process_title').html(title);
            $('#task_public')[0].reset();
            current_id = id;
            var sendInfo = {
                pid: id
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.process.info') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
//                    console.log(data[3].pages[1].title);
                    var process_keywords = '';
                    $.each(data[2], function (key, value) {
                        process_keywords += "<a class='btn btn-default'>" + value.keyword + "</a>"

                    });
//                    $.each(data[3].pages[0], function (key, value) {
//                        console.log(value.title);
                    $('#process_pages').val('');
                    $('#process_pages').select2("trigger", "select", {
                        maximumSelectionLength: 1,
                        data: {id: data[3].pages[0].id, text: data[3].pages[1].title}
                    });
//                    });
                    $('#process_keywords').html(process_keywords);
                    $('#process_title_input').val(data[0]['title']);
                    $('#process_responsibe').html(data[0]['responsible_name']);
                    $('#description').html(data[0]['description']);
                    $('#levels_count').html(data[1]);
                    var process_type = 'تعریف نشده';
                    switch (data[0]['type']) {
                        case 0: {
                            process_type = 'رسمی';
                            break;
                        }
                        case 1: {
                            process_type = 'غیر رسمی';
                            break;
                        }
                    }
                    $('#process_type').html(process_type);
                    ShowProcessTaskEditPermissions(current_id);
                    ShowProcessTaskObservationPermissions(current_id);
                    ShowProcessTasks(id);


                    var first_task = '<select name="first_task" id="first_task" onchange="disable_second(this)" class="form-control col-xs-3"><option value="n">انتخاب کنید ...</option>';
                    for (var i = 0; i < data.length; i++) {
                        first_task += '<option value="' + data[i]['id'] + '">' + data[i]['title'] + '</option>';
                    }
                    first_task += '</select>';
                    var second_task = '<select name="second_task" id="second_task" class="form-control col-xs-3"><option value="n">انتخاب کنید ...</option>';
                    for (var i = 0; i < data.length; i++) {
                        second_task += '<option value="' + data[i]['id'] + '">' + data[i]['title'] + '</option>';
                    }
                    second_task += '</select>';
                    var relation_type = '<select name="relation_type" id="relation_type" class="form-control col-xs-3">';
                    relation_type += '<option value="end_end">پایان - پایان</option>';
                    relation_type += '<option value="start_end">شروع - پایان</option>';
                    relation_type += '<option value="end_start">پایان - شروع</option>';
                    relation_type += '<option value="start_start">شروع - شروع</option>';
                    relation_type += '</select>';
                    $('#f_task').html(first_task);
                    $('#s_task').html(second_task);
                    $('#r_type').html(relation_type);
                    var t = '';
                    t = '<table class="table table-bordered"><thead><th>عنوان</th></thead>';
                    for (var i = 0; i < data.length; i++) {
                        t += '<tr>';
                        t += '<td>' + data[i]['title'] + '</td>';
                        t += '</tr>';
                    }
                    t += '</table>';
                    $('#linked_tasks').html(t);

                    var r = '';
                    r = '<table class="table table-bordered"><thead><th>عنوان وظیفه</th><th>شروع - پایان</th><th>پایان - شروع</th>\
                            <th>پایان - پایان</th><th>شروع - شروع</th></thead>';
                    for (var i = 0; i < data.length; i++) {
                        r += '<tr>';
                        r += '<td>' + data[i]['title'] + '</td>';
                        //r += '<td><table><tr><td><select>';

                        //r += '</select></td></tr><tr></tr></table></td>';
                        r += '<td><div id="end_start_section' + data[i]['id'] + '"></div></td>';
                        r += '<td><div id="start_end_section' + data[i]['id'] + '"></div></td>';
                        r += '<td><div id="end_end_section' + data[i]['id'] + '"></div></td>';
                        r += '<td><div id="start_start_section' + data[i]['id'] + '"></div></td>';
                        // r += '<td>' + data[i]['title'] + '</td>';
                        r += '</tr>';
                    }
                    r += '</table>';
                    $('#process_task_relations').html(r);
                }
            });
            $('#process_details').modal({show: true});
        }
    </script>
@stop
@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')

@stop

