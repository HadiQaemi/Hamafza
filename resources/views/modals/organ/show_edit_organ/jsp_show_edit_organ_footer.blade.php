<div class="col-xs-12">

    <div >
        <div class="col-xs-3 pdrl-2"><span>نام سازمان: {{$organ_title}}</span></div>
        <div class="col-xs-3 pdrl-2"><span>نام چارت: {{$chart_title}}</span></div>
        <div class="col-xs-3 pdrl-2"><span>نام واحد سازمانی بالادستی : {{$parent_title}}</span></div>
    </div>
    <div class="footer_base_div_btn">
        <button class="btn btn-info pull-left" onclick="update_chart_item('close')">ذخیره وبستن</button>
        <button class="btn btn-info pull-left" onclick="update_chart_item('notclose')">ذخیره</button>
    </div>
</div>
</div>

@include('modals.organ.show_edit_organ.helper.show_edit_organ_inline_js')