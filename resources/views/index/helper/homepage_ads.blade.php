@php
    $enabled = false;
    $basic_data_value = \App\Models\Hamahang\BasicdataValue::where('parent_id', 7)->where('value', 1)->first();
@endphp
@if ($basic_data_value)
    @php
        $url = $basic_data_value->attrs()->where('basicdata_attribute_id', 7)->withPivot('value')->first()->pivot->value;
        $sid_url = $url + 0;
        if ($sid_url)
        {
            $page = App\Models\hamafza\Pages::find($sid_url);
            if ($page)
            {
                $spi = $page->subject->product_info;
                if ($spi)
                {
                    $enabled = $spi->ready_to_supply;
                }
            }
        }
    @endphp
    <div class="banader-ads">
        <a href="{{ $url }}"><img style="height: 337px;" src="{{route('FileManager.DownloadFile',['ID', enCode($basic_data_value->attrs()->where('basicdata_attribute_id', 8)->withPivot('value')->first()->pivot->value)]) }}"></a>
    </div>
    <div class="panel-footer text-center" style="padding-top: 18px; height: 68px; background: #568b9d;">
        @if ($enabled)
            <a href="{{ $basic_data_value->attrs()->where('basicdata_attribute_id', 7)->withPivot('value')->first()->pivot->value }}">
                <span style="color: white">
                    @php ($bdv = \App\Models\Hamahang\Basicdata::find(5)->items()->where('id', '148')->get()->first())
                    {!! $bdv ? $bdv->value : 'برای سفارش خرید با تخفیف ویژه کلیک کنید.' !!}
                </span></a>
        @else
            <span style="color: white">
                @php ($bdv = \App\Models\Hamahang\Basicdata::find(5)->items()->where('id', '147')->get()->first())
                {!! $bdv ? $bdv->value : 'تمامی موجودی این محصول به فروش رسیده است.' !!}
            </span>
        @endif
    </div>
@else
    <div style="text-align: center">
        <span>داده‌های اولیه تبلیغات تنظیم نشده است.</span>
    </div>
@endif