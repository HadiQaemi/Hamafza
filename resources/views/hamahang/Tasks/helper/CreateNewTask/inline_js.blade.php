<script type="text/javascript">
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 40px; top: -3px;"><a href="{!! url('/modals/helpview?code=JDNi3x7xEY8') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
    function do_enable() {
        document.getElementById('date1').disabled = false;
        document.getElementById('time1').disabled = false;
    }
    function do_disable() {
        document.getElementById('date1').disabled = true;
        document.getElementById('time1').disabled = true;
    }
    $('#title').keypress(function () {
        $('.task_title').html($(this).val());
    });
    function change_normal_task_timing_type(id) {

        if (id == 1) {
            var txt = '' +
                '<label class="line-height-30 pull-right">تاریخ</label>' +
                '<input type="text" class="form-control DatePicker pull-right" name="respite_date" aria-describedby="respite_date">' +
                '<label class="line-height-30 pull-right">ساعت</label>' +
                '<input type="text" class="form-control TimePicker pull-right" name="respite_time" aria-describedby="respite_time">' +
                '';
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
        }else if (id == 0) {
            var txt = '' +
                '<input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day"/>\n' +
                '<label class="pull-right">روز</label>\n' +
                '<input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="0" />\n' +
                '<label class="pull-right">ساعت</label>\n' +
                '<input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="0" />\n' +
                '<label class="pull-right">دقیقه</label>';

            $('#normal_task_timing').html(txt);

        }else if (id == -1){
            $('#normal_task_timing').html('');
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

    function UpdateTask(form_id, again,action) {
        //console.log(form_id);
		$('#task_form_action').val(action);
        var form_data = $('#' + form_id).serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.update_task')}}',
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
    $(".DatePicker_").persianDatepicker({
        observer: true,
        autoClose: true,
        format: 'YYYY-MM-DD'
    });
    $(".DatePicker_begin_date").persianDatepicker({
        observer: true,
        autoClose: true,
        format: 'YYYY-MM-DD'
    });
    $(".DatePicker_end_date_date").persianDatepicker({
        observer: true,
        autoClose: true,
        format: 'YYYY-MM-DD'
    });
    function remove_new_task(num_add_rel_task) {
        $('#num_add_rel_task' + num_add_rel_task).remove();
    }

	var num_add_rel_task = 1;
    $("#add_rel_task").click(function () {
        if($('#new_task_projects').val()>0)
        {
            var project_span = '' +
                '   <tr id="num_add_rel_task'+num_add_rel_task+'">\n' +
                //			'       <td>\n' +
                //			'       	<label class="pull-right" for="r2">'+(num_add_rel_task++)+'</label>\n' +
                //			'       </td>\n' +
                '       <td><label class="pull-right line-height-30" for="r2">پایین دستی<\label>\n' +
                '       </td>\n' +
                '       <td>\n' +
                // '       	<label class="pull-right" for="r2">'+$('#select2-new_task_projects-container').attr('title')+'</label>\n' +
                // '       		<input name="new_task_projects_[]" type="hidden" value="' +$('#new_task_projects').val()+ '"/>' +
                // '       		<input name="new_task_projects_t[]" type="hidden" value="' +$('#select2-new_task_projects-container').attr('title')+ '"/>' +
                '       	<label class="pull-right line-height-30" style="width:100%;text-align: right" for="r2">پروژه: '+$('#select2-new_task_projects-container').attr('title')+'</label>\n' +
                '       		<input name="new_task_projects_[]" type="hidden" value="' +$('#new_task_projects').val()+ '"/>' +
                '       		<input name="new_task_projects_t[]" type="hidden" value="' +$('#select2-new_task_projects-container').attr('title')+ '"/>' +
                '       </td>\n' +
                '       <td>\n' +
                '           <label class="input-group pull-right">\n' +
                '       		<input name="new_project_weight[]" class="form-control" type="text" value="0"/>' +
                '           </label>\n' +
                '       </td>\n' +
                '       <td>\n' +
                '       	<span class="fa fa-remove remove_new_task pointer" onclick="remove_new_task('+(num_add_rel_task++)+')" for="r2"></span>\n' +
                '       </td>\n' +
                '    </tr>\n';
            $('#task_project').trigger("reset");
            $('#rel_task_list').prepend(project_span);
        }
        if($('#new_task_rel').val()>0)
        {
            var project_span = '' +
                '   <tr id="num_add_rel_task'+num_add_rel_task+'">\n' +
                //			'       <td>\n' +
                //			'       	<label class="pull-right" for="r2">'+(num_add_rel_task++)+'</label>\n' +
                //			'       </td>\n' +
                '       <td>\n' +
                '       	<select name="new_task_relation[]" class="new_task_relation form-control pull-right noLeftPadding noRightPadding" onchange="new_task_relation(this,' + num_add_rel_task + ')" style="width: 150px;">\n' +
                '				<option value="end_start">پایان به شروع</option>\n' +
                '				<option value="start_start">شروع به شروع</option>\n' +
                '				<option value="start_end">شروع به پایان</option>\n' +
                '				<option value="end_end">پایان به پایان</option>\n' +
                '				<option value="up">بالادستی</option>\n' +
                '				<option value="down">پایین دستی</option>\n' +
                // '				<option value="after">گردش کار - بعدی</option>\n' +
                // '				<option value="previous">گردش کار - قبلی</option>\n' +
                '			</select>\n' +
                '           <label class="input-group pull-right intrupt_div" style="width: 150px;">\n' +
                '       		<div class="col-xs-6 noLeftPadding noRightPadding"><input name="new_task_delay_num[]" type="text" class="form-control" placeholder="وقفه"/></div>' +
                '       		<div class="col-xs-6 noLeftPadding noRightPadding"><select name="new_task_delay_type[]" class="form-control" >\n' +
                '					<option value="day">روز</option>\n' +
                '					<option value="week">هفته</option>\n' +
                '					<option value="month">ماه</option>\n' +
                '				</select></div>\n' +
                '           </label>\n' +
                '       </td>\n' +
                '       <td>\n' +
                // '       	<label class="pull-right" for="r2">'+$('#select2-new_task_projects-container').attr('title')+'</label>\n' +
                // '       		<input name="new_task_projects_[]" type="hidden" value="' +$('#new_task_projects').val()+ '"/>' +
                // '       		<input name="new_task_projects_t[]" type="hidden" value="' +$('#select2-new_task_projects-container').attr('title')+ '"/>' +
                '       	<label class="pull-right line-height-30" for="r2">وظیفه: '+$('#select2-new_task_rel-container').attr('title')+'</label>\n' +
                '       		<input name="new_task_tasks_[]" type="hidden" value="' +$('#new_task_rel').val()+ '"/>' +
                '       		<input name="new_task_tasks_t[]" type="hidden" value="' +$('#select2-new_task_rel-container').attr('title')+ '"/>' +
                '       </td>\n' +
                '       <td>\n' +
                '           <label class="input-group pull-right">\n' +
                '       		<input name="new_task_weight[]" class="form-control hidden new_task_weight'+num_add_rel_task+'" type="text" value="0"/>' +
                '           </label>\n' +
                '       </td>\n' +
                '       <td>\n' +
                '       	<span class="fa fa-remove remove_new_task pointer" onclick="remove_new_task('+(num_add_rel_task++)+')" for="r2"></span>\n' +
                '       </td>\n' +
                '    </tr>\n';
            $('#task_project').trigger("reset");
            $('#rel_task_list').append(project_span);
        }
    });
    function new_task_relation(t,num) {
        if($(t).val() == 'up' || $(t).val() == 'down'){
            $(t).next().addClass('hidden');
            $('.new_task_weight'+(num)).removeClass('hidden');
        }
        else{
            $(t).next().removeClass('hidden');
            $('.new_task_weight'+(num)).addClass('hidden');
        }

    }
	var num_add_resource_task = 1;
	$("#add_resource_task").click(function () {
	    var project_span = '' +
			'   <tr id="add_resource_task'+num_add_resource_task+'">\n' +
//			'       <td>\n' +
//			'       	<label class="pull-right" for="r2">'+(num_add_rel_task++)+'</label>\n' +
//			'       </td>\n' +
			'       <td>\n' +
			'       	<label class="pull-right" for="r2">'+$('#select2-new_task_resources-container').attr('title')+'</label>\n' +
			'       		<input name="new_task_resources_h[]" type="hidden" value="' +($('#select2-new_task_resources-container').val().trim()=='' ? $('#select2-new_task_resources-container').attr('title') : $('#select2-new_task_resources-container').val())+ '"/>' +
			'       		<input name="new_task_resources_t[]" type="hidden" value="' +$('#select2-new_task_resources-container').attr('title')+ '"/>' +
			'       </td>\n' +
			'       <td>\n' +
			'           <label class="input-group pull-right">\n' +
							$('#new_task_resources_amount').val() +
			'       		<input name="new_task_resources_amount[]" type="hidden" value="' +$('#new_task_resources_amount').val()+ '"/>' +
			'           </label>\n' +
			'       </td>\n' +
			'       <td>\n' +
			'           <label class="input-group pull-right">\n' +
							$('#new_task_resources_cost').val() +
			'       		<input name="new_task_resources_cost[]" type="hidden" value="' +$('#new_task_resources_cost').val()+ '"/>' +
			'           </label>\n' +
			'       </td>\n' +
			'       <td>\n' +
			'       	<span class="fa fa-remove remove_new_task pointer" onclick="remove_new_task('+(num_add_resource_task++)+')" for="r2"></span>\n' +
			'       </td>\n' +
			'    </tr>\n';
        $('#resources_task_list').append(project_span);
	});
	$("#add_message_task").click(function () {
	    var project_span = '' +
			'   <tr id="add_resource_task'+num_add_resource_task+'">\n' +
//			'       <td>\n' +
//			'       	<label class="pull-right" for="r2">'+(num_add_rel_task++)+'</label>\n' +
//			'       </td>\n' +
			'       <td>\n' +
			'       	<label class="pull-right" for="r2">'+$('#user').val()+'</label>\n' +
			'       		<input name="message_username[]" type="hidden" value="' +$('#user').val()+ '"/>' +
			'       </td>\n' +
			'       <td>\n' +
			'           <label class="input-group pull-right">\n' +
							$('#message').val() +
			'       		<input name="messages[]" type="hidden" value="' +$('#message').val()+ '"/>' +
			'           </label>\n' +
			'       </td>\n' +
			'    </tr>\n';
        $('#message_task_list').append(project_span);
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
	$(".select2_auto_complete_projects").select2({
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
    $(".select2_auto_complete_tasks").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: false,
        ajax: {
            url: "{{route('auto_complete.tasks')}}",
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
    $(".select2_auto_complete_resources").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: true,
        ajax: {
            url: "{{route('auto_complete.resources')}}",
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

    $('#reject_assigner').on('click', function() {
        if($(this).is(":checked")){
            $(".assingned_options").prop('disabled', true);
            $(".rejected_options").prop('disabled', false);
        }
        else {
            $(".rejected_options").prop('disabled', true);
            $(".assingned_options").prop('disabled', false);
        }
    });


    //************** sended to master.blade

    {{--function SaveTask(form_id, again,action) {--}}
        {{--//console.log(form_id);--}}
        {{--$('#task_form_action').val(action);--}}
        {{--var form_data = $('#' + form_id).serialize();--}}
        {{--$.ajax({--}}
            {{--type: "POST",--}}
            {{--url: '{{ route('hamahang.tasks.save_task')}}',--}}
            {{--dataType: "json",--}}
            {{--data: form_data,--}}
            {{--success: function (result) {--}}
                {{--console.log(result);--}}
                {{--if (result.success == true) {--}}
                    {{--if (again == 1) {--}}
                        {{--ResetForm();--}}
                    {{--}--}}
                    {{--else {--}}
                        {{--$('.jsPanel-btn-close').click();--}}
                    {{--}--}}
                    {{--messageModal('success','{{trans('tasks.create_new_task')}}' , {0:'{{trans('app.operation_is_success')}}'});--}}
                {{--}--}}
                {{--else {--}}
                    {{--messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);--}}
                {{--}--}}
            {{--}--}}
        {{--});--}}
    {{--}--}}
    {{--$(document).on('click', '.save_task', function () {--}}

        {{--var save_type = $("input[name='new_task_save_type']:checked").val()--}}
        {{--var $this = $(this);--}}
        {{--var form_id = $this.data('form_id');--}}
        {{--var save_again = $this.data('again_save');--}}
        {{--if (save_type == 1) {--}}
            {{--SaveTask(form_id, save_again,1);--}}
        {{--}--}}
        {{--else if (save_type == 0) {--}}
            {{--SaveTask(form_id, save_again,0);--}}
            {{--//save_as_draft(form_id, save_again);--}}
        {{--}--}}
        {{--else--}}
        {{--{--}}
            {{--alert('{{ trans('tasks.the_save_type_is_not_selected') }}');--}}
        {{--}--}}
    {{--});--}}


    $('#new_task_users_responsible').on('change', function() {
        var none = $(this).find('option:selected').length;
        if(none > 1)
            $('.person_option').show();
        else
            $('.person_option').hide();
		if(none >= 1)
            $('.send_message').show();
        else
            $('.send_message').hide();

        var title = $('#title').val();
        if(title.trim().length>0 && none>0)
            $('.new_task_save_type_final').click();
        else
            $('.new_task_save_type_draft').click();
    });

    $('#task_title').on('keyup', function() {

        var title = $(this).val();
        var new_task_users_responsible = $('#new_task_users_responsible').find('option:selected').length;
        if(title.trim().length>0 && new_task_users_responsible>0)
            $('.new_task_save_type_final').click();
        else
            $('.new_task_save_type_draft').click();
    });
	
	$('#task_schedul').on('change', function() {
        var schedul = $(this).val();
        if(schedul=='minute' || schedul=='hour' || schedul=='daily')
            $('.lbl_repeat_in').addClass('hidden');
        else
            $('.lbl_repeat_in').removeClass('hidden');
		$('.div-schedul div').addClass('hidden');
		$('.'+schedul).removeClass('hidden');
    });
	
	$('#new_task_transcripts').on('change', function() {
        var none = $(this).find('option:selected').length;
        if(none >=1)
            $('.transcript_option').show();
        else
            $('.transcript_option').hide();
    });

    $(document).ready(function () {
        $('.person_option').hide();
        $('.send_message').hide();
        $('.transcript_option').hide();
		$('#create_new_task').on('click', function() {
            var title = $('#title').val();
            var new_task_users_responsible = $('#new_task_users_responsible').find('option:selected').length;
            if(title.trim().length>0 && new_task_users_responsible>0)
                $('.new_task_save_type_final').click();
            else
                $('.new_task_save_type_draft').click();
		});
        new_task_save_type = $("input[name='new_task_save_type']:checked").val();
        if(new_task_save_type==0)
            $('.new_task_save_type_draft').click();
    })

</script>