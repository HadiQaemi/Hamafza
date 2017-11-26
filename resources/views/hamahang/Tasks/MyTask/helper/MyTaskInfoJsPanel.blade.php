<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/select2/dist/css/select2.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/bootstrap/css/select2-bootstrap.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
<div id="tab" class="container table-bordered" style="width: 95%">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#t1" data-toggle="tab" >اطلاعات</a>
        </li>
        <li>
            <a href="#t2" data-toggle="tab">اقدام</a>
        </li>
        <li>
            <a href="#t3" data-toggle="tab">ضمائم</a>
        </li>
        <li>
            <a href="#t4" data-toggle="tab">پیگیری</a>
        </li>
        <li>
            <a href="#t5" data-toggle="tab">واگذاری به دیگران</a>
        </li>
        <li>
            <a href="#t6" data-toggle="tab">بازگردانی وظیفه</a>
        </li>
        <li style="float: left">
            <h5 id="task_type" style="color: blue"></h5>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" style="padding-top: 8px" id="t1">
            <table class="table table-bordered col-md-12">
                <tr>
                    <td class="col-md-2">
                        <label>مهلت</label>
                    </td>
                    <td class="col-md-10">
                        <input type="text" disabled id="respite_panel" name="respite" class=""/>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2">
                        <label for="task_title">عنوان</label>
                    </td>
                    <td class="col-md-10">
                        <input type="text" disabled id="task_title_panel" name="task_title_panel" class="form-control"/>
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
                        <span id="task_employee"></span>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2">
                        <label>رونوشت</label>
                    </td>
                    <td class="col-md-10">
                        <span id="task_transcript"></span>
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
                        <span id="task_keywords"></span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="tab-pane" id="t2" style="padding-top: 8px">
            <table class="table table-bordered col-md-12">
                <tr>
                    <td><label for="title">وضعیت</label></td>
                    <td>
                        <div class="form-inline">
                            <input type="radio" class="" name="status" id="r1" value="0"/>
                            <label for="r1">{{trans('tasks.status_not_started')}}</label>
                            <input type="radio" class="" onclick="check_start_statements()" name="status" id="r2" value="1"/>
                            <label for="r2">{{trans('tasks.status_started')}} - درصد پیشرفت</label>
                            <input type="text" style="width: 25px;padding: 1px;text-align: center" class="form-control" id="percent" name="percent"/>
                            <input type="radio" class="" name="status" id="r3" value="2"/>
                            <label for="r3">{{trans('tasks.status_done')}}</label>
                            <input type="radio" class="" name="status" id="r4" value="3" />
                            <label for="r4" id="label_r4">{{trans('tasks.status_finished')}}</label>
                            <input type="radio" class="" name="status" id="r5" value="4" disabled/>
                            <label for="r5" id="label_r5">متوقف</label>
                            <span class="pull-left"><a class="btn btn-info">تایید نهایی</a></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="">بسته کاری</label></td>
                    <td>
                        <div class="row">
                            <select class="form-control col-md-7" id="task_package"  multiple="multiple">
                                <optgroup label='بسته های کاری' id="packages">
                                    @foreach($packages as $package)
                                        <option value="{{$package->id}}">{{$package->title}}</option>
                                    @endforeach
                                </optgroup>
                                {{--<optgroup label='جدید'>--}}
                                    {{--<option value="new_1425" style="font-weight: bolder">--}}
                                        {{--<i class="glyphicon  glyphicon-plus-sign bigger-125"></i>بسته جدید--}}
                                    {{--</option>--}}
                                {{--</optgroup>--}}
                            </select>
                        </div>
                        <div id="current_packages" class="row" style="margin: 10px"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="row form-inline">
                            <label for="tags">کلیدواژه ها</label>
                        </div>
                    </td>
                    <td>
                        <div class="row-fluid" style="margin-bottom: 10px">
                            <select type="text" class="col-xs-5" id="keywords" name="keywords[]" multiple style="width: 60%"></select>
                        </div>
                        <div class="row-fluid" id="current_kw"></div>
                    </td>
                </tr>
                <tr  style="color: #aaa;">
                    <td><label for="" >برآورد مدت</label></td>
                    <td>
                        <div class="form-inline" id="duration_predicted">
                            <input type="text" style="width: 10px;" class="form-control" name="predicted_time"/>
                            <select class="form-control">
                                <option>ساعت</option>
                                <option>دقیقه</option>
                                <option>روز</option>
                            </select>
                            <label for="">شناور</label>
                            <select class="form-control">
                                <option>این هفته</option>
                                <option></option>
                                <option></option>
                            </select>
                            <label for="">تخصیص وقت</label>
                            <input type="text" style="width: 20px;" class="form-control" name=""/>
                            <label for="">از</label>
                            <input type="text" style="width: 10px;" class="form-control" name=""/>
                            <label for="">تا</label>
                            <input type="text" style="width: 10px;" class="form-control" name=""/>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="tab-pane" id="t3">
            <div class="row-fluid">
                <table id="grid3" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th data-column-id="row_no" data-formatter="row_no">ردیف</th>
                        <th data-column-id="originalName">نام فایل</th>
                        <th data-column-id="extension">نوع فایل</th>
                        <th data-column-id="file_size">حجم فایل</th>
                        <th data-column-id="link" data-formatter="link" data-sortable="false">دانلود</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="t4">
            <div style="max-height: 300px;margin: 8px;background-color: #eeeeee;padding: 8px; overflow-y: scroll">
                <div class="row-fluid">
                    <div class="col-xs-12">
                        <div class="row-fluid">
                            <div class="pull-right">
                                <label>نمایش پیگیری ها :</label>
                            </div>
                            <div class="pull-left">
                                <a class="cursor-pointer" onclick="refresh_follow_ups()"> بروزرسانی <i class="fa fa-refresh"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="qa-message-list" id="follow_up_items"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row-fluid col-xs-12" style="border-top: 1px solid lightgrey;">
                <table class="col-xs-12">
                    <tr>
                        <td class="col-lg-1" style="vertical-align: middle;text-align: center"><label for="">متن پیام</label></td>
                        <td class="col-lg-11">
                            <textarea type="text" class="form-control col-xs-12" placeholder="توضیح ..." name="desc" id="desc12" style="padding: 10px"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="t5" style="margin-top: 8px">
            <div class="row-fluid" style="padding: 10px">
                <div id="TransferTaskToOther">
                    <div class="row-fluid col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        <div class="">
                            <span>واگذاری به : </span>
                            <select id="transferred_to_id"
                                    name="transferred_to_id[]"
                                    class="col-xs-12"
                                    data-placeholder="{{trans('tasks.select_some_options')}}">
                            </select>
                            <span class=" Chosen_single_LeftIcon"></span>
                        </div>
                        <div class="row">
                            <span>توضیح در مورد علت واگذاری : </span>
                        </div>
                        <div class="row" style="margin-top: 8px">
                            <textarea name="TaskTransferDescription" id="TaskTransferDescription" class="col-xs-12" style="padding: 10px"></textarea>
                        </div>
                    </div>
                    <div class="row-fluid" style="margin: 8px;">
                        <a class="btn btn-default pull-left" style="background-color: mediumpurple;color: white" onclick="do_transfer(1)"><i class="fa fa-icon-share-alt"></i>واگذاری</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="t6" style="padding-top: 8px;">
            <div class="row-fluid" style="padding: 10px">
                <div class="row">
                    <span>توضیح در مورد علت بازگردانی : </span>
                </div>
                <div class="row" style="margin-top: 8px">
                    <textarea name="TaskRejectReason" id="TaskRejectReason" class="col-xs-12" style="padding: 10px"></textarea>
                </div>
                <div class="row-fluid" style="margin: 8px;">
                    <a class="btn btn-default pull-left" id="RejectTask" onclick="RejectTask()">بازگردانی</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

@include('hamahang.Tasks.MyTask.helper.MyTaskInfoJsPanel_js')


