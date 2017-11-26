<?php
$keywords_ids = unserialize($tab->value);
$subjects = \App\Models\hamafza\Subject::where('kind', config('constants.APP_DEFAULT_NEWS_ID'))->whereHas('keywords', function ($q) use ($keywords_ids)
{
    $q->whereIn('keywords.id', $keywords_ids);
})->take(5)->get();
?>
@if(isset($subjects))
    @foreach($subjects as $subject)
        @if(isset($subject->pages) && isset($subject->pages[0]))
            <div class="row news_item">
                <div class="col-xs-3 ">
                    <div class="pull-right img_news">
                        @if(isset($subject->pages[0]->defimage))
                            <img class="" style="width:100%; max-height: 75px;" src="{{route('FileManager.DownloadFile',['type'=>'ID', 'id'=>enCode($subject->pages[0]->defimage)]) }}">
                        @else
                            <i class="fa fa-newspaper-o fa-4x"></i>
                        @endif
                    </div>
                </div>
                <div class="col-xs-9 text_news pull-right">
                    <h6>
                        <a href="{{ route('page', $subject->pages[0]->id) }}">{{$subject->title}}</a>
                    </h6>
                    <p>{{ $subject->pages[0]->description }}</p>
                </div>
            </div>
            <div class="clearfixed"></div>
        @endif
    @endforeach
@endif