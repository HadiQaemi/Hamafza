<style type="text/css">
    .jstree li > a > .jstree-icon {
        display: none !important;
    }
</style>

<div class="panel-body searching-cntnt">
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
        <div class="txtsearch">
            <input type="text" placeholder="{{ trans('menus.filter') }}" id="list-search"/>
        </div>
        <div accordion="" class="panel-group accordion" id="accordion">
            <div id="Fehresrt" class="v"></div>
        </div>
    </div>
</div>

<script>
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

