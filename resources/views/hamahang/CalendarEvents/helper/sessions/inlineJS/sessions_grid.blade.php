<script>
    $(document).ready(function() {
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
        $('#form_filter_sessions').on('keyup change', 'input, select, textarea', 'checkbox', function () {
            $('#sessionsGrid').destroy();
            read_table($("#form_filter_sessions").serializeObject());
        });
        read_table($("#form_filter_sessions").serializeObject());
        function  read_table(send_info) {
            $('#sessionsGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "language": LangJson_DataTables,
                processing: true,
                "searching": false,
                serverSide: true,
                "destroy": true,
                "scrollX": true,
                ajax: {
                    url: '{!! route('hamahang.calendar_events.fetch_session',['username'=>$uname] )!!}',
                    type : 'POST',
                    data: send_info
                },
                columns: [
                    {   data: 'title',
                        name: 'title' ,
                        width : '20%',
                        mRender :function(data, type, full)
                        {
                            // if(data.length > 8)
                            // {
                            //     return data.slice(0,8)+'...';
                            // }
                            // else
                            // {
                            var keywords = full.keywords.replace(/&quot;/g,'"');
                            keywords = JSON.parse(keywords);
                            data2 = "";
                            $.each(keywords, function(index) {
                                data2 += '<span class="bottom_keywords one_keyword task_keywords" data-id="'+keywords[index].id+ '" ><i class="fa fa-tag"></i> <span style="color: #6391C5;">'+keywords[index].title+'</span></span>';
                            });
                            return "<div class='" + ( full.assignment_assignment==1 ? 'color_grey' : '' ) + "'>"+full.title+"</div><div class='' style='margin: 2px 0px;padding: 5px;'>"+data2+"</div>";
                            // }
                        }
                    },
                    {
                        data: 'date',
                        name: 'date',
                        width : '20%',
                        mRender :function(data, type, full)
                        {
                            return  full.date;
                        }
                    },
                    {
                        data: 'starttime',
                        name: 'starttime',
                        width : '10%',
                        mRender :function(data, type, full)
                        {
                            return full.starttime;
                        }
                    },
                    {
                        data: 'endtime',
                        name: 'endtime',
                        width : '10%',
                        mRender :function(data, type, full)
                        {

                            return full.endtime;
                        }
                    },
                    {
                        data: 'location',
                        name: 'location',
                        width : '20%',
                        mRender :function(data, type, full)
                        {
                            if(data==null)
                                data = '';
                            if(data.length > 15)
                            {
                                return data.slice(0,8)+'...';
                            }
                            else
                            {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'location',
                        name: 'location',
                        width : '10%',
                        mRender :function(data, type, full)
                        {
                            return 'ایجاد کننده';
                        }
                    },
                    { data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width : '10%',
                        mRender :function (data, type, full)
                        {
                            var actions =
                                "<a class='cursor-pointer jsPanels white-space' href='/CalendarEvents/sessionModal?mode=editSession&id="+full.session_id+"' data-toggle='tooltip'  data-html='true' ><i class='fa fa-edit'></i></a>" +
                                    {{--var actions ='<a class="cls3 margin-right-10"   alt='+'{{trans('calendar_events.ce_edit_label')}}'+' title='+'{{trans('calendar_events.ce_edit_label')}}'+' style="margin: 2px" onclick="editEvent('+full.id+','+full.type+')" href="#"><i class="fa fa-edit"></i></a>'+--}}
                                            {{--'<a class="cls3"   alt='+'{{trans('calendar_events.ce_events_grid_add_reminder')}}'+' title='+'{{trans('calendar_events.ce_events_grid_add_reminder')}}'+' style="margin: 2px" onclick="addReminder('+full.id+')" href="#"><i class="fa fa-bell-o"></i></a>';--}}
                                        '';
                            // if(full.showMinutesDailog==true)
                            // {
                            {{--actions += '<a class="cls3 margin-right-10" alt='+'{{trans('calendar_events.ce_grid_session_register_minute')}}'+' title='+'{{trans('calendar_events.ce_grid_session_register_minute')}}'+' style="margin: 2px" onclick="minutesDailog('+full.id+')" href="#"><i class="fa fa-building-o"></i></a>';--}}
                            // }
                            actions +='<a class="cls3 margin-right-10" alt='+'{{trans('calendar_events.ce_delete_label')}}'+' title='+'{{trans('calendar_events.ce_delete_label')}}'+'  style="margin: 2px" onclick="deleteEvent('+full.session_id+')" href="#"><i class="fa fa-close"></i></a>';
                            return actions;
                        }
                    }
                ],
                "drawCallback": function( settings ) {
                    $('th').removeClass("sorting");
                    $('th').removeClass("sorting_asc");
                    $('th').removeClass("sorting_desc");
                    $('th').addClass("text-right");
                    $('td').addClass("text-right");
                }
            });
        }

    });
</script>