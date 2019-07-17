@if(!isset($error))
<footer class="navbar-fixed-bottom">
    <div class="col-md-12 footerPage">
        <p>
        <ul class="center-block" style="width: 600px; padding-right: 100px" >
            <li><a href="{{App::make('url')->to('/')}}/ms">درباره {{ Config::get('constants.SiteFullTitle')}}</a>
            </li>
            <li>
                <div class="Footicon icon-2-3"></div>
                مبتنی بر <a href="{{App::make('url')->to('/')}}/100">هم&zwnj;افزا</a>
            </li>
            @if(env('CONSTANTS_IndexView') != 'reo')
                <li>
                    <div class="Footicon icon-2-3"></div>
                    پشتیبانی:
                    <a href="http://www.hamafza.co" target="_blank">فناوران مدیریت علم هم&zwnj;افزا</a>
                </li>
            @endif
        </ul>
        </p>

    </div>
</footer>
@endif