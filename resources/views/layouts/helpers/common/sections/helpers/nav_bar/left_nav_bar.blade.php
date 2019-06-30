@php ($logged_in = session('Login') && session('Login') == 'TRUE')

<script>
    keyword_search_time = 0;
    bookmark_search_time = 0;
    $(document).ready(function()
    {
        $('#BookmarkFehresrt').css({'height': $(document).height() - 110});
        $('#portallistDiv').css({'height': $(document).height() - 175});
        $('#keyWords, #Results').css({'height': $(document).height() - 230});
        // GeminiScrollbar_portallistDiv = new GeminiScrollbar({element: document.querySelector('#portallistDiv'), forceGemini: true}).create();
        // GeminiScrollbar_Results = new GeminiScrollbar({element: document.querySelector('#Results'), forceGemini: true}).create();
        // GeminiScrollbar_keyWords = new GeminiScrollbar({element: document.querySelector('#keyWords'), forceGemini: true}).create();
        // GeminiScrollbar_BookmarkFehresrt = new GeminiScrollbar({element: document.querySelector('#BookmarkFehresrt')}).create();
    });
</script>
@php ($change_color = 'kmkz' == config('constants.IndexView') ? ' style="background-color: #367BAB !important;"' : null)
<div class="hidden-xs pull-left user-config logo-configs"{!! $change_color !!}>
    @if(auth()->check())

        <div class="pull-left user-config dropdown"{!! $change_color !!}>
            {{--<a href="#" style="background-color: transparent !important;" id="avatar" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
            <div class="col-xl-12 noLeftPadding noRightPadding">
                <div class="col-xs-4 noLeftPadding noRightPadding">
                    <a style="background-color: transparent !important;" id="avatar" aria-expanded="false" href="{{App::make('url')->to('/')}}/{{ auth()->user()->Uname }}">
                        {{--<span class="caret"></span>--}}
                        <a href="{!! route('modals.edit_user_detail') !!}?act=photo&user_id={{ auth()->id() }}" title="تنظیمات صفحه کاربری" style=" height: 10px;margin-left: -15px;padding: 0;" class=" iconEdit  edit_user_detail_icon user-config img-icon FloatLeft jsPanels">
                            <img class="img-circle img-responsive " src="{{ auth()->user()->avatar_link }}"/>
                        </a>
                    </a>
                </div>
                <div class="col-xs-8 noLeftPadding noRightPadding">
                    <div class="col-xs-12 noLeftPadding noRightPadding">
                        {{ auth()->user()->Name .' '. auth()->user()->Family }}
                    </div>
                    <div class="col-xs-12 noLeftPadding noRightPadding padding-top-5">
                        <a style="background-color: transparent !important;" href="{{ url(auth()->user()->Uname . '/wall') }}" class="wall color-white">دیوار @if(user_notifications_count('wall', auth()->id()) > 0)<span class="badge">{{ user_notifications_count('wall', auth()->id()) }}</span>@endif</a>
                        <a style="background-color: transparent !important;" href="{{ url(auth()->user()->Uname . '/desktop') }}" class="wall color-white">میز کار @if(user_notifications_count('', auth()->id()) > 0)<span class="badge DesktopNotificaton">{{ user_notifications_count('', auth()->id()) }}</span>@endif</a>
                        <a href="{{App::make('url')->to('/')}}/Logout" class="exit glyphicon glyphicon-off color-white" style="font-size: 12pt;"></a>
                    </div>
                </div>
            </div>
            <!-- begin cart`s basket -->

        {{--<a href="{{ route('ugc.desktop.hamahang.bazaar.cart', ['username' => auth()->user()->Uname]) }}" class="wall" style="visibility: {!! count(Session::get('cart')) ? 'visible' : 'hidden' !!}" id="basket_area">--}}
        {{--<div style="display: inline-block;">--}}
        {{--<span>سبد خرید</span>--}}
        {{--<div id="cart_basket_count" style="display: inline-block; border-radius: 100%; background: rgba(252, 255, 7, 0.7); color: black; width: 18px; height: 18px; text-align:center; padding-top: 2px; position: absolute; font-size: 10px; top: -7px; left: -14px">--}}
        {{--{!! count(Session::get('cart')) !!}--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</a>--}}

        <!-- end cart`s basket -->
            <div class="dropdown-menu" style="z-index: 999999;">
                <span class="glyphicon glyphicon-triangle-top"></span>
                <img class="img-responsive pull-right jsPanels" href="{{route('modals.profile_avatar')}}" src="{{ auth()->user()->avatar_link }}"/>
                <b>{{ auth()->user()->Name .' '. auth()->user()->Family }}</b>
                <span>
                @if(session('Summary')!="")
                        {{session('Summary')}}
                    @else
                        {{session('email')}}
                    @endif
                </span>
                <BR>
                <div class="col-md-6 noPadding" style=" margin-right: 90px;">
                    <a style="background-color: #3eb332;border: medium none;border-radius: 0;color: #fff;font-size: 9pt; margin: 10px 0 0;position: relative; width: 100%;" href="{{App::make('url')->to('/')}}/{{ auth()->user()->Uname }}"
                       type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">معرفی</a>
                </div>
                <div class="clearfix"></div>
                <div class="footer">
                    <a style="display: none;" onclick="Amgh" style="z-index: 10000000" id="UserSet" class="jsPanels" href="{{App::make('url')->to('/')}}/modals/setting?sid={{ auth()->user()->id }}&type=user" title="تنظیمات"> مشخصات
                        <div class="icon-tanzimat pull-right" STYLE="FONT-SIZE: 12PT;padding: 3PX;height: 10px;"></div>
                    </a>
                    <a href="{{App::make('url')->to('/')}}/Logout" class="pull-left exit"><span class="glyphicon glyphicon-off"></span>خروج</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    @else
        <img class="pull-right" src="{{App::make('url')->to('/')}}/theme/Content/icons/avatar.png"/>
        <div class="login" data-toggle="modal" data-target="#login">ورود</div>
        {{--<div class="register" data-toggle="modal" data-target="#register">ثبت نام</div>--}}
        <div class="register homepage_register_user">ثبت نام</div>
    @endif
</div>

@php ($style = $logged_in ? null : 'style="display: none;"')
@php ($unstyle = $logged_in ? null : 'style="width: 32%;"')
<ul class="nav navbar-nav pull-left quick-links hidden-xs">
    {{--<li href="#tab1" {!! $style !!}><a><span class="icon-choobalefnazok" title="چوب‌های الف" data-placement="top" data-toggle="tooltip"></span></a></li>--}}
    <li href="#tab1" {!! $style !!}><a><span class="icon-choobalefnazok" title="چوب‌های الف" data-placement="top" data-toggle="tooltip"></span></a></li>
    <li href="#tab2"><a><span class="icon-dargah icon-dargah-click" title="درگاه‌ها" data-placement="top" data-toggle="tooltip"></span></a></li>
    <li href="#tab3"><a><span class="icon-tag" title="کلید واژه‌ها" data-placement="top" data-toggle="tooltip"></span></a></li>
    <li href="#tab4"><a><span class="icon-search-1" title="جستجو" data-placement="top" data-toggle="tooltip"></span></a></li>
</ul>
<script>
    $(document).ready(function()
    {
        $('#TagRes').hide();
        $('#TagRes').show();
        $('#TagRes').mCustomScrollbar();
    });
    $(function ()
    {

        $('#Navigatekeywords').select2
        ({
            minimumInputLength: 3,
            dir: 'rtl',
            width: '100%',
            tags: false,
            ajax:
                {
                    url: '{{route('auto_complete.keywords')}}',
                    type: 'post',
                    dataType: 'json',
                    quietMillis: 150,
                    data: function(term)
                    {
                        return {term: term, 'exist_in': ''};
                    },
                    results: function(data)
                    {
                        return {results: $.map(data, function(item) { return {text: item.text, id: item.id} })};
                    }
                }
        });
        $('#KeywordFehresrt').jstree({'plugins': ['search']});
        var to = false;
    });
    $('#KeywordFehresrt').jstree
    ({
        'plugins': ['search'],
        'core': {'data': [{!! GetPublicKeyword() !!}], 'rtl': true, 'themes': {'icons': false}}
    });
    $('#KeywordFehresrt').bind('select_node.jstree', function (e, data)
    {
        var ids = data.node.id;
        var texts = data.node.text;
        $('#Navigatekeywords').select2('trigger', 'select', {data: {id: ids, text: texts}});
        $('#TagRes').animate({scrollTop: 0}, 600);
    }).on('activate_node.jstree', function (e, data)
    {
        window.location.href = data.node.a_attr.href;
        history.pushState('', document.title, window.location.pathname + window.location.search);
    });
</script>