<script type="text/javascript">
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute;left: 116px;top: -3px;"><a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzarvazife&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
    function do_enable() {
        document.getElementById('date1').disabled = false;
        document.getElementById('time1').disabled = false;
    }
    function do_disable() {
        document.getElementById('date1').disabled = true;
        document.getElementById('time1').disabled = true;
    }

    function change_normal_task_timing_type(id) {

        if (id == 1) {
            var txt = '' +
                '<div class="row-fluid">' +
                '   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">' +
                '       <div class=" row">' +
                '           <div class="col-sm-6 col-xs-12">' +
                '               <label class="line-height-30 pull-right">تاریخ</label>' +
                '               <div class=" pull-right">' +//input-group
//                '                   <span class="input-group-addon" id="respite_date">' +
//                '                       <i class="fa fa-calendar"></i>' +
//                '                   </span>' +
                '                   <input type="text" class="form-control DatePicker" name="respite_date" aria-describedby="respite_date">' +
                '               </div>' +
                '           </div>' +
                '           <div class="col-sm-6 col-xs-12">' +
                '               <label class="line-height-30">ساعت</label>' +
                '               <div class=" pull-right">' +//input-group
//                '                   <span class="input-group-addon" id="respite_time">' +
//                '                       <i class="fa fa-clock-o"></i>' +
//                '                   </span>' +
                '                   <input type="text" class="form-control TimePicker" name="respite_time" aria-describedby="respite_time">' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '   <div class="clearfix"></div>' +
                '</div>';
            $('#normal_task_timing').html(txt);
            $(".TimePicker").persianDatepicker({
                format: "HH:mm:ss a",
                timePicker: {
                    //showSeconds: false,
                },
                onlyTimePicker: true
            });

            $(".DatePicker").persianDatepicker({
                observer: true,
                autoClose: true,
                format: 'YYYY-MM-DD'
            });
        }
        if (id == 0) {
            var txt = '' +
                '<div class="row-fluid">\n' +
                '   <div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">\n' +
                '       <div class="row-fluid">\n' +
                '           <div class="col-sm-12 col-xs-12 form-inline">\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day"/>\n' +
                '               <label class="pull-right">روز</label>\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="0" />\n' +
                '               <label class="pull-right">ساعت</label>\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="0" />\n' +
                '               <label class="pull-right">دقیقه</label>\n' +
                '           </div>\n' +
                '       </div>\n' +
                '   </div>\n' +
                '   <div class="clearfix"></div>\n' +
                '</div>\n';

            $('#normal_task_timing').html(txt);

        }
    }
    function change_respite_type(id) {
        if (id == 0) {
            var respite_span = '' +
                '<table class="table col-xs-12">' +
                '   <tr>' +
                '       <td >' +
                '           <input type="radio" name="respite_timing_type" onclick="change_normal_task_timing_type(0)" value="0"/>' +
                '           <label for="r2">تعیین مدت زمان انجام</label>' +
                '           <input type="radio" name="respite_timing_type" onclick="change_normal_task_timing_type(1)"  value="1" checked/>' +
                '           <label for="r1">تعیین تاریخ پایان</label>' +
                '       </td>' +
                '   </tr>' +
                '   <tr>' +
                '       <td>' +
                '<div class="row-fluid">\n' +
                '   <div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35" id="normal_task_timing">\n' +
                '       <div class="row-fluid">\n' +
                '           <div class="col-sm-12 col-xs-12 form-inline">\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day"/>\n' +
                '               <label class="pull-right">روز</label>\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="0" />\n' +
                '               <label class="pull-right">ساعت</label>\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="0" />\n' +
                '               <label class="pull-right">دقیقه</label>\n' +
                '           </div>\n' +
                '       </div>\n' +
                '   </div>\n' +
                '   <div class="clearfix"></div>\n' +
                '</div>\n'
            '       </td>' +
            '   </tr>' +
            '</table>';
            $('#respite_span').html(respite_span);
            $('#project_span').html('');
            $(".TimePicker").persianDatepicker({
                format: "HH:mm:ss a",
                timePicker: {
                    //showSeconds: false,
                },
                onlyTimePicker: true
            });

            $(".DatePicker").persianDatepicker({
                observer: true,
                autoClose: true,
                format: 'YYYY-MM-DD'
            });
        }
        else if (id == 1) {
            var respite_span = '' +
                '<div class="row-fluid">\n' +
                '   <div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">\n' +
                '       <div class="row-fluid">\n' +
                '           <div class="col-sm-12 col-xs-12 form-inline">\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day"/>\n' +
                '               <label class="pull-right">روز</label>\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="00" />\n' +
                '               <label class="pull-right">ساعت</label>\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="00" />\n' +
                '               <label class="pull-right">دقیقه</label>\n' +
                '           </div>\n' +
                '       </div>\n' +
                '   </div>\n' +
                '   <div class="clearfix"></div>\n' +
                '</div>\n';
            $('#respite_span').html(respite_span);
            // $('#project_span').html(project_span);

            var project_span = '' +
                '<table>\n' +
                '   <tr>\n' +
                '       <td>\n' +
                '           <label class="pull-left" for="r2">{{ trans('projects.select_project') }} : </label>\n' +
                '        </td>\n' +
                '        <td>\n' +
                '           <div class="input-group pull-left">\n' +
                '               <span class="input-group-addon" id="">\n' +
                '                   <i class="fa fa-tasks"></i>\n' +
                '               </span>\n' +
                '               <select id="project_id" name="project_id" class="select2_auto_complete_project" data-placeholder="{{trans('app.select_one_record')}}" ></select>\n' +
                '            </div>\n' +
                '         </td>\n' +
                '    </tr>\n' +
                '</table>\n';

            $('#project_span').html(project_span);
            $(".select2_auto_complete_project").select2({
                minimumInputLength: 3,
                dir: "rtl",
                width: "100%",
                tags: false,
                ajax: {
                    url: "{{route('auto_complete.projects')}}",
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
        }
        else if (id == 2) {
            var txt = '' +
                '<div class="row-fluid">\n' +
                '   <div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">\n' +
                '       <div class="row-fluid">\n' +
                '           <div class="col-sm-12 col-xs-12 form-inline">\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day" value="0"/>\n' +
                '               <label class="pull-right">روز</label>\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="0"/>\n' +
                '               <label class="pull-right">ساعت</label>\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="0"/>\n' +
                '               <label class="pull-right">دقیقه</label>\n' +
                '           </div>\n' +
                '       </div>\n' +
                '   </div>\n' +
                '   <div class="clearfix"></div>\n' +
                '</div>\n';

            var project_span = '' +
                '<table>\n' +
                '   <tr>\n' +
                '       <td>\n' +
                '           <label class="pull-left" for="r2">{{ trans('process.select_process') }} : </label>\n' +
                '        </td>\n' +
                '        <td>\n' +
                '           <div class="input-group pull-left">\n' +
                '               <span class="input-group-addon" id="">\n' +
                '                   <i class="fa fa-tasks"></i>\n' +
                '               </span>\n' +
                '               <select id="process_id" name="process_id" class="select2_auto_complete_process" data-placeholder="{{trans('app.select_one_record')}}"  >\n' +
                '                   <option value=""></option>\n' +
                '               </select>\n' +
                '            </div>\n' +
                '         </td>\n' +
                '    </tr>\n' +
                '</table>\n';
            $('#project_span').html(project_span);
            $(".select2_auto_complete_process").select2({
                minimumInputLength: 1,
                dir: "rtl",
                width: "100%",
                tags: false,
                ajax: {
                    url: "{{route('auto_complete.process')}}",
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
            $('#respite_span').html(txt);
        }
    }
    function save_as_draft(form_id, again) {
        var form_data = $('#' + form_id).serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.save_drafts') }}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (again == 1) {
                    ResetForm();
                }
                else {
                    JS_Panel.close();
                }
                {{--window.location.replace("{{ route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts',['username'=>auth()->user()->Uname]) }}");--}}
                {{--if(result.success == true)--}}
                {{--{--}}
                {{--messageModal('success','{{trans('app.operation_is_success')}}',result.message);--}}
                {{--}--}}
                {{--else--}}
                {{--{--}}
                {{--messageModal('error','{{trans('app.operation_is_failed')}}',result.error);--}}
                {{--}--}}
            }
        });
    }
    function SaveTask(form_id, again) {
        //console.log(form_id);
        var form_data = $('#' + form_id).serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.save_task')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                console.log(result);
                if (result.success == true) {
                    if (again == 1) {
                        ResetForm();
                    }
                    else {
                        $('.jsPanel-btn-close').click();
                    }
                    messageModal('success','{{trans('tasks.create_new_task')}}' , {0:'{{trans('app.operation_is_success')}}'});
                }
                else {
                    messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                }
            }
        });
    }
    function ResetForm() {
        $('#new_task_users').val('');
        $('#new_task_transcripts').val('');
        $('#new_task_pages').val('');
        $('#new_task_keywords').val('');
        $('#create_new_task').trigger("reset");
    }
    $(".TimePicker").persianDatepicker({
        format: "HH:mm:ss a",
        timePicker: {
            //showSeconds: false,
        },
        onlyTimePicker: true
    });
    $(".DatePicker").persianDatepicker({
        observer: true,
        autoClose: true,
        format: 'YYYY-MM-DD'
    });

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
    $(".select2_auto_complete_transcripts").select2({
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
    $(".select2_auto_complete_page").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: false,
        ajax: {
            url: "{{route('auto_complete.pages')}}",
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
    $(".select2_auto_complete_keywords").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: true,
        ajax: {
            url: "{{route('auto_complete.keywords')}}",
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

    $(document).on('click', '.save_task', function () {

        var save_type = $("input[name='new_task_save_type']:checked").val()
        var $this = $(this);
        var form_id = $this.data('form_id');
        var save_again = $this.data('again_save');
        if (save_type == 1) {
            SaveTask(form_id, save_again);
        }
        else if (save_type == 0) {
            save_as_draft(form_id, save_again);
        }
        else
        {
            alert('{{ trans('tasks.the_save_type_is_not_selected') }}');
        }
    });

    $('#new_task_users').on('change', function() {
        var none = $(this).find('option:selected').length;
        if(none > 1)
            $('.person_option').show();
        else
            $('.person_option').hide();
    });

    $(document).ready(function () {
        $('.person_option').hide();

        $('.new_task_save_type_final').click();
    })
</script>