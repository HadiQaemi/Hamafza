@php ($logged_in = session('Login') && session('Login') == 'TRUE')

<script>
    keyword_search_time = 0;
    bookmark_search_time = 0;
    $(document).ready(function()
    {
        $('#BookmarkFehresrt').css({'height': $(document).height() - 110});
        $('#portallistDiv').css({'height': $(document).height() - 175});
        $('#keyWords, #Results').css({'height': $(document).height() - 230});
        GeminiScrollbar_portallistDiv = new GeminiScrollbar({element: document.querySelector('#portallistDiv'), forceGemini: true}).create();
        GeminiScrollbar_Results = new GeminiScrollbar({element: document.querySelector('#Results'), forceGemini: true}).create();
        GeminiScrollbar_keyWords = new GeminiScrollbar({element: document.querySelector('#keyWords'), forceGemini: true}).create();
        GeminiScrollbar_BookmarkFehresrt = new GeminiScrollbar({element: document.querySelector('#BookmarkFehresrt')}).create();
    });
</script>
@php ($change_color = 'kmkz' == config('constants.IndexView') ? ' style="background-color: #367BAB !important;"' : null)
<div class="hidden-xs pull-left user-config logo-configs"{!! $change_color !!}>
    @if(auth()->check())

        <div class="pull-left user-config dropdown"{!! $change_color !!}>
            <a href="#" style="background-color: transparent !important;" id="avatar" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                {{ auth()->user()->Name .' '. auth()->user()->Family }}
                <span class="caret"></span>
                <img class="img-circle img-responsive jsPanels" href="{{route('modals.profile_avatar')}}" src="{{ auth()->user()->avatar_link }}"/>
            </a>
            <a style="background-color: transparent !important;" href="{{ url(auth()->user()->Uname . '/wall') }}" class="wall">دیوار @if(user_notifications_count('wall', auth()->id()) > 0)<span class="badge">{{ user_notifications_count('wall', auth()->id()) }}</span>@endif</a>
            <a style="background-color: transparent !important;" href="{{ url(auth()->user()->Uname . '/desktop') }}" class="wall">میز کار @if(user_notifications_count('', auth()->id()) > 0)<span class="badge DesktopNotificaton">{{ user_notifications_count('', auth()->id()) }}</span>@endif</a>
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
                       type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">درباره</a>
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
        <div class="register" data-toggle="modal" data-target="#register">ثبت نام</div>
    @endif
</div>

@php ($style = $logged_in ? null : 'style="display: none;"')
@php ($unstyle = $logged_in ? null : 'style="width: 32%;"')
<ul class="nav navbar-nav pull-left quick-links hidden-xs">
    <li href="#tab1" {!! $style !!}><a><span class="icon-choobalefnazok" title="چوب‌های الف" data-placement="top" data-toggle="tooltip"></span></a></li>
    <li href="#tab2"><a><span class="icon-dargah icon-dargah-click" title="درگاه‌ها" data-placement="top" data-toggle="tooltip"></span></a></li>
    <li href="#tab3"><a><span class="icon-tag" title="کلید واژه‌ها" data-placement="top" data-toggle="tooltip"></span></a></li>
    <li href="#tab4"><a><span class="icon-search-1" title="جستجو" data-placement="top" data-toggle="tooltip"></span></a></li>
</ul>

<div id="h_sidenav" class="h_sidenav" style="overflow: hidden;">
    <div id="h_sidenav_client" class="h_sidenav_client">
        <i class="fa fa-close h_sidenav_close" onclick="h_sidenav_close();"></i>
        <a style="margin: -1px 0 0 20px; padding: 0; font-size: 11pt;" class="jsPanels icon icon-help HelpIcons HelpBookmarks" title="راهنمای اینجا" href="{!! url('/modals/helpview?code=x_k4R_cmY34') !!}"></a>
        <a style="margin: -1px 0 0 20px; padding: 0; font-size: 11pt;" class="jsPanels icon icon-help HelpIcons HelpPortals" title="راهنمای اینجا" href="{!! url('/modals/helpview?code=WU99UI5IUgw') !!}"></a>
        <a style="margin: -1px 0 0 20px; padding: 0; font-size: 11pt;" class="jsPanels icon icon-help HelpIcons HelpKeywords" title="راهنمای اینجا" href="{!! url('/modals/helpview?code=UPjv2yJSc80') !!}"></a>
        <a style="margin: -1px 0 0 20px; padding: 0; font-size: 11pt;" class="jsPanels icon icon-help HelpIcons HelpSearch" title="راهنمای اینجا" href="{!! url('/modals/helpview?code=A4MfrJnJ3DI') !!}"></a>
        <ul class="nav nav-tabs navbar-navtabs" style="font-size: 11px;">
            @if ($logged_in)<li><a class="new_sidebar" data-toggle="tab" id="tab1" href="#page1">چوب&zwnj;های الف</a></li>@endif
            <li {!! $unstyle !!}><a class="new_sidebar" data-toggle="tab" id="tab2" href="#page2">درگاه&zwnj;ها</a></li>
            <li {!! $unstyle !!}><a class="new_sidebar" data-toggle="tab" id="tab3" href="#page3">کلیدواژه&zwnj;ها</a></li>
            <li {!! $unstyle !!}><a class="new_sidebar" data-toggle="tab" id="tab4" href="#page4">جستجو</a></li>
        </ul>
        <div class="tab-content" style="padding-top: 20px;">@if ($logged_in)
                <div id="page1" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-11 txtsearch">
                            <input type="text" class="list-search col-md-5 GharbalSearchNavbar" id="bookmarklist-search" placeholder="غربال..." />
                        </div>
                    </div>
                    <div class="innerpane" style="overflow: hidden; height: 1000px;">
                        <div id="BookmarkFehresrt" style="padding-right: 25px; height: 1000px; overflow: hidden;"></div>
                    </div>
                </div>@endif
            <div id="page2" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-11 txtsearch">
                        <input type="text" class="list-search col-md-5 GharbalSearchNavbar" id="portallist-search" placeholder="غربال..." />
                    </div>
                </div>
                <div class="innerpane" style="overflow: hidden; height: 1000px;">
                    <div accordion="" class="panel-group accordion" id="portallistDiv" style="height: 1000px; width: 390px; overflow: hidden;">
                        <div id="PrtalFehresrt" class="v"></div>
                    </div>
                </div>
            </div>
            <div id="page3" class="tab-pane fade">
                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        {{--@include('sections.tagNavigat')--}}
                        <select type="text" name="Navigatekeywords" id="Navigatekeywords" multiple="multiple" onchange="$('.keywords_and_or_client').css({'visibility': $(this).find(':selected').length > 1 ? 'visible' : 'hidden'});"></select>
                        <div style="margin-top: 10px; visibility: hidden;" class="keywords_and_or_client">
                            <input type="radio" id="keywords_and_or_0" value="0" name="keywords_and_or" class="keywords_and_or" checked="checked" /><label for="keywords_and_or_0" style="font-weight: normal;">حداقل یکی</label>
                            <input type="radio" id="keywords_and_or_1" value="1" name="keywords_and_or" class="keywords_and_or" /><label for="keywords_and_or_1" style="font-weight: normal;">همه</label>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <input type="button" value="بیاب" title="Searchpost" class="btn btn-primary" id="TagBut" style="padding:6px;">
                        <img id="Tagloding" src="{{App::make('url')->to('/')}}/img/loader.gif" style="display: none;"/>
                        <div id="TagRefBut" style="cursor:pointer;display:none;cursor: pointer;height: 15px;overflow: hidden;">
                            <a onclick="RefreshTags();" href="#">
                                <div class="icon icon-chap1"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs navbar-navtabs" style="font-size: 11px; width: 90%; margin-right: 20px;">
                    <li style="width: 49%;" class="active"><a id="tab3_1" class="new_sidebar" data-toggle="tab" href="#keyWords" style="height: 50px;">گزینه‌ها</a></li>
                    <li style="width: 49%;"><a class="new_sidebar" data-toggle="tab" id="ShowResKey" href="#Results" style="height: 50px;">یافته‌ها</a></li>
                </ul>
                <div class="tab-content" style="width: 430px; height: 1000px; overflow: hidden;">
                    <div id="keyWords" class="tab-pane active in" style="height: 100px;">
                        <div accordion="" class="panel-group accordion" id="Bookmarkaccordion">
                            <div id="KeywordFehresrt" style="margin-top: 5px;"></div>
                        </div>
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
                    </div>
                    <div id="Results" class="tab-pane fade" @if(session('TagSearch')=='') style="display: none;" @endif>
                        <div class="innerpane">
                            <div class="panel-group accordion" id="Bookmarkaccordion2" style="margin-right: 15pt; margin-top: 15px;">
                                <div id="KeywordSearch">
                                    @if(session('TagSearch')!='')
                                        {{session('TagSearch')}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="page4" class="tab-pane fade" style="margin: 0 15px 0 15px;">
                <div class="row">
                    <input type="text" name="search_term" id="search_term" class="form-control pull-right" style="width: 80%;" />
                    <input type="button" name="search_submit" id="search_submit" class="btn btn-primary pull-left" value="بیاب" style="height: 34px;  width: 15%;" />
                </div>
                <div class="row">
                    <ul class="nav nav-tabs navbar-navtabs">
                        <li style="width: 49%;" class="active"><a class="new_sidebar" data-toggle="tab" href="#page4_pane1" id="page4_tab1" style="height: 50px;">غربال</a></li>
                        <li style="width: 49%;"><a class="new_sidebar" data-toggle="tab" href="#page4_pane2" id="page4_tab2" style="height: 50px;">یافته‌ها</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="page4_pane1" class="tab-pane fade in active" style="padding: 15px 0 15px 0;">
                        <div>
                            <label style="font-weight: normal;"><input type="checkbox" name="search_for_title" id="search_for_title" checked="checked"> {!! trans('app.title') !!}</label><br />
                            <label style="font-weight: normal;"><input type="checkbox" name="search_for_content" id="search_for_content"> {!! trans('app.content') !!}</label>
                        </div>
                        <div style="margin-top: 10px;">
                            <label style="font-weight: normal;"><input type="checkbox" name="search_in_posts" id="search_in_posts" checked="checked"> {!! trans('app.posts') !!}</label><br />
                            <label style="font-weight: normal;"><input type="checkbox" name="search_in_pages" id="search_in_pages" checked="checked"> {!! trans('app.pages') !!}</label>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="page4_pane2" style="padding: 15px 0 15px 0;">
                        <div id="page4_pane2_content">
                            <span>{!! trans('app.no_result') !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function()
        {
            GeminiScrollbar_make('#page4_pane2_content');
            $('#search_term').keypress(function(event) {
                if (event.keyCode == 13 || event.which == 13) {
                    $('#search_submit').click();
                }
            });
            $(document).on('click', '#search_submit', function()
            {
                search_term = $('#search_term').val().trim();
                search_for_title = +$('#search_for_title').is(':checked');
                search_for_content = +$('#search_for_content').is(':checked');
                search_in_posts = +$('#search_in_posts').is(':checked');
                search_in_pages = +$('#search_in_pages').is(':checked');
                if ('' == search_term) { alert('برای جستجو چیزی بنویسید.'); return; }
                if (!(search_for_title || search_for_content)) { alert('حداقل یکی از گزینه های "عنوان" یا "متن" را انتخاب کنید.'); return; }
                if (!(search_in_posts || search_in_pages)) { alert('حداقل یکی از گزینه های "صفحات" یا "پست ها" را انتخاب کنید.'); return; }
                $('#page4_pane2_content').fadeOut(function()
                {
                    $('#page4_pane2_content').html('<span class="loader_slider"></span>');
                    $('#page4_pane2_content').fadeIn();
                });
                $('#page4_tab2').click();
                $.ajax
                ({
                    type: 'post',
                    url: Baseurl + 'search',
                    cache: false,
                    data:
                        {
                            'term': search_term,
                            'for_title': search_for_title,
                            'for_content': search_for_content,
                            'in_posts': search_in_posts,
                            'in_pages': search_in_pages
                        },
                    success: function(response)
                    {
                        $('#page4_pane2_content').fadeOut(function()
                        {
                            $('#page4_pane2_content').html(response);
                            $('#page4_pane2_content').fadeIn(function()
                            {
                                GeminiScrollbar_make('#page4_pane2_content');
                            });
                        });
                    }
                });
            });

            $(document).on('keyup', '#bookmarklist-search', function ()
            {
                clearTimeout(bookmark_search_time);
                bookmark_search_time = setTimeout(function ()
                {
                    $('#BookmarkFehresrt').html('<div class="loader"></div>');
                    $.ajax
                    ({
                        type: 'post',
                        url: Baseurl + 'bookmarks',
                        data: {'term': $('#bookmarklist-search').val()},
                        dataType: 'html',
                        success: function (response)
                        {
                            $('#BookmarkFehresrt').html(response);
                            GeminiScrollbar_BookmarkFehresrt.update();
                        }
                    });
                }, 1000);
            });
        });
    </script>
</div>