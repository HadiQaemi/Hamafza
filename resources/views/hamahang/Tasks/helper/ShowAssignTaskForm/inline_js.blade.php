<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/jsclender/jalali.js"></script>
<script type="text/javascript">
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 40px; top: -3px;"><a href="{!! url('/modals/helpview?code=').enCode('284') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
    function do_enable() {
        document.getElementById('date1').disabled = false;
        document.getElementById('time1').disabled = false;
    }
    function do_disable() {
        document.getElementById('date1').disabled = true;
        document.getElementById('time1').disabled = true;
    }
    $('input:radio[name="reject_assigner"]').change(function(){
        if($(this).val() == 1){
            $("#assigns_new").prop('disabled', true);
        }else {
            $("#assigns_new").prop('disabled', false);
        }
    });
    $('#task_schedul').on('change', function() {
        var schedul = $(this).val();
        $('.div-schedul div').addClass('hidden');
        $('.'+schedul).removeClass('hidden');
    });
    $("#action_duration").keyup(function(){
        m = moment($('#action_date_begin').val(), 'jYYYY-jM-jD');
        m.add((($('#action_time_type').val()*$(this).val())/24), 'day');
        $('#action_date_').val(m.format('jYYYY-jM-jD'));
    });
    $("#action_date_,#action_date_begin").change(function(){
        m1 = moment($('#action_date_begin').val(), 'jYYYY-jM-jD');
        m2 = moment($('#action_date_').val(), 'jYYYY-jM-jD');
        var duration = moment.duration(m2.diff(m1));
        var days = duration.asDays();
        $('#action_duration').val(days);
        $('#action_time_type').val('24');
    });
    $('#add_schedul').click(function () {
        $('#schedul_list').append('<div class="col-xs-12 noRightPadding noLeftPadding"><div class="col-lg-2 noRightPadding noLeftPadding"></div><div class="col-lg-5 noRightPadding noLeftPadding margin-right-20"><div class="col-lg-4 noRightPadding noLeftPadding"><label>{{ trans('tasks.begin') }}: </label>' + $('#action_date_begin').val() + ' </div><div class="col-lg-4 noRightPadding noLeftPadding"><label>{{ trans('tasks.predict_duration') }}: </label>' + $('#action_duration').val() + ' </div><div class="col-lg-4 noRightPadding noLeftPadding"><label>{{ trans('tasks.end') }}: </label>' + $('#action_date_').val() + '</div></div><div class="col-lg-2 noRightPadding noLeftPadding"><a class="btn btn-danger fa fa-remove"></a></div></div>');
    });
    function change_normal_task_timing_type(id) {
        if (id == 1) {
            var txt = '' +
                // '<div class="row-fluid">' +
                // '   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">' +
                // '       <div class=" row">' +
                // '           <div class="col-sm-6 col-xs-12">' +
                '               <label class="line-height-30">تاریخ</label>' +
                // '               <div class=" pull-right">' +//input-group
//                '                   <span class="input-group-addon" id="respite_date">' +
//                '                       <i class="fa fa-calendar"></i>' +
//                '                   </span>' +
                '                   <input type="text" class="form-control" name="respite_date" id="respite_date" {{ isset($task['respite_date']) ? 'value='.$task['respite_date'] : '' }} aria-describedby="respite_date">' +
//                 '               </div>' +
//                 '           </div>' +
//                 '           <div class="col-sm-6 col-xs-12">' +
                '               <label class="line-height-30">ساعت</label>' +
//                 '               <div class=" pull-right">' +//input-group
// //                '                   <span class="input-group-addon" id="respite_time">' +
// //                '                       <i class="fa fa-clock-o"></i>' +
// //                '                   </span>' +
                '                   <input type="text" class="form-control TimePicker" name="respite_time" aria-describedby="respite_time" {{ isset($task['respite_time']) ? 'value='.$task['respite_time'] : '' }}>' +
//                 '               </div>' +
//                 '           </div>' +
//                 '       </div>' +
//                 '   </div>' +
//                 '   <div class="clearfix"></div>' +
//                 '</div>' +
            '';
            $('#normal_task_timing').html(txt);
            // $(".TimePicker").persianDatepicker({
            //     format: "HH:mm:ss a",
            //     timePicker: {
            //         //showSeconds: false,
            //     },
            //     onlyTimePicker: true
            // });

            $("#respite_date").persianDatepicker({
                observer: true,
                autoClose: true,
                format: 'YYYY-MM-DD',
            });
        }else if (id == 0) {
            var txt = '' +
                // '<div class="row-fluid">\n' +
                // '   <div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">\n' +
                // '       <div class="row-fluid">\n' +
                // '           <div class="col-sm-12 col-xs-12 form-inline">\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day"/>\n' +
                '               <label class="pull-right">روز</label>\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="0" />\n' +
                '               <label class="pull-right">ساعت</label>\n' +
                '               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="0" />\n' +
                '               <label class="pull-right">دقیقه</label>\n' +
                // '           </div>\n' +
                // '       </div>\n' +
                // '   </div>\n' +
                // '   <div class="clearfix"></div>\n' +
                // '</div>\n'
                '';

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
            // $(".TimePicker").persianDatepicker({
            //     format: "HH:mm:ss a",
            //     timePicker: {
            //         //showSeconds: false,
            //     },
            //     onlyTimePicker: true
            // });

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
                '               <select id="project_id" name="project_id" class="select2_auto_c`omplete_project" data-placeholder="{{trans('app.select_one_record')}}" ></select>\n' +
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
    function SaveTask(form_id, again,action) {
        //console.log(form_id);
		$('#task_form_action').val(action);
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
                    {{--messageModal('success','{{trans('tasks.create_new_task')}}' , {0:'{{trans('app.operation_is_success')}}'});--}}
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
    $("#action_time").persianDatepicker({
        format: "HH:mm:ss a",
        timePicker: {
            //showSeconds: false,
        },
        onlyTimePicker: true
    });

    $("#action_time_to").persianDatepicker({
        selectedDate:"23:15:00 am",
        format: "HH:mm",
        timePicker: {
            //showSeconds: false,
        },
        onlyTimePicker: true
    });

    $("#action_time_from").on('keyup', function() {
        var action_time_from = $('#action_time_from').val().split(':');
        action_time_from = parseInt(action_time_from[0])*60 + parseInt(action_time_from[1]);
        var action_time_to = $('#action_time_to').val().split(':');
        action_time_to = parseInt(action_time_to[0])*60 + parseInt(action_time_to[1]);
        if(action_time_to > action_time_from)
            $("#action_duration_act").val(Math.floor((action_time_to-action_time_from)/(parseInt($('#action_duration_act_type').val()=='ساعت' ? 60 : 1))));
    });

    $("#action_duration_act").on('keyup', function() {
        var pe = new persianDate().subtract('milliseconds', 1000*$('#action_duration_act').val()*($('#action_duration_act_type').val()=='ساعت' ? 3600 : 60));
        $("#action_time_from").val(parseArabic(pe.format('HH:mm')));
    });
    $("#action_duration_act_type").on('change', function() {
        var pe = new persianDate().subtract('milliseconds', 1000*$('#action_duration_act').val()*($('#action_duration_act_type').val()=='ساعت' ? 3600 : 60));
        $("#action_time_from").val(parseArabic(pe.format('HH:mm')));
    });

    $(".DatePicker").persianDatepicker({
        observer: true,
        autoClose: true,
        format: 'YYYY-MM-DD'
    });
    function remove_new_task(num_add_rel_task) {
        $('#num_add_rel_task' + num_add_rel_task).remove();
    }
	var num_add_rel_task = 1;
	$("#add_rel_task").click(function () {
//	    alert($('#new_task_tasks').val());
		var project_span = '' +
			'   <tr id="num_add_rel_task'+num_add_rel_task+'">\n' +
//			'       <td>\n' +
//			'       	<label class="pull-right" for="r2">'+(num_add_rel_task++)+'</label>\n' +
//			'       </td>\n' +
			'       <td>\n' +
			'       	<label class="pull-right" for="r2">'+$('#select2-new_task_tasks-container').attr('title')+$('#select2-new_task_tasks-container').val()+'</label>\n' +
			'       		<input name="new_task_tasks_[]" type="hidden" value="' +$('#new_task_tasks').val()+ '"/>' +
			'       </td>\n' +
			'       <td>\n' +
			'           <label class="input-group pull-right">\n' +
							$('#new_task_weight').val() +
			'       		<input name="new_task_weight[]" type="text" value="0"/>' +
			'           </label>\n' +
			'       </td>\n' +
			'       <td>\n' +
			'       	<select name="new_task_relation[]" class="form-control" >\n' +
			// '				<option value="end_start">پایان به شروع</option>\n' +
			// '				<option value="start_start">شروع به شروع</option>\n' +
			// '				<option value="start_end">شروع به پایان</option>\n' +
			// '				<option value="end_end">پایان به پایان</option>\n' +
			'				<option value="up">بالادستی</option>\n' +
			'				<option value="down">پایین دستی</option>\n' +
			// '				<option value="after">گردش کار - بعدی</option>\n' +
			// '				<option value="previous">گردش کار - قبلی</option>\n' +
			'			</select>\n' +
			'       </td>\n' +
			'		<td>\n' +
			'           <label class="input-group pull-right">\n' +
			'       		<div class="col-xs-6"><input name="new_task_delay_num[]" type="text" class="form-control" placeholder="وقفه"/></div>' +
			'       		<div class="col-xs-6"><select name="new_task_delay_type[]" class="form-control" >\n' +
			'					<option value="day">روز</option>\n' +
			'					<option value="week">هفته</option>\n' +
			'					<option value="month">ماه</option>\n' +
			'				</select></div>\n' +
			'           </label>\n' +
			'       </td>\n' +
			'       <td>\n' +
			'       	<span class="fa fa-trash remove_new_task pointer" onclick="remove_new_task('+(num_add_rel_task++)+')" for="r2"></span>\n' +
			'       </td>\n' +
			'    </tr>\n';
        $('#rel_task_list').append(project_span);
	});
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
			'       	<span class="fa fa-trash remove_new_task pointer" onclick="remove_new_task('+(num_add_resource_task++)+')" for="r2"></span>\n' +
			'       </td>\n' +
			'    </tr>\n';
        $('#resources_task_list').append(project_span);
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
            url: "{{route('auto_complete.subjects')}}",
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
    $('#new_task_users').on('change', function() {
        var none = $(this).find('option:selected').length;
        if(none > 1)
            $('.person_option').show();
        else
            $('.person_option').hide();
		if(none >= 1)
            $('.send_message').show();
        else
            $('.send_message').hide();
    });
	
	$('#task_schedul').on('change', function() {
        var schedul = $(this).val();
		$('.div-schedul div').addClass('hidden');
		$('.'+schedul).removeClass('hidden');
    });
    function remove_action(action_list, ctid, ce) {
        var saveObj = {};
        saveObj.ctid = ctid;
        saveObj.ce = ce;
        $.ajax({
            url: '{{ URL::route('hamahang.calendar_events.delete_task_event')}}',
            type: 'POST', // Send post dat
            data: saveObj,
            async: false,
            success: function (s) {
                res = JSON.parse(s);
                if (res.success == false) {
                    errorsFunc('{{trans('calendar_events.ce_error_label')}}', res.error, '', '');
                } else {
                    $('.action_list'+action_list).remove();
                }
            }
        });
    }
    $('input:radio[name="timing_type"]').on('click', function () {
        if($(this).val() == 'manual')
        {
            $('.time_manual').removeClass('hidden');
        }else{
            $('.time_manual').addClass('hidden');
        }
    });
    $("#add_message_task").click(function () {
        if($('#message').val() == '')
        {

        }else {
            var project_span = '' +
                '   <tr id="add_resource_task'+num_add_resource_task+'">\n' +
                //			'       <td>\n' +
                //			'       	<label class="pull-right" for="r2">'+(num_add_rel_task++)+'</label>\n' +
                //			'       </td>\n' +
                '       <td>\n' +
                '       	<label class="pull-right" for="r2">'+$('#user').val()+'</label>\n' +
                '       		<input name="message_username[]" type="hidden" value="' +$('#user').val()+ '"/>' +
                '       		<input name="message_user_id[]" type="hidden" value="' +$('#user_id').val()+ '"/>' +
                '       </td>\n' +
                '       <td>\n' +
                '       	<label class="pull-right" for="r2">' + $(this).attr('date') + '</label>' +
                '       </td>\n' +
                '       <td>\n' +
                '           <label class="input-group pull-right">\n' + $('#message').val() +
                '       		<input name="messages[]" type="hidden" value="' +$('#message').val()+ '"/>' +
                '           </label>\n' +
                '       </td>\n' +
                '    </tr>\n';
            $('#message_task_list').append(project_span);
        }
    });
    var action_list = 10000;
	$('#add_btn_action').on('click', function() {
	    if(!($('#action_duration_act').val()>0)){
            messageModal('error', '{{trans('app.operation_is_failed')}}', '{{trans('calendar_events.no_enter_duration')}}');
            return false;
        }
        startdate = $('#action_date').val().split('-');
        enddate = $('#action_date').val().split('-');
        title = $('.task_title').val();
        var startdate = JalaliDate.jalaliToGregorian(startdate[0], startdate[1], startdate[2]);
        var enddate = JalaliDate.jalaliToGregorian(enddate[0], enddate[1], enddate[2]);
        var task_id = $('#task_id').val();
        var saveObj = {};
        startdate = startdate[0] + '-' + startdate[1] + '-' + startdate[2] + " " + $('#action_time_from').val() + ':00';
        enddate = enddate[0] + '-' + enddate[1] + '-' + enddate[2] + " " + $('#action_time_to').val() + ':00';
        saveObj.hstartdate = startdate;
        saveObj.henddate = enddate;
        saveObj.htitle = title;
        saveObj.hcid = '';
        saveObj.event_type = "task";
        saveObj.task_id = $('#tid').val();
        $.ajax({
            url: '{{ URL::route('hamahang.calendar_events.save_task_event')}}',
            type: 'POST', // Send post dat
            data: saveObj,
            async: false,
            success: function (s) {
                res = JSON.parse(s);
                if (res.success == false) {
                    errorsFunc('{{trans('calendar_events.ce_error_label')}}', res.error, '', '');
                } else {
                    action_list ++;
                    html =
                        '<div class="col-xs-12 action_list'+action_list+'" style="margin-top:10px">' +
                        '<div class="col-xs-2"> </div>' +
                        '<div class="col-xs-1">{{trans('tasks.in_date')}} </div>' +
                        '<div class="col-xs-3"><input type="hidden" name="action_date_list[]" value="' + $('#action_date').val() + '"><span class="margin-right-10"> ' + $('#action_date').val() + '' +
                        '</span> <span class="margin-right-10"> <input type="hidden" name="action_date_list[]" value="' + $('#action_duration_act').val() + '">{{trans('tasks.duration')}}: ' + $('#action_duration_act').val() +
                        '</span> <span class="margin-right-10"> <input type="hidden" name="action_duration_type_list[]" value="' + $('#action_duration_act_type').val() + '">' + $('#action_duration_act_type').val() + '</span> </div>' +
                        '<div class="col-xs-4"><span class="margin-right-10"> {{ trans('tasks.from') }} </span><input type="hidden" class="margin-right-10" name="action_time_from_list[]" value="' + $('#action_time_from').val() + '"> <span class="margin-right-10"> ' + $('#action_time_from').val() +
                        ' </span> <span class="margin-right-10"> {{ trans('tasks.to') }} </span><input type="hidden" name="action_time_to_list[]" value="' + $('#action_time_to').val() + '"><span class="margin-right-10">' + $('#action_time_to').val() + '</span>' +
                        '<i class="fa fa-remove pointer margin-right-10" onclick="remove_action('+action_list+')"></i></div>' +
                        '</div>';
                    $('#action_list').append(html);
                }
            }
        });
    });

	$('#new_task_transcripts').on('change', function() {
        var none = $(this).find('option:selected').length;
        if(none >=1)
            $('.transcript_option').show();
        else
            $('.transcript_option').hide();
    });

    $(document).ready(function () {
        $('#assign_object').on('change', function() {
            if ($(this).is(':checked')) {
                $('input:radio[name="reject_assigner"]').prop('disabled', false);
            }else{
                $('input:radio[name="reject_assigner"]').prop('disabled', true);
            }
        });
        @if($task['respite_timing_type']==0 || $task['respite_timing_type']==1)
            change_normal_task_timing_type({{$task['respite_timing_type']}});
        @endif
//        $("#respite_date").persianDatepicker({
//            observer: true,
//            autoClose: true,
//            format: 'YYYY-MM-DD'
//        });
        $('.person_option').hide();
        $('.send_message').hide();
        $('.transcript_option').hide();

        $('.new_task_save_type_final').click();
    })
</script>