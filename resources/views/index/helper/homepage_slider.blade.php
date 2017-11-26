@if($slider_values)
    <div id="banader_homepage_slider" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <?php $j = 0 ?>
            @foreach($slider_values as $slide)
                @if($j == 0)
                    <?php $class = 'active'; ?>
                @else
                    <?php $class = ''; ?>
                @endif
                <li data-target="#banader_homepage_slider" data-slide-to="{{ $j }}" class="{{ $class }}"></li>
                <?php $j++ ?>
            @endforeach
        </ol>
        <div class="carousel-inner">
            <?php $i = 1 ?>
            @foreach($slider_values as $slide)
                @if($i == 1)
                    <?php $class = 'active'; ?>
                @else
                    <?php $class = ''; ?>
                @endif
                <div class="homepage_slider item {{ $class }}">
                    <img src="{{route('FileManager.DownloadFile',['ID', enCode($slide->attrs()->where('basicdata_attribute_id', 6)->withPivot('value')->first()->pivot->value)]) }}" alt="{{ $slide->title }}"
                         style="width:100%; height: 445px;">
                    <div class="carousel-caption">
                        <h3 class="homepage_slider_caption">{{ $slide->title }}</h3>
                        {{--<p>LA is always so much fun!</p>--}}
                    </div>
                </div>
                <?php $i++ ?>
            @endforeach
        </div>
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#banader_homepage_slider" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">قبلی</span>
        </a>
        <a class="right carousel-control" href="#banader_homepage_slider" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">بعدی</span>
        </a>
    </div>
    @else
    <div style="text-align: center">
        <span>داده‌های اولیه اسلایدر تنظیم نشده است.</span>
    </div>
@endif
