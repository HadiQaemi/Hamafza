<script>
    $(document).ready(function () {

        $('#gridDtataTable').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables,
            "scrollX": true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('hamahang.calendar_events.list',['username'=>$uname] )!!}',
                type: 'POST'
            },
            columns: [
                {
                    data: 'rowIndex',
                    name: 'rowIndex',
                    width: '1%'


                },
                {
                    data: 'title',
                    name: 'title',
                    width: '30%',
                    mRender: function (data, type, full) {

                        return '<table><tr>' +
                            // '<td class="fa fa-calendar"></td>' +
                            '<td class="c"> <spane>' + data + '</span></td>' +
                            // '<td class=" glyphicon glyphicon-time"> </td> ' +
                            // '<td class=""> <span> ' + startdate[1] + '</span></td>' +
                            '</tr></table>';
                    }
                },
                {
                    data: 'startdate',
                    name: 'startdate',
                    width: '20%',
                    mRender: function (data, type, full) {
                        var startdate = data.split(' ');
                        if (startdate[1] == '00:00:00') {
                            startdate[1] = '------';
                        }
                        return '<table><tr>' +
                                // '<td class="fa fa-calendar"></td>' +
                                '<td class="c"> <spane>' + startdate[0] + '</span></td>' +
                                // '<td class=" glyphicon glyphicon-time"> </td> ' +
                                '<td class=""> <span> ' + startdate[1] + '</span></td>' +
                                '</tr></table>';
                    }
                },
                {
                    data: 'enddate',
                    name: 'enddate',
                    width: '20%',
                    mRender: function (data, type, full) {
                        var enddate = data.split(' ');
                        if (enddate[1] == '00:00:00') {
                            enddate[1] = '------';
                        }
                        return '<table class=""><tr>' +
                                // '<td class=" fa fa-calendar"></td>' +
                                '<td class=""> <spane>' + enddate[0] + '</span></td>' +
                                // '<td class=" glyphicon glyphicon-time"> </td> ' +
                                '<td class=""><span> ' + enddate[1] + '</span></td>' +
                                '</tr></table>';
                        ;
                    }
                },
                // {
                //     data: 'allDay',
                //     name: 'allDaay',
                //     width: '2%',
                //     mRender: function (data, type, full) {
                //         //console.log(data);
                //         if (full.allDay == 1) {
                //             return '<i class="fa fa-check"></i>';
                //         }
                //         else {
                //             return '<i class=" fa fa-close"></i>';
                //         }
                //     }
                // },
                {
                    data: 'type'
                    , name: 'type',
                    width: '10%',
                    mRender: function (data, type, full) {
                        switch (data) {
                            case 0:
                                return '{{trans("calendar_events.ce_events_grid_event")}}';
                                break;
                            case 1:
                                return '{{trans("calendar_events.ce_events_grid_session")}}';
                                break;
                            case 2:
                                return '{{trans("calendar_events.ce_events_grid_invitation")}}';
                                break;
                            case 3:
                                return '{{trans("calendar_events.ce_events_grid_reminder")}}';
                                break;

                        }
                    }


                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '10%',
                    mRender: function (data, type, full) {
                        //console.log(full);
                        var actions = '';
                        if (full.access_list.edit) {
                            actions += '<a class="cls3"   alt=' + '{{trans('calendar_events.ce_edit_label')}}' + ' title=' + '{{trans('calendar_events.ce_edit_label')}}' + ' style="margin: 2px" onclick="editEvent(' + full.id + ',' + full.type + ')" href="#"><i class="fa fa-edit"></i></a>';

                        }
                        if (full.access_list.delete) {
                            actions += '<a class="cls3"   alt=' + '{{trans('calendar_events.ce_delete_label')}}' + ' title=' + '{{trans('calendar_events.ce_delete_label')}}' + ' style="margin: 2px" onclick="deleteEvent(' + full.id + ')" href="#"><i class="fa fa-close"></i></a>';

                        }
                        if (full.access_list.add_reminder){
                            actions += '<a class="cls3"   alt=' + '{{trans('calendar_events.ce_events_grid_add_reminder')}}' + ' title=' + '{{trans('calendar_events.ce_events_grid_add_reminder')}}' + ' style="margin: 2px" onclick="addReminder(' + full.id + ')" href="#"><i class="fa fa-bell-o"></i></a>';
                    }
                        if(full.showMinutesDailog==true && full.type==1)
                        {
                            actions += '<a class="cls3"  alt='+'{{trans('calendar_events.ce_grid_session_register_minute')}}'+' title='+'{{trans('calendar_events.ce_grid_session_register_minute')}}'+'   style="margin: 2px" onclick="minutesDailog('+full.id+')" href="#"><i class="fa fa-building-o"></i></a>';

                        }
                        return actions;

                    }

                }

            ]
        });

    });
</script>