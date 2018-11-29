<style type="text/css">
    /*.jstree li > a > .jstree-icon {*/
        /*display: none !important;*/
    /*}*/
</style>

{{--<div class="Fehrest">--}}
    {{--<div class="panel-heading panel-heading-darkblue ">فهرست</div>--}}
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px;height: 80vh;overflow:auto;width: 100%;padding: 0px;margin: 0px;background: #999999">
        <style>
            #pcol_32{
                overflow-x: hidden;
            }
            #pcol_32 > div{
                margin-left: -10px;
            }
            .background-white.scrl {
                background: #999999;
            }
            .container-menu {
                padding-top: 2px;
                margin-left: -5px;
            }
            .container-menu > ul {
                list-style: none;
                padding: 0;
                margin: 0 0 20px 0;
            }

            .dropdown-ver a {
                text-decoration: none;
            }
            .dropdown-ver [data-toggle="dropdown-ver"] {
                position: relative;
                display: block;
                color: white;
                background: #67696b;
                box-shadow: 0 1px 0 #888c8e inset, 0 -1px 0 #484a4c inset;
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.3);
                padding: 10px;
                text-align: right;
            }
            .dropdown-ver [data-toggle="dropdown-ver"]:hover {
                background: #919292;
            }
            .dropdown-ver .icon-arrow {
                position: absolute;
                display: block;
                font-size: 0.7em;
                color: #fff;
                top: 14px;
                left: 10px;
            }
            .dropdown-ver .dropdown-menu {
                max-height: 0;
                overflow: hidden;
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .dropdown-ver .dropdown-menu li {
                padding: 0;
                text-align: right;
            }
            .dropdown-ver .dropdown-menu li a {
                display: block;
                color: #111;
                background: #b3b3b3;
                padding: 10px 10px;
            }
            .dropdown-ver .active > a{
                border-right: 4px solid #FFF;
            }
            .dropdown-ver .dropdown-menu li a:active {
                border-right: 4px solid #FFF;
            }
            .dropdown-ver .dropdown-menu li a:focus {
                border-right: 4px solid #FFF;
            }
            .dropdown-ver .dropdown-menu li a:hover {
                background: #a09d9d;
            }
            .dropdown-ver .show, .dropdown-ver .hide {
                -moz-transform-origin: 50% 0%;
                -ms-transform-origin: 50% 0%;
                -webkit-transform-origin: 50% 0%;
                transform-origin: 50% 0%;
            }
            .dropdown-ver .show li{
                border-bottom: 1px solid #fff;
            }
            .dropdown-ver .show li a{
                padding-right: 20px;
            }
            .dropdown-ver .show {
                position: relative;
                width: 100%;
                font-size: 10px;
                margin-bottom: 15px;
                display: block;
                max-height: 9999px;
                -moz-transform: scaleY(1);
                -ms-transform: scaleY(1);
                -webkit-transform: scaleY(1);
                transform: scaleY(1);
                animation: showAnimation 0.0s ease-in-out;
                -moz-animation: showAnimation 0.0s ease-in-out;
                -webkit-animation: showAnimation 0.0s ease-in-out;
                -moz-transition: max-height 1s ease-in-out;
                -o-transition: max-height 1s ease-in-out;
                -webkit-transition: max-height 1s ease-in-out;
                transition: max-height 1s ease-in-out;
            }
            .dropdown-ver .hide {
                max-height: 0;
                -moz-transform: scaleY(0);
                -ms-transform: scaleY(0);
                -webkit-transform: scaleY(0);
                transform: scaleY(0);
                animation: hideAnimation 0.0s ease-out;
                -moz-animation: hideAnimation 0.0s ease-out;
                -webkit-animation: hideAnimation 0.0s ease-out;
                -moz-transition: max-height 0.6s ease-out;
                -o-transition: max-height 0.6s ease-out;
                -webkit-transition: max-height 0.6s ease-out;
                transition: max-height 0.6s ease-out;
            }
        </style>
        <div class="container-menu"></div>

        {{--<div id="Fehresrt" class="v"></div>--}}
        {{--<div class="txtsearch">--}}
            {{--<input type="text" placeholder="غربال..." id="list-search"/>--}}
        {{--</div>--}}
        {{--<div accordion="" class="panel-group accordion" id="accordion">--}}
            {{--<div id="Fehresrt" class="v"></div>--}}
        {{--</div>--}}
    </div>
{{--</div>--}}
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
    $(document).on('click', '.dropdown-ver', function (e) {
        var node = $(this).attr('node');
        $('.dropdown-menu').removeClass('show');
        $('.dropdown-ver').removeClass('active');
        $('.dropdown-menu').addClass('hide');
        $('.node' + node).removeClass('hide');
        $('.node' + node).addClass('show');
        $('.show-index').removeClass('hide');
        $('.show-index').addClass('show');
        $(this).addClass('active');
    });
    $.ajax({
        type: "POST",
        async: false,
        url: '{{ URL::route('hamahang.Menus.get_menu_nodes')}}',
        data: {
            'id': '#',
            'type_id': '{{ $type_id }}',
            'current_url': '{{url()->current()}}'
            @if($subject_id)
            , 'subject_id': '{{$subject_id}}'
            @endif
        },
        success: function(msg){
            console.log(msg);
            $('.container-menu').html(msg);
        },
    });
    {{--$('#Fehresrt').jstree({--}}
        {{--"plugins": ["search", "sort"],--}}
        {{--'core': {--}}
            {{--'data': {--}}
                {{--"url": '{{ URL::route('hamahang.Menus.get_menu_nodes')}}',--}}
                {{--type: 'POST',--}}
                {{--"data": function (node) {--}}
                    {{--return {--}}
                        {{--"id": node.id,--}}
                        {{--'type_id': '{{ $type_id }}',--}}
                        {{--'current_url': '{{url()->current()}}'--}}
                        {{--@if($subject_id)--}}
                        {{--, 'subject_id': '{{$subject_id}}'--}}
                        {{--@endif--}}
                    {{--};--}}
                {{--}--}}
            {{--}--}}
        {{--},--}}
        {{--'rtl': true,--}}
        {{--"themes": {--}}
            {{--"icons": false--}}
        {{--}--}}
    {{--});--}}
    $("#Fehresrt").on("activate_node.jstree", function (e, data) {
        if (data.node.a_attr.href != '#') {
            window.location.href = data.node.a_attr.href;
            history.pushState("", document.title, window.location.pathname + window.location.search);
        }
    });
    {{--$("#Fehresrt").bind('select_node.jstree',
        function (e, data) {
            var id = data.node.id;
            var n = id.indexOf("#");
//    domain = "{{App::make('url')->to('/')}}//desktop/" + id;
            if (data.node.a_attr.href != '#') {
                var n = id.indexOf("#");
                {{--domain = "{{App::make('url')->to('/')}}/{{$uname}}/desktop/" + id;
                window.location = domain;
            }
            else {

            }
        })
        .on("activate_node.jstree", function (e, data) {
            if (data.node.a_attr.href != '#') {
                window.location.href = data.node.a_attr.href;
                history.pushState("", document.title, window.location.pathname + window.location.search);
            }
        });--}}
</script>




{{--<script>--}}
    {{--$(function () {--}}
        {{--$("#Fehresrt").jstree({--}}
            {{--"plugins": ["search"]--}}
        {{--});--}}
        {{--var to = false;--}}
        {{--$('#list-search').keyup(function () {--}}
            {{--if (to) {--}}
                {{--clearTimeout(to);--}}
            {{--}--}}
            {{--to = setTimeout(function () {--}}
                {{--var v = $('#list-search').val();--}}
                {{--$('#Fehresrt').jstree(true).search(v);--}}
            {{--}, 250);--}}
        {{--});--}}
    {{--});--}}
    {{--$('#Fehresrt').jstree({--}}
        {{--"plugins": ["search"],--}}
        {{--'core': {--}}
            {{--'data': [--}}
                {{--{!!$Tree!!}--}}
            {{--],--}}
            {{--'rtl': true,--}}
            {{--"themes": {--}}
                {{--"icons": false--}}
            {{--}--}}
        {{--}--}}
    {{--});--}}
    {{--$('#Fehresrt').bind--}}
    {{--(--}}
            {{--'select_node.jstree',--}}
            {{--function (e, data)--}}
            {{--{--}}
                {{--var id = data.node.id;--}}
                {{--var n = id.indexOf('#');--}}
                {{--if ($('#' + id).hasClass('jstree-leaf'))--}}
                {{--{--}}
                    {{--if (n != -1)--}}
                    {{--{--}}
                                {{--@if ('user' == $PageType)--}}
                        {{--var href = id;--}}
                        {{--var target = $(href).parents('.scrl-2.big');--}}
                        {{--if (target.length)--}}
                        {{--{--}}
                            {{--e.preventDefault();--}}
                            {{--target.mCustomScrollbar('scrollTo', href);--}}
                        {{--}--}}
                        {{--@endif--}}
                    {{--} else--}}
                    {{--{--}}
                        {{--@if (isset($ContentType) && 'OnlyTree' == $ContentType)--}}
                        {{--jQuery('#TextSection').css('width', '100%');--}}
                        {{--jQuery('#TextSection').html('<div style="min-height: 350px;"><div class="loader"></div><div>');--}}
                        {{--jQuery.ajax--}}
                        {{--({--}}
                            {{--type: 'POST',--}}
                            {{--url: '{{ route('hamafza.get_tree_node') }}',--}}
                            {{--data: {ptid: id},--}}
                            {{--cache: false,--}}
                            {{--success: function (html)--}}
                            {{--{--}}
                                {{--jQuery('#TextSection').html(html);--}}
                            {{--}--}}
                        {{--});--}}
                                {{--@else--}}
                        {{--var href = '#t' + id;--}}
                        {{--window.location = href;--}}
                        {{--//var urls='#t'+id;--}}
                        {{--//location.hash = urls;--}}
                        {{--//window.location = urls;--}}
                        {{--//$("#main").css("top", "53px");--}}
                        {{--@endif--}}
                    {{--}--}}
                {{--}--}}
            {{--}).on('activate_node.jstree', function (e, data)--}}
    {{--{--}}
        {{--window.location.href = data.node.a_attr.href;--}}
        {{--history.pushState("", document.title, window.location.pathname + window.location.search);--}}
    {{--});--}}
{{--</script>--}}

