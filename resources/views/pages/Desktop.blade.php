@extends('layouts.master')
@section('content')
    <div class="panel-body text-decoration">
        <div class='text-content'>
            @if($content=='thesarusadd')
                @include('pages.Desktop.ADD.thesarus')
            @elseif($content=='formadd')
                @include('pages.Desktop.ADD.formadd')
            @elseif($content=='subject_field')
                @include('pages.Desktop.fields')
            @elseif($content=='user_edit')
                @include('pages.Desktop.user_form')
            @elseif($content=='user_add')
                @include('pages.Desktop.ADD.user_form')
            @elseif($content=='ProccessAdd')
                @include('pages.Desktop.ADD.ProccessAdd')
            @elseif($content=='editsubtype')
            @else
                {!!$content!!}
            @endif
        </div>
    </div>
@stop
@section('keywords')
    <div class='text-content'>
        @if (!empty($keywords) && is_array($keywords))
            <hr>
            <b>کلیدواژه‌ها:</b>
            @foreach($keywords as $item)
                <li><a href="{{ $item['id'] }}">{{ $item['title']}}</a></li>
            @endforeach
        @endif
    </div>
@stop
@include('sections.files')
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
{{--
@section('Tree')
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
                    'data': {
                        "url": '{{ URL::route('hamahang.Menus.get_menu_nodes')}}',
                        type: 'POST',
                        "data": function (node) {
                            return {"id": node.id};
                        }
                    },
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
                    // domain = "{{App::make('url')->to('/')}}//desktop/" + id;
                    if (n == -1) {
                        var n = id.indexOf("#");
                        domain = "{{App::make('url')->to('/')}}/{{$sid}}/desktop/" + id;
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
        <script>
            $(document).ready(function () {
                $('.TitleMenu').click(function () {
                    $('.TitleMenu').next(".v").hide();
                    $(this).next(".v").show();
                });
            });
        </script>
    </div>
@stop
--}}
