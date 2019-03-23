<style>
    .HFM_ModalOpenBtn{
        border: none !important;
    }
</style>
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
    <form action="{{ route('hamahang.tasks.save_task') }}" class="" name="create_new_task" id="create_new_task" method="post"
          enctype="multipart/form-data">
        <div class="tab-content new-task-form">
            <div class="tab-pane active tab-view" id="tab_t1">
                <div class="row">
                    <div class="base_tabs">
                        <div class="row-fluid">
                            <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>نام</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="organ_title" id="root_item_title" class="form-control" placeholder="نام"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>نام خانوادگی</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="organ_title" id="root_item_title" class="form-control" required placeholder="نام خانوادگی"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>کد ملی</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="organ_title" id="root_item_title" class="form-control" placeholder="کد ملی"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>شماره موبایل</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="organ_title" id="root_item_title" class="form-control" required placeholder="شماره موبایل"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                                <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                        <label>تاریخ تولد</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <input name="organ_title" id="root_item_title" class="form-control" placeholder="تاریخ تولد"/>
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
                                    <input name="organ_title" id="root_item_title" class="form-control" placeholder="نام شرکت"/>
                                </div>
                            </div>
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>سمت</label>
                                </div>
                                <div class="col-xs-9">
                                    <input name="organ_title" id="root_item_title" class="form-control" required placeholder="سمت"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 noLeftMargin noRightMargin noLeftPadding">
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>تاریخ شروع</label>
                                </div>
                                <div class="col-xs-10">
                                    <input name="organ_title" id="root_item_title" class="form-control" placeholder="تاریخ شروع"/>
                                </div>
                            </div>
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>تاریخ پایان</label>
                                </div>
                                <div class="col-xs-9">
                                    <input name="organ_title" id="root_item_title" class="form-control" required placeholder="تاریخ پایان"/>
                                </div>
                                <div class="pull-right line-height-35">
                                    <a class="btn btn-primary fa fa-plus"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 margin-top-20 border-bottom" id="job_list">
                            <div class="col-xs-1">ردیف</div>
                            <div class="col-xs-4">نام شرکت</div>
                            <div class="col-xs-3">سمت</div>
                            <div class="col-xs-2">شروع</div>
                            <div class="col-xs-2">پایان</div>
                        </div>
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
                                    <input name="organ_title" id="root_item_title" class="form-control" placeholder="نام دانشگاه"/>
                                </div>
                            </div>
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>مقطع تحصیلی</label>
                                </div>
                                <div class="col-xs-9">
                                    <select class="form-control">
                                        <option value="">دیپلم</option>
                                        <option value="">فوق دیپلم</option>
                                        <option value="">لیسانس</option>
                                        <option value="">فوق لیسانس</option>
                                        <option value="">دکتری</option>
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
                                    <input name="organ_title" id="root_item_title" class="form-control" placeholder="رشته تحصیلی"/>
                                </div>
                            </div>
                            <div class="form-group col-md-6 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                <div class="col-xs-2 line-height-35 noLeftMargin noRightMargin noRightPadding noLeftPadding">
                                    <label>فارغ التحصیلی</label>
                                </div>
                                <div class="col-xs-9">
                                    <input name="organ_title" id="root_item_title" class="form-control" required placeholder="تاریخ فارغ التحصیلی"/>
                                </div>
                                <div class="pull-right line-height-35">
                                    <a class="btn btn-primary fa fa-plus"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 margin-top-20 border-bottom" id="job_list">
                            <div class="col-xs-1">ردیف</div>
                            <div class="col-xs-3">نام دانشگاه</div>
                            <div class="col-xs-3">مقطع</div>
                            <div class="col-xs-3">رشته تحصیلی</div>
                            <div class="col-xs-2">فارغ التحصیلی</div>
                        </div>
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
                                <input name="organ_title" id="root_item_title" class="form-control" required placeholder=""/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-xs-1">
                                <label>واحد</label>
                            </div>
                            <div class="col-xs-11">
                                <select id="organ_parent" name="parent_organ" class="js-states form-control"></select>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-xs-1">
                                <label>شغل</label>
                            </div>
                            <div class="col-xs-11">
                                <input name="organ_title" id="root_item_title" class="form-control" required placeholder=""/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-xs-1">
                                <label>سمت</label>
                            </div>
                            <div class="col-xs-11">
                                <select id="organ_parent" name="parent_organ" class="js-states form-control"></select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
