@extends('layout.master')
@section('csrf_token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('Specific_CSS_Plugin')
    <link href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}" rel="stylesheet"/>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <table id="MyFilesGrid" data-ajax="true" data-url="{{URL::route('FileManager.AjaxGridMyFiles')}}" class="table table-condensed table-hover table-striped">
                    <thead>
                    <tr>
                        <th data-column-id="id" data-type="numeric" data-identifier="true">#</th>
                        <th data-column-id="originalName">{{trans('filemanager.file_name')}}</th>
                        <th data-column-id="extension">{{trans('filemanager.file_postfix')}}</th>
                        <th data-column-id="mimeType">{{trans('filemanager.file_type')}}</th>
                        <th data-column-id="size">{{trans('filemanager.file_size')}}</th>
                        <th data-column-id="created_at">{{trans('filemanager.file_create_date')}}</th>
                        <th data-column-id="link" data-formatter="link" data-sortable="false"{{trans('filemanager.action')}}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop

@section('SpecificJSPlugin')
    <script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('assets/Packages/Grid/dist/jquery.bootgrid.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('assets/Packages/Grid/dist/jquery.bootgrid.fa.js')}}" type="text/javascript"></script>
    <script>
        var selectedrow = [];
        $("#MyFilesGrid").bootgrid({
            selection: true,
            multiSelect: true,
            formatters: {
                "link": function (column, row) {
                    return "<a class='cls3' style='margin: 2px' onclick='f(" + row.id + ")' href=\"#\"><i class='fa fa-edit'></i></a><a style='margin:2px;' class='cls3'  onclick='del(" + row.id + ")' href=\"#\"><i >حذف</i></a>";
                }
            }

        }).on("selected.rs.jquery.bootgrid", function(e, rows)
        {
            //console.log(e);

            for (var i = 0; i < rows.length; i++)
            {
                var x = parseInt (rows[i].id);
                selectedrow['"'+x+'"'] = x;
            }
            console.log(selectedrow);
        }).on("deselected.rs.jquery.bootgrid", function(e, rows)
        {
            for (var i = 0; i < rows.length; i++)
            {
                var x = parseInt (rows[i].id);
                delete selectedrow['"'+x+'"'];
            }
            console.log(selectedrow);
        });
    </script>
@stop

