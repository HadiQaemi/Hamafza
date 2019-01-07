<div id="tab" class="row table-bordered" style="border-bottom: none">
    <ul class="nav nav-tabs">
        <li>
            <a href="#tab_t1" data-toggle="tab">تعریف</a>
        </li>
        <li class="disabled">
            {{--<a href="#tab_t2" data-toggle="tab">تنظیم</a>--}}
            <a href="" data-toggle="tab">تنظیم</a>
        </li>
        <li class="disabled">
            {{--<a href="#tab_t3" data-toggle="tab">منابع</a>--}}
            <a href="" data-toggle="tab">منابع</a>
        </li>
        <li>
            <a href="#tab_t4" data-toggle="tab">روابط</a>
        </li>
        <li>
            <a href="#tab_t6" data-toggle="tab">تخصیص</a>
        </li>
        <li class="active">
            <a href="#tab_t5" data-toggle="tab">اقدام</a>
        </li>
        <li>
            <a href="#tab_t7" data-toggle="tab">گفتگو</a>
        </li>
        <li>
            <a href="#tab_t8" data-toggle="tab">سابقه</a>
        </li>
        <li style="float: left">
            <h5 id="task_type" style="color: blue"></h5>
        </li>
    </ul>
    @php
    $task = $res['task'];
    $edit_able = ($res['task_all']->uid == Auth::id() ? true : false);
    @endphp

    {{--<form action="{{ route('hamahang.tasks.save_task') }}" class="" name="ShowTaskForm" id="ShowTaskForm" method="post"--}}
    <form action="{{ route('hamahang.tasks.update_task') }}" class="" name="ShowTaskForm" id="ShowTaskForm" method="post" enctype="multipart/form-data">
        <div class="tab-content new-task-form">
            <div class="tab-pane" style="padding-top: 8px;margin-top:20px" id="tab_t1">
                <div class="row col-lg-12">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('tasks.title') }}</label></div>
                    <div class="col-lg-8">
                        <input type="text" class="form-control border-radius" {{$edit_able == 1 ? ' name="title" id="title" ' : 'disabled'}} value="{{$task['title']}}"/>
                        <input type="hidden" name="tid" id="tid" value="{{$res['task_id']}}"/>
                        <input type="hidden" name="aid" id="aid" value="{{$res['aid']}}"/>
                    </div>
                    <div class="col-lg-3">
                        <div class="pull-right" style="height: 30px;line-height: 30px;">
                            <input type="radio" value="0" {{$edit_able == 1 ? ' name="type" id="official" ' : 'disabled'}} {{$task['type'] ==0 ? 'checked' : ''}}/>
                            <label for="official">{{ trans('app.official') }}</label>
                            <input type="radio" value="1" {{$edit_able == 1 ? ' name="type" id="unofficial" ' : 'disabled'}} {{$task['type'] ==1 ? 'checked' : ''}}/>
                            <label for="unofficial">{{ trans('app.unofficial') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('tasks.description') }}</label></div>
                    <div class="col-lg-11">
                        <div id="for-desc">
                            <div class="row col-lg-12 header">
                                <span class="pointer tab_desc active tab_text" rel="tab_text">{{trans('app.text')}}</span>
                                <span class="pointer tab_desc tab_view" rel="tab_view">{{trans('app.view')}}</span>
                            </div>
                            <div class="row main-desc">
                                <textarea class="form-control row content_tab_text content_tab" {{$edit_able == 1 ? ' name=task_desc id=desc ' : 'disabled'}} name="task_desc" placeholder="{{ trans('tasks.description') }}" cols="30" rows="4">{{$task['task_desc']}}</textarea>
                                <div class="content_tab_view content_tab hidden">
                                    {!! preg_replace('/img::/','<div><img src="'.route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']).'/',preg_replace('/::img/','"></div>',$task['task_desc'])) !!}
                                </div>
                            </div>
                            @if($edit_able == 1)
                                <div class="filemanager-buttons-client pull-right bottom-desc">
                                    <label for="fileToUpload" class="pointer">
                                        <input type="file" class="fileToUpload form-control" style="display: none;" id="fileToUpload"/>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                        </svg>
                                        <div class="display-inline">{{trans('app.add_file')}}</div>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-1"><label class="line-height-35">{{ trans('tasks.top') }}</label></div>
                    <div class="col-lg-11">
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
                <div class="row col-lg-12" style="border-top: #ccc solid 1px;margin: 10px 0px;padding-top: 10px">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('tasks.responsible') }}</label></div>
                    <div class="col-lg-11">
                        <div class="col-sm-4 row" style="padding: 0px;">
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
                        <div class="col-sm-8" style="padding-right: 5px;">

                            <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_users_responsible']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                            <input type="radio" {{$edit_able == 1 ? ' name="assign_type" id="use_type1" ' : 'disabled'}} value="1" {{$task['assign_type'] ==1 ? 'checked' : ''}}/>
                            <label class="" for="use_type1">{{ trans('tasks.collective') }}</label>
                            <input type="radio" {{$edit_able == 1 ? ' name="assign_type" id="use_type2" ' : 'disabled'}} value="2" {{$task['assign_type'] ==2 ? 'checked' : ''}}/>
                            <label class="" for="use_type2">{{ trans('tasks.individual') }}</label>

                            <input type="radio" name="assign_type" id="use_type3" disabled=""/>
                            <label for="use_type2" style="margin-left: 0px;margin-right: 5px">{{ trans('tasks.one_person') }}</label>

                            <input type="checkbox" {{$edit_able == 1 ? ' name="send_mail" id="send_mail" ' : 'disabled'}} value="1" {{isset($task['send_mail']) ? 'checked' : ''}}/>
                            <label class="" for="send_mail">{{ trans('tasks.send-mail') }}</label>
                            <input type="checkbox" {{$edit_able == 1 ? ' name="send_sms" id="send_sms" ' : 'disabled'}} value="1" {{isset($task['send_sms']) ? 'checked' : ''}}/>
                            <label class="" for="send_sms">{{ trans('tasks.send-sms') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('app.transcript') }}</label></div>
                    <div class="col-lg-11">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 row" style="padding: 0px;">
                            <select class="select2_auto_complete_transcripts"
                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple {{$edit_able == 1 ? ' name="transcripts[]" id="new_task_transcripts" ' : 'disabled'}} >
                                @if(!empty($res['task_transcripts']))
                                    @foreach($res['task_transcripts'] as $task_transcripts)
                                        <option selected="selected" value="{{ $task_transcripts->id }}">{{ $task_transcripts->Name.' '.$task_transcripts->Family }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 smaller-90 line-height-35" style="padding-right: 5px;">
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_transcripts']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                            <input type="checkbox" {{$edit_able == 1 ? ' name="report_on_cr" id="report-type1" ' : 'disabled'}} value="1" {{isset($task['report_on_cr']) ? 'checked' : ''}}/>
                            <label for="report-type1" class="">{{ trans('tasks.report_on_task_creation') }}</label>
                            <input type="checkbox" {{$edit_able == 1 ? ' name="report_on_co" id="report-type2" ' : 'disabled'}} value="1" {{isset($task['report_on_co']) ? 'checked' : ''}}/>
                            <label for="report-type2" class="">{{ trans('tasks.report_on_task_completion') }}</label>
                            <input type="checkbox" {{$edit_able == 1 ? ' name="report_to_manager" id="report-type3" ' : 'disabled'}} value="1" {{isset($task['report_to_manager']) ? 'checked' : ''}}/>
                            <label for="report-type3" class="">{{ trans('tasks.report_on_responsible') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12" style="border-top: #ccc solid 1px;margin: 10px 0px;padding-top: 10px">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding"><label class="line-height-35">{{ trans('tasks.keyword') }}</label></div>
                    <div class="col-lg-11">
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
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noRightPadding noLeftPadding line-height-35">
                            <label class="noRightPadding noLeftPadding">{{ trans('tasks.do_respite') }}</label>
                        </div>
                    </div>
                    <div class="col-lg-11 line-height-35">

                        <div class="col-xs-12 noRightPadding noLeftPadding">
                            <span class="pull-right;">
                                {{--<input type="radio" {{$edit_able == 1 ? ' name=respite_timing_type id=on-time ' : 'disabled'}} value="2" {{ $task['respite_timing_type']==2 ? 'checked' : '' }}/>--}}
                                {{--<label for="on-time">{{ trans('tasks.on-time') }}</label>--}}
                                <input type="radio" {{$edit_able == 1 ? ' name=respite_timing_type id=no-detemine ' : 'disabled'}} onclick="" value="3" {{ $task['respite_timing_type']==3 ? 'checked' : '' }}/>
                                <label for="no-detemine">{{ trans('tasks.no-detemine') }}</label>
                            </span>
                            <span class="pull-right;">
                                <input type="radio" {{$edit_able == 1 ? ' name=respite_timing_type id=determination_doing_duration ' : 'disabled'}} onclick="change_normal_task_timing_type(0)" value="0" {{ $task['respite_timing_type']==0 ? 'checked' : '' }}/>
                                <label for="determination_doing_duration">{{ trans('tasks.determination_doing_duration') }}</label>
                                <input type="radio" {{$edit_able == 1 ? ' name=respite_timing_type id=determination_end_date ' : 'disabled'}} onclick="change_normal_task_timing_type(1)" value="1" {{ $task['respite_timing_type']==1 ? 'checked' : '' }}/>
                                <label for="determination_end_date">{{ trans('tasks.determination_end_date') }}</label>
                            </span>

                            <span id="normal_task_timing" class="pull-right;line-height-35" style="display: inline-flex">
                                <input class="form-control border-radius col-xs-1 pull-right" style="width: 55px" {{$edit_able == 1 ? ' name="duration_day" id="duration_day" ' : 'disabled'}} value="{{isset($task['duration_day']) ? $task['duration_day'] : ''}}" />
                                <label class="pull-right">روز</label>
                                <input class="form-control border-radius col-xs-1 pull-right" style="width: 55px" {{$edit_able == 1 ? ' name="duration_hour" id="duration_hour" ' : 'disabled'}} value="{{isset($task['duration_hour']) ? $task['duration_hour'] : ''}}"/>
                                <label class="pull-right">ساعت</label>
                                <input class="form-control border-radius col-xs-1 pull-right" style="width: 55px" {{$edit_able == 1 ? ' name="duration_min" id="duration_min" ' : 'disabled'}} value="{{isset($task['duration_min']) ? $task['duration_min'] : ''}}"/>
                                <label class="pull-right">دقیقه</label>
                            </span>
                        </div>

                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noRightPadding noLeftPadding line-height-35">
                            <label class="noRightPadding noLeftPadding">{{trans('tasks.priority')}}</label>
                        </div>
                    </div>
                    <div class="col-lg-11 line-height-35">
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
                    <div class="col-xs-1" style="padding-left: 0px;width: 100px;">
                        <label class="pull-right line-height-35" >{{trans('tasks.every')}}</label>
                        <input type="text" {{$edit_able == 1 ? ' name="task_schedul_num" id="task_schedul_num" ' : 'disabled'}} class="form-control border-radius" style="width: 30px;" value="{{$task['task_schedul_num']}}" >
                    </div>
                    <div class="col-xs-2">
                        <select {{$edit_able == 1 ? ' name=task_schedul id=task_schedul ' : 'disabled'}} class="form-control border-radius line-height-35">
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
                            {{--                            {!! Form::text('daily_value', null, ['class' => 'form-control border-radius TimePicker line-height-35']) !!}--}}
                        </div>
                        <div class="weekly row {{($task['task_schedul'] == 'weekly') ? '' : 'hidden'}}">
                            @for ($i = 0; $i < 7; $i++)
                                <div class="input-group pull-right weekly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                    <input {{$edit_able == 1 ? ' name=""  ' : 'disabled'}} id="weekly_value_{{$i}}" class="" style="width: 22px;" name="weekly_value[]" type="checkbox" value="{{$i}}" {{isset($task['weekly_value'][$i]) ? 'checked' : ''}}>
                                    <label style="line-height: 10px;" for="{{ "weekly_value_$i" }}">{{trans('tasks.array_weekly_weekdays.'.$i)}}</label>
                                </div>
                            @endfor
                        </div>
                        <div class="monthly {{($task['task_schedul'] == 'monthly') ? '' : 'hidden'}}">
                            <div class="input-group pull-right monthly col-xs-12" style="padding: 5px;height: 52px;">
                                @for ($i = 0; $i < 5; $i++)
                                    <div class="input-group pull-right monthly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                        <input {{$edit_able == 1 ? ' name="monthly_value[]" id="monthly_value_'.$i.'" ' : 'disabled'}} class="" style="width: 22px;" type="checkbox" value="{{$i}}" {{isset($task['monthly_value'][$i]) ? 'checked' : ''}}>
                                        <label style="line-height: 10px;" for="{{ "monthly_value_$i" }}">{{trans('tasks.array_monthly_months.'.$i)}}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="seasonly {{($task['task_schedul'] == 'seasonly') ? '' : 'hidden'}}">
                            <div class="input-group pull-right seasonly col-xs-12" style="padding: 5px;height: 52px;">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="input-group pull-right seasonly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                        <input  {{$edit_able == 1 ? ' name="seasonly_value[]" id="seasonly_value_'.$i.'" ' : 'disabled'}} class="" style="width: 22px;" type="checkbox" value="{{$i}}" {{isset($task['seasonly_value'][$i]) ? 'checked' : ''}}>
                                        <label style="line-height: 10px;" for="{{ "seasonly_value_$i" }}">{{trans('tasks.array_seasonly_seasons.'.$i)}}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="yearly {{($task['task_schedul'] == 'yearly') ? '' : 'hidden'}}">
                            <div class="input-group pull-right yearly col-xs-12" style="padding: 5px;height: 52px;">
                                @for ($i = 0; $i < 12; $i++)
                                    <div class="input-group pull-right yearly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                        <input  {{$edit_able == 1 ? ' name="yearly_num[]" id="yearly_num_'.$i.'" ' : 'disabled'}} class="" style="width: 10px;" type="checkbox" value="{{$i}}" {{isset($task['yearly_num'][$i]) ? 'checked' : ''}}>
                                        <label style="line-height: 10px;" for="{{ "yearly_num_$i" }}">{{trans('tasks.array_yearly_years.'.$i)}}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-group col-xs-12">
                    <div class="col-xs-1 pull-right">
                        <label for="r2" class="line-height-35">{{ trans('tasks.begin') }}</label>
                    </div>
                    <div class="col-xs-2 noRightPadding noLeftPadding">
                        {{--<input type="text" value="{{$task['schedul_begin_date']}}" class="form-control border-radius DatePicker" {{$edit_able == 1 ? ' name=schedul_begin_date id=schedul_begin_date ' : 'disabled'}} aria-describedby="schedul_begin_date" >--}}
                        <input type="text" value="{{$task['schedul_begin_date']}}" class="form-control border-radius DatePicker" {{$edit_able == 1 ? ' name=schedul_begin_date id=schedul_begin_date ' : 'disabled'}} aria-describedby="schedul_begin_date" >
                    </div>
                </div>
                <div class="input-group col-xs-12">
                    <div class="col-xs-1 pull-right">
                        <label for="r2" class="line-height-35">{{ trans('tasks.end') }}</label>
                    </div>
                    <div class="col-xs-10 noRightPadding noLeftPadding">
                        <div class="daily col-xs-2" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;height: 34px !important;">
                                    <input type="radio" {{$edit_able == 1 ? ' name=schedul_end_date id=schedul_end_date_none ' : 'disabled'}} value="schedul_end_date_none" {{ $task['schedul_end_date']=='schedul_end_date_none' ? 'checked="checked"' : '' }} />
                                </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <label for="schedul_end_date_none">{{ trans('tasks.none') }}</label>
                                </span>
                        </div>
                        <div class="daily col-xs-3" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="radio" {{$edit_able == 1 ? ' name=schedul_end_date id=schedul_end_date_events ' : 'disabled'}} value="schedul_end_date_events" {{ $task['schedul_end_date']=='schedul_end_date_events' ? 'checked="checked"' : '' }} />
                                </span>
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label for="schedul_end_date_events">{{ trans('tasks.after') }}</label>
                                </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text"  {{$edit_able == 1 ? ' name=schedul_end_num_events id=schedul_end_date_events_ ' : 'disabled'}} class="form-control border-radius" style="width: 40px;" value="{{isset($task['schedul_end_num_events']) ? $task['schedul_end_num_events'] : ''}}" >
                                </span>
                            <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                    <label for="schedul_end_date_events_">{{ trans('tasks.event') }}</label>
                                </span>
                        </div>
                        <div class="daily col-xs-2" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;height: 34px">
                                    <input type="radio"  {{$edit_able == 1 ? ' name=schedul_end_date id=schedul_end_date_date ' : 'disabled'}} value="schedul_end_date_date" {{ $task['schedul_end_date']=='schedul_end_date_date' ? 'checked="checked"' : '' }} />
                                </span>
                            <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;height: 34px">
                                    <label for="schedul_end_date_date">{{ trans('tasks.in-date') }}</label>
                                </span>
                        </div>
                        <div class="daily col-xs-3" style="margin: 0 0 5px 5px;">
                                <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                    <input type="text" class="form-control border-radius DatePicker" {{$edit_able == 1 ? ' name=schedul_end_date id=schedul_end_date_ ' : 'disabled'}} aria-describedby="schedul_end_date_date"  value="{{$task['schedul_end_date']}}"/>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="input-group col-xs-12" style="border-top:1px solid #ccc;margin-top: 10px;padding-top: 10px">
                    <div class="col-xs-1 pull-right">
                        <label for="r2" class="line-height-35">{{ trans('tasks.form') }}</label>
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
                <div class="input-group col-xs-12" style="border-top:1px solid #ccc;margin-top: 10px;padding-top: 10px">
                    <div class="col-xs-1 pull-right">
                        <label for="r2" class="line-height-35">{{ trans('tasks.here-help') }}</label>
                    </div>
                    <div class="col-xs-11 margin-top-10">
                        <select class="select2_auto_complete_user col-xs-12"
                                data-placeholder="{{trans('tasks.select_some_options')}}" multiple
                                {{$edit_able == 1 ? ' name="users[]" id="new_task_users_" ' : 'disabled'}}>
                            <option value=""></option>
                        </select>
                        <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                    </div>
                </div>
                <div class="input-group col-xs-12" style="border-top:1px solid #ccc;margin-top: 10px;padding-top: 10px">
                    <div class="col-xs-1 pull-right">
                        <input type="checkbox" {{$edit_able == 1 ? ' name=end_on_assigner_accept id=end_on_assigner_accept ' : 'disabled'}} {{ isset($task['end_on_assigner_accept']) ? 'checked="checked"' : '' }} style="height: 20px"/>
                    </div>
                    <div class="col-xs-11 margin-top-10">
                        <label for="end_on_assigner_accept">{{ trans('tasks.modal_task_details_assignor_accept_or_ended') }}</label>
                    </div>
                </div>
                <div class="input-group col-xs-12">
                    <div class="col-xs-1 pull-right">
                        <input type="checkbox" {{$edit_able == 1 ? ' name=transferable id=transferable ' : 'disabled'}} {{ isset($task['transferable']) ? 'checked="checked"' : '' }} style="height: 20px"/>
                    </div>
                    <div class="col-xs-11 margin-top-10">
                        <label for="transferable">{{ trans('tasks.modal_task_details_assignor_to_another') }}</label>
                    </div>
                </div>
                {{--<div class="pull-right col-xs-12" style="height: 30px;line-height: 30px;">--}}
                    {{--<input type="radio" {{$edit_able == 1 ? ' name="kind" id="kind_activity" ' : 'disabled'}}  value="1" {{$task['kind'] ==1 ? 'checked' : ''}}/>--}}
                    {{--<label for="kind_activity">{{ trans('tasks.activity') }}</label>--}}
                    {{--<input type="radio" {{$edit_able == 1 ? ' name="kind" id="kind_event" ' : 'disabled'}} value="0" {{$task['kind'] ==0 ? 'checked' : ''}}/>--}}
                    {{--<label for="kind_event">{{ trans('tasks.event')}}</label>--}}
                {{--</div>--}}
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
                            <input type="text" id="new_task_resources_amount" class="form-control border-radius noRightPadding noLeftPadding text-center" placeholder="{{ trans('tasks.amount') }}"/>
                        </div>
                        <div class="col-xs-1">
                            <input type="text" id="new_task_resources_cost" class="form-control border-radius noRightPadding noLeftPadding text-center" placeholder="{{ trans('tasks.cost') }}"/>
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
{{--                            <th class="col-xs-1">{{ trans('tasks.action') }}</th>--}}
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
                                    {{--<td>--}}
                                        {{--<span class="fa fa-trash btn btn-primary remove_new_task" onclick="remove_new_task({{$k.'show'}})" for="r2"></span>--}}
                                    {{--</td>--}}
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
                            {{--<input type="text" id="new_task_weight" class="form-control border-radius noRightPadding noLeftPadding text-center" placeholder="{{ trans('tasks.weight') }}" />--}}
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
                            {{--<th class="col-xs-1">{{ trans('tasks.action') }}</th>--}}
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
                                            <input {{$edit_able == 1 ? ' name="new_task_weight[]"  ' : 'disabled'}} type="hidden" value="{{$res['task']['new_task_weight'][$k]}}"/>
                                        </label>
                                    </td>
                                    <td>
                                        <select class="form-control border-radius" {{$edit_able == 1 ? ' name="new_task_relation[]"  ' : 'disabled'}}>
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
                                                <input {{$edit_able == 1 ? ' name="new_task_delay_num[]"  ' : 'disabled'}} value="{{$res['task']['new_task_delay_num'][$k]}}" type="text" class="form-control border-radius" placeholder="وقفه"/>
                                            </div>
                                            <div class="col-xs-6">
                                                <select {{$edit_able == 1 ? ' name="new_task_delay_type[]"  ' : 'disabled'}} class="form-control border-radius" >
                                                    <option value="day" {{$res['task']['new_task_delay_type'][$k] == 'day' ? 'selected="selected"' :''}}>روز</option>
                                                    <option value="week" {{$res['task']['new_task_delay_type'][$k] == 'week' ? 'selected="selected"' :''}}>هفته</option>
                                                    <option value="month" {{$res['task']['new_task_delay_type'][$k] == 'month' ? 'selected="selected"' :''}}>ماه</option>
                                                </select>
                                            </div>
                                        </label>
                                    </td>
                                    {{--<td>--}}
                                        {{--<span class="fa fa-trash btn btn-primary remove_new_task" onclick="remove_new_task({{$k.'show'}})" for="r2"></span>--}}
                                    {{--</td>--}}
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane active" id="tab_t5" style="padding: 8px;">
                <div class="row col-lg-12" style="margin-top: 20px;">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding noLeftPadding">
                        <label for="r2" style="height: 30px;line-height: 30px;">{{ trans('tasks.status') }}</label>
                    </div>
                    <div class="col-lg-11 noRightPadding noLeftPadding">
                        <div class="pull-right noRightPadding noLeftPadding" style="height: 30px;line-height: 30px;">
                            <input type="radio" name="task_status" id="not_start" value="0"  {{$res['task_status'] ==0 ? 'checked' : ''}}/>
                            <label for="not_start">{{ trans('tasks.not_start') }}</label>
                        </div>
                        <div class="pull-right" style="height: 30px;line-height: 30px;margin-right: 10px">
                            <input type="radio" name="task_status" id="on_done" value="1" {{$res['task_status'] ==1 ? 'checked' : ''}}/>
                            <label for="on_done">{{ trans('tasks.on_done')}}</label>
                            <input type="text" id="num_event" class="form-control border-radius" style="width: 40px;display: inline" name="progress" value="{{$res['percent']}}" >
                            <label for="on_done">{{ trans('tasks.precent_progress') }}</label>
                        </div>
                        <div class="pull-right" style="height: 30px;line-height: 30px;margin-right: 10px">
                            <input type="radio" name="task_status" id="status_done" value="2" {{$res['task_status'] ==2 ? 'checked' : ''}}/>
                            <label for="status_done">{{ trans('tasks.status_done') }}</label>
                        </div>
                        <div class="pull-right" style="height: 30px;line-height: 30px;margin-right: 10px">
                            <input type="radio" name="task_status" id="status_finished" value="3" {{$res['task_status'] ==3 ? 'checked' : ''}}/>
                            <label for="status_finished">{{ trans('tasks.status_finished') }}</label>
                        </div>
                        <div class="pull-right" style="height: 30px;line-height: 30px;margin-right: 10px">
                            <input type="radio" name="task_status" id="status_suspended" value="4" {{$res['task_status'] ==4 ? 'checked' : ''}}/>
                            <label for="status_suspended">{{ trans('tasks.status_suspended') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12 margin-top-20">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding noLeftPadding">
                        <label for="r2" style="height: 30px;line-height: 30px;">{{ trans('tasks.report') }}</label>
                    </div>
                    <div class="pull-right height-30 line-height-30">
                        <label for="determined-time">{{ trans('tasks.set_action_on') }}: </label>
                        <input type="text" class="form-control border-radius DatePicker" style="display: inline;width: 110px;" id="action_date" name="action_date" aria-describedby="respite_date">
                    </div>
                    <div class="pull-right height-30 line-height-30 margin-right-10">
                        <label for="determined-time">{{ trans('tasks.duration') }}</label>
                    </div>
                    <div class="pull-right height-30 line-height-30 margin-right-10">
                        <input type="text" class="form-control border-radius" style="display: inline;width: 50px;" id="action_duration_act" name="action_duration_act" placeholder="{{ trans('tasks.duration') }}" aria-describedby="respite_date">
                    </div>
                    <div class="pull-right height-30 line-height-30 margin-right-10">
                        <select class="form-control" id="action_duration_act_type">
                            <option value="ساعت">ساعت</option>
                            <option value="دقیقه">دقیقه</option>
                        </select>
                    </div>
                    <div class="pull-right height-30 line-height-30 margin-right-10">
                        <label for="determined-time">{{ trans('tasks.from').' '.trans('tasks.hour') }}</label>
                        <input type="text" class="form-control border-radius TimePicker" value="0" style="display: inline" id="action_time_from" name="action_time_from" aria-describedby="respite_time">
                        <label for="determined-time">{{ trans('tasks.to').' '.trans('tasks.hour') }}</label>
                        <input type="text" class="form-control border-radius TimePicker" value="" style="display: inline" id="action_time_to" name="action_time_to" aria-describedby="respite_time">
                    </div>
                    <div class="pull-right height-30 line-height-30 margin-right-10">
                        <i class="btn btn-primary fa fa-plus" id="add_btn_action"></i>
                    </div>
                </div>
                <div class="row col-lg-12" id="action_list">
                    @foreach($events->original['data'] as $Aevent)
                        <div class="col-xs-12 action_list'+action_list+'" style="margin-top:10px">
                            <div class="col-xs-2"> </div>
                            <div class="col-xs-1">{{trans('tasks.in_date')}} </div>
                            <div class="col-xs-3">
                                <span class="margin-right-10"> {{$Aevent['startdate']}}</span>
                                <span class="margin-right-10"> {{trans('tasks.duration')}}: </span>
                            </div>
                            <div class="col-xs-4">
                                <span class="margin-right-10">{{$Aevent['enddate']}}</span>
                                <i class="fa fa-remove pointer margin-right-10" ctid='{{trans('tasks.duration')}}' ce='{{trans('tasks.duration')}}' onclick="remove_action()"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row col-lg-12 margin-top-15 margin-bottom-20 border-bottom padding-bottom-20">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding noLeftPadding">
                        <label class="line-height-35">{{ trans('tasks.description') }}</label>
                    </div>
                    <div class="col-lg-10 noRightPadding noLeftPadding">
                        <div id="for-desc">
                            <div class="row col-lg-12 header">
                                <span class="pointer tab_desc active tab_text" rel="tab_text">{{trans('app.text')}}</span>
                                <span class="pointer tab_desc tab_view" rel="tab_view">{{trans('app.view')}}</span>
                            </div>
                            <div class="row main-desc">
                                <textarea class="form-control row content_tab_text content_tab" name="action_explain" id="explain" placeholder="{{ trans('tasks.description') }}" cols="30" rows="4"></textarea>
                                <div class="content_tab_view content_tab hidden">
                                    {!! preg_replace('/img::/','<div><img src="'.route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']).'/',preg_replace('/::img/','"></div>','')) !!}
                                </div>
                            </div>
                            @if($edit_able == 1)
                                <div class="filemanager-buttons-client pull-right bottom-desc">
                                    <label for="fileToUpload2" class="pointer">
                                        <input type="file" class="fileToUpload2 form-control" style="display: none;" id="fileToUpload2"/>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                        </svg>
                                        <div class="display-inline">{{trans('app.add_file')}}</div>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12 margin-top-15">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noRightPadding noLeftPadding">
                        <div class="pull-right">
                            <input type="radio" name="reject_assigner" id="reject_assigner" class="reject_assigner" value="3" checked/>
                            <label for="reject_assigner" style="height: 30px;line-height: 30px;" class="rejected_options noRightPadding noLeftPadding">{{ trans('tasks.action') }}</label>
                            <input type="radio" name="reject_assigner" id="reject_assigner0" class="" value="1" style="display: inline" disabled/>
                            <label for="reject_assigner0" style="height: 30px;line-height: 30px;" class="rejected_options noRightPadding noLeftPadding">{{ trans('tasks.reject') }}</label>
                            <input type="radio" name="reject_assigner" id="reject_assigner1" class="" value="0" style="display: inline"/>
                            <label for="reject_assigner1" class="rejected_options" >{{ trans('tasks.reject_to') }}</label>
                        </div>
                        <div class="pull-right width-400">
                            <select id="assigns_new" name="assigns_new[]" class="select2_auto_complete_transcripts assingned_options"
                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple disabled=""></select>
                            <span class=" Chosen-LeftIcon"></span>
                        </div>
                        <div class="pull-right margin-right-10 line-height-35">
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'assigns_new']) !!}" class="jsPanels assingned_options" title="{{ trans('tasks.selecet_user') }}">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12 margin-top-15 margin-bottom-20 border-bottom padding-bottom-20">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding noLeftPadding">
                        <label class="line-height-35">{{ trans('tasks.description') }}</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="rejected_options form-control border-radius" placeholder="توضیح ..." name="explain_reject" id="explain_reject" value=""/>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_t6" style="padding-top: 8px;margin-top:20px">

                <div class="row col-lg-12" style="border-bottom: #ccc solid 1px;">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding noLeftPadding">
                        <label class="line-height-35">{{ trans('tasks.ready') }}</label>
                    </div>
                    <div class="col-lg-11">
                        <div class="pull-right" style="height: 30px;line-height: 30px;margin-right: 10px">
                            <label for="">{{ trans('tasks.ready_body')}}</label>

                            <input type="radio" name="ready_body" id="ready_body_0" value="0" checked/>
                            <label for="ready_body_0">{{ trans('tasks.low') }}</label>

                            <input type="radio" name="ready_body" id="ready_body_l" value="1"/>
                            <label for="ready_body_l">{{ trans('tasks.high') }}</label>
                        </div>
                        <div class="pull-right" style="height: 30px;line-height: 30px;margin-right: 50px">
                            <label for="on_done">{{ trans('tasks.ready_mental')}}</label>

                            <input type="radio" name="ready_mental" id="ready_mental_0" value="0" checked/>
                            <label for="ready_mental_0">{{ trans('tasks.low') }}</label>

                            <input type="radio" name="ready_mental" id="ready_mental_l" value="1"/>
                            <label for="ready_mental_l">{{ trans('tasks.high') }}</label>
                        </div>

                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding noLeftPadding">
                        <label class="line-height-35">{{ trans('tasks.predict_duration') }}</label>
                    </div>
                    <div class="col-lg-10">
                        <div class="pull-right" style="height: 30px;line-height: 30px;margin-right: 10px">
                            <input type="text" class="form-control border-radius display-inline" name="action_duration" id="action_duration" value="1"/>
                        </div>
                        <div class="pull-right" style="height: 30px;line-height: 30px;">
                            <select id="action_time_type" name="action_time_type" class="form-control border-radius">
                                <option value="1">{{trans('tasks.hour')}}</option>
                                <option value="24">{{trans('tasks.day')}}</option>
                                <option value="168">{{trans('tasks.week')}}</option>
                                <option value="720">{{trans('tasks.month')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12" style="border-bottom: #ccc solid 1px;">
                    <div class="row col-lg-12 noLeftPadding noRightPadding">
                        <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding noLeftPadding">
                            <label class="line-height-35">{{ trans('tasks.timing') }}</label>
                        </div>
                        <div class="col-lg-10">
                            <div class="pull-right">
                                <input type="radio" name="timing_type" id="timing_automatic" value="automatic" disabled/>
                                <label class="line-height-35" for="timing_automatic">{{ trans('tasks.automatic') }}</label>
                            </div>
                            <div class="pull-right" style="height: 30px;line-height: 30px;margin-right: 10px">
                                <input type="radio" name="timing_type" id="timing_manual" value="manual" checked/>
                                <label class="line-height-35" for="timing_manual">{{ trans('tasks.manual') }}</label>
                            </div>

                            {{--<div class="pull-right" style="height: 30px;line-height: 30px;margin-right: 30px">--}}
                                {{--<input type="radio" name="done_time" id="not-determine" value="not-determine"/>--}}
                                {{--<label for="not-determine">{{ trans('tasks.no-just-detemine') }}</label>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    <div class="row col-lg-12 noLeftPadding noRightPadding time_manual">
                        <div class="col-lg-12 noLeftPadding noRightPadding">
                            <div class="col-lg-2 noLeftPadding noRightPadding"></div>
                            <div class="pull-right">
                                <label>{{ trans('tasks.begin') }}: </label>
                                <input type="text" class="form-control border-radius DatePicker" style="display: inline" name="action_date" aria-describedby="respite_date">
                            </div>
                        </div>
                        <div class="col-lg-12 noLeftPadding noRightPadding">
                            <div class="col-lg-2 noLeftPadding noRightPadding"></div>
                            <div class="pull-right" style="height: 30px;line-height: 30px;">
                                <label>{{ trans('tasks.end') }}: </label>
                                <input type="radio" name="done_time" id="to_end" value="to_end" checked/>
                            </div>
                            <div class="pull-right" style="height: 30px;line-height: 30px;">
                                <label for="to_end">{{ trans('tasks.to') }}</label>
                            </div>
                            <div class="pull-right" style="height: 30px;line-height: 30px;">
                                <select id="task_schedul_" name="to_end" class="form-control border-radius">
                                    <option value="daily">{{trans('tasks.today')}}</option>
                                    <option value="weekly">{{trans('tasks.this')}} {{trans('tasks.week')}}</option>
                                    <option value="monthly">{{trans('tasks.this')}} {{trans('tasks.month')}}</option>
                                </select>
                            </div>
                            <div class="pull-right" style="height: 30px;line-height: 30px;">
                                <input type="radio" name="done_time" id="determined-time" value="determined-time"/>
                                <label for="determined-time">{{ trans('tasks.in') }}</label>
                                <input type="text" class="form-control border-radius DatePicker" style="display: inline" id="action_date" name="action_date" aria-describedby="respite_date">
                                <label for="determined-time">{{ trans('tasks.hour') }}</label>
                                <input type="text" class="form-control border-radius TimePicker" style="display: inline" id="action_time" name="action_time" aria-describedby="respite_time">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12" style="margin-top: 10px;margin-bottom: 20px;border-bottom: #ccc solid 1px;">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noRightPadding noLeftPadding">
                        <label class="line-height-35">{{ trans('tasks.keywords') }}</label>
                    </div>
                    <div class="col-lg-11">
                        <select id="new_task_keywords_" class="select2_auto_complete_keywords" name="assigns_keywords[]"
                                data-placeholder="{{trans('tasks.can_select_some_options')}}"
                                multiple="multiple"></select>
                        <span class=" Chosen-LeftIcon"></span>
                    </div>
                </div>

            </div>
            <div class="tab-pane" id="tab_t7" style="padding-top: 8px;margin-top:20px">
                <div class="col-xs-12 margin-bottom-30">
                    <div class="col-xs-11">
                        <input type="text" id="message" class="form-control border-radius" placeholder="پیام"/>
                        <input type="hidden" id="user" class="form-control border-radius" value="{{Session::get('Name').' '.Session::get('Family')}}"/>
                    </div>
                    <div class="col-xs-1 pointer line-height-35">
                        <a id="add_message_task" class="btn btn-primary">{{trans('app.submit')}}</a>
                    </div>

                </div>
                <div class="col-xs-12">
                    <table id="ChildsGrid" class="table table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="col-xs-2">کاربر</th>
                            <th class="col-xs-10">پیام</th>
                        </tr>
                        </thead>
                        <tbody id="message_task_list">
                            @if(isset($res['task']['message_username']))
                                @foreach($res['task']['message_username'] as $k=>$message_username)
                                    <tr id="add_resource_task{{$k.'show'}}">
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
            <div class="tab-pane" id="tab_t8" style="padding-top: 8px;margin-top:20px">
                <div class="col-xs-12">
                    <table id="ChildsGrid" class="table dt-responsive nowrap display dataTable no-footer" style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="col-xs-2">زمان</th>
                            <th class="col-xs-2">کاربر</th>
                            <th class="col-xs-8">اقدام</th>
                        </tr>
                        </thead>
                        <tbody id="message_task_list">
                            @if(isset($res['task_history']))
                                @foreach($res['task_history'] as $k=>$task_history)
                                    <tr id="add_resource_task{{$k.'show'}}">
                                        <td style="border-bottom: 1px solid #999;text-align: center">
                                            {{$task_history->created_at}}
                                        </td>
                                        <td style="border-bottom: 1px solid #999;text-align: center">
                                            {{$task_history->Name.' '.$task_history->Family}}
                                        </td>
                                        <td style="border-bottom: 1px solid #999;text-align: center">
                                            {{ trans('tasks.'.$task_history->operation_type).''.(trim($task_history->descript)=='' ? '' : ': ').$task_history->descript }}
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
<script>
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
                    if (data.success)
                    {
                        $('#desc').val($('#desc').val() + "\nimg::" + data.FileID + "::img");
                        if($('#desc').val() != undefined)
                            $('.content_tab_view').html($('#desc').val().replace('img::','<img src="{{route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']).'/'}}').replace('::img','">'));
                    } else
                    {
                        messageModal('fail', 'خطا', data.result);
                    }
                }
            });
        });
        $(".fileToUpload2").on('change', function() {
            var formElement = $( '.fileToUpload2' )[0].files[0];
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
                    if (data.success)
                    {
                        $('#explain').val($('#explain').val() + "\nimg::" + data.FileID + "::img");
                        if($('#explain').val() != undefined)
                            $('.content_tab_view').html($('#explain').val().replace('img::','<img src="{{route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']).'/'}}').replace('::img','">'));
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

@include('hamahang.Tasks.helper.ShowAssignTaskForm.inline_js')
{!! $HFM_CN_Task['JavaScripts'] !!}