
    <link type="text/css" rel="stylesheet"  href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
    <link type="text/css" rel="stylesheet"  href="{{URL::to('assets/Packages/TagsInput/css/jquery.tagsinput.rtl.css')}}">
    <link type="text/css" rel="stylesheet"  href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
    <link type="text/css" rel="stylesheet"  href="http://192.168.1.100/Sample_Code/chosen-bootstrap.css">


    <div id="form_jspanel" style="position: relative; margin: 25px;">
        <div class="col-lg-12 " dir="rtl">
            <div class="panel panel-info">
                <div class="panel-heading "> {{ trans('tasks.create_new_task') }} </div>
                <div class="panel-body " dir="rtl">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="pill">{{ trans('modal.plural') }}</a></li>
                        {{--<li><a href="#set" data-toggle="pill">{{trans('tasks.settings')}}</a></li>--}}
                        {{--<li><a href="#resources" data-toggle="pill">منابع</a></li>--}}
                        {{--<li><a href="#relations" data-toggle="pill">روابط</a></li>--}}

                    </ul>
                    <form action="{{ route('hamahang.tasks.save_task') }}" class="" name="task_public" id="task_public" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="draft" id="draft" value="0"/>
                        <input type="hidden" name="first_m" id="first_m" value="0"/>
                        <input type="hidden" name="first_u" id="first_u" value="0"/>
                        <input type="hidden" name="assigner_id" value="125"/>
                        <div class="tab-content">

                            <div id="home" class="tab-pane fade in active">
                                @include('hamahang.Tasks.helper.CreateNewTask.task_create')
                            </div>

                            {{--<div id="set" class="tab-pane fade">--}}
                            {{--@include('hamafza.tasks.helper.CreateNewTask.task_settings')--}}
                            {{--</div>--}}

                            {{--<div id="resources" class="tab-pane fade">--}}
                            {{--@include('hamafza.tasks.helper.CreateNewTask.task_resources')--}}
                            {{--</div>--}}

                            {{--<div id="relations" class="tab-pane fade">--}}
                            {{--@include('hamafza.tasks.helper.CreateNewTask.task_relations')--}}
                            {{--</div>--}}



                        </div>
                        <hr>
                        <input type="hidden" id="save_type" name="save_type" value="0"/>
                        <button  class="btn btn-info pull-left" id="save_commit">
                            <i ></i>
                            {{trans('tasks.submit')}}
                        </button>
                        <button onclick="save_as_draft()" class="btn btn-default pull-left" id="save_draft" >
                            <i ></i>
                            {{trans('tasks.draft')}}
                        </button>
                        <a class="btn btn-default pull-left" href="{{ route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts',['username'=>$uname]) }}" >{{ trans('modal.show_drafts') }}</a>
                    </form>
                    {!! $HFM_CNT['UploadForm'] !!}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/TagsInput/js/jquery.tagsinput.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
    <script type="text/javascript">
        function change_normal_task_timing_type(id) {
            if(id==1)
            {
                var txt = '<div class="row-fluid">\
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">\
                    <div class=" row">\
                    <div class="col-sm-6 col-xs-12">\
                    <label class="line-height-30 pull-right">{{ trans('modal.date') }}</label>\
                    <div class="input-group pull-right">\
                    <span class="input-group-addon" id="respite_date">\
                    <i class="fa fa-calendar"></i>\
                    </span>\
                    <input type="text" class="form-control DatePicker" name="respite_date" aria-describedby="respite_date">\
                    </div>\
                    </div>\
                    <div class="col-sm-6 col-xs-12">\
                    <label class="line-height-30">{{ trans('modal.hour') }}</label>\
                    <div class="input-group">\
                    <span class="input-group-addon" id="respite_time">\
                    <i class="fa fa-clock-o"></i>\
                    </span>\
                    <input type="text" class="form-control TimePicker" name="respite_time"\
                aria-describedby="respite_time">\
                        </div>\
                        </div>\
                        </div>\
                        </div>\
                        <div class="clearfix"></div>\
                    </div>';
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
            if(id==2)
            {
                var txt = '<div class="row-fluid">\
                        <div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">\
                    <div class="row-fluid">\
                    <div class="col-sm-12 col-xs-12 form-inline">\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day"/>\
                    <label class="pull-right">{{ trans('modal.day') }}</label>\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="00" disabled/>\
                    <label class="pull-right">{{ trans('modal.hour') }}</label>\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="00" disabled/>\
                    <label class="pull-right">{{ trans('modal.minute') }}</label>\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_sec" id="duration_sec" value="00" disabled/>\
                    <label class="pull-right">{{ trans('modal.second') }}</label>\
                    </div>\
                    </div>\
                    </div>\
                    <div class="clearfix"></div>\
                    </div>';

                $('#normal_task_timing').html(txt);

            }else if (id == -1){
                $('#normal_task_timing').html('');
            }
        }

        function change_respite_type(id) {
            if(id ==0)
            {
                var respite_span = '<table class="table col-xs-12">\
                        <tr>\
                        <td >\
                        <input type="radio" name="respite_timing_type" onclick="change_normal_task_timing_type(1)"  value="0" checked/>\
            <label for="r1">{{ trans('modal.define_end_date') }}</label>\
            <input type="radio" name="respite_timing_type" onclick="change_normal_task_timing_type(2)" value="1"/>\
                    <label for="r2">{{ trans('modal.define_duration_of') }}</label>\
            </td>\
            </tr>\
            <tr>\
            <td>\
            <span id="normal_task_timing">\
                    <div class="row-fluid">\
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">\
                    <div class=" row">\
                    <div class="col-sm-6 col-xs-12">\
                    <label class="line-height-30 pull-right">{{ trans('modal.date') }}</label>\
                    <div class="input-group pull-right">\
                    <span class="input-group-addon" id="respite_date">\
                    <i class="fa fa-calendar"></i>\
                    </span>\
                    <input type="text" class="form-control DatePicker" name="respite_date" aria-describedby="respite_date">\
                    </div>\
                    </div>\
                    <div class="col-sm-6 col-xs-12">\
                    <label class="line-height-30">{{ trans('modal.hour') }}</label>\
                    <div class="input-group">\
                    <span class="input-group-addon" id="respite_time">\
                    <i class="fa fa-clock-o"></i>\
                    </span>\
                    <input type="text" class="form-control TimePicker" name="respite_time"\
                aria-describedby="respite_time">\
                        </div>\
                        </div>\
                        </div>\
                        </div>\
                        <div class="clearfix"></div>\
                    </div>\
                    </span>\
                    </td>\
                    </tr>\
                    </table>';
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
            else if(id == 1)
            {
                var respite_span = '<div class="row-fluid">\
                        <div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">\
                    <div class="row-fluid">\
                    <div class="col-sm-12 col-xs-12 form-inline">\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day"/>\
                    <label class="pull-right">{{ trans('modal.day') }}</label>\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="00" disabled/>\
                    <label class="pull-right">{{ trans('modal.hour') }}</label>\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="00" disabled/>\
                    <label class="pull-right">{{ trans('modal.minute') }}</label>\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_sec" id="duration_sec" value="00" disabled/>\
                    <label class="pull-right">{{ trans('modal.second') }}</label>\
                    </div>\
                    </div>\
                    </div>\
                    <div class="clearfix"></div>\
                    </div>';
                $('#respite_span').html(respite_span);
                // $('#project_span').html(project_span);
                var project_span = '' +
                        '<table>\n' +
                        '   <tr>\n' +
                        '       <td>\n' +
                        '           <label class="pull-left" for="r2">{{ trans('modal.project_name') }}</label>\n' +
                        '        </td>\n'+
                        '        <td>\n' +
                        '           <div class="input-group pull-left">\n' +
                        '               <span class="input-group-addon" id="">\n' +
                        '                   <i class="fa fa-tasks"></i>\n' +
                        '               </span>\n' +
                        '               <select id="project_id" name="project[]" class="chosen-rtl form-control" data-placeholder="{{ trans('modal.select') }}" style="width: 150px" >\n' +
                        '                   <option value=""></option>\n' +
                        '               </select>\n' +
                        '            </div>\n' +
                        '         </td>\n' +
                        '    </tr>\n' +
                        '</table>\n';
                $('#project_span').html(project_span);
                $('#project_id').ajaxChosen({
                    dataType    : 'json',
                    type        : 'POST',
                    url         : "{{ route('hamahang.project.user_projects') }}"
                });
            }
            else if(id == 2)
            {
                var txt = '<div class="row-fluid">\
                        <div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">\
                    <div class="row-fluid">\
                    <div class="col-sm-12 col-xs-12 form-inline">\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day"/>\
                    <label class="pull-right">{{ trans('modal.day') }}</label>\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="00" disabled/>\
                    <label class="pull-right">{{ trans('modal.hour') }}</label>\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="00" disabled/>\
                    <label class="pull-right">{{ trans('modal.minute') }}</label>\
                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_sec" id="duration_sec" value="00" disabled/>\
                    <label class="pull-right">{{ trans('modal.second') }}</label>\
                    </div>\
                    </div>\
                    </div>\
                    <div class="clearfix"></div>\
                    </div>';
                var project_span = '' +
                        '<table>\n' +
                        '   <tr>\n' +
                        '       <td>\n' +
                        '           <label class="pull-left" for="r2">{{ trans('modal.process_name') }}</label>\n' +
                        '        </td>\n'+
                        '        <td>\n' +
                        '           <div class="input-group pull-left">\n' +
                        '               <span class="input-group-addon" id="">\n' +
                        '                   <i class="fa fa-tasks"></i>\n' +
                        '               </span>\n' +
                        '               <select id="process_id" name="process_id[]" class="chosen-rtl form-control" data-placeholder="{{ trans('modal.select') }} " style="width: 150px" >\n' +
                        '                   <option value=""></option>\n' +
                        '               </select>\n' +
                        '            </div>\n' +
                        '         </td>\n' +
                        '    </tr>\n' +
                        '</table>\n';
                $('#project_span').html(project_span);
                $('#project_id').ajaxChosen({
                    dataType    : 'json',
                    type        : 'POST',
                    url         : "{{ route('hamahang.process.user_process') }}"
                });
                $('#process_id').ajaxChosen({
                    dataType    : 'json',
                    type        : 'POST',
                    url         : "{{ route('hamahang.process.user_process') }}"
                });
                $('#respite_span').html(txt);
            }
        }
        $(".js-data-example-ajax").select2({
            minimumInputLength: 2,
            tags: [],
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('autocomplete_pages_list',['username'=>$UName]) }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
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
        (function ($) {
            $('#tags').tagsInput
            ({
                'width'                 : 'auto',
                'height'                : 'auto',
                'minChars'              : 0,
                'maxChars'              : 0, // if not provided there is no limit
                'delimiter'             : [','],   // Or a string with a single delimiter. Ex: ';'
                'interactive'           : true,
                'defaultText'           : '{{trans('tasks.enter_keywords')}}',
                'placeholderColor'      : '#777777',
                'removeWithBackspace'   : true,
                //'autocomplete_url': url_to_autocomplete_api,
                //'autocomplete': { option: value, option: value},
                //'onAddTag':callback_function,
                //'onRemoveTag':callback_function,
                //'onChange' : callback_function,
            });

            $('#states-multi-select-users').ajaxChosen({
                dataType    : 'json',
                type        : 'POST',
                url         : "{{ route('autocomplete',['username'=>$uname]) }}"
            });

            $('#states-multi-select-transcripts').ajaxChosen({
                dataType    : 'json',
                type        : 'POST',
                url         : "{{ route('autocomplete',['username'=> $uname ]) }}"
            });

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

        })(jQuery);

    </script>

    {!! $HFM_CNT['JavaScripts'] !!}

    <script>
        function save_as_draft() {

            $('#save_type').val(1);
            $('#task_public').attr('action', '{{ route('hamahang.tasks.save_drafts') }}');
            $('#task_public').submit();

        }

        function do_enable()
        {
            document.getElementById('date1').disabled = false;
            document.getElementById('time1').disabled = false;
        }
        function do_disable()
        {
            document.getElementById('date1').disabled = true;
            document.getElementById('time1').disabled = true;
        }


    </script>

