@extends('layouts.master')
@section('content')
<div class="panel-body text-decoration" >

    <script>
        $(document).ready(function() {
        $(".selection").click(function() {
        sThisVal = '';
                $('input:checkbox.selection').each(function () {
        sThisVal += (this.checked ? "'"+$(this).val()+"'" : "") + ',';
        });
        //alert(sThisVal);
                var type = '{{$PType}}';
                $("#frame").attr("src", Baseurl + "user_measuresget?sel=" + sThisVal + "&type=" + type);
        });
        });            </script>
     dasd {{$finish3}}
    <div style="padding: 10px;">fgdg
        نمایش وظایف 
        <input type="checkbox" class="selection" name="finish" value="0"  {{$finish0}} >{{trans('tasks.status_not_started')}}
        <input type="checkbox" class="selection"  name="finish" value="1"  {{$finish1}}>{{trans('tasks.status_started')}}
        <input type="checkbox" class="selection"  name="finish" value="2"  {{$finish2}}>{{trans('tasks.status_done')}}
        <input type="checkbox" class="selection"  name="finish" value="3" {{$finish3}}>{{trans('tasks.status_finished')}}

    <div class='text-content'>
        <iframe id="frame" src="{{App::make('url')->to('/')}}/user_measuresget?type={{$PType}}&sel='0'" frameborder="0" style="display: block;background: #fff;border: none;height: 100vh;width: 100%;" height="100%" width="100%">

        </iframe> 
    </div>

    @stop

    @section('keywords')
    <div class='text-content'>
        @if (is_array($keywords))
        <hr>
        <b>کلیدواژه‌ها:</b>
        @foreach($keywords as $item)
        <li><a href="{{ $item['id'] }}">{{ $item['title']}}</a></li>
        @endforeach
        @endif
    </div>
    @stop


    @section('Files')
    @if (is_array($Files) && count($Files)>0)
    <div class="spacer">
        <div class="panel panel-light fix-box1">
            <div class="fix-inr1">
                <div style="padding: 0;" class="panel-heading panel-heading-darkblue"></div>
                <div class="panel-body text-decoration">
                    <b>{{ trans('label.Files')  }}</b>
                    @foreach($Files as $item)
                    <li><a href="{{ $item['id'] }}">{{ $item['ext']}} -><span>{{ $item['title']}}</span>:{{ $item['size']}}ک.ب</a></li>
                    @endforeach
                </div>

            </div>

        </div>
    </div>
    @endif
    @stop




    @section('tabs')
    @if (is_array($tabs))
    @foreach($tabs as $item)
    @if (trim($item['link']) === trim($pid))
    <li class="active"><a href="{{App::make('url')->to('/')}}/{{ $item['href'] }}">{{ $item['title'] }}</a></li>
    @else
    <li><a href="{{App::make('url')->to('/')}}/{{ $item['href'] }}">{{ $item['title']}}</a></li>
    @endif
    @endforeach
    @endif
    @stop

    @section('Tree')
    @if ($Tree!='')

    <div class="panel-body searching-cntnt">

        <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
            <div class="txtsearch">
                <input type="text" placeholder="غربال..." id="list-search" />
            </div>
            <div accordion="" class="panel-group accordion" id="accordion">
                <div id="Fehresrt" class="v"></div>
            </div>  
        </div>

        <script>
                    $(function () {
                    $("#Fehresrt").jstree({
                    "plugins" : [ "search" ]
                    });
                            var to = false;
                            $('#list-search').keyup(function () {
                    if (to) { clearTimeout(to); }
                    to = setTimeout(function () {
                    var v = $('#list-search').val();
                            $('#Fehresrt').jstree(true).search(v);
                    }, 250);
                    });
                    });
                    $('#Fehresrt').jstree({
            "plugins" : [ "search" ],
                    'core': {
                    'data': [
                    {{$Tree}}
                    ],
                            'rtl': true,
                            "themes": {
                            "icons": false
                            }
                    }
            });
                    $("#Fehresrt").bind('select_node.jstree',
                    function (e, data)
                    {
                    var id = data.node.id;
                            var n = id.indexOf("#");
                            //                            domain = "{{App::make('url')->to('/')}}//desktop/" + id;
                            if (n == - 1){
                    var n = id.indexOf("#");
                            domain = "{{App::make('url')->to('/')}}/{{$uname}}/desktop/" + id;
                            window.location = domain;
                    }
                    else{

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
                    $(function () {
                    $("#Fehresrt{{$i}}").jstree({
                    });
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
                    function (e, data)
                    {
                    var id = data.node.id;
                            var n = id.indexOf("#");
                            domain = "{{App::make('url')->to('/')}}/{{$uname}}/desktop/" + id;
                            if (n == - 1)
                            window.location = domain;
                    }); ;</script>

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
