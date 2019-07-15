<script>
    var calendarGrid = {};
    var currenCalendar = 0;
    $(document).ready(function () {
        calendarGrid = $('#personalCalendarGrid').DataTable({
            "fnDrawCallback": function (oSettings) {
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
            sPaginationType: "bootstrap",
            pageLength: 5,
            lengthChange: false,
            destroy: true,
            info: false,
            ajax: {
                url: '{{ route('hamahang.calendar.personal_calendar')}}',
                type: 'POST'
            },
            columns: [
                /*{
                    data: 'rowIndex',
                    name: 'rowIndex' ,
                    width : '1%'
                },*/
                {
                    data: 'title',
                    name: 'title',
                    width: '79%',
                    mRender: function (data, type, full) {
                        var action = "";
                        if (currenCalendar == 0) {
                            if (full.is_default == 1) {
                                action += "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' style='margin: 2px' onclick='showEvent(" + full.id + ")' href=\"#\"><i class='fa fa-eye'></i></a>";
                            }
                            else {
                                action += "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' style='margin: 2px' onclick='showEvent(" + full.id + ")' href=\"#\"><i class='fa fa-eye-slash'></i></a>";
                            }
                        } else {
                            if (currenCalendar == full.id) {
                                action += "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' style='margin: 2px' onclick='showEvent(" + full.id + ")' href=\"#\"><i class='fa fa-eye'></i></a>";
                            }
                            else {
                                action += "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_view")}}' style='margin: 2px' onclick='showEvent(" + full.id + ")' href=\"#\"><i class='fa fa-eye-slash'></i></a>";
                            }
                        }
                        if (data.length > 35) {
                            var title = data.substr(0, 35) + '...';
                        }
                        else {
                            var title = data;
                        }
                        if (currenCalendar == 0) {
                            if (full.is_default == 1) {
                                return action + "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_edit")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_edit")}}' style='margin: 2px;margin-right:5px' onclick='ediPersonalCalendar(" + full.id + ",\"" + full.title + "\")' href=\"#\">" + '<b>' + title + '</b></a>';
                            }
                            else {
                                return action + "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_edit")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_edit")}}' style='margin: 2px;margin-right:5px' onclick='ediPersonalCalendar(" + full.id + ",\"" + full.title + "\")' href=\"#\">" + title + '</a>';
                            }
                        }
                        else {
                            if (currenCalendar == full.id) {
                                return action + "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_edit")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_edit")}}' style='margin: 2px;margin-right:5px' onclick='ediPersonalCalendar(" + full.id + ",\"" + full.title + "\")' href=\"#\">" + '<b>' + title + '</b></a>';
                            }
                            else {
                                return action + "<a class='cls3'  alt='{{trans("calendar.calendar_save_calendar_grid_action_edit")}}' title='{{trans("calendar.calendar_save_calendar_grid_action_edit")}}' style='margin: 2px;margin-right:5px' onclick='ediPersonalCalendar(" + full.id + ",\"" + full.title + "\")' href=\"#\">" + title + '</a>';
                            }
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '20%',
                    mRender: function (data, type, full) {
                        var action = "";

                        if (full.is_optional != 1)
                            action += "<a alt='حذف' class='pointer HazfCalendar' title='{{trans("calendar.calendar_save_calendar_grid_action_delete")}}' style='margin:2px; display:none' onclick='deletePersonalCalendar(" + full.id + ")'><i class='fa fa-close'></i></a>";
                        return action;
                    }
                }
            ]
        });
    });
</script>