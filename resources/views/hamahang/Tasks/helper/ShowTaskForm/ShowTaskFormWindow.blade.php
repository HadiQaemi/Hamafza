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
        <a href="#tab_t6" data-toggle="tab">گفتگو</a>
        </li>
        <li>
        <a href="#tab_t7" data-toggle="tab">سابقه</a>
        </li>
        <li style="float: left">
            <h5 id="task_type" style="color: blue"></h5>
        </li>
    </ul>
    @php
    $task = $res['task'];
    $edit_able = ($res['task_all']->uid != Auth::id() ? true : true);
    @endphp

    {{--<form action="{{ route('hamahang.tasks.save_task') }}" class="" name="ShowTaskForm" id="ShowTaskForm" method="post"--}}
    <form action="{{ route('hamahang.tasks.update_task') }}" class="" name="ShowTaskForm" id="ShowTaskForm" method="post" enctype="multipart/form-data">
        <div class="tab-content new-task-form">
            <div class="tab-pane active" style="padding-top: 8px;margin-top:20px" id="tab_t1">
                <div class="row col-lg-12">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('tasks.title') }}</label></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <input type="text" class="form-control" {{$edit_able == 1 ? ' name="title" id="title" ' : 'disabled'}} value="{{$task['title']}}"/>
                            <input type="hidden" name="tid" id="tid" value="{{$res['task_id']}}"/>
                        </div>
                        <div class="row">
                            <div class="pull-right" style="height: 30px;line-height: 30px;border-left:1px solid #aaa">
                                <input type="radio" value="0" {{$edit_able == 1 ? ' name="type" id="official" ' : 'disabled'}} {{$task['type'] ==0 ? 'checked' : ''}}/>
                                <label for="official">{{ trans('app.official') }}</label>
                                <input type="radio" value="1" {{$edit_able == 1 ? ' name="type" id="unofficial" ' : 'disabled'}} {{$task['type'] ==1 ? 'checked' : ''}}/>
                                <label for="unofficial">{{ trans('app.unofficial') }}</label>
                            </div>
                            {{--<div class="pull-right" style="height: 30px;line-height: 30px;border-left:1px solid #aaa">--}}
                                {{--<input type="radio" {{$edit_able == 1 ? ' name="kind" id="kind_activity" ' : 'disabled'}}  value="1" {{$task['kind'] ==1 ? 'checked' : ''}}/>--}}
                                {{--<label for="kind_activity">{{ trans('tasks.activity') }}</label>--}}
                                {{--<input type="radio" {{$edit_able == 1 ? ' name="kind" id="kind_event" ' : 'disabled'}} value="0" {{$task['kind'] ==0 ? 'checked' : ''}}/>--}}
                                {{--<label for="kind_event">{{ trans('tasks.event')}}</label>--}}
                            {{--</div>--}}
                            <div class="pull-right" style="height: 30px;line-height: 30px;border-left:1px solid #aaa">
                                <input type="radio" {{$edit_able == 1 ? ' name="importance" id="importance_yes" ' : 'disabled'}} value="1" {{$task['importance'] ==1 ? 'checked' : ''}}/>
                                <label for="importance_yes">{{ trans('tasks.important') }}</label>
                                <input type="radio" {{$edit_able == 1 ? ' name="importance" id="importance_no" ' : 'disabled'}} value="0" {{$task['importance'] ==0 ? 'checked' : ''}}/>
                                <label for="importance_no">{{ trans('tasks.unimportant')}}</label>
                            </div>
                            <div class="pull-right" style="height: 30px;line-height: 30px;">
                                <input type="radio" {{$edit_able == 1 ? ' name="immediate" id="immediate_yes" ' : 'disabled'}} value="1" {{$task['immediate'] ==1 ? 'checked' : ''}}/>
                                <label for="immediate_yes" >{{ trans('tasks.immediate') }}</label>
                                <input type="radio" {{$edit_able == 1 ? ' name="immediate" id="immediate_no" ' : 'disabled'}} value="0"  {{$task['immediate'] ==0 ? 'checked' : ''}}/>
                                <label for="immediate_no">{{ trans('tasks.Non-urgent') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-2"><label class="line-height-35">{{ trans('tasks.top') }}</label></div>
                    <div class="col-lg-10">
                        <select class="select2_auto_complete_page"
                                data-placeholder="{{trans('tasks.can_select_some_options')}}"
                                multiple="multiple" {{$edit_able == 1 ? ' name="pages[]" id="new_task_pages" ' : 'disabled'}} >
                            @if(!empty($res['task_pages']))
                                @foreach($res['task_pages'] as $page)
                                    <option selected="selected" value="{{ $page->id }}">{{ $page->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('tasks.description') }}</label></div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control row" {{$edit_able == 1 ? ' name="task_desc" id="desc" ' : 'disabled'}} value="{{$task['task_desc']}}"/>
                    </div>
                </div>
                <div class="row col-lg-12" style="border-top: #ccc solid 1px;margin: 10px 0px;padding-top: 10px">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('tasks.responsible') }}</label></div>
                    <div class="col-lg-10">
                        <div class="col-sm-6 row" style="padding: 0px;">
                            <select class="select2_auto_complete_user col-xs-12"
                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple {{$edit_able == 1 ? ' name="users[]" id="new_task_users_responsible" ' : 'disabled'}} >
                                @if(!empty($res['task_users']))
                                    @foreach($res['task_users'] as $task_users)
                                        <option selected="selected" value="{{ $task_users->id }}">{{ $task_users->Name.' '.$task_users->Family }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class=" Chosen-LeftIcon"></span>
                        </div>
                        <div class="col-sm-6 line-height-35" style="padding-right: 5px;">

                            <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_users_responsible']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                            <input type="radio" {{$edit_able == 1 ? ' name="assign_type" id="use_type1" ' : 'disabled'}} value="1" checked/>
                            <label class="" for="use_type1">{{ trans('tasks.collective') }}</label>
                            <input type="radio" {{$edit_able == 1 ? ' name="assign_type" id="use_type2" ' : 'disabled'}} class="" value="2"/>
                            <label class="" for="use_type2">{{ trans('tasks.individual') }}</label>

                            <input type="checkbox" {{$edit_able == 1 ? ' name="send_mail" id="send_mail" ' : 'disabled'}} value="1"/>
                            <label class="" for="send_mail">{{ trans('tasks.send-mail') }}</label>
                            <input type="checkbox" {{$edit_able == 1 ? ' name="send_sms" id="send_sms" ' : 'disabled'}} value="1"/>
                            <label class="" for="send_sms">{{ trans('tasks.send-sms') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('app.transcript') }}</label></div>
                    <div class="col-lg-10">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 row" style="padding: 0px;">
                            <select class="select2_auto_complete_transcripts"
                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple {{$edit_able == 1 ? ' name="transcripts[]" id="new_task_transcripts" ' : 'disabled'}} >
                                @if(!empty($res['task_transcripts']))
                                    @foreach($res['task_transcripts'] as $task_transcripts)
                                        <option selected="selected" value="{{ $task_transcripts->id }}">{{ $task_transcripts->Name.' '.$task_transcripts->Family }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 smaller-90 line-height-35" style="padding-right: 5px;">
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_transcripts']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                            <input type="checkbox" {{$edit_able == 1 ? ' name="report_on_cr" id="report-type1" ' : 'disabled'}} value="1"/>
                            <label for="report-type1" class="transcript_option">{{ trans('tasks.report_on_task_creation') }}</label>
                            <input type="checkbox" {{$edit_able == 1 ? ' name="report_on_co" id="report-type2" ' : 'disabled'}} value="1"/>
                            <label for="report-type2" class="transcript_option">{{ trans('tasks.report_on_task_completion') }}</label>
                            <input type="checkbox" {{$edit_able == 1 ? ' name="report_to_manager" id="report-type3" ' : 'disabled'}} value="1"/>
                            <label for="report-type3" class="transcript_option">{{ trans('tasks.report_on_responsible') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12" style="border-top: #ccc solid 1px;margin: 10px 0px;padding-top: 10px">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('tasks.keyword') }}</label></div>
                    <div class="col-lg-10">
                        <select class="select2_auto_complete_keywords"
                                data-placeholder="{{trans('tasks.can_select_some_options')}}"
                                multiple="multiple"
                                {{$edit_able == 1 ? ' name="keywords[]" id="new_task_keywords" ' : 'disabled'}} >
                            @if(!empty($res['task_keywords']))
                                @foreach($res['task_keywords'] as $task_keywords)
                                    <option selected="selected" value="{{ $task_keywords->id }}">{{ $task_keywords->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class=" Chosen-LeftIcon"></span>
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding noLeftPadding">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noRightPadding noLeftPadding line-height-35">
                            <label class="noRightPadding noLeftPadding">{{ trans('tasks.do_respite') }}</label>
                        </div>
                    </div>
                    <div class="col-lg-10 noRightPadding noLeftPadding line-height-35">
                        <div class="col-xs-3 noRightPadding noLeftPadding">
                            <input type="radio" {{$edit_able == 1 ? ' name="respite_timing_type" id="determination_doing_duration" ' : 'disabled'}} onclick="change_normal_task_timing_type(0)" value="0" {{ $task['respite_timing_type']==0 ? '' : 'checked' }}/>
                            <label for="determination_doing_duration">{{ trans('tasks.determination_doing_duration') }}</label>
                            <input type="radio" {{$edit_able == 1 ? ' name="respite_timing_type" id="determination_end_date" ' : 'disabled'}} onclick="change_normal_task_timing_type(1)" value="1" {{ $task['respite_timing_type']==1 ? '' : 'checked' }}/>
                            <label for="determination_end_date">{{ trans('tasks.determination_end_date') }}</label>
                        </div>
                        <div id="normal_task_timing" class="col-xs-5 form-inline noRightPadding noLeftPadding">
                            <input class="form-control col-xs-1 pull-right" style="width: 55px" {{$edit_able == 1 ? ' name="duration_day" id="duration_day" ' : 'disabled'}} value="{{isset($task['duration_day']) ? $task['duration_day'] : ''}}" />
                            <label class="pull-right">روز</label>
                            <input class="form-control col-xs-1 pull-right" style="width: 55px" {{$edit_able == 1 ? ' name="duration_hour" id="duration_hour" ' : 'disabled'}} value="{{isset($task['duration_hour']) ? $task['duration_hour'] : ''}}"/>
                            <label class="pull-right">ساعت</label>
                            <input class="form-control col-xs-1 pull-right" style="width: 55px" {{$edit_able == 1 ? ' name="duration_min" id="duration_min" ' : 'disabled'}} value="{{isset($task['duration_min']) ? $task['duration_min'] : ''}}"/>
                            <label class="pull-right">دقیقه</label>
                        </div>
                        <div class="col-xs-4 noRightPadding noLeftPadding">
                            <input type="radio" {{$edit_able == 1 ? ' name="respite_timing_type" id="on-time" ' : 'disabled'}} value="2" {{ $task['respite_timing_type']==2 ? '' : 'checked' }}/>
                            <label for="on-time">{{ trans('tasks.on-time') }}</label>
                            <input type="radio" {{$edit_able == 1 ? ' name="respite_timing_type" id="no-detemine" ' : 'disabled'}} onclick="" value="3" {{ $task['respite_timing_type']==3 ? '' : 'checked' }}/>
                            <label for="no-detemine">{{ trans('tasks.no-detemine') }}</label>
                        </div>
                    </div>
                </div>

                <div class="row col-lg-12" style="border-top: #ccc solid 1px;margin: 10px 0px;padding-top: 10px">
                    <label class="line-height-35 pull-right">{{ trans('app.attachments') }}</label>
                    <div class="row-fluid pull-right">
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
                </div>
                <div class="row-fluid">
                    {!! $HFM_CN_Task['ShowResultArea']['CreateNewTask'] !!}
                </div>

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="draft" id="draft" value="0"/>
                <input type="hidden" name="first_m" id="first_m" value="0"/>
                <input type="hidden" name="first_u" id="first_u" value="0"/>
                <input type="hidden" name="assigner_id" value="125"/>
                <input type="hidden" name="task_form_action" id="task_form_action" value=""/>
                <input type="hidden" id="save_type" name="save_type" value="0"/>
                {!! $HFM_CN_Task['UploadForm'] !!}

            </div>
            <div class="tab-pane" style="padding: 8px;margin-top:20px" id="tab_t2">
                <div class="input-group col-xs-12" style="margin: 0 0 15px 5px;">
                    <div class="col-xs-1 noRightPadding noLeftPadding">
                        <label class="pull-right line-height-35  noRightPadding noLeftPadding" >{{trans('tasks.every')}}</label>
                        <input type="text" {{$edit_able == 1 ? ' name="task_schedul_num" id="task_schedul_num" ' : 'disabled'}} class="form-control" style="width: 40px;" value="" >
                    </div>
                    <div class="col-xs-2 noRightPadding noLeftPadding">
                        <select {{$edit_able == 1 ? ' name="task_schedul" id="task_schedul" ' : 'disabled'}} class="form-control line-height-35">
                            <option value="minute" {{$task['task_schedul'] == 'minute' ? 'selected="selected"' : ''}}>{{trans('tasks.minute')}}</option>
                            <option value="hour" {{$task['task_schedul'] == 'hour' ? 'selected="selected"' : ''}}>{{trans('tasks.hour')}}</option>
                            <option value="daily" {{$task['task_schedul'] == 'daily' ? 'selected="selected"' : ''}}>{{trans('tasks.day')}}</option>
                            <option value="weekly" {{$task['task_schedul'] == 'weekly' ? 'selected="selected"' : ''}}>{{trans('tasks.week')}}</option>
                            <option value="monthly" {{$task['task_schedul'] == 'monthly' ? 'selected="selected"' : ''}}>{{trans('tasks.month')}}</option>
                            <option value="seasonly" {{$task['task_schedul'] == 'seasonly' ? 'selected="selected"' : ''}}>{{trans('tasks.season')}}</option>
                            <option value="yearly" {{$task['task_schedul'] == 'yearly' ? 'selected="selected"' : ''}}>{{trans('tasks.year')}}</option>
                        </select>
                    </div>
                    <div class="col-xs-8 div-schedul">
                        <div class="minute col-xs-12 {{($task['task_schedul'] == 'minute') ? '' : 'hidden'}}">
                        </div>
                        <div class="hour col-xs-12 {{($task['task_schedul'] == 'hour') ? '' : 'hidden'}}">
                        </div>
                        <div class="daily col-xs-12 {{($task['task_schedul'] == 'daily') ? '' : 'hidden'}}">
                            {{--                            {!! Form::text('daily_value', null, ['class' => 'form-control TimePicker line-height-35']) !!}--}}
                        </div>
                        <div class="weekly row {{($task['task_schedul'] == 'weekly') ? '' : 'hidden'}}">
                            @for ($i = 0; $i < 7; $i++)
                                <div class="input-group pull-right weekly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                    <input {{$edit_able == 1 ? ' name="" id="" ' : 'disabled'}} id="weekly_value_{{$i}}" class="" style="width: 22px;" name="weekly_value[]" type="checkbox" value="{{$i}}">
                                    <label style="line-height: 10px;" for="{{ "weekly_value_$i" }}">{{trans('tasks.array_weekly_weekdays.'.$i)}}</label>
                                </div>
                            @endfor
                        </div>
                        <div class="monthly {{($task['task_schedul'] == 'monthly') ? '' : 'hidden'}}">
                            <div class="input-group pull-right monthly col-xs-12" style="padding: 5px;height: 52px;">
                                @for ($i = 0; $i < 5; $i++)
                                    <div class="input-group pull-right monthly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                        <input {{$edit_able == 1 ? ' name="monthly_value[]" id="monthly_value_'.$i.'" ' : 'disabled'}} class="" style="width: 22px;" type="checkbox" value="{{$i}}">
                                        <label style="line-height: 10px;" for="{{ "monthly_value_$i" }}">{{trans('tasks.array_monthly_months.'.$i)}}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="seasonly {{($task['task_schedul'] == 'seasonly') ? '' : 'hidden'}}">
                            <div class="input-group pull-right seasonly col-xs-12" style="padding: 5px;height: 52px;">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="input-group pull-right seasonly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                        <input  {{$edit_able == 1 ? ' name="seasonly_value[]" id="seasonly_value_'.$i.'" ' : 'disabled'}} class="" style="width: 22px;" type="checkbox" value="{{$i}}">
                                        <label style="line-height: 10px;" for="{{ "seasonly_value_$i" }}">{{trans('tasks.array_seasonly_seasons.'.$i)}}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="yearly {{($task['task_schedul'] == 'yearly') ? '' : 'hidden'}}">
                            <div class="input-group pull-right yearly col-xs-12" style="padding: 5px;height: 52px;">
                                @for ($i = 0; $i < 12; $i++)
                                    <div class="input-group pull-right yearly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                        <input  {{$edit_able == 1 ? ' name="yearly_num[]" id="yearly_num_'.$i.'" ' : 'disabled'}} class="" style="width: 10px;" type="checkbox" value="{{$i}}">
                                        <label style="line-height: 10px;" for="{{ "yearly_num_$i" }}">{{trans('tasks.array_yearly_years.'.$i)}}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-group col-xs-12 noRightPadding noLeftPadding">
                    <div class="col-xs-1 pull-right noRightPadding noLeftPadding">
                        <label for="r2" class="line-height-35">{{ trans('tasks.begin') }}</label>
                    </div>
                    <div class="col-xs-2 noRightPadding noLeftPadding">
                        <input type="text" value="" class="form-control DatePicker" {{$edit_able == 1 ? ' name="schedul_begin_date" id="schedul_begin_date" ' : 'disabled'}} aria-describedby="schedul_begin_date" >
                    </div>
                </div>
                <div class="col-xs-12 noRightPadding noLeftPadding">

                    <div class="col-xs-10 noRightPadding noLeftPadding">
                        <div class="daily col-xs-1 noRightPadding noLeftPadding">
                            <label for="r2" class=" line-height-35">{{ trans('tasks.end') }}</label>
                        </div>
                        <div class="daily col-xs-2" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                    <input type="radio" {{$edit_able == 1 ? ' name="schedul_end_date" id="schedul_end_date_none" ' : 'disabled'}} value="schedul_end_date_none" {{ $task['schedul_end_date']=='schedul_end_date_none' ? 'checked="checked"' : '' }} />
                                </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <label for="schedul_end_date_none">{{ trans('tasks.none') }}</label>
                                </span>
                        </div>
                        <div class="daily col-xs-3" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="radio" {{$edit_able == 1 ? ' name="schedul_end_date" id="schedul_end_date_events" ' : 'disabled'}} value="schedul_end_date_events" {{ $task['schedul_end_date']=='schedul_end_date_events' ? 'checked="checked"' : '' }} />
                                </span>
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label for="schedul_end_date_events">{{ trans('tasks.after') }}</label>
                                </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text"  {{$edit_able == 1 ? ' name="schedul_end_num_events" id="schedul_end_date_events_" ' : 'disabled'}} class="form-control" style="width: 40px;" value="" >
                                </span>
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label for="schedul_end_date_events_">{{ trans('tasks.event') }}</label>
                                </span>
                        </div>
                        <div class="daily col-xs-2" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;height: 34px">
                                    <input type="radio"  {{$edit_able == 1 ? ' name="schedul_end_date" id="schedul_end_date_date" ' : 'disabled'}} value="schedul_end_date_date" {{ $task['schedul_end_date']=='schedul_end_date_date' ? 'checked="checked"' : '' }} checked/>
                                </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;height: 34px">
                                    <label for="schedul_end_date_date">{{ trans('tasks.in-date') }}</label>
                                </span>
                        </div>
                        <div class="daily col-xs-3" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text" class="form-control DatePicker_end_date_date" {{$edit_able == 1 ? ' name="schedul_end_date_date" id="schedul_end_date_" ' : 'disabled'}} aria-describedby="schedul_end_date_date" >
                                </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 noRightPadding noLeftPadding" style="border-top:1px solid #ccc;margin-top: 10px;padding-top: 10px">
                    <div class="col-xs-1 noRightPadding noLeftPadding margin-top-10">
                        <label class="line-height-35">{{ trans('tasks.form') }}</label>
                    </div>
                    <div class="col-xs-11 margin-top-10">
                        <select class="select2_auto_complete_user col-xs-12"
                                data-placeholder="{{trans('tasks.select_some_options')}}" multiple
                                {{$edit_able == 1 ? ' name="users[]" id="new_task_users" ' : 'disabled'}}>
                            <option value=""></option>
                        </select>
                        <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                    </div>
                </div>
                <div class="col-xs-12 noRightPadding noLeftPadding">
                    <div class="col-xs-1 noRightPadding noLeftPadding">
                        <label class="line-height-35">{{ trans('tasks.here-help') }}</label>
                    </div>
                    <div class="col-xs-11">
                        <select class="select2_auto_complete_user col-xs-12"
                                data-placeholder="{{trans('tasks.select_some_options')}}" multiple
                                {{$edit_able == 1 ? ' name="users[]" id="new_task_users_" ' : 'disabled'}}>
                            <option value=""></option>
                        </select>
                        <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                    </div>
                </div>
                <div class="col-xs-12 noRightPadding noLeftPadding" style="border-top:1px solid #ccc;margin-top: 10px;padding-top: 10px">
                    <div class="col-xs-1 noRightPadding noLeftPadding">
                        <input type="checkbox" {{$edit_able == 1 ? ' name="end_on_assigner_accept" id="end_on_assigner_accept" ' : 'disabled'}} style="height: 20px"/>
                    </div>
                    <div class="col-xs-10">
                        <label for="end_on_assigner_accept">{{ trans('tasks.modal_task_details_assignor_accept_or_ended') }}</label>
                    </div>
                </div>
                <div class="col-xs-12 noRightPadding noLeftPadding">
                    <div class="col-xs-1 noRightPadding noLeftPadding">
                        <input type="checkbox" {{$edit_able == 1 ? ' name="transferable" id="transferable" ' : 'disabled'}} style="height: 20px"/>
                    </div>
                    <div class="col-xs-11">
                        <label for="transferable">{{ trans('tasks.modal_task_details_assignor_to_another') }}</label>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_t3" style="padding-top: 8px;margin-top:20px">
                @if($edit_able == 1)
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
                            <input type="text" id="new_task_resources_amount" class="form-control noRightPadding noLeftPadding text-center" placeholder="{{ trans('tasks.amount') }}"/>
                        </div>
                        <div class="col-xs-1">
                            <input type="text" id="new_task_resources_cost" class="form-control noRightPadding noLeftPadding text-center" placeholder="{{ trans('tasks.cost') }}"/>
                        </div>
                        <div class="col-xs-1">
                            <span class="btn btn-primary fa fa-plus" id="add_resource_task"></span>
                        </div>
                    </div>
                @endif
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
                        @if(isset($res['task']['new_task_resources_t']))
                            @foreach($res['task']['new_task_resources_t'] as $k=>$new_task_resources)
                                <tr id="add_resource_task{{$k.'show'}}">
                                    {{--<td>--}}
                                    {{--<label class="pull-right" for="r2">'+(num_add_rel_task++)+'</label>--}}
                                    {{--</td>--}}
                                    <td>
                                        <label class="pull-right" for="r2">{{$new_task_resources}}</label>
                                        <input name="new_task_resources_h[]" type="hidden" value="{{$res['task']['new_task_resources_h'][$k]}}"/>
                                        <input name="new_task_resources_t[]" type="hidden" value="{{$new_task_resources}}"/>
                                    </td>
                                    <td>
                                        <label class="input-group pull-right">
                                            {{$res['task']['new_task_resources_amount'][$k]}}
                                            <input name="new_task_resources_amount[]" type="hidden" value="{{$res['task']['new_task_resources_amount'][$k]}}"/>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="input-group pull-right">
                                            {{$res['task']['new_task_resources_cost'][$k]}}
                                            <input name="new_task_resources_cost[]" type="hidden" value="{{$res['task']['new_task_resources_cost'][$k]}}"/>
                                        </label>
                                    </td>
                                    <td>
                                        <span class="fa fa-remove remove_new_task pointer" onclick="remove_new_task({{$k.'show'}})" for="r2"></span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab_t4" style="padding-top: 8px;margin-top:20px">
                @if($edit_able == 1)
                    <div class="col-xs-12">
                        <div class="col-xs-1">
                            <label class="line-height-35">{{ trans('tasks.task') }}</label>
                        </div>
                        <div class="col-xs-9">
                            <select id="new_task_tasks" name="rel_tasks[]" class="select2_auto_complete_tasks col-xs-12"
                                    {{--<select id="new_task_users" name="class[]" class="select2_auto_complete_tasks col-xs-12"--}}
                                    data-placeholder="{{trans('tasks.select_some_options')}}">
                                <option value=""></option>
                            </select>
                            <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                        </div>
                        {{--<div class="col-xs-1 no-padding-left no-padding-right">--}}
                            {{--<input type="text" id="new_task_weight" class="form-control noRightPadding noLeftPadding text-center" placeholder="{{ trans('tasks.weight') }}" />--}}
                        {{--</div>--}}
                        <div class="col-xs-1">
                            <span class="btn btn-primary" id="add_rel_task">{{ trans('app.add') }}</span>
                        </div>
                    </div>
                @endif
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
                        @if(isset($res['task']['new_task_tasks_t']))
                            @foreach($res['task']['new_task_tasks_t'] as $k=>$new_task_tasks)
                                <tr id="num_add_rel_task{{$k.'show'}}">
                                    {{--<td>--}}
                                    {{--<label class="pull-right" for="r2">'+(num_add_rel_task++)+'</label>--}}
                                    {{--</td>--}}
                                    <td>
                                        <label class="pull-right" for="r2">{{$new_task_tasks}}</label>
                                        <input name="new_task_tasks_[]" type="hidden" value="{{$res['task']['new_task_tasks_'][$k]}}"/>
                                        <input name="new_task_tasks_t[]" type="hidden" value="{{$new_task_tasks}}"/>
                                    </td>
                                    <td>
                                        <label class="input-group pull-right">
                                            {{$res['task']['new_task_weight'][$k]}}
                                            <input {{$edit_able == 1 ? ' name="new_task_weight[]" id="" ' : 'disabled'}} type="hidden" value="{{$res['task']['new_task_weight'][$k]}}"/>
                                        </label>
                                    </td>
                                    <td>
                                        <select class="form-control" {{$edit_able == 1 ? ' name="new_task_relation[]" id="" ' : 'disabled'}}>
                                            {{--<option value="end_start" {{$res['task']['new_task_relation'][$k] == 'end_start' ? 'selected="selected"' :''}}>پایان به شروع</option>--}}
                                            {{--<option value="start_start" {{$res['task']['new_task_relation'][$k] == 'start_start' ? 'selected="selected"' :''}}>شروع به شروع</option>--}}
                                            {{--<option value="start_end" {{$res['task']['new_task_relation'][$k] == 'start_end' ? 'selected="selected"' :''}}>شروع به پایان</option>--}}
                                            {{--<option value="end_end" {{$res['task']['new_task_relation'][$k] == 'end_end' ? 'selected="selected"' :''}}>پایان به پایان</option>--}}
                                            <option value="up" {{$res['task']['new_task_relation'][$k] == 'up' ? 'selected="selected"' :''}}>بالادستی</option>
                                            <option value="down" {{$res['task']['new_task_relation'][$k] == 'down' ? 'selected="selected"' :''}}>پایین دستی</option>
                                            {{--<option value="after" {{$res['task']['new_task_relation'][$k] == 'after' ? 'selected="selected"' :''}}>گردش کار - بعدی</option>--}}
                                            {{--<option value="previous" {{$res['task']['new_task_relation'][$k] == 'previous' ? 'selected="selected"' :''}}>گردش کار - قبلی</option>--}}
                                        </select>
                                    </td>
                                    <td>
                                        <label class="input-group pull-right">
                                            <div class="col-xs-6">
                                                <input {{$edit_able == 1 ? ' name="new_task_delay_num[]" id="" ' : 'disabled'}} value="{{$res['task']['new_task_delay_num'][$k]}}" type="text" class="form-control" placeholder="وقفه"/>
                                            </div>
                                            <div class="col-xs-6">
                                                <select {{$edit_able == 1 ? ' name="new_task_delay_type[]" id="" ' : 'disabled'}} class="form-control" >
                                                    <option value="day" {{$res['task']['new_task_delay_type'][$k] == 'day' ? 'selected="selected"' :''}}>روز</option>
                                                    <option value="week" {{$res['task']['new_task_delay_type'][$k] == 'week' ? 'selected="selected"' :''}}>هفته</option>
                                                    <option value="month" {{$res['task']['new_task_delay_type'][$k] == 'month' ? 'selected="selected"' :''}}>ماه</option>
                                                </select>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <span class="fa fa-remove remove_new_task pointer" onclick="remove_new_task({{$k.'show'}})" for="r2"></span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
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
                            <label for="on_done">{{ trans('tasks.on_done').' '.trans('tasks.precent_progress') }}</label>
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
                        <select id="assigns_new" name="assigns_new[]" class="select2_auto_complete_transcripts"
                                data-placeholder="{{trans('tasks.select_some_options')}}" multiple></select>
                        <span class=" Chosen-LeftIcon"></span>
                    </div>
                    <div class="col-xs-1 pull_right">
                        <span class="input-group-addon edited-addon pull_right" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'assigns_new']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12" style="border-bottom: 1px solid #eee;padding: 10px 0px">
                    <div class="col-xs-1">
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <label class="line-height-35">{{ trans('tasks.keyword') }}</label>
                        </span>
                    </div>
                    <div class="col-xs-11">
                        <select id="new_task_keywords_" class="select2_auto_complete_keywords" name="assigns_keywords[]"
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
                            <label for="not-determine">{{trans('tasks.description')}}</label>
                        </span>
                    </div>
                    <div class="col-xs-11">
                        <input type="text" name="action_explain" id="explain" class="form-control" placeholder="{{trans('tasks.description')}}"/>
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
                    <div class="col-xs-2">
                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label for="quality-not_determined">{{ trans('tasks.score') }}</label>
                        </span>
                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                            <input type="text" name="quality_score" id="quality-score" value="" class="form-control"/>
                        </span>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_t6" style="padding-top: 8px;margin-top:20px">
                <div class="col-xs-12">
                    <div class="col-xs-3">
                        <label class="line-height-3">گفتگو</label>
                    </div>
                    <div class="col-xs-8">
                        <input type="text" id="message" class="form-control" placeholder="پیام"/>
                        <input type="hidden" id="user" class="form-control" value="{{Session::get('Name').' '.Session::get('Family')}}"/>
                    </div>
                    <div class="col-xs-1">
                        <span class="btn btn-primary fa fa-plus" id="add_message_task"></span>
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
                            @if(isset($res['task']['message_username']))
                                @foreach($res['task']['message_username'] as $k=>$message_username)
                                    <tr id="add_resource_task{{$k.'show'}}">
                                        {{--<td>--}}
                                        {{--<label class="pull-right" for="r2">'+(num_add_rel_task++)+'</label>--}}
                                        {{--</td>--}}
                                        <td>
                                            <label class="pull-right" for="r2">{{$res['task']['message_username'][$k]}}</label>
                                            <input name="message_username[]" type="hidden" value="{{$res['task']['message_username'][$k]}}"/>
                                        </td>
                                        <td>
                                            <label class="input-group pull-right">
                                                {{$res['task']['messages'][$k]}}
                                                <input name="messages[]" type="hidden" value="{{$res['task']['messages'][$k]}}"/>
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab_t7" style="padding-top: 8px;margin-top:20px">
                <div class="col-xs-12">
                    <table id="ChildsGrid" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="col-xs-2">کاربر</th>
                            <th class="col-xs-5">اقدام</th>
                            <th class="col-xs-5">زمان</th>
                        </tr>
                        </thead>
                        <tbody id="message_task_list">
                            @if(isset($res['task_history']))
                                @foreach($res['task_history'] as $k=>$task_history)
                                    <tr id="add_resource_task{{$k.'show'}}">
                                        <td>
                                            <label class="pull-right" for="r2">{{$task_history->Name.' '.$task_history->Family}}</label>
                                        </td>
                                        <td>
                                            <label class="pull-right" for="r2">{{ trans('tasks.'.$task_history->operation_type) }}</label>
                                        </td>
                                        <td>
                                            <label class="pull-right" for="r2">{{$task_history->created_at}}</label>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
<script>
    $.ajax({
        url: '{{ URL::route('auto_complete.get_user_calendar')}}',
        type: 'Post', // Send post dat
        dataType:'json',
        success: function (s) {

            var options = '';
            $('select[name="event_cid"]').empty();
            for (var i = 0; i < s.length; i++) {
                if(s[i].is_default ==1)
                {
                    options += '<option  selected=true value="' + s[i].id + '">' + s[i].title + '</option>';
                }
                else{
                    options += '<option value="' + s[i].id + '">' + s[i].title + '</option>';
                }


            }

            $('select[name="event_cid"]').append(options);
            $('select[name="event_cid"]').select2({
                dir: "rtl",
                width: '100%',
            });
        }
    });
    $(document).ready(function()
    {
        $(".fileToUpload").on('change', function() {
            var formElement = $( '.fileToUpload' )[0].files[0];
            var data = new FormData();
            data.append('image',formElement);
            data.append('pid','{{rand(1,100).rand(1,100)}}');
            data.append('form_type','form');
            $.ajax
            ({
                url: '{{ route('FileManager.tinymce_external_filemanager') }}',
                type: 'post',
                dataType: 'json',
                data: data,
                processData: false,
                contentType: false,
                success: function(data)
                {
                    console.log(data);
                    if (data.success)
                    {
                        $('#desc').val($('#desc').val() + "\nimg::" + data.FileID + "::img");
                        $('.content_tab_view').html($('#desc').val().replace('img::','<img src="{{route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']).'/'}}').replace('::img','">'));
                    } else
                    {
                        messageModal('fail', 'خطا', data.result);
                    }
                }
            });
        });
        //tab_text tab_view
        $(".tab_desc").on('click', function() {
            $(".tab_desc").removeClass('active');
            $(".content_tab").addClass('hidden');
            $("#for-desc .header").css('height','30px !important');
            $(this).addClass('active');
            $(".content_"+$(this).attr('rel')).removeClass('hidden');
        });
        $(document).on('click', '#form_tinymce_upload .form-submit', function()
        {

        });
    });
</script>

<script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>

@include('hamahang.Tasks.helper.CreateNewTask.inline_js')
{!! $HFM_CN_Task['JavaScripts'] !!}