@php
    $slider_values = App\Models\Hamahang\BasicdataValue::where('parent_id', 6)->get();
@endphp
<div id="custom_carousel_1" class="carousel slide" data-ride="carousel" data-interval="10000">
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        @if($slider_values)
            @php $i = 1; @endphp
            @foreach($slider_values as $slide)
                @php
                    if($i == 1) {$class = 'active';}
                    else {$class = '';}
                    $link = App\Models\Hamahang\BasicdataAttributesValues
                        ::where('basicdata_value_id', '=', $slide->id)
                        ->where('basicdata_attribute_id', '=', 5)
                        ->first();
                @endphp
                <div class="item {{ $class }}">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="{{trim($link->value) != '' ? $link->value : '#'}}" style="color: #fff">
                                    <img src="{{route('FileManager.DownloadFile',['ID', enCode($slide->attrs()->where('basicdata_attribute_id', 6)->withPivot('value')->first()->pivot->value)]) }}" class="img-responsive" style="height: 150px; width: 336px;">
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <h3 style="font-size: 18px;">
                                    {!! (trim($link->value) != '' ? '<a href="'.$link->value.'" style="color: #fff">'.$slide->title.'</a>' : $slide->title ) !!}
                                </h3>
                                <p style="text-align: justify">
                                    {!! (trim($link->value) != '' ? '<a href="'.$link->value.'" style="color: #fff">'.$slide->comment.'</a>' : $slide->comment) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @php $i++; @endphp
            @endforeach
        @endif
    </div>
    <!-- End Carousel Inner -->
    <!-- Controls -->
    <div class="slider-controler">
        <ol class="carousel-indicators" style="margin: 0px">
            @if($slider_values)
                @php $i = 1; @endphp
                @foreach($slider_values as $slide)
                    @php
                        if($i == 1) {$class = 'active';}
                        else {$class = '';}
                    @endphp
                    <li data-target="#custom_carousel_1" data-slide-to="{{ $i-1 }}" class="{{ $class }}"></li>
                    @php $i++; @endphp
                @endforeach
            @endif
        </ol>
    </div>
</div>