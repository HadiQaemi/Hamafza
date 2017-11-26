<div class="panel panel-default" style="margin: 10px;">
    @include('hamahang.Basicdata.items-panel-heading')
    <div class="panel-body">
        <table id="grid_social" width="100%"
               class="table table-condensed table-bordered table-striped table-hover td-center-align">
            <thead>
            <th style="text-align: center;">{{ trans('tools.rowIndex') }}</th>
            <th style="text-align: center;">{{ trans('tools.head_pic') }}</th>
            <th style="text-align: center;">{{ trans('tools.relatedtab') }}</th>
            <th style="text-align: center;">{{ trans('tools.title') }}</th>
            <th style="text-align: center;">{{ trans('tools.link') }}</th>
            <th style="text-align: center;">{{ trans('tools.operations') }}</th>
            </thead>
        </table>
    </div>
</div>
<script>
    Item_Scial_Grid = $('#grid_social').DataTable
    ({
        language: LangJson_DataTables,
        processing: true,
        serverSide: true,

        dom: '<"space-10">' +
        ' <"row form-inline" <"col-xs-4"f> <"col-xs-4"l>  <"col-xs-4 text-left toolbar"> <"clearfixed">>' +
        ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
        ' <"row" <"col-xs-3"i><"col-xs-9 text-left"p> <"clearfixed"> >',
        initComplete: function () {
            $("div.toolbar").html
            (
                '<a href="{!! route('modals.basicdata_ad_social_view') !!}?basicdata_id={{$data->id}}" class="jsPanels createnewvalue1">' +
                '<button style="position: relative; float: left;"  data-item_type="role" class="btn btn-info btn_grid_add_item " type="button">' +
                '   <i ></i> ' +
                '   {{ trans('app.add')}}' +
                '</button>' +
                '</a>'
            );
        },
        ajax: {
            url: '{!! route('hamahang.basicdata.load_items') !!}',
            type: 'POST',
            data: {'id': id}
        },
        columns: [
            {
                sortable: false,
                searchable: false,
                data: 'id'
            },
            {
                sortable: false,
                searchable: false,
                data: 'item_image',
                name: 'item_image',
                mRender: function (data, type, full) {
                    r = '<div><img width="112" height="70" src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>''])}}/' + full.item_image + '"/></div>';
                    return r;
                }
            },
            {
                sortable: false,
                searchable: false,
                data: 'related_tab',
                name: 'related_tab',
                mRender: function (data, type, full) {
                    r = '<div>' + full.related_tab + '</div>';
                    return r;
                }
            },
            {
                sortable: false,
                searchable: true,
                data: 'title',
                name: 'title',
                mRender: function (data, type, full) {
                    r = '<div>' + full.title + '</div>';
                    return r;
                }
            },
            {
                sortable: false,
                searchable: false,
                data: 'item_url',
                name: 'item_url',
                mRender: function (data, type, full) {
                    r = '<div ><a target="_blank" class="btn btn-info" href="' + full.item_url + '"><i class="">لینک</i></a> </div>';
                    return r;
                }
            },
            {
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    make_delete = '<i class="fa fa-times" style="font-size: 17px; cursor: pointer; " onclick="if (confirm(\'آیا مطمئن هستید؟\')) { ' +
                        'do_delete_value(' + full.id + ',Item_Scial_Grid); }"></i>';
                    make_edit = '<a class="jsPanels" data-test="test" href="{!! route('modals.basicdata_social_settings_view') !!}?parent_id={{$data->id}}&data=' + full.id + '"><i class="fa fa-pencil-square-o" style="font-size: 14px;"></i></a>';
                    return make_edit + ' ' + make_delete;
                }
            }
        ]
    });
    {{-- groupGrid.on('order.dt search.dt', function () {
        groupGrid.column(0,
            {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();--}}

 Item_Scial_Grid.on('order.dt search.dt', function () {
Item_Scial_Grid.column(0,
    {
        search: 'applied',
        order: 'applied'
    }).nodes().each(function (cell, i) {
    cell.innerHTML = i + 1;
});
}).draw();

</script>
