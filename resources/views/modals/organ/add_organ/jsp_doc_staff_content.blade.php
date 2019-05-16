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
        initialValueType: 'persian',
        format: 'YYYY-MM-DD',
    });
    $(".persianDatepicker-bd").persianDatepicker({
        observer: true,
        initialValue: true,
        initialValueType: 'persian',
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
            <a href="#tab_t2" data-toggle="tab">اطلاعات همسر</a>
        </li>
        <li>
            <a href="#tab_t3" data-toggle="tab">اطلاعات فرزندان</a>
        </li>
        <li>
            <a href="#tab_t4" data-toggle="tab">اشنایان</a>
        </li>
        <li style="float: left">
            <h5 id="task_type" style="color: blue"></h5>
        </li>
    </ul>
    <form name="staff_form" id="staff_form" method="post"
          enctype="multipart/form-data">
        <input type="hidden" name="sid" value="{{isset($sid) ? $sid : ''}}">
        <div class="tab-content">
            <div class="tab-pane active tab-view" id="tab_t1">
                <div class="row">
                    {{--<pre>--}}
                        {{--{{print_r($staff)}}--}}
                        {{--<hr/>--}}
                    {{--</pre>--}}
                    <div class="base_tabs">
                        <div class="row-fluid">
                            <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                                <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>نوع مسکن</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="home_type" id="home_type" class="form-control" placeholder="نوع مسکن" value="{{isset($staff->home_type) ? $staff->home_type : ''}}"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>نوع قرارداد</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="contract_type" id="contract_type" class="form-control" required placeholder="نوع قرارداد" value="{{isset($staff->contract_type) ? $staff->contract_type: ''}}"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>بیمه</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="insurance_num" id="insurance_num" class="form-control" placeholder="شماره تامین اجتماعی" value="{{isset($staff->insurance_num) ? $staff->insurance_num : ''}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                                <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>جانبازی</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="veteran_precent" id="veteran_precent" class="form-control" required placeholder="درصد جانبازی" value="{{isset($staff->veteran_precent) ? $staff->veteran_precent : ''}}"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>آزاده</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="captivity_duration" id="captivity_duration" class="form-control" required placeholder="مدت اسارت" value="{{isset($staff->captivity_duration) ? $staff->captivity_duration : ''}}"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>رزمنده</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="time_war" id="time_war" class="form-control" required placeholder="مدت حضور در جبهه" value="{{isset($staff->time_war) ? $staff->time_war : ''}}"/>
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
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>نام</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="spouse_name" class="form-control" required placeholder="نام همسر"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>نام خانوادگی</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="spouse_lastname" class="form-control" required placeholder="نام خانوادگی همسر"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>تاریخ تولد</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="birth_date" class="form-control persianDatepicker" required placeholder="تاریخ تولد"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>شغل</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="spouse_job" class="form-control" required placeholder="شغل"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>موبایل</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="spouse_mobile" class="form-control" required placeholder="شماره موبایل"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>تاریخ ازدواج</label>
                                </div>
                                <div class="col-xs-9">
                                    <input id="marry_date" class="form-control persianDatepicker" required placeholder="تاریخ پایان"/>
                                </div>
                                <div class="pull-right line-height-35">
                                    <a class="fa fa-plus pointer" id="add_spouse"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 margin-top-20 border-bottom">
                            <div class="col-xs-1">ردیف</div>
                            <div class="col-xs-2">نام</div>
                            <div class="col-xs-2">نام خانوادگی</div>
                            <div class="col-xs-2">شغل</div>
                            <div class="col-xs-2">موبایل</div>
                            <div class="col-xs-1"></div>
                        </div>
                        @php $cnt = 1; @endphp
                        <div class="col-xs-12" id="spouse_list">
                            @if(!empty($staff->spouses))
                                @foreach($staff->spouses as $spouse)
                                    <div class="col-xs-12 margin-top-10">
                                        <div class="col-xs-1">{{$cnt++}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="spouse_name[]" value="{{$spouse->name}}"/>{{$spouse->name}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="spouse_lastname[]" value="{{$spouse->last_name}}"/>{{$spouse->last_name}}</div>
                                        <div class="hidden"><input type="hidden" name="birth_date[]" value="{{$spouse->birth_date}}"/>{{$spouse->birth_date}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="spouse_job[]" value="{{$spouse->job}}"/>{{$spouse->job}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="spouse_mobile[]" value="{{$spouse->mobile}}"/>{{$spouse->mobile}}</div>
                                        <div class="hidden"><input type="hidden" name="marry_date[]" value="{{$spouse->married_date}}"/>{{$spouse->married_date}}</div>
                                        <div class="col-xs-1"><i class="fa fa-remove remove-staff-item pointer"></i></div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tab-view" id="tab_t3">
                <div class="row">
                    <div class="base_tabs">
                        <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>نام</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="child_name" class="form-control" required placeholder="نام فرزند"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>تاریخ تولد</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="child_birth_date" class="form-control persianDatepicker" required placeholder="تاریخ تولد"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>کد ملی</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="child_national_code" class="form-control" required placeholder="کد ملی"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>شغل</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="child_job" class="form-control" required placeholder="شغل"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>موبایل</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="child_mobile" class="form-control" required placeholder="شماره موبایل"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>تحصیلات</label>
                                </div>
                                <div class="col-xs-9">
                                    <select id="child_edu_grade" class="form-control">
                                        <option value="diploma">دیپلم</option>
                                        <option value="after_diploma">فوق دیپلم</option>
                                        <option value="bsc">لیسانس</option>
                                        <option value="msc">فوق لیسانس</option>
                                        <option value="phd">دکتری</option>
                                    </select>
                                </div>
                                <div class="pull-right line-height-35">
                                    <a class="fa fa-plus pointer" id="add_child"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 margin-top-20 border-bottom">
                            <div class="col-xs-1">ردیف</div>
                            <div class="col-xs-2">نام</div>
                            <div class="col-xs-2">کدملی</div>
                            <div class="col-xs-2">شغل</div>
                            <div class="col-xs-2">موبایل</div>
                            <div class="col-xs-1"></div>
                        </div>
                        @php $cnt = 1; @endphp
                        <div class="col-xs-12" id="child_list">
                            @if(!empty($staff->childs))
                                @foreach($staff->childs as $child)
                                    <div class="col-xs-12 margin-top-10">
                                        <div class="col-xs-1">{{$cnt++}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="child_name[]" value="{{$child->name}}"/>{{$child->name}}</div>
                                        <div class="hidden"><input type="hidden" name="child_birth_date[]" value="{{$child->birth_date}}"/>{{$child->birth_date}}</div>
                                        <div class="hidden"><input type="hidden" name="child_edu_grade[]" value="{{$child->grade}}"/>{{$child->grade}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="child_national_code[]" value="{{$child->national_id}}"/>{{$child->national_id}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="child_job[]" value="{{$child->job}}"/>{{$child->job}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="child_mobile[]" value="{{$child->mobile}}"/>{{$child->mobile}}</div>
                                        <div class="col-xs-1"><i class="fa fa-remove remove-staff-item pointer"></i></div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tab-view" id="tab_t4">
                <div class="row">
                    <div class="base_tabs">
                        <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                            <div class="form-group col-md-3 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>نام</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="related_name" class="form-control" required placeholder="نام اشنا"/>
                                </div>
                            </div>
                            <div class="form-group col-md-3 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-4 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>نام خانوادگی</label>
                                </div>
                                <div class="col-xs-8">
                                    <input id="related_lastname" class="form-control" required placeholder="نام خانوادگی اشنا"/>
                                </div>
                            </div>
                            <div class="form-group col-md-3 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>سمت</label>
                                </div>
                                <div class="col-xs-10">
                                    <input id="related_post" class="form-control" required placeholder="سمت"/>
                                </div>
                            </div>
                            <div class="form-group col-md-3 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>کدملی</label>
                                </div>
                                <div class="col-xs-9">
                                    <input id="related_code_melli" class="form-control" required placeholder="کدملی"/>
                                </div>
                                <div class="pull-right line-height-35">
                                    <a class="fa fa-plus pointer" id="add_related_persons"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 margin-top-20 border-bottom margin-bottom-5">
                            <div class="col-xs-1">ردیف</div>
                            <div class="col-xs-2">نام</div>
                            <div class="col-xs-2">نام خانوادگی</div>
                            <div class="col-xs-2">کدملی</div>
                            <div class="col-xs-2">سمت</div>
                            <div class="col-xs-1"></div>
                        </div>
                        @php $cnt = 1; @endphp
                        <div class="col-xs-12" id="related_persons_list">
                            @if(!empty($staff->families))
                                @foreach($staff->families as $family)
                                    <div class="col-xs-12 margin-top-10">
                                        <div class="col-xs-1">{{$cnt++}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="related_name[]" value="{{$family->name}}"/>{{$family->name}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="related_lastname[]" value="{{$family->last_name}}"/>{{$family->last_name}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="related_code_melli[]" value="{{$family->national_id}}"/>{{$family->national_id}}</div>
                                        <div class="col-xs-2"><input type="hidden" name="related_post[]" value="{{$family->post}}"/>{{$family->post}}</div>
                                        <div class="col-xs-1"><i class="fa fa-remove remove-staff-item pointer"></i></div>
                                    </div>
                                @endforeach
                            @endif
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
                        item_id: $('#chart_item_job').val()
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