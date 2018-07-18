<script>
    $(document).ready(function() {
        window.table_chart_grid3 = $('#grid3').DataTable();
        var send_info = {
            @if(isset($filter_subject_id))
            subject_id: '{{ $filter_subject_id }}'
            @endif
        };
        LangJson_DataTables = window.LangJson_DataTables;
        LangJson_DataTables.emptyTable = '{{trans('projects.no_project_inserted')}}';
        window.ProjectList = $('#personalCalendarGrid').DataTable({
            "fnDrawCallback": function(oSettings) {
                if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                    $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
                }
            },
            "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
            "dom": window.CommonDom_DataTables,
            "language": window.LangJson_DataTables,
            lengthChange: false,
            destroy: true,
            info :false,
            "ajax": {
                "url": "{{ route('hamahang.projects.list') }}",
                "type": "POST",
                "data": send_info
            },
            columns: [
                // {"data": "id"},
//                    {"data": "title"},
                {
                    "data": "title",
                    "mRender": function (data, type, full) {
                        return "<a class='project_info cursor-pointer' data-p_id= '"+ full.id +"' >"+ full.title +"</a>";
                    }
                },
                {"data": "full_name"}
            ],
            fnInitComplete : function() {
                // alert($(this).find('tbody tr').length);
                // if ($(this).find('tbody tr').length<=1) {
                //     $('#fieldset').hide();
                //     $('#fieldset_noData').text(LangJson_DataTables.emptyTable);
                // }
            }
        });
    });
</script>