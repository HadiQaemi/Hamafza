@php
    $slider_values = App\Models\Hamahang\BasicdataValue::where('parent_id', 6)->get();
@endphp

@if($slider_values)
    @php $i = 1; @endphp
    @foreach($slider_values as $slide)
        @php
            if($i == 1) {$class = 'active';}
            else {$class = '';}
        @endphp
        <div class="item {{ $class }}">
            <img src="{{route('FileManager.DownloadFile',['ID', enCode($slide->attrs()->where('basicdata_attribute_id', 6)->withPivot('value')->first()->pivot->value)]) }}" style="height: 284px; width: 704px;">
            <div class="carousel-caption">
                <p>{{$slide->title}}</p>
            </div>
        </div><!-- End Item -->
        @php $i++; @endphp
    @endforeach
@endif

{{--<div class="item active">--}}
{{--<img src="{{App::make('url')->to('/')}}/theme/itrak/img/slide1.png">--}}
{{--<div class="carousel-caption">--}}
{{--<p>شرکت آزمایش و تحقیقات قطعات و مجموعه خودرو (ایتراک) بر اساس تفکر راهبردی ستاد سیاست گذاری صنعت خودرو در سال 1376 با مشارکت 80 شرکت طراحی و مهندسی و سازنده قطعات</p>--}}
{{--</div>--}}
{{--</div><!-- End Item -->--}}

{{--<div class="item">--}}
{{--<img src="{{App::make('url')->to('/')}}/theme/itrak/img/slide1.png">--}}
{{--<div class="carousel-caption">--}}
{{--<p>شرکت آزمایش و تحقیقات قطعات و مجموعه خودرو (ایتراک) بر اساس تفکر راهبردی ستاد سیاست گذاری صنعت خودرو در سال 1376 با مشارکت 80 شرکت طراحی و مهندسی و سازنده قطعات</p>--}}
{{--</div>--}}
{{--</div><!-- End Item -->--}}

{{--<div class="item">--}}
{{--<img src="{{App::make('url')->to('/')}}/theme/itrak/img/slide1.png">--}}
{{--<div class="carousel-caption">--}}
{{--<p>شرکت آزمایش و تحقیقات قطعات و مجموعه خودرو (ایتراک) بر اساس تفکر راهبردی ستاد سیاست گذاری صنعت خودرو در سال 1376 با مشارکت 80 شرکت طراحی و مهندسی و سازنده قطعات</p>--}}
{{--</div>--}}
{{--</div><!-- End Item -->--}}

{{--<div class="item">--}}
{{--<img src="{{App::make('url')->to('/')}}/theme/itrak/img/slide1.png">--}}
{{--<div class="carousel-caption">--}}
{{--<p>شرکت آزمایش و تحقیقات قطعات و مجموعه خودرو (ایتراک) بر اساس تفکر راهبردی ستاد سیاست گذاری صنعت خودرو در سال 1376 با مشارکت 80 شرکت طراحی و مهندسی و سازنده قطعات</p>--}}
{{--</div>--}}
{{--</div><!-- End Item -->--}}

{{--<div class="item">--}}
{{--<img src="{{App::make('url')->to('/')}}/theme/itrak/img/slide1.png">--}}
{{--<div class="carousel-caption">--}}
{{--<p>شرکت آزمایش و تحقیقات قطعات و مجموعه خودرو (ایتراک) بر اساس تفکر راهبردی ستاد سیاست گذاری صنعت خودرو در سال 1376 با مشارکت 80 شرکت طراحی و مهندسی و سازنده قطعات</p>--}}
{{--</div>--}}
{{--</div><!-- End Item -->--}}