<div class="panel panel-default" style="margin: 10px;">
    @include('hamahang.Basicdata.items-panel-heading')
    <div class="panel-body">
        <table id="grid" width="100%" class="table dt-responsive nowrap display text-center">
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


    groupGrid = $('#grid').DataTable
    ({
        language: LangJson_DataTables,
        processing: true,
        serverSide: true,
        //dom: '<"col-xs-5"f><"col-xs-5 floatleft"l><"tools-group-toolbar">t<"toolbar"><"col-xs-14 text-center"p><"clearfixed">',
        dom: '<"space-10">' +
        ' <"row form-inline" <"col-xs-4"f> <"col-xs-4"l>  <"col-xs-4 text-left toolbar"> <"clearfixed">>' +
        ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
        ' <"row" <"col-xs-3"i><"col-xs-9 text-left"p> <"clearfixed"> >',
        initComplete: function () {
            $("div.toolbar").html
            (
                '<a href="{!! route('modals.basicdata_ad_research_view') !!}?parent_id=' + id + '" class="jsPanels createnewvalue1">' +
                '<button style="position: relative; float: left;" data-item_type="role" class="btn btn-info btn_grid_add_item " type="button">' +
                '   <i class=""></i> ' +
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
                data: 'id'
            },
            {
                mRender: function (data, type, full) {
                    r = '<img width="112" height="70" src="{{ route('FileManager.DownloadFile',['ID',''])}}/' + full.slider_image + '" alt="" class="img-rounded img-preview">';
                    return r;
                }
            }, {
                data: 'related_tab',
                name: 'related_tab',
                mRender: function (data, type, full) {
                    r = '<div>' + full.related_tab + '</div>';
                    return r;
                }
            }, {
                data: 'title',
                name: 'title',
                mRender: function (data, type, full) {
                    r = '<div>' + full.title + '</div>';
                    return r;
                }
            },
            {

                mRender: function (data, type, full) {
                    r = '<div ><a target="_blank" class="btn btn-info" href="' + full.slider_url + '"><i class="">لینک</i></a> </div>';
                    return r;
                }
            },
            {
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    make_delete = '<i class="fa fa-times" style="font-size: 17px; cursor: pointer; " onclick="if (confirm(\'آیا مطمئن هستید؟\')) { do_delete_value(' + full.id + ',groupGrid); }"></i>';
                    make_edit = '<a class="jsPanels" data-test="test" href="{!! route('modals.basicdata_items_research_view') !!}?data=' + full.id + '"><i class="fa fa-pencil-square-o"></i></a>';
                    return make_edit + ' ' + make_delete;
                }
            }
        ]
    });
    groupGrid.on('order.dt search.dt', function () {
        groupGrid.column(0,
            {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
</script>
