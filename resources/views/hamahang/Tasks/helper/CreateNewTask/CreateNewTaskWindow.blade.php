<div id="tab" class="row table-bordered" style="border-bottom: none">
    <ul class="nav nav-tabs">
        <li  class="active">
            <a href="#tab_t1" data-toggle="tab">تعریف</a>
        </li>
        <li>
            <a href="#tab_t2" data-toggle="tab">تنظیم</a>
        </li>
        <li>
            <a href="#tab_t3" data-toggle="tab">منابع</a>
        </li>
        <li>
            <a href="#tab_t4" data-toggle="tab">روابط</a>
        </li>
        <li>
            <a href="#tab_t5" data-toggle="tab">اقدام</a>
        </li>
        <li>
            <a href="#tab_t6" data-toggle="tab">بحث و پیگیری</a>
        </li>
        <li>
            <a href="#tab_t7" data-toggle="tab">سابقه</a>
        </li>
        <li style="float: left">
            <h5 id="task_type" style="color: blue"></h5>
        </li>
    </ul>
    <form action="{{ route('hamahang.tasks.save_task') }}" class="" name="create_new_task" id="create_new_task" method="post"
          enctype="multipart/form-data">
        <div class="tab-content">
            <div class="tab-pane active" style="padding-top: 8px" id="tab_t1">

                <table class="table col-xs-12">
                    <tr>
                        <td class="width-120" style="border: none;">
                            <label class="line-height-35">{{ trans('tasks.title') }}</label>
                        </td>
                        <td style="border: none;">
                            <div class="row-fluid">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="title" id="title"/>
                                    </div>
                                    <div class="clearfixed"></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 line-height-35" style="padding-top: 5px;padding-bottom: 5px;">
                                        <div class="pull-right" style="height: 30px;line-height: 30px;border-left:1px solid #aaa">
                                            <input type="radio" name="type" value="0" id="official" checked/>
                                            <label for="official">{{ trans('app.official') }}</label>
                                            <input type="radio" name="type" value="1" id="unofficial"/>
                                            <label for="unofficial">{{ trans('app.unofficial') }}</label>
                                        </div>
                                        <div class="pull-right" style="height: 30px;line-height: 30px;border-left:1px solid #aaa">
                                            <input type="radio" name="kind" value="1" id="kind_activity"/>
                                            <label for="kind_activity">{{ trans('tasks.activity') }}</label>
                                            <input type="radio" name="kind" value="0" id="kind_event" checked/>
                                            <label for="kind_event">{{ trans('tasks.event')}}</label>
                                        </div>
                                        <div class="pull-right" style="height: 30px;line-height: 30px;border-left:1px solid #aaa">
                                            <input type="radio" name="importance" id="importance_yes" value="1"/>
                                            <label for="importance_yes">{{ trans('tasks.important') }}</label>
                                            <input type="radio" name="importance" id="importance_no" value="0" checked/>
                                            <label for="importance_no">{{ trans('tasks.unimportant')}}</label>
                                        </div>
                                        <div class="pull-right" style="height: 30px;line-height: 30px;">
                                            <input type="radio" name="immediate" id="immediate_yes" value="1"/>
                                            <label for="immediate_yes" >{{ trans('tasks.immediate') }}</label>
                                            <input type="radio" name="immediate" id="immediate_no" value="0" checked/>
                                            <label for="immediate_no">{{ trans('tasks.Non-urgent') }}</label>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="width-120" style="border: none;">
                            <label class="line-height-35">{{ trans('app.about') }}</label>
                        </td>
                        <td style="border: none;">
                            <div class="row-fluid">
                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row">
                                    <select id="new_task_pages" class="select2_auto_complete_page " name="pages[]"
                                            data-placeholder="{{trans('tasks.can_select_some_options')}}"
                                            multiple="multiple">
                                        @if($sid)
                                            <option value="{{$sid}}" selected>{{$subject->title}}</option>
                                        @endif
                                    </select>
                                    {{--<span class="fa fa-sticky-note Chosen-LeftIcon"></span>--}}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="width-120" style="border: none;">
                            <label class="line-height-35">{{ trans('tasks.description') }}</label>
                        </td>
                        <td style="border: none;">
                            <div class="row-fluid">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 line-height-35">
                                    <input type="text" class="form-control row" name="task_desc" id="desc" value="{{@$sel}}"/>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="width-120">
                            <label class="line-height-35">{{ trans('tasks.responsible') }}</label>
                        </td>
                        <td>
                            <div class="row-fluid">
                                <div class="col-sm-6 row" style="padding-left: 0px;">
                                    <select id="new_task_users_responsible" name="users[]" class="select2_auto_complete_user col-xs-12"
                                            data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                        <option value=""></option>
                                    </select>
                                    <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                                </div>
                                <div class="col-sm-6 line-height-35" style="padding-right: 5px;">

                                    <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_users']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                        <span class="icon icon-afzoodane-fard fonts"></span>
                                    </a>
                                    <input type="radio" name="assign_type" id="use_type1" class="person_option" value="1" checked/>
                                    <label class="person_option" for="use_type1">{{ trans('tasks.collective') }}</label>
                                    <input type="radio" name="assign_type" id="use_type2" class="person_option" value="2"/>
                                    <label class="person_option" for="use_type2">{{ trans('tasks.individual') }}</label>

                                    <input type="checkbox" name="send_mail" id="send_mail" class="send_message" value="1"/>
                                    <label class="send_message" for="send_mail">{{ trans('tasks.send-mail') }}</label>
                                    <input type="checkbox" name="send_sms" id="send_sms" class="send_message" value="1"/>
                                    <label class="send_message" for="send_sms">{{ trans('tasks.send-sms') }}</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="width-120" style="border: none;">
                            <label class="line-height-35">{{ trans('app.transcript') }}</label>
                        </td>
                        <td style="border: none;">
                            <div class="row-fluid">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 row" style="padding-left: 0px;">
                                    <select id="new_task_transcripts" name="transcripts[]" class="select2_auto_complete_transcripts"
                                            data-placeholder="{{trans('tasks.select_some_options')}}" multiple></select>
                                    <span class=" Chosen-LeftIcon"></span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 smaller-90 line-height-35" style="padding-right: 5px;">
                                    <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_transcripts']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                        <span class="icon icon-afzoodane-fard fonts"></span>
                                    </a>
                                    <input type="checkbox" name="report_on_cr" id="report-type1" class="transcript_option" value="1"/>
                                    <label for="report-type1" class="transcript_option">{{ trans('tasks.report_on_task_creation') }}</label>
                                    <input type="checkbox" name="report_on_co" id="report-type2" class="transcript_option" value="1"/>
                                    <label for="report-type2" class="transcript_option">{{ trans('tasks.report_on_task_completion') }}</label>
                                    <input type="checkbox" name="report_to_manager" id="report-type3" class="transcript_option" value="1"/>
                                    <label for="report-type3" class="transcript_option">{{ trans('tasks.report_on_responsible') }}</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="width-120">
                            <label class="line-height-35">{{ trans('tasks.keywords') }}</label>
                        </td>
                        <td>
                            <div class="row-fluid">
                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row">
                                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                                            data-placeholder="{{trans('tasks.can_select_some_options')}}"
                                            multiple="multiple"></select>
                                    <span class=" Chosen-LeftIcon"></span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="width-120" style="border: none;">
                            <label class="line-height-35">{{ trans('tasks.do_respite') }}</label>
                        </td>
                        <td style="border: none;">
                            <div id="respite_span">
                                <div class="col-xs-2">
                                    <input type="radio" name="respite_timing_type" id="determination_doing_duration" onclick="change_normal_task_timing_type(0)" value="0" checked/>
                                    <label for="determination_doing_duration">{{ trans('tasks.determination_doing_duration') }}</label>
                                    <input type="radio" name="respite_timing_type" id="determination_end_date" onclick="change_normal_task_timing_type(1)" value="1"/>
                                    <label for="determination_end_date">{{ trans('tasks.determination_end_date') }}</label>
                                </div>
                                <div id="normal_task_timing" class="col-xs-5">
                                    <div class="row-fluid">
                                        <div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                                            <div class="row-fluid">
                                                <div class="col-sm-12 col-xs-12 form-inline">
                                                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day" value="1"/>
                                                    <label class="pull-right">روز</label>
                                                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="0"/>
                                                    <label class="pull-right">ساعت</label>
                                                    <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="0"/>
                                                    <label class="pull-right">دقیقه</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <input type="radio" name="respite_timing_type" id="on-time" onclick="" value="2"/>
                                    <label for="on-time">{{ trans('tasks.on-time') }}</label>
                                    <input type="radio" name="respite_timing_type" id="no-detemine" onclick="" value="3"/>
                                    <label for="no-detemine">{{ trans('tasks.no-detemine') }}</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="width-120 ">
                            <label class="line-height-35">{{ trans('app.attachments') }}</label>
                            <div class="row-fluid">
                                <div class="filemanager-buttons-client">
                                    <div class="btn btn-default pull-left HFM_ModalOpenBtn" data-section="{{ enCode('CreateNewTask') }}" data-multi_file="Multi" style="margin-right: 0px;">
                                        <i class="glyphicon glyphicon-plus-sign" style="color: skyblue"></i>
                                        <span>{{trans('app.add_file')}}</span>
                                    </div>
                                    {{--<div data-section="{{ enCode(session('page_file')) }}"  class="HFM_RemoveAllFileFSS_SubmitBtn btn btn-default pull-left" style=" color:#555;">--}}
                                    {{--<i class="glyphicon glyphicon-remove-sign" style=" color:#FF6600;"></i>--}}
                                    {{--<span>{{trans('filemanager.remove_all_attachs')}}</span>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="pull-right filemanager-title-client">
                                    {{--<h4 class="filemanager-title">{{trans('filemanager.attachs')}}</h4>--}}
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </td>
                        <td>
                            <div class="row-fluid">
                                {!! $HFM_CN_Task['ShowResultArea']['CreateNewTask'] !!}
                            </div>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="draft" id="draft" value="0"/>
                <input type="hidden" name="first_m" id="first_m" value="0"/>
                <input type="hidden" name="first_u" id="first_u" value="0"/>
                <input type="hidden" name="assigner_id" value="125"/>
                <input type="hidden" name="task_form_action" id="task_form_action" value=""/>
                <input type="hidden" id="save_type" name="save_type" value="0"/>
            {!! $HFM_CN_Task['UploadForm'] !!}

            </div>
            <div class="tab-pane" id="tab_t2" style="padding: 8px;">
                <div class="input-group pull-right col-xs-12" style="margin: 0 0 15px 5px;">
                    <div class="col-xs-2">
                        <select id="task_schedul" name="task_schedul" class="form-control">
                            <option value="daily">{{trans('tasks.daily')}}</option>
                            <option value="weekly">{{trans('tasks.weekly')}}</option>
                            <option value="monthly">{{trans('tasks.monthly')}}</option>
                            <option value="seasonly">{{trans('tasks.seasonly')}}</option>
                            <option value="yearly">{{trans('tasks.yearly')}}</option>
                        </select>
                    </div>
                    <div class="col-xs-10 div-schedul">
                        <div class="daily col-xs-12">
                            <div class="daily col-xs-2" style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label style="line-height: 10px;" >{{trans('tasks.every')}}</label>
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text" id="daily_num" class="form-control" style="width: 40px;" name="daily_num" value="" >
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label style="line-height: 10px;" >{{trans('tasks.day')}}</label>
                                </span>
                            </div>
                            <div class="input-group pull-right daily col-xs-10" style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                                {!! Form::text('daily_value', null, ['class' => 'form-control TimePicker']) !!}
                            </div>
                        </div>
                        <div class="weekly hidden col-xs-12">
                            <div class="weekly col-xs-2"  style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label style="line-height: 10px;" >{{trans('tasks.every')}}</label>
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text" id="weekly_num" class="form-control" style="width: 40px;" name="weekly_num" value="" >
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label style="line-height: 10px;" >{{trans('tasks.week')}}</label>
                                </span>
                            </div>
                            <div class="input-group pull-right weekly col-xs-10" style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                                @for ($i = 0; $i < 7; $i++)
                                    <div class="input-group pull-right weekly" style="margin: 0 0 5px 5px;width: 13%">
                                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                            <input id="weekly_value_{{$i}}" class="form-control pull-right" style="width: 22px;" name="weekly_value[]" type="checkbox" value="{{$i}}">
                                        </span>
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                            <label style="line-height: 10px;" for="{{ "weekly_value_$i" }}">{{trans('tasks.array_weekly_weekdays.'.$i)}}</label>
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="monthly hidden">
                            <div class="monthly col-xs-2"  style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label style="line-height: 10px;" >{{trans('tasks.every')}}</label>
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text" id="monthly_num" class="form-control" style="width: 40px;" name="monthly_num" value="" >
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label style="line-height: 10px;" >{{trans('tasks.month')}}</label>
                                </span>
                            </div>
                            <div class="input-group pull-right monthly col-xs-10" style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                                @for ($i = 0; $i < 5; $i++)
                                    <div class="input-group pull-right monthly" style="margin: 0 0 5px 5px;width: 13%">
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
                                            <input id="monthly_value_{{$i}}" class="form-control pull-right" style="width: 22px;" name="monthly_value[]" type="checkbox" value="{{$i}}">
                                        </span>
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                            <label style="line-height: 10px;" for="{{ "monthly_value_$i" }}">{{trans('tasks.array_monthly_months.'.$i)}}</label>
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="seasonly hidden">
                            <div class="seasonly col-xs-2" style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label style="line-height: 10px;" >{{trans('tasks.every')}}</label>
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text" id="seasonly_num" class="form-control" style="width: 40px;" name="seasonly_num" value="" >
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label style="line-height: 10px;" >{{trans('tasks.season')}}</label>
                                </span>
                            </div>
                            <div class="input-group pull-right seasonly col-xs-10" style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="input-group pull-right seasonly" style="margin: 0 0 5px 5px;width: 22%">
                                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                            <input id="seasonly_value_{{$i}}" class="form-control pull-right" style="width: 22px;" name="seasonly_value[]" type="checkbox" value="{{$i}}">
                                        </span>
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                            <label style="line-height: 10px;" for="{{ "seasonly_value_$i" }}">{{trans('tasks.array_seasonly_seasons.'.$i)}}</label>
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="yearly hidden">
                            <div class="yearly col-xs-2" style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label style="line-height: 10px;" >{{trans('tasks.every')}}</label>
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text" id="yearly_num" class="form-control" style="width: 40px;" name="yearly_num" value="" >
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label style="line-height: 10px;" >{{trans('tasks.year')}}</label>
                                </span>
                            </div>
                            <div class="input-group pull-right yearly col-xs-10" style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                                @for ($i = 0; $i < 12; $i++)
                                    <div class="input-group pull-right yearly" style="margin: 0 0 5px 5px;width: 13%">
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
                                            <input id="yearly_num_{{$i}}" class="form-control pull-right" style="width: 22px;" name="yearly_num[]" type="checkbox" value="{{$i}}">
                                        </span>
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                            <label style="line-height: 10px;" for="{{ "yearly_num_$i" }}">{{trans('tasks.array_yearly_years.'.$i)}}</label>
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12" style="margin: 15px 0 0px 5px;">
                        <div class="col-xs-3" style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;height: 52px;">
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <label for="r2">{{ trans('tasks.begin') }}</label>
                            </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <input type="text" class="form-control DatePicker_begin_date" name="schedul_begin_date" aria-describedby="schedul_begin_date" id="schedul_begin_date">
                            </span>
                        </div>
                        <div class="col-xs-9" style="border: solid 1px #eee !important;border-radius: 4px;padding: 5px;">
                            <div class="daily col-xs-1" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                    <label for="r2">{{ trans('tasks.end') }}</label>
                                </span>
                            </div>
                            <div class="daily col-xs-2" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                    <input type="radio" name="schedul_end_date" value="schedul_end_date_none" id="schedul_end_date_none"/>
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <label for="schedul_end_date_none">{{ trans('tasks.none') }}</label>
                                </span>
                            </div>
                            <div class="daily col-xs-3" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="radio" name="schedul_end_date" value="schedul_end_date_events" id="schedul_end_date_events"/>
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label for="schedul_end_date_events">{{ trans('tasks.after') }}</label>
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text" id="schedul_end_date_events_" class="form-control" style="width: 40px;" name="schedul_end_num_events" value="" >
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label for="schedul_end_date_events_">{{ trans('tasks.event') }}</label>
                                </span>
                            </div>
                            <div class="daily col-xs-2" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;height: 34px">
                                    <input type="radio" name="schedul_end_date" value="schedul_end_date_date" id="schedul_end_date_date" checked/>
                                </span>
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;height: 34px">
                                    <label for="schedul_end_date_date">{{ trans('tasks.in-date') }}</label>
                                </span>
                            </div>
                            <div class="daily col-xs-3" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text" class="form-control DatePicker_end_date_date" name="schedul_end_date_date" aria-describedby="schedul_end_date_date" id="schedul_end_date_">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12" style="border-top:1px solid #ccc;margin-top: 10px;padding-top: 10px">
                    <div class="col-xs-1">
                        <label class="line-height-35">{{ trans('tasks.form') }}</label>
                    </div>
                    <div class="col-xs-11">
                        <select id="new_task_users" name="users[]" class="select2_auto_complete_user col-xs-12"
                                data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                            <option value=""></option>
                        </select>
                        <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-1">
                        <label class="line-height-35">{{ trans('tasks.here-help') }}</label>
                    </div>
                    <div class="col-xs-11">
                        <select id="new_task_users_" name="users[]" class="select2_auto_complete_user col-xs-12"
                                data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                            <option value=""></option>
                        </select>
                        <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                    </div>
                </div>
                <div class="col-xs-12" style="border-top:1px solid #ccc;margin-top: 10px;padding-top: 10px">
                    <div class="col-xs-1">
                        <input type="checkbox" class="form-control" name="end_on_assigner_accept" id="end_on_assigner_accept" style="height: 20px"/>
                    </div>
                    <div class="col-xs-10">
                        <label for="end_on_assigner_accept">{{ trans('tasks.modal_task_details_assignor_accept_or_ended') }}</label>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-1">
                        <input type="checkbox" class="form-control" name="transferable" id="transferable" style="height: 20px"/>
                    </div>
                    <div class="col-xs-11">
                        <label for="transferable">{{ trans('tasks.modal_task_details_assignor_to_another') }}</label>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_t3" style="padding: 8px;">
                <div class="col-xs-12">
                    <div class="col-xs-1">
                        <label class="line-height-35">{{ trans('tasks.resource') }}</label>
                    </div>
                    <div class="col-xs-8">
                        <select id="new_task_resources" name="new_task_resources[]" class="select2_auto_complete_resources col-xs-12"
                                {{--<select id="new_task_users" name="class[]" class="select2_auto_complete_tasks col-xs-12"--}}
                                data-placeholder="{{trans('tasks.select_some_options')}}">
                            <option value=""></option>
                        </select>
                        <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                    </div>
                    <div class="col-xs-1">
                        <input type="text" id="new_task_resources_amount" class="form-control" placeholder="{{ trans('tasks.amount') }} {{ trans('tasks.resource') }}"/>
                    </div>
                    <div class="col-xs-1">
                        <input type="text" id="new_task_resources_cost" class="form-control" placeholder="{{ trans('tasks.cost') }}"/>
                    </div>
                    <div class="col-xs-1">
                        <span class="btn btn-info fa fa-plus" id="add_resource_task"></span>
                    </div>
                </div>
                <div class="col-xs-12">
                    <table id="ChildsGrid" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            {{--<th class="col-xs-1">{{ trans('tasks.number') }}</th>--}}
                            <th class="col-xs-5">{{ trans('tasks.resource') }}</th>
                            <th class="col-xs-1">{{ trans('tasks.amount') }}</th>
                            <th class="col-xs-2">{{ trans('tasks.cost') }}</th>
                            <th class="col-xs-1">{{ trans('tasks.action') }}</th>
                        </tr>
                        </thead>
                        <tbody id="resources_task_list">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab_t4" style="padding: 8px;">
                <div class="col-xs-12">
                    <div class="col-xs-1">
                        <label class="line-height-35">{{ trans('tasks.class') }}</label>
                    </div>
                    <div class="col-xs-9">
                        <select id="new_task_tasks" name="rel_tasks[]" class="select2_auto_complete_tasks col-xs-12"
                        {{--<select id="new_task_users" name="class[]" class="select2_auto_complete_tasks col-xs-12"--}}
                                data-placeholder="{{trans('tasks.select_some_options')}}">
                            <option value=""></option>
                        </select>
                        <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                    </div>
                    <div class="col-xs-1">
                        <input type="text" id="new_task_weight" class="form-control" />
                    </div>
                    <div class="col-xs-1">
                        <span class="btn btn-info fa fa-plus" id="add_rel_task"></span>
                    </div>
                </div>
                <div class="col-xs-12">
                    <table id="ChildsGrid" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            {{--<th class="col-xs-1">{{ trans('tasks.number') }}</th>--}}
                            <th class="col-xs-5">{{ trans('tasks.name-task') }}</th>
                            <th class="col-xs-1">{{ trans('tasks.weight') }}</th>
                            <th class="col-xs-2">{{ trans('tasks.relation') }}</th>
                            <th class="col-xs-3">{{ trans('tasks.delay') }}</th>
                            <th class="col-xs-1">{{ trans('tasks.action') }}</th>
                        </tr>
                        </thead>
                        <tbody id="rel_task_list">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab_t5" style="padding: 8px;">
                <div class="col-xs-12" style="border-bottom: 1px solid #eee;padding: 10px 0px">
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label for="r2">{{ trans('tasks.form') }}</label>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12" style="border-bottom: 1px solid #eee;padding: 10px 0px">
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label for="r2">{{ trans('tasks.status') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-2">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="radio" name="task_status" id="not_start" value="not_start" checked/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="not_start">{{ trans('tasks.not_start') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-3">
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <input type="radio" name="task_status" id="on_done" value="on_done"/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                            <label for="on_done">{{ trans('tasks.on_done') }}-{{ trans('tasks.precent_progress') }}</label>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <input type="text" id="num_event" class="form-control" style="width: 40px;" name="num_day" value="" >
                        </span>
                    </div>
                    <div class="col-xs-2">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="radio" name="task_status" id="status_done" value="status_done" />
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="status_done">{{ trans('tasks.status_done') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-2">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="radio" name="task_status" id="status_finished" value="status_finished"/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="status_finished">{{ trans('tasks.status_finished') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-2">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="radio" name="task_status" id="status_suspended" value="status_suspended"/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="status_suspended">{{ trans('tasks.status_suspended') }}</label>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12" style="padding: 10px 0px">
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label for="r2">{{ trans('tasks.reject') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-2">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="checkbox" name="reject_assigner" id="reject_assigner" value="reject_assigner"/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="reject_assigner">{{ trans('tasks.reject_assigner') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-9">
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <input type="text" class="form-control" placeholder="توضیح ..." name="explain_reject" id="explain_reject" value=""/>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12" style="padding: 10px 0px">
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label class="line-height-35">{{ trans('tasks.reject_to') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-10">
                        <select id="new_task_transcripts_" name="transcripts[]" class="select2_auto_complete_transcripts"
                                data-placeholder="{{trans('tasks.select_some_options')}}" multiple></select>
                        <span class=" Chosen-LeftIcon"></span>
                    </div>
                    <div class="col-xs-1 pull_right">
                        <span class="input-group-addon edited-addon pull_right" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_transcripts']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12" style="border-bottom: 1px solid #eee;padding: 10px 0px">
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label class="line-height-35">{{ trans('tasks.keywords') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-11">
                        <select id="new_task_keywords_" class="select2_auto_complete_keywords" name="keywords[]"
                                data-placeholder="{{trans('tasks.can_select_some_options')}}"
                                multiple="multiple"></select>
                        <span class=" Chosen-LeftIcon"></span>
                    </div>
                </div>
                <div class="col-xs-12" style="border-bottom: 1px solid #eee;padding: 10px 0px">
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label class="line-height-35">{{ trans('tasks.ready') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label class="line-height-35">{{ trans('tasks.ready_body') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="radio" name="ready_body" id="ready_body_0" value="0" checked/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="ready_body_0">{{ trans('tasks.low') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="radio" name="ready_body" id="ready_body_l" value="1"/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="ready_body_l">{{ trans('tasks.high') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-1">

                    </div>
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label class="line-height-35">{{ trans('tasks.ready_mental') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="radio" name="ready_mental" id="ready_mental_0" value="0" checked/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="ready_mental_0">{{ trans('tasks.low') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="radio" name="ready_mental" id="ready_mental_l" value="1"/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="ready_mental_l">{{ trans('tasks.high') }}</label>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12" style="padding: 10px 0px">
                    <div class="col-xs-3" style="padding: 0px;margin: 0px;">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label class="line-height-35">{{ trans('tasks.duration') }}</label>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="text" class="form-control" name="action_duration" id="action_duration" value="1"/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <select id="action_time_type" name="action_time_type" class="form-control">
                                <option value="hour">{{trans('tasks.hour')}}</option>
                                <option value="daily">{{trans('tasks.day')}}</option>
                                <option value="weekly">{{trans('tasks.week')}}</option>
                                <option value="monthly">{{trans('tasks.month')}}</option>
                            </select>
                        </span>
                    </div>
                    <div class="col-xs-1" style="padding: 0px; margin-right: 10px;">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label class="line-height-35">{{ trans('tasks.done_time') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-2" style="padding: 0px; margin: 0px;">
                        <div class="col-xs-3" style="padding: 0px; margin: 0px;">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <input type="radio" name="done_time" id="to_end" value="to_end"/>
                            </span>
                        </div>
                        <div class="col-xs-3" style="padding: 0px; margin: 0px;">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <label for="to_end">{{ trans('tasks.to_end') }}</label>
                            </span>
                        </div>
                        <div class="col-xs-6" style="padding: 0px; margin: 0px;">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <select id="task_schedul_" name="task_schedul_" class="form-control">
                                    <option value="daily">{{trans('tasks.this')}} {{trans('tasks.day')}}</option>
                                    <option value="weekly">{{trans('tasks.this')}} {{trans('tasks.week')}}</option>
                                    <option value="monthly">{{trans('tasks.this')}} {{trans('tasks.month')}}</option>
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="col-xs-1">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <input type="radio" name="done_time" id="determined-time" value="determined-time"/>
                            </span>
                        </div>
                        <div class="col-xs-1">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <label for="determined-time">{{ trans('tasks.in') }}</label>
                            </span>
                        </div>
                        <div class="col-xs-5">
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <input type="text" class="form-control DatePicker" name="action_date" aria-describedby="respite_date">
                            </span>
                        </div>
                        <div class="col-xs-1">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                {{ trans('tasks.hour') }}
                            </span>
                        </div>
                        <div class="col-xs-4">
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <input type="text" class="form-control TimePicker" name="action_time" aria-describedby="respite_time">
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="radio" name="done_time" id="not-determine" value="not-determine"/>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="not-determine">{{ trans('tasks.no-just-detemine') }}</label>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12" style="border-bottom: 1px solid #eee;padding: 10px 0px">
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="not-determine">{{ trans('tasks.no-just-detemine') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-11">
                        <input type="text" name="action_explain" id="explain" class="form-control"/>
                    </div>
                </div>
                <div class="col-xs-12" style="border-bottom: 1px solid #eee;padding: 10px 0px">
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="not-determine">{{ trans('tasks.quality_done') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-9">
                        <div class="col-xs-2">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <input type="radio" name="quality_done" id="quality-excelent" value="excelent"/>
                            </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <label for="quality-excelent">{{ trans('tasks.excelent') }}</label>
                            </span>
                        </div>
                        <div class="col-xs-2">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <input type="radio" name="quality_done" id="quality-well" value="well"/>
                            </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <label for="quality-well">{{ trans('tasks.well') }}</label>
                            </span>
                        </div>
                        <div class="col-xs-2">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <input type="radio" name="quality_done" id="quality-average" value="average"/>
                            </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <label for="quality-average">{{ trans('tasks.average') }}</label>
                            </span>
                        </div>
                        <div class="col-xs-2">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <input type="radio" name="quality_done" id="quality-week" value="week"/>
                            </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <label for="quality-week">{{ trans('tasks.week') }}</label>
                            </span>
                        </div>
                        <div class="col-xs-2">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <input type="radio" name="quality_done" id="quality-very_week" value="very_week"/>
                            </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <label for="quality-very_week">{{ trans('tasks.very_week') }}</label>
                            </span>
                        </div>
                        <div class="col-xs-2">
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                <input type="radio" name="quality_done" id="quality-not_determined" value="not_determined" checked/>
                            </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <label for="quality-not_determined">{{ trans('tasks.not_determined') }}</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="quality-not_determined">{{ trans('tasks.score') }}</label>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="text" name="quality_score" id="quality-score" value="" class="form-control"/>
                        </span>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_t6" style="padding: 8px;">
                <div class="col-xs-12">
                    <div class="col-xs-3">
                        <label class="line-height-3">بحث و پیگیری</label>
                    </div>
                    <div class="col-xs-8">
                        <input type="text" id="message" class="form-control" placeholder="پیام"/>
                        <input type="hidden" id="user" class="form-control" value="{{Session::get('Name').' '.Session::get('Family')}}"/>
                    </div>
                    <div class="col-xs-1">
                        <span class="btn btn-info fa fa-plus" id="add_message_task"></span>
                    </div>
                </div>
                <div class="col-xs-12">
                    <table id="ChildsGrid" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            {{--<th class="col-xs-1">{{ trans('tasks.number') }}</th>--}}
                            <th class="col-xs-2">کاربر</th>
                            <th class="col-xs-10">پیام</th>
                        </tr>
                        </thead>
                        <tbody id="message_task_list">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab_t7" style="padding: 8px;">
                <div class="col-xs-12">
                    <table id="ChildsGrid" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            {{--<th class="col-xs-1">{{ trans('tasks.number') }}</th>--}}
                            <th class="col-xs-2">کاربر</th>
                            <th class="col-xs-5">اقدام</th>
                            <th class="col-xs-5">زمان</th>
                        </tr>
                        </thead>
                        <tbody id="message_task_list">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </form>
</div>

{{--<div class="col-xs-12 col-md-12">--}}
    {{--<form action="{{ route('hamahang.tasks.save_task') }}" class="" name="create_new_task" id="create_new_task" method="post"--}}
          {{--enctype="multipart/form-data">--}}
        {{--<table class="table col-xs-12">--}}
            {{--<tr>--}}
                {{--<td class="width-120">--}}
                    {{--<label class="line-height-35">{{ trans('tasks.title') }}</label>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<div class="row-fluid">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-sm-7">--}}
                                {{--<input type="text" class="form-control" name="title" id="title"/>--}}
                            {{--</div>--}}
                            {{--<div class="clearfixed"></div>--}}
                        {{--</div>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-12 line-height-35">--}}
                                {{--<div class="pull-right" style="margin: 0 0 0 10px;">--}}
                                    {{--<input type="radio" name="type" value="0" checked/>--}}
                                    {{--<label for="r1">{{ trans('app.official') }}</label>--}}
                                    {{--<input type="radio" name="type" value="1"/>--}}
                                    {{--<label for="r2">{{ trans('app.unofficial') }}</label>--}}
                                {{--</div>--}}
                                {{--<div class="pull-right" style="margin: 0 10px;">--}}
                                    {{--<input type="radio" name="importance" value="1"/>--}}
                                    {{--<label>{{ trans('tasks.important') }}</label>--}}
                                    {{--<input type="radio" name="importance" value="0" checked/>--}}
                                    {{--<label>{{ trans('tasks.unimportant')}}</label>--}}
                                {{--</div>--}}

                                {{--<div class="pull-right" style="margin: 0 10px;">--}}
                                    {{--<input type="radio" name="immediate" value="1"/>--}}
                                    {{--<label>{{ trans('tasks.immediate') }}</label>--}}
                                    {{--<input type="radio" name="immediate" value="0" checked/>--}}
                                    {{--<label>{{ trans('tasks.Non-urgent') }}</label>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}
                            {{--</div>--}}
                            {{--<div class="clearfix"></div>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="width-120">--}}
                    {{--<label class="line-height-35">{{ trans('tasks.importance') }}--}}
                        {{--{{ trans('tasks.immediacy') }}--}}
                    {{--</label>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<div class="row-fluid">--}}
                        {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-xs-6">--}}
                                    {{--<label>{{ trans('tasks.importance') }} :</label>--}}
                                    {{--<span class="input-group">--}}
                                        {{--<input type="radio" name="importance" value="1"/>--}}
                                        {{--<label>{{ trans('tasks.important') }}</label>--}}
                                        {{--<input type="radio" name="importance" value="0" checked/>--}}
                                        {{--<label>{{ trans('tasks.unimportant')}}</label>--}}
                                    {{--</span>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-6">--}}
                                    {{--<label>{{ trans('tasks.immediacy') }} :</label>--}}
                                    {{--<span class="input-group">--}}
                                        {{--<input type="radio" name="immediate" value="1"/>--}}
                                        {{--<label>{{ trans('tasks.immediate') }}</label>--}}
                                        {{--<input type="radio" name="immediate" value="0" checked/>--}}
                                        {{--<label>{{ trans('tasks.Non-urgent') }}</label>--}}
                                    {{--</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td>{{ trans('tasks.task_type') }}</td>--}}
                {{--<td>--}}
                    {{--<div class="row">--}}
                        {{--<table class="table no-margin no-padding">--}}
                            {{--<tr>--}}
                                {{--<td style="border-top: none;">--}}
                                    {{--<input type="radio" id="use_type0" name="use_type" value="0" onclick="change_respite_type(0)" checked/>  <!-------- normal task  ---->--}}
                                    {{--<label for="r1">{{ trans('tasks.ordinary_task') }}</label>--}}
                                    {{--<input type="radio" id="use_type1" name="use_type" value="1" onclick="change_respite_type(1)"/>          <!-------- project task  ---->--}}
                                    {{--<label for="r2">{{ trans('tasks.project_task') }}</label>--}}
                                    {{--<input type="radio" id="use_type2" name="use_type" value="2" onclick="change_respite_type(2)"/>          <!-------- process task  ---->--}}
                                    {{--<label for="r2">{{ trans('tasks.process_task') }}</label>--}}
                                {{--</td>--}}
                                {{--<td style="border-top: none;">--}}
                                    {{--<div id="project_span" class="pull-right"></div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--</table>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="width-120">--}}
                    {{--<label class="line-height-35">{{ trans('tasks.do_respite') }}</label>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<div id="respite_span">--}}
                        {{--<table class="table col-xs-12 no-padding no-margin">--}}
                            {{--<tr>--}}
                                {{--<td style="border-top: none;">--}}
                                    {{--<input type="radio" name="respite_timing_type" onclick="change_normal_task_timing_type(0)" value="0" checked/>--}}
                                    {{--<label for="r2">{{ trans('tasks.determination_doing_duration') }}</label>--}}
                                    {{--<input type="radio" name="respite_timing_type" onclick="change_normal_task_timing_type(1)" value="1"/>--}}
                                    {{--<label for="r1">{{ trans('tasks.determination_end_date') }}</label>--}}
                                {{--</td>--}}
                                {{--<td style="border-top: none;">--}}
                                    {{--<div id="normal_task_timing">--}}
                                        {{--<div class="row-fluid">--}}
                                            {{--<div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">--}}
                                                {{--<div class="row-fluid">--}}
                                                    {{--<div class="col-sm-12 col-xs-12 form-inline">--}}
                                                        {{--<input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day" value="1"/>--}}
                                                        {{--<label class="pull-right">روز</label>--}}
                                                        {{--<input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="0"/>--}}
                                                        {{--<label class="pull-right">ساعت</label>--}}
                                                        {{--<input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="0"/>--}}
                                                        {{--<label class="pull-right">دقیقه</label>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="clearfix"></div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="width-120">--}}
                    {{--<label class="line-height-35">{{ trans('tasks.responsible') }}</label>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<div class="row-fluid">--}}
                        {{--<div class="col-sm-7 row" style="padding-left: 0px;">--}}
                            {{--<select id="new_task_users" name="users[]" class="select2_auto_complete_user col-xs-12"--}}
                                    {{--data-placeholder="{{trans('tasks.select_some_options')}}" multiple>--}}
                                {{--<option value=""></option>--}}
                            {{--</select>--}}
                            {{--<span style=" position: absolute; left: 20px; top: 10px;" class=""></span>--}}


                        {{--</div>--}}
                        {{--<div class="col-sm-5 line-height-35" style="padding-right: 5px;">--}}

                            {{--<a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_users']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">--}}
                                {{--<span class="icon icon-afzoodane-fard fonts"></span>--}}
                            {{--</a>--}}
                            {{--<input type="radio" name="assign_type" id="use_type1" class="person_option" value="1" checked/>--}}
                            {{--<label class="person_option" for="use_type1">{{ trans('tasks.collective') }}</label>--}}
                            {{--<input type="radio" name="assign_type" id="use_type2" class="person_option" value="2"/>--}}
                            {{--<label class="person_option" for="use_type2">{{ trans('tasks.individual') }}</label>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="width-120">--}}
                    {{--<label class="line-height-35">{{ trans('app.transcript') }}</label>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<div class="row-fluid">--}}
                        {{--<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row" style="padding-left: 0px;">--}}
                            {{--<select id="new_task_transcripts" name="transcripts[]" class="select2_auto_complete_transcripts"--}}
                                    {{--data-placeholder="{{trans('tasks.select_some_options')}}" multiple></select>--}}
                            {{--<span class=" Chosen-LeftIcon"></span>--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 smaller-90 line-height-35" style="padding-right: 5px;">--}}
                            {{--<a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_transcripts']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">--}}
                                {{--<span class="icon icon-afzoodane-fard fonts"></span>--}}
                            {{--</a>--}}
                            {{--<input type="checkbox" name="report_on_cr" id="report-type1"/>--}}
                            {{--<label for="">{{ trans('tasks.report_on_task_creation') }}</label>--}}
                            {{--<input type="checkbox" name="report_on_co" id="report-type2"/>--}}
                            {{--<label for="">{{ trans('tasks.report_on_task_completion') }}</label>--}}
                            {{--<input type="checkbox" name="report_to_manager" id="report-type3"/>--}}
                            {{--<label for="">اطلاع به مسئولان</label>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="width-120">--}}
                    {{--<label class="line-height-35">{{ trans('app.about') }}</label>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<div class="row-fluid">--}}
                        {{--<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row">--}}
                            {{--<select id="new_task_pages" class="select2_auto_complete_page " name="pages[]"--}}
                                    {{--data-placeholder="{{trans('tasks.can_select_some_options')}}"--}}
                                    {{--multiple="multiple">--}}
                                {{--@if($sid)--}}
                                    {{--<option value="{{$sid}}" selected>{{$subject->title}}</option>--}}
                                {{--@endif--}}
                            {{--</select>--}}
                            {{--<span class="fa fa-sticky-note Chosen-LeftIcon"></span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="width-120">--}}
                    {{--<label class="line-height-35">{{ trans('tasks.keywords') }}</label>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<div class="row-fluid">--}}
                        {{--<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row">--}}
                            {{--<select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"--}}
                                    {{--data-placeholder="{{trans('tasks.can_select_some_options')}}"--}}
                                    {{--multiple="multiple"></select>--}}
                            {{--<span class=" Chosen-LeftIcon"></span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td></td>--}}
                {{--<td>--}}
                    {{--<div class="row-fluid">--}}
                        {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">--}}
                            {{--<div class="form-inline">--}}
                                {{--<input type="checkbox" class="form-control" name="end_on_assigner_accept" id="manager"/>--}}
                                {{--<label for="date">{{ trans('tasks.modal_task_details_assignor_accept_or_ended') }}</label>--}}
                                {{--<input type="checkbox" class="form-control" name="transferable" id="manager"/>--}}
                                {{--<label for="date">{{ trans('tasks.modal_task_details_assignor_to_another') }}</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="width-120 ">--}}
                    {{--<label class="line-height-35">{{ trans('app.attachments') }}</label>--}}
                    {{--<div class="row-fluid">--}}
                        {{--<div class="filemanager-buttons-client">--}}
                            {{--<div class="btn btn-default pull-left HFM_ModalOpenBtn" data-section="{{ enCode('CreateNewTask') }}" data-multi_file="Multi" style="margin-right: 0px;">--}}
                                {{--<i class="glyphicon glyphicon-plus-sign" style="color: skyblue"></i>--}}
                                {{--<span>{{trans('app.add_file')}}</span>--}}
                            {{--</div>--}}
                            {{--<div data-section="{{ enCode(session('page_file')) }}"  class="HFM_RemoveAllFileFSS_SubmitBtn btn btn-default pull-left" style=" color:#555;">--}}
                            {{--<i class="glyphicon glyphicon-remove-sign" style=" color:#FF6600;"></i>--}}
                            {{--<span>{{trans('filemanager.remove_all_attachs')}}</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="pull-right filemanager-title-client">--}}
                            {{--<h4 class="filemanager-title">{{trans('filemanager.attachs')}}</h4>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<div class="row-fluid">--}}
                        {{--{!! $HFM_CN_Task['ShowResultArea']['CreateNewTask'] !!}--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="width-120">--}}
                    {{--<label class="line-height-35">{{ trans('app.description') }}</label>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<div class="row-fluid">--}}
                        {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 line-height-35">--}}
                            {{--<input type="text" class="form-control row" name="task_desc" id="desc" value="{{@$sel}}"/>--}}
                            {{--<div class="clearfix"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
        {{--</table>--}}
        {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
        {{--<input type="hidden" name="draft" id="draft" value="0"/>--}}
        {{--<input type="hidden" name="first_m" id="first_m" value="0"/>--}}
        {{--<input type="hidden" name="first_u" id="first_u" value="0"/>--}}
        {{--<input type="hidden" name="assigner_id" value="125"/>--}}
        {{--<input type="hidden" id="save_type" name="save_type" value="0"/>--}}
    {{--</form>--}}
    {{--{!! $HFM_CN_Task['UploadForm'] !!}--}}
{{--</div>--}}

<script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>

@include('hamahang.Tasks.helper.CreateNewTask.inline_js')
{!! $HFM_CN_Task['JavaScripts'] !!}