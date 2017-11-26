@extends('layouts.master')
@section('content')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

<div class='text-content'>
    
     <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>Id</th>
                
            </tr>
        </thead>
    </table>
    
   
    
    
    <script>
            var dataSet = {{$content}};
       $(function() {
    $('#users-table').DataTable({
        "dom": window.CommonDom_DataTables,
        processing: true,
        serverSide: true,
        ajax: dataSet,
        columns: [
            { data: 'id', name: 'id' }
           
        ]
    });
});
} );

        </script>
        
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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
<li class="active"><a href="{{ $item['href'] }}">{{ $item['title'] }}</a></li>
@else
<li><a href="{{ $item['href'] }}">{{ $item['title']}}</a></li>
@endif
@endforeach
@endif
@stop

@section('Tree')
@if ($Tree!='')



<div class="panel-body searching-cntnt">

    <?php $i = 1; ?>
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
                                domain = '{{$uname}}?tab=desktop&Type=' + id;
                                if (n == - 1)
                                window.location = domain;
                                }); ;    </script>

<?php $i++; ?>
@endforeach

<script>
                    $(document).ready(function () {
$('.TitleMenu').click(function () {
$('.TitleMenu').next( ".v" ).hide();
$(this).next( ".v" ).show();
            });
            });
                    
</script>
</div>



@endif
@stop
