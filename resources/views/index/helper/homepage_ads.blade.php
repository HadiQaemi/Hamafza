<?php
    $basic_data_value = \App\Models\Hamahang\BasicdataValue::where('parent_id', 7)->where('value', 1)->first();
?>
@if($basic_data_value)
        <div class="banader-ads">
            <a href="{{ $basic_data_value->attrs()->where('basicdata_attribute_id', 7)->withPivot('value')->first()->pivot->value }}"><img style="height: 337px;" src="{{route('FileManager.DownloadFile',['ID', enCode($basic_data_value->attrs()->where('basicdata_attribute_id', 8)->withPivot('value')->first()->pivot->value)]) }}"></a>
        </div>
        <div class="panel-footer text-center" style="padding-top: 18px; height: 68px; background: #568b9d;">
            {{--<a href="{{ $basic_data_value->attrs()->where('basicdata_attribute_id', 7)->withPivot('value')->first()->pivot->value }}"><span style="color: white">[برای سفارش خرید با تخفیف ویژه کلیک کنید.]</span></a>--}}
            <span style="color: white">تمامی موجودی کتاب به فروش رسیده است</span>
        </div>
@else
    <div style="text-align: center">
        <span>داده‌های اولیه تبلیغات تنظیم نشده است.</span>
    </div>
@endif