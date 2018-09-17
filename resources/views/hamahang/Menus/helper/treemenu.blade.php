<style type="text/css">
    .jstree li > a > .jstree-icon {
        display: none !important;
    }
</style>

{{--<div class="Fehrest">--}}
    {{--<div class="panel-heading panel-heading-darkblue ">فهرست</div>--}}
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
        <div class="txtsearch">
            <input type="text" placeholder="غربال..." id="list-search"/>
        </div>
        <div accordion="" class="panel-group accordion" id="accordion">
            <div id="Fehresrt" class="v"></div>
        </div>
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
    $('#Fehresrt').jstree({
        "plugins": ["search", "sort"],
        'core': {
            'data': {
                "url": '{{ URL::route('hamahang.Menus.get_menu_nodes')}}',
                type: 'POST',
                "data": function (node) {
                    return {
                        "id": node.id,
                        'type_id': '{{ $type_id }}',
                        'current_url': '{{url()->current()}}'
                        @if($subject_id)
                        , 'subject_id': '{{$subject_id}}'
                        @endif
                    };
                }
            }
        },
        'rtl': true,
        "themes": {
            "icons": false
        }
    });
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

