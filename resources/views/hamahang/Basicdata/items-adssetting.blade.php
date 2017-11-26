<div class="panel panel-default" style="margin: 10px;">
    @include('hamahang.Basicdata.items-panel-heading')
    <div class="panel-body">
        <table id="grid" width="100%" class="table table-condensed table-bordered table-striped table-hover td-center-align">
            <thead>
            <th style="text-align: center;">{{ trans('tools.rowIndex') }}</th>
            <th style="text-align: center;">{{ trans('tools.ad_image') }}</th>
            <th style="text-align: center;">{{ trans('tools.title') }}</th>
            <th style="text-align: center;">{{ trans('tools.url_address') }}</th>
            <th style="text-align: center;">{{ trans('tools.default') }}</th>
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
        initComplete: function ()
        {
            $("div.toolbar").html
            (
                '<a href="{!! route('modals.basicdata_ad_settings_view')  !!}?parent_id=' + id + '" class="jsPanels createnewvalue1">' +
                '<button style="position: relative; float: left;" data-item_type="role" class="btn btn-info btn_grid_add_item " type="button">' +
                '   <i ></i> ' +
                '   {{ trans('app.add')}}' +
                '</button>' +
                '</a>'
            );
        },
        ajax:
            {
                url: '{!! route('hamahang.basicdata.load_items') !!}',
                type: 'POST',
                data: {'id' : id}
            },
        columns:
            [
                {
                    data: 'id'
                },
                {
                    data: 'ad_image',
                    name: 'ad_image',
                    mRender: function (data, type, full)
                    {
                        r = '<img width="112" height="70" src="{{ route('FileManager.DownloadFile',['ID',''])}}/' + full.ad_image + '" alt="" class="img-rounded img-preview">';
                        return r;
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                    mRender: function (data, type, full)
                    {
                        r = '<div>' + full.title + '</div>';
                        return r;
                    }
                },
                {
                    data: 'url_address',
                    name: 'url_address',
                    mRender: function (data, type, full)
                    {
                        r = '<div>' + full.url_address + '</div>';
                        return r;
                    }
                },
                {
                    data: 'default',
                    name: 'default',
                    mRender: function (data, type, full)
                    {
                        var ch = '';
                        if (parseInt(full.value))
                            ch = 'checked';
                        else
                            ch = '';
                        return '<input type="radio" name="default" data-item_id="' + full.id + '" '+ ch +' onclick="setDefaultAd('+ full.id +')" >';
                    }
                },
                {
                    sortable: false,
                    searchable: false,
                    mRender: function (data, type, full)
                    {
                        make_delete = '<i class="fa fa-times" style="font-size: 17px; cursor: pointer; " onclick="if (confirm(\'آیا مطمئن هستید؟\')) { do_delete_value(' + full.id + ',groupGrid); }"></i>';
                        make_edit = '<a class="jsPanels" data-test="test" href="{!! route('modals.basicdata_ad_settings_view') !!}?data=' + full.id + '"><i class="fa fa-pencil-square-o"></i></a>';
                        return make_edit + ' ' + make_delete;
                    }
                }
            ]
    });
    groupGrid.on('order.dt search.dt', function ()
    {
        groupGrid.column(0,
            {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i)
        {
            cell.innerHTML = i + 1;
        });
    }).draw();

    function do_delete_value(deleteid)
    {
        $.ajax
        ({
            type: 'post',
            url: '<?php echo route('modals.basicdata_value_delete'); ?>',
            data: {'deleteid': deleteid},
            dataType: 'json',
            success: function(data)
            {
                if (data.success)
                {
                    window.location.reload();
                }
            },
        });
    }

    function setDefaultAd(item_id) {
        $.ajax
        ({
            type: 'post',
            url: '<?php echo route('modals.basicdata_value_set_default_ad'); ?>',
            data: {'item_id': item_id},
            dataType: 'json',
            success: function(data)
            {
                if (data.success == true) {
                    messageModal('success', 'تبلیغ پیش‌فرض', data.message);
                }
                else {
                    messageModal('error', 'خطا در پیش‌فرض کردن تبلیغ', data.error);

                }
            },
        });
    }

//    $(document).ready(function () {
//        $('input.default_ad').on('change', function() {
//            console.log('cl')
//            $('input.default_ad').not(this).prop('checked', false);
//        });
//    });


</script>
