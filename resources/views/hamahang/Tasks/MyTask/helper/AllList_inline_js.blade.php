<script>
    (function ($) {
        $.fn.serializeObject = function () {

            var self = this,
                json = {},
                push_counters = {},
                patterns = {
                    "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                    "key": /[a-zA-Z0-9_]+|(?=\[\])/g,
                    "push": /^$/,
                    "fixed": /^\d+$/,
                    "named": /^[a-zA-Z0-9_]+$/
                };


            this.build = function (base, key, value) {
                base[key] = value;
                return base;
            };

            this.push_counter = function (key) {
                if (push_counters[key] === undefined) {
                    push_counters[key] = 0;
                }
                return push_counters[key]++;
            };

            $.each($(this).serializeArray(), function () {

                // skip invalid keys
                if (!patterns.validate.test(this.name)) {
                    return;
                }

                var k,
                    keys = this.name.match(patterns.key),
                    merge = this.value,
                    reverse_key = this.name;

                while ((k = keys.pop()) !== undefined) {

                    // adjust reverse_key
                    reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                    // push
                    if (k.match(patterns.push)) {
                        merge = self.build([], self.push_counter(reverse_key), merge);
                    }

                    // fixed
                    else if (k.match(patterns.fixed)) {
                        merge = self.build([], k, merge);
                    }

                    // named
                    else if (k.match(patterns.named)) {
                        merge = self.build({}, k, merge);
                    }
                }

                json = $.extend(true, json, merge);
            });

            return json;
        };
    })(jQuery);
    $('#form_filter_priority').on('keyup', '#title', function () {
        filter_tasks_list();
    });
    $('input:checkbox').change(function () {
        filter_tasks_list();
    });
    $('#form_filter_priority').on('change', 'select', function () {
        filter_tasks_list();
    });
    // $('#title, .task_status, .task_immediate, .task_important, .official_type, input[name="task_status[]"], input[name="task_final[]"], input[name="task_immediate[]"], input[name="official_type[]"], input[name="task_important[]"]').on('keyup change', function () {
    //     filter_tasks_list();
    // });
    // $('#form_filter_priority').on('keyup', 'input, select, textarea', 'checkbox', function () {
    //     filter_tasks_list();
    // });
    function filter_tasks_list(data) {
        window.table_chart_grid2.destroy();
        readTable($("#form_filter_priority").serializeObject());
        {{--$.ajax({--}}
        {{--url: '{{ route('hamahang.tasks.my_tasks.fetch') }}',--}}
        {{--method: 'POST',--}}
        {{--dataType: "json",--}}
        {{--data: $("#form_filter_priority").serialize(),--}}
        {{--success: function (res) {--}}
        {{--//console.log(res.success);--}}
        {{--if (res.success == true) {--}}
        {{--$('#priority_content_area').html(res.data);--}}
        {{--//messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'});--}}
        {{--} else if (res.success == false) {--}}
        {{--messageModal('error', '{{trans('app.operation_is_failed')}}', res.error);--}}
        {{--}--}}
        {{--}--}}
        {{--});--}}

    }
    $('.form-check-input').click(function () {
        // $(document).on('click','')
        if($('label[for="'+$(this).attr('id')+'"]').hasClass('background-gray')){
            $('label[for="'+$(this).attr('id')+'"]').removeClass('background-gray');
            $(this).parent().removeClass('background-gray');
        }
        else{
            $(this).parent().addClass('background-gray');
            $('label[for="'+$(this).attr('id')+'"]').addClass('background-gray');
        }
        // $(document).on('click', 'input[name="task_status[]"]', function () {
        //     if($(this).checked)
        //     {
        //         alert('hi hadi');
        //     }
        // });
    });

    function ShowErrorModal(data) {
        err_list_txt = '';
        $.each(data, function (key, value) {
            err_list_txt += '';
            switch (value.relation) {
                case 0: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
                case 1: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
                case 2: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
                case 3: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
            }
        });
        $('#errors').html(err_list_txt);
        $('#change_statuts_err').modal({show: true});
        $("#r1").prop("checked", true);
    }

    //////////////////////////////////////////
    var send_info = {
        @if(isset($filter_subject_id))
        subject_id: '{{ $filter_subject_id }}'
        @endif

    };
    readTable($("#form_filter_priority").serializeObject());

    function readTable(send_info) {
        @if(isset($filter_subject_id))
            send_info["subject_id"] = '{{ $filter_subject_id }}'
        @endif

        LangJson_DataTables = window.LangJson_DataTables;
        LangJson_DataTables.sLoadingRecords = '<div class="loader preloader"></div>';
        LangJson_DataTables.searchPlaceholder = '{{trans('tasks.search_in_task_title_placeholder')}}';
        window.table_chart_grid2 = $('#MyTasksTable').DataTable({
            "dom": window.CommonDom_DataTables,
            "ajax": {
                "url": "{{ route('hamahang.tasks.my_tasks.fetch_all_task') }}",
                "type": "POST",
                "data": send_info
            },
            "searching": false,
            "autoWidth": false,
            "order": [[3, "desc"]],
            "language": LangJson_DataTables,
            "processing": false,
            "pageLength": 25,
            columns: [
                {
                    "data": "title",
                    "mRender": function (data, type, full) {
                        var id = full.id;
                        // split = full.title.split(' ');
                        // sub_title = '';
                        // $.each(split,function(i,val){
                        //     if(i<=10){
                        //         sub_title = sub_title + ' ' + val;
                        //     }else if(i==11){
                        //         sub_title = sub_title + ' ...';
                        //     }
                        // });
                        return "<a class='cursor-pointer jsPanels white-space' href='/modals/ViewTaskForm?tid=" + full.id + "&aid=" + full.assignment_id + "' data-toggle='tooltip' title='" + full.title + (full.desc == null ? '' : "\n" + full.desc) + "'>" + full.title + "</a>";
                        // return full.title;
                    },
                    "width": "70%"
                },
                {
                    "data": "employee",
                    "mRender": function (data, type, full) {
                        var keywords = full.keywords.replace(/&quot;/g, '"');
                        keywords = JSON.parse(keywords);
                        data2 = "";
                        $.each(keywords, function (index) {
                            data2 += '<span class="bottom_keywords one_keyword task_keywords" data-id="' + keywords[index].id + '" ><i class="fa fa-tag"></i> <span style="color: #6391C5;">' + keywords[index].title + '</span></span>';
                        });
                        employee = full.employee;
                        employee = employee.split('--**--');
                        avator = '<a href="'+employee[1]+'"><img src="'+employee[0]+'" style="border: 1px solid #eee; padding: 1px; margin: 0 5px; border-radius: 30px; height: 30px; width: 30px;"></a>';
                        return avator + "<a href='/" + employee[1] + "'>" + employee[2] + "</a>" + "<div class='' style='margin: 2px 0px;padding: 5px;'>" + data2 + "</div>";
                    },
                    "width": "10%"
                },
                {"data": "assigner"},
                {
                    "data": "assignment_created_at",
                    "mRender": function (data, type, full) {
                        return '<span class="hidden">' + full.assignment_created_at.num_date + '</span>' + full.assignment_created_at.jdate;
                    },
                    "width": "5%"
                },
                {
                    "data": "immediate",
                    "mRender": function (data, type, full) {
                        return "<img class='immediate-pic' src='/assets/images/" + full.immediate.output_image + ".png' title='" + full.immediate.output + "' data-toggle='tooltip'/>";
                    },
                    "width": "5%"
                },
                {
                    "data": "respite",
                    "mRender": function (data, type, full) {
                        return "<div class='respite_number " + full.respite.bg + "' data-toggle='tooltip' title='" + full.respite.gdate + "' >" + full.respite.respite_days + "</div>";
                    },
                    "width": "5%"
                },
                {
                    "data": "type",
                    "mRender": function (data, type, full) {
                        return "<img class='immediate-pic' src='/assets/images/task" + full.type.id + ".png' title='" + full.type.status_name + "' data-toggle='tooltip'/>";
                    },
                    "width": "5%"
                }

//            , {
//                "data": "id", "width": "8%",
//                "bSearchable": false,
//                "bSortable": false,
//                "mRender": function (data, type, full) {
//                    var id = full.id;
//                    return "<a class='cls3' style='margin: 2px' onclick='f(" + full.id + ")' href=\"#\"><i class='fa fa-edit'></i></a><a style='margin:2px;' class='cls3' \
//                                                                                                                                                                                                                                onclick='del(" + full.id + ")' href=\"#\"><i class='fa fa-trash'></i></a>";
//                }
//            }
            ]
        })
    }

    $(".select2_auto_complete_user").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: false,
        ajax: {
            url: "{{route('auto_complete.users')}}",
            dataType: "json",
            type: "POST",
            quietMillis: 150,
            data: function (term) {
                return {
                    term: term
                };
            },
            results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            }
        }
    });
    var t2_default;
    var current_tab = '';
    var current_id = '';

</script>