@extends('layouts.master')
@section('content')
    <div class="panel-body text-decoration">
         <div style="margin: 15px;">
            <form id="myForm">
                <table class="table">
                    <tbody>
                    <tr>
                        <td style="text-align: right;border:none;">
                            <input type="radio" checked="" value="my" class="TypeSel" id="TypeSel" name="TypeSel">صفحاتی که من
                            <select class="form-control" style="width: 300px;display: inline;" id="MeCombo" name="MeCombo">
                                <option value="Created_ME" @if($pname=='Created_ME') selected @endif>ایجاد کرده ام</option>
                                <option value="Edited_ME" @if($pname=='Edited_ME') selected @endif>ویرایش کرده ام</option>
                                <option value="follow_ME" @if($pname=='follow_ME') selected @endif>دنبال میکنم</option>
                                <option value="like_ME" @if($pname=='like_ME') selected @endif>پسندیده ام</option>
                                <option value="ano_ME" @if($pname=='ano_ME') selected @endif>یاداشت گذاشته ام</option>
                                <option value="highlight_ME" @if($pname=='highlight_ME') selected @endif>علامت گذاری کرده ام</option>
                                <option value="Proc_ME" @if($pname=='Proc_ME') selected @endif>دارای نقش هستم</option>
                                <option value="visited_ME" @if($pname=='visited_ME') selected @endif>بازدید کرده ام</option>
                                <option value="Sug_ME" @if($pname=='Sug_ME') selected @endif>معرفی کرده ام</option>
                                <option value="ALL_ME" @if($pname=='ALL_ME') selected @endif>همه</option>
                            </select>
                        </td>
                        <td style="text-align: right;border:none;">
                            <input type="radio" value="ALL_Other" @if($pname=='ALL_Other') checked @endif name="TypeSel">همه
                        </td>
                        <td style="text-align: right;border:none;">
                            <input type="radio" value="Deleted_pages" @if($pname=='Deleted_pages') checked @endif  name="TypeSel">حذف شده‌ها
                        </td>
                        <td style="text-align: left;border:none;">
                            <input class="btn btn-primary floatLeft" value="بیاب" id="submitPage" name="submit" style="width: 50px;">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>

        <div class='text-content'>
            <div id='TableContent'>
                {!!$content!!}
            </div>
        </div>
        <script>
            $("#submitPage").click(function () {
                var sel = $("#MeCombo").val();
                var rad = $('input[name=TypeSel]:checked', '#myForm').val();
                if (rad == 'my')
                    window.location = "{{App::make('url')->to('/')}}/{{session('Uname')}}/desktop/Files/" + sel;
                else
                    window.location = "{{App::make('url')->to('/')}}/{{session('Uname')}}/desktop/Files/" + rad;

            });
        </script>
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
                        <span class="TitleMenu openMenu">{{$item['name']}}</span>
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
                                'data':'{!! json_encode($item['menus'], true) !!}',
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
