<script>
    $(document).ready(function () {

        (function($){
            $.fn.serializeObject = function(){

                var self = this,
                    json = {},
                    push_counters = {},
                    patterns = {
                        "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                        "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                        "push":     /^$/,
                        "fixed":    /^\d+$/,
                        "named":    /^[a-zA-Z0-9_]+$/
                    };


                this.build = function(base, key, value){
                    base[key] = value;
                    return base;
                };

                this.push_counter = function(key){
                    if(push_counters[key] === undefined){
                        push_counters[key] = 0;
                    }
                    return push_counters[key]++;
                };

                $.each($(this).serializeArray(), function(){

                    // skip invalid keys
                    if(!patterns.validate.test(this.name)){
                        return;
                    }

                    var k,
                        keys = this.name.match(patterns.key),
                        merge = this.value,
                        reverse_key = this.name;

                    while((k = keys.pop()) !== undefined){

                        // adjust reverse_key
                        reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                        // push
                        if(k.match(patterns.push)){
                            merge = self.build([], self.push_counter(reverse_key), merge);
                        }

                        // fixed
                        else if(k.match(patterns.fixed)){
                            merge = self.build([], k, merge);
                        }

                        // named
                        else if(k.match(patterns.named)){
                            merge = self.build({}, k, merge);
                        }
                    }

                    json = $.extend(true, json, merge);
                });

                return json;
            };
        })(jQuery);
        $('#form_filter_reminders').on('keyup change', 'input, select, textarea', 'checkbox', function () {
            $('#sessionsGrid').destroy()
            read_table($("#form_filter_reminders").serializeObject());
        });
        read_table($("#form_filter_reminders").serializeObject());
        function  read_table(send_info) {
            console.log(send_info);
            $('#gridDtataTable').DataTable({
                "dom": window.CommonDom_DataTables,
                "language": LangJson_DataTables,
                "scrollX": true,
                processing: true,
                "destroy": true,
                serverSide: true,
                ajax: {
                    url: '{!! route('hamahang.calendar_events.list',['username'=>$uname] )!!}',
                    type: 'POST',
                    data: send_info
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
                    // {
                    //     data: 'enddate',
                    //     name: 'enddate',
                    //     width: '20%',
                    //     mRender: function (data, type, full) {
                    //         var enddate = data.split(' ');
                    //         if (enddate[1] == '00:00:00') {
                    //             enddate[1] = '------';
                    //         }
                    //         return '<table class=""><tr>' +
                    //                 // '<td class=" fa fa-calendar"></td>' +
                    //                 '<td class=""> <spane>' + enddate[0] + '</span></td>' +
                    //                 // '<td class=" glyphicon glyphicon-time"> </td> ' +
                    //                 '<td class=""><span> ' + enddate[1] + '</span></td>' +
                    //                 '</tr></table>';
                    //         ;
                    //     }
                    // },
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
                        data: 'event_type',
                        name: 'event_type',
                        width: '10%',
                        mRender: function (data, type, full) {
                            switch (data) {
                                case 'event':
                                    return '{{trans("calendar_events.ce_events_grid_event")}}';
                                    break;
                                case 'session':
                                    return '{{trans("calendar_events.ce_events_grid_session")}}';
                                    break;
                                case 'invitation':
                                    return '{{trans("calendar_events.ce_events_grid_invitation")}}';
                                    break;
                                case 'reminder':
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
                            {{--if (full.access_list.add_reminder){--}}
                            {{--actions += '<a class="cls3"   alt=' + '{{trans('calendar_events.ce_events_grid_add_reminder')}}' + ' title=' + '{{trans('calendar_events.ce_events_grid_add_reminder')}}' + ' style="margin: 2px" onclick="addReminder(' + full.id + ')" href="#"><i class="fa fa-bell-o"></i></a>';--}}
                            {{--}--}}
                            {{--if(full.showMinutesDailog==true && full.type==1)--}}
                            {{--{--}}
                            {{--actions += '<a class="cls3"  alt='+'{{trans('calendar_events.ce_grid_session_register_minute')}}'+' title='+'{{trans('calendar_events.ce_grid_session_register_minute')}}'+'   style="margin: 2px" onclick="minutesDailog('+full.id+')" href="#"><i class="fa fa-building-o"></i></a>';--}}

                            {{--}--}}
                                return actions;

                        }

                    }

                ]
            });
        }
    });
</script>