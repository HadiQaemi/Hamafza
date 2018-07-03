<script>
    var calendarGrid = {};
    var currenCalendar = 0;
    $(document).ready(function() {
        calendarGrid = $('#personalCalendarGrid').DataTable({
            "fnDrawCallback": function(oSettings) {
                if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                    $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
                }
            },
            "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
            "dom": window.CommonDom_DataTables,
            "language": window.LangJson_DataTables,
            processing: true,
            serverSide: true,
            pagingType: "numbers",
            autoWidth: false,
            sPaginationType : "bootstrap",
            pageLength: 5,
            lengthChange: false,
            destroy: true,
            info :false,
            ajax: {
                url: '{{ route('hamahang.calendar.personal_calendar')}}',
                type : 'POST'
            },
            columns: [
                /*{
                    data: 'rowIndex',
                    name: 'rowIndex' ,
                    width : '1%'
                },*/
                {
                    data: 'title',
                    name: 'title' ,
                    width : '79%',
                    mRender :function (data, type, full)
                    {
                        if(data.length > 35)
                        {
                            var title=   data.substr(0, 35)+'...';
                        }
                        else{
                            var title = data;
                        }
                        if(currenCalendar==0)
                        {
                            if(full.is_default ==1)
                            {
                                return '<b>'+title+'</b>';
                            }
                            else
                            {
                                return title;
                            }
                        }
                        else {
                            if(currenCalendar ==full.id)
                            {
                                return '<b>'+title+'</b>';
                            }
                            else
                            {
                                return title;
                            }
                        }
                    }
                },
                { data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width : '20%',
                    mRender :function (data, type, full)
                    {
                        var action =  "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_edit")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_edit")}}' style='margin: 2px' onclick='ediPersonalCalendar(" + full.id+",\""+full.title+"\")' href=\"#\"><i class='fa fa-cog'></i></a>";
                        if(currenCalendar==0)
                        {
                            if(full.is_default == 1)
                            {
                                action += "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' style='margin: 2px' onclick='showEvent(" + full.id + ")' href=\"#\"><i class='fa fa-eye'></i></a>";
                            }
                            else {
                                action += "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' style='margin: 2px' onclick='showEvent(" + full.id + ")' href=\"#\"><i class='fa fa-eye-slash'></i></a>";
                            }
                        }else{
                            if(currenCalendar ==full.id)
                            {
                                action += "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' style='margin: 2px' onclick='showEvent(" + full.id + ")' href=\"#\"><i class='fa fa-eye'></i></a>";
                            }
                            else
                            {
                                action += "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' style='margin: 2px' onclick='showEvent(" + full.id + ")' href=\"#\"><i class='fa fa-eye-slash'></i></a>";
                            }
                        }
                        action += "<a alt='حذف' title='{{trans("calendar.calendar_save_calendar_grid_action_delete")}}' style='margin:2px;' class='cls3'  onclick='deletePersonalCalendar(" + full.id + ")'><i class='fa fa-close'></i></a>";
                        return action;
                    }
                }
            ]
        });
    });
</script>