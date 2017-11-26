@extends('layouts.master')
@section('specific_plugin_style')
    <link rel="stylesheet" href="{{url('theme/Content/css/FlowChart.css')}}"/>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{url('theme/Scripts/jquery-1.11.0.min.js')}}"></script>
    <script type="text/javascript" src="{{url('theme/Scripts/FlowChart.js')}}"></script>
@stop
@section('content')
    <div class="panel-body text-decoration">
        <div class='text-content'>
            @if (is_array($content))
                <ul id="source" style="display: none;">
                    @foreach($content as $item)
                        <li><span class="text">{{ $item->phase_name}}</span></li>
                    @endforeach
                </ul>
                <div id="target"></div>
                <script type="text/javascript">
                    $(function () {
                        $('#source').flowChart('#target');
                    });
                </script>
            @else
                @if ($content=='edit')
                    @include('pages.Desktop.editform')
                @endif
            @endif
        </div>
    </div>
@stop
@include('sections.keywords')
@include('sections.tabs')
@section('Tree')
    @if ($Tree!='')
        <div class="panel-body searching-cntnt">
            <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
                <div class="txtsearch">
                    <input type="text" placeholder="غربال..." id="list-search"/>
                </div>
                <div accordion="" class="panel-group accordion" id="accordion">
                    <div id="Fehresrt" class="v"></div>
                </div>
            </div>
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
                $("#Fehresrt").bind('select_node.jstree',
                    function (e, data) {
                        var id = data.node.id;
                        var n = id.indexOf("#");
                        //                            domain = "{{App::make('url')->to('/')}}//desktop/" + id;
                        if (n == -1) {
                            var n = id.indexOf("#");
                            domain = "{{App::make('url')->to('/')}}/{{$uname}}/desktop/" + id;
                            window.location = domain;
                        }
                        else {

                        }
                    })
                    .on("activate_node.jstree", function (e, data) {
                        window.location.href = data.node.a_attr.href;
                        history.pushState("", document.title, window.location.pathname + window.location.search);
                    });
            </script>
            <?php $i = 1; ?>
            @if(is_array($Tree))
                @foreach($Tree as $item)
                    <div accordion="" class="panel-group accordion" id="accordion">
                        <span class="TitleMenu openMenu">{{$item->name}}</span>
                        @if ($i==1)
                            <div id="Fehresrt{{$i}}" class="v openMenu"></div>
                        @else
                            <div id="Fehresrt{{$i}}" class="v closeMenu"></div>
                        @endif
                    </div>
                    <script>
                        $(function () {
                            $("#Fehresrt{{$i}}").jstree({});
                        });
                        $('#Fehresrt{{$i}}').jstree({
                            'core': {
                                'data':
                                {{json_encode($item->menus, true) }}
                                ,
                                'rtl': true,
                                "themes": {
                                    "icons": false
                                }
                            }
                        });
                        $("#Fehresrt{{$i}}").bind('select_node.jstree',
                            function (e, data) {
                                var id = data.node.id;
                                var n = id.indexOf("#");
                                domain = "{{App::make('url')->to('/')}}/{{$uname}}/desktop/" + id;
                                if (n == -1)
                                    window.location = domain;
                            });
                    </script>
                    <?php $i++; ?>
                @endforeach
            @endif
            <script>
                $(document).ready(function () {
                    $('.TitleMenu').click(function () {
                        $('.TitleMenu').next(".v").hide();
                        $(this).next(".v").show();
                    });
                });
            </script>
        </div>
    @endif
@stop
