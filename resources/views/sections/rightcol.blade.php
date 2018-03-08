@if (isset($Tree) && $Tree!='' && $Tree!='groupadmin' && $Tree!='ismember')
    <div class="Fehrest">
        <div class="panel-heading panel-heading-darkblue ">فهرست</div>
        <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
            <div class="txtsearch">
                <input type="text" placeholder="غربال..." id="list-search"/>
            </div>
            <div accordion="" class="panel-group accordion" id="accordion">
                <div id="Fehresrt" class="v"></div>
            </div>
        </div>
    </div>
    <style>
        .jstree-leaf > a
        {
            color: #337ab7 !important;
            font-size: 10px !important;
        }
        .jstree-open > a,
        .jstree-closed > a
        {
            font-size: 12px !important;
        }
    </style>
    <script>
        $(function () {
            $("#Fehresrt").jstree({
                "plugins": ["search"]
            });
            var to = false;
            $('#list-search').keyup(function () {
                if (to) {
                    clearTimeout(to);
                }
                to = setTimeout(function () {
                    var v = $('#list-search').val();
                    $('#Fehresrt').jstree(true).search(v);
                }, 250);
            });
        });
        $('#Fehresrt').jstree({
            "plugins": ["search"],
            'core': {
                'data': [
                    {!!$Tree!!}
                ],
                'rtl': true,
                "themes": {
                    "icons": false
                }
            }
        });
        $('#Fehresrt').bind
        (
            'select_node.jstree',
            function (e, data)
            {
                var id = data.node.id;
                var n = id.indexOf('#');
                if ($('#' + id).hasClass('jstree-leaf'))
                {
                    if (n != -1)
                    {
                                @if ('user' == $PageType)
                        var href = id;
                        var target = $(href).parents('.scrl-2.big');
                        if (target.length)
                        {
                            e.preventDefault();
                            target.mCustomScrollbar('scrollTo', href);
                        }
                        @endif
                    } else
                    {
                        @if (isset($ContentType) && 'OnlyTree' == $ContentType)
                        jQuery('#TextSection').css('width', '100%');
                        jQuery('#TextSection').html('<div style="min-height: 350px;"><div class="loader"></div><div>');
                        jQuery.ajax
                        ({
                            type: 'POST',
                            url: '{{ route('hamafza.get_tree_node') }}',
                            data: {ptid: id},
                            cache: false,
                            success: function (html)
                            {
                                jQuery('#TextSection').html(html);
                            }
                        });
                                @else
                        var href = '#t' + id;
                        window.location = href;
                        //var urls='#t'+id;
                        //location.hash = urls;
                        //window.location = urls;
                        //$("#main").css("top", "53px");
                        @endif
                    }
                }
            }).on('activate_node.jstree', function (e, data)
        {
            window.location.href = data.node.a_attr.href;
            history.pushState("", document.title, window.location.pathname + window.location.search);
        });
    </script>
@endif
@if (is_array($RightCol))
    @foreach($RightCol as $item)
        <div class="panel-heading panel-heading-darkblue">{!!$item[0] !!} </div>
        <div class="panel panel-light panel-list padding-remove">
        <!--<div class="panel-heading panel-heading-darkblue">{!!$item[0] !!}</div>-->
            <div class="panel-body new-list">
                <?php
                $item[1] = json_encode($item[1]);
                $item[1] = json_decode($item[1]);
                ?>
                @if (is_array($item[1]) && count($item[1])>0 )
                    <ul class="">
                        @foreach($item[1]  as $items)
                            <li>
                                <table>
                                    @if($item[2]=='wall')
                                        <?php
                                        if (array_key_exists('OrganPic', $items) && $items->OrganPic != '')
                                        {
                                            $pics = 'pics/group/Groups.png';
                                            if (trim($items->OrganPic) != '' && file_exists('pics/group/' . $items->OrganPic))
                                                $pics = 'pics/group/' . $items->OrganPic;
                                            $name = $items->OrganName;
                                            $link = $items->Organlink;
                                            $link2 = $items->Organlink;
                                        }
                                        else
                                        {
                                            $pics = $items->avatar_img_url;//'pics/user/Users.png';
                                            //if (trim($items->Pic) != '' && file_exists('pics/user/' . $items->Pic))
                                            //$pics = 'pics/user/' . $items->Pic;
                                            // $link = $items->Uname . "/wall";
                                            $link = session('Uname') . "/wall";
                                            $link2 = $items->Uname;
                                            $name = $items->Name . ' ' . $items->Family;
                                        }
                                        ?>
                                        <tr>
                                            <td style="width: 30px;"><a class="stooltip title-button1 status " data-placement="top" data-toggle="tooltip" page="user" href="{!!App::make('url')->to('/')!!}/{!!$link2!!}"><img
                                                            title="{!!$name!!}" class="CircleImage" src="{!!$pics!!}"/></a></td>
                                            <td style="text-align: right;"><a href="{!!App::make('url')->to('/')!!}/{!!$link!!}">{!!$items->title!!}</a></td>
                                        </tr>
                                    @elseif($item[2]=='userwall')
                                        <?php
                                        $pic = 'pics/group/Groups.png';
                                        if (trim($items->Pic) != '' && file_exists('pics/group/' . $items->Pic))
                                        {
                                            $pic = 'pics/group/' . $items->Pic;
                                        }
                                        ?>
                                        @if($items->isorgan=='0')
                                            <tr>
                                                <td style="width: 30px;"><img class="CircleImage" src="{!!App::make('url')->to('/')!!}/{!!$pic!!}"/></td>
                                                <td style="text-align: right;"><a target="b_blank" href="{!!App::make('url')->to('/')!!}/{!!$items->link!!}?tab=contents">{!!$items->name!!}</a></td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td style="width: 30px;"><img class="CircleImage" src="{!!App::make('url')->to('/')!!}/{!!$pic!!}"/></td>
                                                <td style="text-align: right;"><a target="b_blank" href="{!!App::make('url')->to('/')!!}/{!!$items->link!!}?tab=contents" style="color:#424F5A">{!!$items->name!!}</a></td>
                                            </tr>
                                        @endif
                                    @elseif($item[2]=='alerts')
                                        <tr>
                                            <td style="text-align: right;">@if($items->read==0) <b>@endif <a target="b_blank" href="{!!$items->link!!}/contents">{!!$items->subject2!!}</a>@if($items->read==0) </b>@endif</td>
                                        </tr>
                                    @elseif($item[2]=='usernot')
                                        @if ( array_key_exists('link', $items) && $items->link!= '')
                                            <tr>
                                                <td style="width: 30px;"></td>
                                                <td style="text-align: right;"><a href="{!! $items->link!!}">{!! $items['subject']!!}</a></td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td style="width: 30px;"></td>
                                                <td style="text-align: right;"><a href="viewnotif.php?NotID={!! $items['id']!!}" rel="nofollow">{!! $items['subject']!!}</a></td>
                                            </tr>
                                        @endif
                                    @else
                                        <?php
                                        $pics = 'pics/user/Users.png';
                                        if (trim($items->Pic) != '' && file_exists('pics/user/' . $items->Pic))
                                            $pics = 'pics/user/' . $items->Pic;
                                        ?>
                                        <tr>
                                            <td style="width: 30px;"><img class="CircleImage" src="{!!$pics!!}"/></td>
                                            <td style="text-align: right;"><a href="{!!App::make('url')->to('/')!!}/forum/{!!$items->sid!!}">{!!$items->title!!}</a></td>
                                        </tr>
                                    @endif
                                </table>
                            </li>
                        @endforeach
                    </ul>
                @else
                    @if(!is_array($item[1]))
                        {!!$item[1]!!}
                    @endif
                @endif
            </div>
        </div>
    @endforeach
@endif
{{--

@php
    $route = Route::current();
    $route_type = strtolower($route->type);
    $route_id = $route->id;
    //dd($route_id);
@endphp

@if ('370450' == $route_id && 'onlytree' == $route_type)
    <script>
        $(document).ready(function()
        {
            $('#19694_anchor').click();
            $('#19695_anchor').click();
        });
    </script>
@endif
--}}
