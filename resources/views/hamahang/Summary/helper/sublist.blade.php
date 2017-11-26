<style type="text/css">
    .jstree li > a > .jstree-icon
    {
        display: none !important;
    }
</style>
<table id="grid_values" width="100%" class="table table-condensed table-bordered table-striped table-hover" style="text-align: right;">
    <thead>
        <th style="width: 33%">{{ trans('tools.value') }}</th>
        <th style="width: 33%">{{ trans('tools.datetime') }}</th>
        <th style="width: 33%">{{ trans('tools.operations') }}</th>
    </thead>
</table>
<script>
    function fill_dt_values()
    {
        if ('object' == typeof(groupGrid)) { groupGrid.destroy(); }
        groupGrid = $('#grid_values').DataTable(
        {
            language: LangJson_DataTables,
            processing: true,
            serverSide: true,
            dom: '<"col-xs-5"f><"col-xs-5 floatleft"l><"tools-group-toolbar">t<"toolbar"><"col-xs-14 text-center"p><"clearfixed">',
            ajax:
            {
                url: '{!! route('hamahang.summary.get_values') !!}',
                data: {'id': '{!! $id !!}'},
                type: 'POST',
            },
            columns:
            [
                {
                    data: 'value',
                    width: '33%',
                    mRender: function (data, type, full)
                    {
                        r = '<div style="direction: ltr; color: ' + (full.value < 0 ? 'red' : 'green') + '">' + full.value + '</div>';
                        return r;
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    width: '33%',
                    mRender: function (data, type, full)
                    {
                        r = full.created_at;
                        return r;
                    }
                },
                {
                    width: '33%',
                    mRender: function (data, type, full)
                    {
                        if (-1 == full.href)
                        {
                            r = '<span style="color: lightgray;">غیر قابل مشاهده [حذف شده]</span>';
                        } else
                        {
                            r = '<a href="' + full.href + '" target="_blank">مشاهده</a>';
                        }
                        return r;
                    }
                }
            ]
        });
    }
    $(document).ready(function()
    {
        fill_dt_values();
    });
</script>

