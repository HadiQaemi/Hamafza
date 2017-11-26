


    @extends('layouts.master')
@section('content')
    <script type="text/ecmascript" src="{{App::make('url')->to('/')}}/theme/jqwidgets/grid.locale-en.js"></script>
    <!-- This is the Javascript file of jqGrid -->
    <script type="text/ecmascript" src="{{App::make('url')->to('/')}}/theme/jqwidgets/jquery.jqGrid.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="{{App::make('url')->to('/')}}/theme/jqwidgets//ui.jqgrid-bootstrap.css" />
    <script src="{{App::make('url')->to('/')}}/theme/jqwidgets/plugins/jquery.searchFilter.js" type="text/javascript"></script>

<div class="panel-body text-decoration">

    <div class='text-content'>

        <div style="margin-left:20px">
    <table id="jqGrid"></table>
    <div id="jqGridPager"></div>
</div>
    <script type="text/javascript">
        $(document).ready(function () {

            $("#jqGrid").jqGrid({
                url: 'http://trirand.com/blog/phpjqgrid/examples/jsonp/getjsonp.php?callback=?&qwery=longorders',
                mtype: "GET",
				styleUI : 'Bootstrap',
                datatype: "jsonp",
                colModel: [
                    { label: 'OrderID', name: 'OrderID', key: true},
                    { label: 'Customer ID', name: 'CustomerID', search:true ,searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']} },
                    { label: 'Order Date', name: 'OrderDate', search:true },
                    { label: 'Freight', name: 'Freight', search:true },
                    { label:'Ship Name', name: 'ShipName', search:true }
                ],
				viewrecords: true,
                height: 500,
                rowNum: 10,
                pager: "#jqGridPager"
            });
            jQuery("#jqGrid").jqGrid('filterToolbar',{searchOperators : true});
        });

   </script>


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
           sssssssss

        @else

        @endif
        <div id="grid_export" style="margin: auto;">
    </div>
        <div id="grid_php" style="margin:5px auto;"></div>


    </div>

 <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
        <div id="jqxgrid">
        </div>
        <div>
            <h3>Alignment</h3>
            <div style="float: left;" id="leftbutton">Left</div>
            <div style="float: left;" id="centerbutton">Center</div>
            <div style="float: left;" id="rightbutton">Right</div>
        </div>
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


