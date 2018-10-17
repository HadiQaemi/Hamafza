@php ($logged_in = session('Login') && session('Login') == 'TRUE')
<style>
    ::-webkit-scrollbar {width: 8px}
    ::-webkit-scrollbar-track {background: #ccc;}
    ::-webkit-scrollbar-thumb {background: #999;}
</style>
<style>
    #KeywordSearch,#KeywordFehresrt ul {
        width: 350px !important;
        overflow-y: auto !important;
        height: 80vh !important;
        overflow-x: hidden;
        padding-bottom: 100px;
    }
    #PrtalFehresrt {
        height: 90vh;
        overflow-y: scroll;
        padding-bottom: 100px;
    }
    #BookmarkFehresrt {
        height: 90vh !important;
        overflow-y: scroll !important;
        padding-bottom: 100px !important;
    }

</style>
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
        $(".select2-search__field").attr("placeholder", "{{trans('tasks.search_some_persons')}}").blur();
    });
</script>
@php ($change_color = 'kmkz' == config('constants.IndexView') ? ' style="background-color: #367BAB !important;"' : null)
@php ($style = $logged_in ? null : 'style="display: none;"')
@php ($unstyle = $logged_in ? null : 'style="width: 32%;"')
<div id="h_sidenav" class="h_sidenav" style="overflow: hidden;">
    <div id="h_sidenav_client" class="h_sidenav_client">
        <i class="fa fa-angle-double-left h_sidenav_close" onclick="h_sidenav_close();"></i>
        <a class="jsPanels icon icon-help h_sidenav_help HelpIcons HelpBookmarks" title="راهنمای اینجا" href="{!! url('/modals/helpview?code=x_k4R_cmY34') !!}"></a>
        <a style="margin: -1px 0 0 20px; padding: 0; font-size: 11pt;" class="jsPanels icon icon-help HelpIcons HelpPortals" title="راهنمای اینجا" href="{!! url('/modals/helpview?code=WU99UI5IUgw') !!}"></a>
        <a style="margin: -1px 0 0 20px; padding: 0; font-size: 11pt;" class="jsPanels icon icon-help HelpIcons HelpKeywords" title="راهنمای اینجا" href="{!! url('/modals/helpview?code=UPjv2yJSc80') !!}"></a>
        <a style="margin: -1px 0 0 20px; padding: 0; font-size: 11pt;" class="jsPanels icon icon-help HelpIcons HelpSearch" title="راهنمای اینجا" href="{!! url('/modals/helpview?code=A4MfrJnJ3DI') !!}"></a>
        <ul class="nav nav-tabs navbar-navtabs" style="font-size: 11px;">
            @if ($logged_in)<li><a class="new_sidebar" data-toggle="tab" id="tab1" href="#page1">چوب&zwnj;های الف</a></li>@endif
            <li {!! $unstyle !!}><a class="new_sidebar" data-toggle="tab" id="tab2" href="#page2">درگاه&zwnj;ها</a></li>
            <li {!! $unstyle !!}><a class="new_sidebar" data-toggle="tab" id="tab3" href="#page3">کلیدواژه&zwnj;ها</a></li>
            <li {!! $unstyle !!}><a class="new_sidebar" data-toggle="tab" id="tab4" href="#page4">جستجو</a></li>
        </ul>
        <div class="tab-content" style="width:390px;padding-top: 20px;">@if ($logged_in)
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
            <div id="page3" class="tab-pane fade margin-top--5">
                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 Navigatekeywords">
                        {{--@include('sections.tagNavigat')--}}
                        <select type="text" name="Navigatekeywords" id="Navigatekeywords" multiple="multiple" onchange="$('.keywords_and_or_client').css({'display': $(this).find(':selected').length > 1 ? 'inline' : 'none'});"></select>
                        <div style="margin-top: 10px; display: none;color:#FFF" class="keywords_and_or_client">
                            <input type="radio" id="keywords_and_or_0" value="0" name="keywords_and_or" class="keywords_and_or" checked="checked" /><label for="keywords_and_or_0" style="font-weight: normal;">حداقل یکی</label>
                            <input type="radio" id="keywords_and_or_1" value="1" name="keywords_and_or" class="keywords_and_or" /><label for="keywords_and_or_1" style="font-weight: normal;">همه</label>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <input type="button" value="{{trans('app.find')}}" title="Searchpost" class="btn btn-primary" id="TagBut" style="height: 34px;">
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
                <div class="tab-content" style="width: 390px; height: 1000px; overflow: hidden;">
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
                    <div id="Results" class="tab-pane fade"  style="@if(session('TagSearch')=='')display: none;@endif height: 72vh !important;" >
                        <div class="innerpane">
                            <div class="panel-group accordion" id="Bookmarkaccordion2" style="margin-top: 15px;">
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
                    <input type="text" name="search_term" id="search_term" class="form-control pull-right" placeholder="{{trans('app.search_term')}} ..." style="width: 80%;background: #787979 !important;" />
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