<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/select2/dist/css/select2.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/bootstrap/css/select2-bootstrap.css')}}"/>
<div class="row" style="padding: 15px;">
    <!---------------->
    <div id="tab" class="row table-bordered" style="width: 95%;">
        <ul class="nav nav-tabs">
            <li  class="active">
                <a href="#tab_t1" data-toggle="tab">اطلاعات</a>
            </li>
            <li>
                <a href="#tab_t2" data-toggle="tab">اقدام</a>
            </li>
            <li>
                <a href="#tab_t3" data-toggle="tab">ضمائم</a>
            </li>
            <li>
                <a href="#tab_t4" data-toggle="tab">پیگیری</a>
            </li>
            <li>
                <a href="#tab_t5" data-toggle="tab">سوابق</a>
            </li>
            <li>
                <a href="#tab_t6" data-toggle="tab">وراثت</a>
            </li>
            <li>
                <a href="#tab_t7" data-toggle="tab">زمانبندی</a>
            </li>
            <li style="float: left">
                <h5 id="task_type" style="color: blue"></h5>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" style="padding-top: 8px" id="tab_t1">
                <table class="table table-bordered col-md-12">
                    <tr>
                        <td class="col-md-2">
                            <label>مهلت</label>
                        </td>
                        <td class="col-md-10">
                            <input type="text" disabled id="respite" name="respite" class=""/>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-2">
                            <label for="task_title">عنوان</label>
                        </td>
                        <td class="col-md-10">
                            <input type="text" disabled id="task_title" name="task_title" class="form-control"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-2">
                            <label for="description">اولویت</label>
                        </td>
                        <td class="col-md-10">
                            <span id="priority"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-2">
                            <label>مسئول انجام</label>
                        </td>
                        <td class="col-md-10">
                            <select class="task_info_users" id="task_info_users" name="task_info_users[]" multiple="multiple">

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-2">
                            <label>رونوشت</label>
                        </td>
                        <td class="col-md-10">
                            <select class="task_info_users" id="task_info_transcripts" name="task_info_transcripts[]" multiple="multiple">

                            </select>
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
                            <select class="select2_pages" id="task_info_keywords" name="task_info_keywords[]" multiple="multiple">

                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane" id="tab_t2" style="padding-top: 8px">
                <table class="table table-bordered col-md-12">
                    <tr>
                        <td><label for="title">وضعیت</label></td>
                        <td>
                            <span id="status"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">کیفیت انجام</label></td>
                        <td>
                            <div class="form-inline">
                                <input type="radio" class="" name="quality" id="q1" value="1"/>
                                <label for="r1">عالی</label>
                                <input type="radio" class="" name="quality" id="q2" value="2"/>
                                <label for="r2">خوب</label>
                                <input type="radio" class="" name="quality" id="q3" value="3"/>
                                <label for="r2">متوسط</label>
                                <input type="radio" class="" name="quality" id="q4" value="4"/>
                                <label for="r2">ضعیف</label>
                                <input type="radio" class="" name="quality" id="q5" value="5"/>
                                <label for="r2">بسیارضعیف</label>
                                <input type="radio" class="" name="quality" id="q0" value="0"/>
                                <label for="r2">تعیین نشده</label>

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">عملیات</label></td>
                        <td>
                            <a class="btn btn-default" onclick="EndTask() " disabled="disabled" id="task_end">پایان</a>
                            <a class="btn btn-default" onclick="StopTask()" disabled="disabled" id="task_stop">توقف انجام</a>
                            <a class="btn btn-default" onclick="RestartTask()" disabled="disabled" id="task_restart">شروع مجدد</a>
                        </td>
                    </tr>
                </table>
                <div class="row-fluid">
                    <div class="col-xs-6">
                        <div class="panel panel-default" style="width: 99%">
                            <div class="panel-heading" style="background-color: lightgrey;padding: 2px">
                                <p style="font-size: 12px">سوابق وضعیت انجام</p>
                            </div>
                            <div class="panel-body" style="height: 150px;overflow-y: scroll">
                                <table class="table table-striped" style="padding: 0">
                                    <thead>
                                    <tr>
                                        <th>وضعیت</th>
                                        <th>درصد</th>
                                        <th>تاریخ</th>
                                    </tr>
                                    </thead>
                                    <tbody id="h1">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="panel panel-default" style="">
                            <div class="panel-heading" style="background-color: lightgrey;padding: 2px">
                                <p style="font-size: 12px">سوابق ارزیابی کیفیت</p>
                            </div>
                            <div class="panel-body" style="height: 150px;overflow-y: scroll">
                                <table class="table table-striped" style="padding: 0;">
                                    <thead>
                                    <tr>
                                        <th>نتیجه ارزیابی</th>
                                        <th>تاریخ</th>
                                    </tr>
                                    </thead>
                                    <tbody id="h2">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_t3">
                <div class="row-fluid">
                    <div class="row-fluid">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-25">
                            {!! $HFM_CNT['Buttons']['AddNewFiles'] !!}
                            {!! $HFM_CNT['ShowResultArea']['AddNewFiles'] !!}
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row-fluid">
                    <table id="files_grid" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">عنوان</th>
                            <th class="text-center">نوع فایل</th>
                            <th class="text-center">حجم فایل</th>
                            <th class="text-center">عملیات</th>
                            {{--<th>دانلود</th>--}}
                            {{--<th>عملیات</th>--}}
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab_t4">
                <div style="max-height: 300px;margin: 8px;background-color: #eeeeee;padding: 8px; overflow-y: scroll">
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            <div class="row-fluid">
                                <div class="pull-right">
                                    <label>نمایش پیگیری ها :</label>
                                </div>
                                <div class="pull-left">
                                    <a class="cursor-pointer" onclick="refresh_follow_ups()">
                                        <span> بروزرسانی</span>
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="qa-message-list" id="follow_up_items">

                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid col-xs-12" style="border-top: 1px solid lightgrey;">
                    <table class="col-xs-12">
                        <tr>
                            <td class="col-lg-1" style="vertical-align: middle;text-align: center">
                                <label for="">متن پیام</label></td>
                            <td class="col-lg-11">
                                                <textarea type="text" class="form-control col-xs-12" placeholder="توضیح ..." name="desc" id="desc12" style="padding: 10px">
                                                </textarea>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab_t5">
                <div class="row">
                    <div class="col-xs-12 well well-sm center" style="text-align: left">
                        <span style="position: absolute;right: 5px;">راهنمای رنگ ها</span>
                        <span style="margin-right: 8px;">ایجاد  <i class="fa fa-square" style="color: lightgreen;border: 1px solid #999"></i></span>
                        <span style="margin-right: 8px;">انتقال  <i class="fa fa-square" style="color: yellow;border: 1px solid #999"></i></span>
                        <span style="margin-right: 8px;">تغییر وضعیت  <i class="fa fa-square" style="color: lightcyan;border: 1px solid #999"></i></span>
                        <span style="margin-right: 8px;">توقف  <i class="fa fa-square" style="color: lightpink;border: 1px solid #999"></i></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 time_line">
                        <div class="featurette" id="about">
                            <!------------------------code---------------start---------------->
                            <div class="row" style="max-height: 400px;overflow-y: scroll;padding: 15px;direction: rtl">
                                <div class="timeline-centered" id="Timeline"></div>
                            </div>
                            <!----Code------end----------------------------------->
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane" id="tab_t6" style="padding: 8px;">
                <div class="row">
                    <div class="progress">
                        <div id="progress" class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="95" style="width:1%;border-color: #0A246A;background-color: cyan;color: black"><span
                                    id="progress_rext"></span></div>
                    </div>
                    <a class="btn btn-info pull-left" id="btn_select_task_childs">انتخاب فرزندان</a>
                </div>
                <div class="row-fluid" id="ModalContent">
                    <table id="ChildsGrid" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>عنوان</th>
                            <th>وزن</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab_t7" style="padding: 8px 0 8px 0;">
                <div class="row-fluid">
                    @include('hamahang.Scheduler.helper.content')
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
    <!---------------->
    <div style="clear: both;"></div>
</div>

{!! $HFM_CNT['UploadForm'] !!}
<script>
    $('#btn_select_task_childs').click(function () {
        show_select_tasks_window_modal(2, current_id, 1);
    })
</script>
<script type="text/javascript" src="{{URL::asset('assets/Packages/select2/dist/js/select2.full.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/Packages/select2/dist/js/i18n/fa.js')}}"></script>
@include('hamahang.Tasks.MyAssignedTask.helper.MyAssignedTaskInfoJsPanel_js')
@include('hamahang.Scheduler.helper.js-plugins')
@include('hamahang.Scheduler.helper.js-inline')
{!! $HFM_CNT['JavaScripts'] !!}