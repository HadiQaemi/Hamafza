<style>
    .HFM_ModalOpenBtn{
        border: none !important;
    }
</style>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
<script>
    $(".persianDatepicker").persianDatepicker({
        observer: true,
        autoClose: true,
        format: 'YYYY-MM-DD',
    });
</script>
<div id="tab" class="row table-bordered" style="border-bottom: none">
    <ul class="nav nav-tabs">
        <li class="active" id="define">
            <a href="#tab_t1" data-toggle="tab">اطلاعات فردی</a>
        </li>
        <li>
            <a href="#tab_t2" data-toggle="tab">اطلاعات شغلی</a>
        </li>
        <li>
            <a href="#tab_t3" data-toggle="tab">اطلاعات تحصیلی</a>
        </li>
        <li>
            <a href="#tab_t4" data-toggle="tab">انتساب شغل</a>
        </li>
        <li style="float: left">
            <h5 id="task_type" style="color: blue"></h5>
        </li>
    </ul>
    <form name="create_new_staff" id="create_new_staff" method="post"
          enctype="multipart/form-data">
        <div class="tab-content new-task-form">
            <div class="tab-pane active tab-view" id="tab_t1">
                <div class="row">
                    <div class="base_tabs">
                        <div class="row-fluid">
                            <div class="col-xs-12 form-group noLeftMargin noRightMargin noLeftPadding noLeftPadding">
                                <div class="col-xs-6 form-group noPadding noLeftMargin noRightMargin noLeftPadding noLeftPadding">
                                    <div class="col-xs-2 noPadding noLeftMargin noRightMargin noLeftPadding noLeftPadding">
                                        <label for="system_user">کاربران سامانه</label>
                                    </div>
                                    <div class="col-xs-9">
                                        <select id="system_user" class="select2_auto_complete_system_user col-xs-12" data-placeholder="انتخاب از کاربران سیستم"></select>
                                    </div>
                                    <div class="col-xs-1 line-height-35">
                                        <a class="fa fa-check pointer" id="select_from_system_user" rel="{{route('hamahang.org_chart.insert_staff')}}"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>نام</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="staff_name" id="staff_name" class="form-control" placeholder="نام"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>نام خانوادگی</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="staff_last_name" id="staff_last_name" class="form-control" required placeholder="نام خانوادگی"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>کد ملی</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="staff_national_id" id="staff_national_id" class="form-control" placeholder="کد ملی"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>شماره موبایل</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="staff_mobile" id="staff_mobile" class="form-control" required placeholder="شماره موبایل"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>تاریخ تولد</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="staff_birth_day" id="staff_birth_day" class="form-control persianDatepicker" placeholder="تاریخ تولد"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="pull-right noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <div class="pull-right line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                            <label>وضعیت تاهل</label>
                                        </div>
                                        <div class="pull-right line-height-35">
                                            <div class="pull-right">
                                                <input type="radio" name="is_married" id="single" value="0"/>
                                                <label for="single" class="pointer">مجرد</label>
                                            </div>
                                            <div class="pull-right">
                                                <input type="radio" name="is_married" id="married" value="1"/>
                                                <label for="married" class="pointer">متاهل</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pull-right noLeftMargin noRightMargin noRightPadding noLeftPadding margin-right-50">
                                        <div class="pull-right line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                            <label>جنسیت</label>
                                        </div>
                                        <div class="pull-right line-height-35">
                                            <div class="pull-right">
                                                <input type="radio" name="gender" id="man" value="man"/>
                                                <label for="man" class="pointer">مرد</label>
                                            </div>
                                            <div class="pull-right">
                                                <input type="radio" name="gender" id="woman" value="woman"/>
                                                <label for="woman" class="pointer">زن</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tab-view" id="tab_t2">
                <div class="row">
                    <div class="base_tabs">
                        <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>نام شرکت</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="staff_job_corp" class="form-control" placeholder="نام شرکت"/>
                                </div>
                            </div>
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>سمت</label>
                                </div>
                                <div class="col-xs-9">
                                    <input id="staff_job_pos" class="form-control" required placeholder="سمت"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>تاریخ شروع</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="staff_job_begin" class="form-control persianDatepicker" placeholder="تاریخ شروع"/>
                                </div>
                            </div>
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>تاریخ پایان</label>
                                </div>
                                <div class="col-xs-9">
                                    <input id="staff_job_end" class="form-control persianDatepicker" required placeholder="تاریخ پایان"/>
                                </div>
                                <div class="pull-right line-height-35">
                                    <a class="fa fa-plus pointer" id="add_job"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 border-bottom">
                            <div class="col-xs-1">ردیف</div>
                            <div class="col-xs-4">نام شرکت</div>
                            <div class="col-xs-2">سمت</div>
                            <div class="col-xs-2">شروع</div>
                            <div class="col-xs-2">پایان</div>
                            <div class="col-xs-1"></div>
                        </div>
                        <div class="col-xs-12" id="staff_job_list"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tab-view" id="tab_t3">
                <div class="row">
                    <div class="base_tabs">
                        <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>نام دانشگاه</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="staff_edu_uni" class="form-control" placeholder="نام دانشگاه"/>
                                </div>
                            </div>
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>مقطع تحصیلی</label>
                                </div>
                                <div class="col-xs-9">
                                    <select id="staff_edu_grade" class="form-control">
                                        <option value="diploma">دیپلم</option>
                                        <option value="after_diploma">فوق دیپلم</option>
                                        <option value="bsc">لیسانس</option>
                                        <option value="msc">فوق لیسانس</option>
                                        <option value="phd">دکتری</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>رشته تحصیلی</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="staff_edu_major" class="form-control" placeholder="رشته تحصیلی"/>
                                </div>
                            </div>
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>فارغ التحصیلی</label>
                                </div>
                                <div class="col-xs-9">
                                    <input id="staff_edu_date_grade" class="form-control persianDatepicker" required placeholder="تاریخ فارغ التحصیلی"/>
                                </div>
                                <div class="pull-right line-height-35">
                                    <a class="fa fa-plus pointer" id="staff_add_edu"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 margin-top-20 border-bottom">
                            <div class="col-xs-1">ردیف</div>
                            <div class="col-xs-3">نام دانشگاه</div>
                            <div class="col-xs-2">مقطع</div>
                            <div class="col-xs-3">رشته تحصیلی</div>
                            <div class="col-xs-2">فارغ التحصیلی</div>
                            <div class="col-xs-1"></div>
                        </div>
                        <div class="col-xs-12" id="staff_edu_list"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tab-view" id="tab_t4">
                <div class="row">
                    <div class="base_tabs">
                        <div class="form-group col-md-12">
                            <div class="col-xs-1">
                                <label>سازمان</label>
                            </div>
                            <div class="col-xs-11">
                                <select name="staff_organ" id="staff_organ" class="select2_auto_complete_organ col-xs-12" data-placeholder="" ></select>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-xs-1">
                                <label>واحد</label>
                            </div>
                            <div class="col-xs-11">
                                <select name="chart_item" id="chart_item" class="select2_auto_complete_chart col-xs-12" data-placeholder="" ></select>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-xs-1">
                                <label>شغل</label>
                            </div>
                            <div class="col-xs-11">
                                <select name="chart_item_job" id="chart_item_job" class="select2_auto_complete_onet_jobs_item col-xs-12" data-placeholder="" ></select>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-xs-1">
                                <label>سمت</label>
                            </div>
                            <div class="col-xs-11">
                                <select id="chart_item_job_position" name="chart_item_job_position" class="select2_auto_complete_job_position col-xs-12" class="js-states form-control"></select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $(".select2_auto_complete_organ").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.organs')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
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

        $(".select2_auto_complete_chart").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.organ_chart_items')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term,
                        organ: $('#staff_organ').val()
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

        $(".select2_auto_complete_onet_jobs_item").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.onet_jobs_items')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term,
                        item_id: $('#chart_item').val()
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

        $(".select2_auto_complete_job_position").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.org_charts_items_posts')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term,
                        item_id: $('#chart_item').val()
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

        $(".select2_auto_complete_system_user").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.users')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
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
    });
</script>