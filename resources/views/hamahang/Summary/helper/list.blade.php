<style type="text/css">
    .jstree li > a > .jstree-icon
    {
        display: none !important;
    }
</style>
<script>
    function fill_dt()
    {
        if ('object' == typeof(groupGrid)) { groupGrid.destroy(); }
        groupGrid = $('#grid').DataTable(
        {
            language: LangJson_DataTables,
            processing: true,
            serverSide: true,
            dom: window.CommonDom_DataTables,
            ajax:
            {
                url: '{!! route('hamahang.summary.get_values_groups') !!}',
                type: 'POST',
            },
            columns:
            [
                {
                    data: 'title',
                    name:'default_value.title',
                    width: '55%',
                    mRender: function (data, type, full)
                    {
                        r = '<a href="{!! route('hamahang.summary.get_values_jspanel') !!}?id=' + full.type_value_id + '" class="jsPanels">' + full.title + '</a>';
                        return r;
                    }
                },
                {
                    data: 'count',
                    width: '20%',
                    mRender: function (data, type, full)
                    {
                        r = '<a href="{!! route('hamahang.summary.get_values_jspanel') !!}?id=' + full.type_value_id + '" class="jsPanels"><div style="direction: ltr; color: ' + (full.count < 0 ? 'red' : 'green') + '">' + full.count + '</div></a>';
                        return r;
                    }
                },
                {
                    data: 'total',
                    name: 'total',
                    width: '25%',
                    mRender: function (data, type, full)
                    {
                        r = '<div style="direction: ltr; color: ' + (full.total < 0 ? 'red' : 'green') + '">' + full.total + '</div>';
                        return r;
                    }
                }
            ]
        });
    }
    $(document).ready(function()
    {
        fill_dt();
    });
</script>

