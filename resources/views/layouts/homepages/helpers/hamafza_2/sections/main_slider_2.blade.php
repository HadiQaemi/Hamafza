@php
    $subjects = \App\Models\hamafza\Subject::where('kind', config('constants.HOMEPAGE_SECOND_SLIDER_TYPE'))->take(5)->get();
@endphp
<div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="2500">
    <div class="carousel-inner">
        @if(isset($subjects))
            @php $i = 1; @endphp
            @foreach($subjects as $subject)
                @php
                    if($i == 1) {$class = 'active';}
                    else {$class = '';}
                @endphp
                @if(isset($subject->pages) && isset($subject->pages[0]))
                    <div class="item {{ $class }}">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-2" style="margin-right: 1%"><img src="{{route('FileManager.DownloadFile',['type'=>'ID', 'id'=>enCode($subject->pages[0]->defimage)]) }}" class="img-responsive"></div>
                                <div class="col-xs-9" style="margin-right: 2%; margin-top: -3%">
                                    <a href="{{ route('page', $subject->pages[0]->id) }}"><h3 style="font-size: 16px; color: #FFF;">{{ $subject->title }}</h3></a>
                                    <p style="text-align: justify">{{ $subject->pages[0]->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @php $i++; @endphp
            @endforeach
        @endif
    </div>
    <!-- Controls -->
    <div class="slider-controler">
        <a class="left carousel-control" href="#custom_carousel" data-slide="prev">
            <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
        </a>
        <a class="right carousel-control" href="#custom_carousel" data-slide="next">
            <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
        </a>
    </div>
</div>