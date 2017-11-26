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
            @elseif($content=='ProccessAdd')
                @include('pages.Desktop.ADD.ProccessAdd')
            @elseif($content=='editsubtype')
                sssssssss
            @else
                {!!$content!!}
            @endif
        </div>
        @stop
        @section('tabs')
            @if (is_array($tabs))
                @foreach($tabs as $item)
                    @if (trim($item->link) === trim($pid))
                        <li class="active"><a href="{{App::make('url')->to('/')}}/{{ $item->href }}">{{ $item->title }}</a></li>
                    @else
                        <li><a href="{{App::make('url')->to('/')}}/{{ $item->href }}">{{ $item->title}}</a></li>
                    @endif
                @endforeach
            @endif
        @stop

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
                                {{--domain = "{{App::make('url')->to('/')}}//desktop/" + id;--}}
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
                            });</script>


                    <?php $i = 1; ?>
                    @if(is_array($Tree))
                        @foreach($Tree as $item)

                            <div accordion="" class="panel-group accordion" id="accordion">
                                <span class="TitleMenu openMenu">{{$item['name']}}</span>

                                @if ($i==1)
                                    <div id="Fehresrt{{$i}}" class="v openMenu"></div>
                                @else
                                    <div id="Fehresrt{{$i}}" class="v closeMenu"></div>
                                @endif


                            </div>
                            <script>
                                <?php
                                $sid = session('Uname');
                                ?>
                                            $(function () {
                                    $("#Fehresrt{{$i}}").jstree({});
                                });
                                $('#Fehresrt{{$i}}').jstree({
                                    'core': {
                                        'data':
                                        {{json_encode($item['menus'], true) }}
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
                                        domain = "{{App::make('url')->to('/')}}/{{$sid}}/desktop/" + id;
                                        if (n == -1)
                                            window.location = domain;
                                    });
                                ;</script>

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