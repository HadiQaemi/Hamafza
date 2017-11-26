<div class="col-md-6 col-sm-12 col-xs-12" style="padding-left: 4px">
    <div class="news">
        <p class="news-title">اخبار</p>
        <ul class="tabs" data-persist="true">
            <li>
                <a href="#view1">اخبار</a>
            </li>
            <li>
                <a href="#view2">رویدادها</a>
            </li>
            <li>
                <a href="#view3">آمار</a>
            </li>
        </ul>
        <div class="tabcontents">
            <div id="view1" style="z-index: 100">
                <div class="ScrollNew" style="direction: rtl;;height: 375px;z-index: 1">
                    @if( count($news)>0)
                        @foreach($news as $item)
                            <?php $kind = $item->kind;?>
                            <div class="list-tab">
                                <img src="{{App::make('url')->to('/')}}/{{$item->defimage}}">
                                <div class="tab-text">
                                    <h3><a href="{{App::make('url')->to('/')}}/{{$item->id}}">{{$item->title}}</a></h3>
                                    <p>{{$item->description}}</p>
                                </div>
                            </div>
                        @endforeach
                        <a href="{{url('/')}}/rss/{{$kind}}" target="_blank"><img src="img/rss.png"> </a>
                        <a href="{{url('/')}}/rss/{{$kind}}" target="_blank" style="margin-left:10px;;float:left"><img src="img/ellipsis.png"> </a>
                    @endif
                </div>
            </div>
            <div id="view2">
                <div class="list-tab">
                    <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/news.png">
                    <div class="tab-text">
                        <h3>اجازه عبور کشتی ها صادر شد</h3>
                        <p>و دریانوردی قشم از ترابری 9.3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون کالای نفتی و غیر نفتی در بنادر این جزیره در ابتدای سال جاری تا کنون خبر داد.</p>
                    </div>
                </div>
                <div class="list-tab">
                    <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/news.png">

                    <div class="tab-text">
                        <h3>اجازه عبور کشتی ها صادر شد</h3>
                        <p>و دریانوردی قشم از ترابری 9.3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون کالای نفتی و غیر نفتی در بنادر این جزیره در ابتدای سال جاری تا کنون خبر داد.</p>
                    </div>
                </div>
                <div class="list-tab">
                    <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/news.png">
                    <div class="tab-text">
                        <h3>اجازه عبور کشتی ها صادر شد</h3>
                        <p>و دریانوردی قشم از ترابری 9.3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون کالای نفتی و غیر نفتی در بنادر این جزیره در ابتدای سال جاری تا کنون خبر داد.</p>
                    </div>
                </div>
            </div>
            <div id="view3">
                <div class="list-tab">
                    <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/news.png">
                    <div class="tab-text">
                        <h3>اجازه عبور کشتی ها صادر شد</h3>
                        <p>و دریانوردی قشم از ترابری 9.3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون کالای نفتی و غیر نفتی در بنادر این جزیره در ابتدای سال جاری تا کنون خبر داد.</p>
                    </div>
                </div>
                <div class="list-tab">
                    <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/news.png">
                    <div class="tab-text">
                        <h3>اجازه عبور کشتی ها صادر شد</h3>
                        <p>و دریانوردی قشم از ترابری 9.3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون کالای نفتی و غیر نفتی در بنادر این جزیره در ابتدای سال جاری تا کنون خبر داد.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>