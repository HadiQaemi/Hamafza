<form id="Form_Update_Item" method="post" action="#" id="">
    <div class="padding-top-20" style="height: 60vh;overflow: scroll;padding-bottom: 40px">
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                {{trans('org_chart.choose_job')}}
            </div>
            <div class="col-xs-10">
                <input type="text" name="choose_job" id="choose_job" class="form-control" placeholder="{{trans('org_chart.choose_job')}}"/>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                {{trans('org_chart.extra_title')}}
            </div>
            <div class="col-xs-10">
                <input type="text" name="extra_title" id="extra_title" class="form-control" placeholder="{{trans('org_chart.extra_title')}}"/>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-6 noRightPadding noLeftPadding">
                <div class="col-xs-4 line-height-35">
                    {{trans('org_chart.mens_num')}}
                </div>
                <div class="col-xs-8">
                    <input type="text" name="mens_num" id="mens_num" class="form-control" placeholder="{{trans('org_chart.mens_num')}}"/>
                </div>
            </div>
            <div class="col-xs-6 noRightPadding noLeftPadding">
                <div class="col-xs-4 line-height-35">
                    {{trans('org_chart.female_num')}}
                </div>
                <div class="col-xs-8">
                    <input type="text" name="female_num" id="female_num" class="form-control" placeholder="{{trans('org_chart.female_num')}}"/>
                </div>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                <input type="checkbox" class="noRightMargin" name="need_successor" id="need_successor" />{{trans('org_chart.need_successor')}}
            </div>
            <div class="col-xs-10">
                <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">
                    {{trans('org_chart.need_successor_users')}}
                </div>
                <div class="col-xs-10 noRightPadding noLeftPadding">
                    <input type="text" name="need_successor_users" id="need_successor_users" class="form-control" placeholder="{{trans('org_chart.need_successor_users')}}"/>
                </div>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                <input type="checkbox" class="noRightMargin" name="outsourced" id="outsourced" />{{trans('org_chart.outsourced')}}
            </div>
            <div class="col-xs-10">
                <div class="col-xs-2 noRightPadding noLeftPadding line-height-35">
                    {{trans('org_chart.outsourced_num')}}
                </div>
                <div class="col-xs-10 noRightPadding noLeftPadding">
                    <input type="text" name="outsourced_num" id="outsourced_num" class="form-control" placeholder="{{trans('org_chart.outsourced_num')}}"/>
                </div>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                {{trans('org_chart.work_place')}}
            </div>
            <div class="col-xs-10">
                <input type="text" name="work_place" id="work_place" class="form-control" placeholder="{{trans('org_chart.work_place')}}"/>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                {{trans('org_chart.share_payment')}}
            </div>
            <div class="col-xs-10">
                <input type="text" name="share_payment" id="share_payment" class="form-control" placeholder="{{trans('org_chart.share_payment')}}"/>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                {{trans('org_chart.working_hours')}}
            </div>
            <div class="col-xs-10 line-height-35">
                <input type="checkbox" name="working_hours[]" id="working_hours[]" value="full_time"/>{{trans('org_chart.full_time')}}
                <input type="checkbox" class="margin-right-20" name="working_hours[]" id="part_time" value="part_time" />{{trans('org_chart.part_time')}}
                <input type="checkbox" class="margin-right-20" name="working_hours[]" id="shift" value="shift"/>{{trans('org_chart.shift')}}
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                {{trans('org_chart.access')}}
            </div>
            <div class="col-xs-10 line-height-35">
                <input type="checkbox" name="access[]" id="full_time" value="full_time"/>دسترسی به اکانت مالی
                <input type="checkbox" class="margin-right-20" name="access[]" id="part_time" value="part_time" />دسترسی به سرورها
                <input type="checkbox" class="margin-right-20" name="access[]" id="shift" value="shift"/>دسترسی به سیستم پرداخت
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                {{trans('org_chart.advantages')}}
            </div>
            <div class="col-xs-10 line-height-35">
                <input type="checkbox" name="working_hours[]" id="advantages[]" value="full_time"/>اتاق اختصاص مشترک
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="part_time" value="part_time" />اتاق اشتراکی
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="shift" value="shift"/>راننده
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="shift" value="shift"/>خودرو
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="shift" value="shift"/>لب تاپ
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="shift" value="shift"/>ناهار
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="shift" value="shift"/>شام
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="shift" value="shift"/>بیمه تکمیلی
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="shift" value="shift"/>استخر
            </div>
        </div>
    </div>
</form>
