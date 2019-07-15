<!-- Sesssion Modal --->
{{--<div class="modal fade" id="add_seesion_dialog">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>{{trans("calendar_events.ce_modal_session_header_title")}}</span>:
                    <span class="bg-warning"
                          style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
                <ul class='nav nav-wizard class="col-md-12"'>

                    <li class='active' class="col-md-6"><a href='#step1'>{{trans("calendar_events.ce_modal_session_navbar_nav1")}}</a></li>

                    <li><a href='#step2' class="col-md-6">{{trans("calendar_events.ce_modal_session_navbar_nav2")}}</a></li>


                </ul>
            </div><!-- end modal header -->
            <div class="modal-body">
                <div class="container table-bordered" style="width: 95%">--}}
{{--<ul class='nav nav-wizard class="col-md-12"'>--}}

{{--<li class='active' class="col-md-6"><a href='#step1'>{{trans("calendar_events.ce_modal_session_navbar_nav1")}}</a></li>--}}

{{--<li><a href='#step2' class="col-md-6">{{trans("calendar_events.ce_modal_session_navbar_nav2")}}</a></li>--}}


{{--</ul>--}}
<div id="form-content" class="padding-bottom-10">
    <div id="sessionMsgBox"></div>
    <form id="sessionForm" role="form" class="form-horizontal">
        <div id="form-session-content">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#s_event" data-toggle="tab">
                        <span>{{trans("calendar_events.ce_modal_session_navbar_define")}}</span>
                    </a>
                </li>
                <li >
                    <a href="#s_form" data-toggle="tab">
                        <span>{{trans('calendar_events.ce_modal_session_navbar_setting')}}</span>
                    </a>
                </li>
                <li>
                    <a class="disable-tab">
                        <span> {{trans('calendar_events.ce_modal_session_navbar_accept')}}</span>
                    </a>
                </li>
                <li>
                    <a class="disable-tab">
                        <span> {{trans('calendar_events.ce_modal_session_navbar_note')}}</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content" style="overflow: auto;height: 50vh;padding-bottom: 180px;">
                <div id="s_event" class="tab-pane fade in active">
                    <div class="col-md-12">
                        <div class="">
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-1">
                                    <label>
                                        {{--<span class="required">*</span>--}}
                                        {{trans('calendar_events.ce_modal_events_title_field_lable')}}
                                    </label>
                                </div>
                                @if(isset($session['title']))
                                    <input name="mode" id="mode" type="hidden" class="form-control" value="edit">
                                    <input name="sid" id="sid" type="hidden" class="form-control" value="{{enCode($session->id)}}">
                                @else
                                    <input name="mode" id="mode" type="hidden" class="form-control" value="insert">
                                @endif
                                <div class="col-xs-8">
                                    <input name="title" id="session_title" class="form-control" placeholder="{{trans('calendar_events.ce_modal_events_title_field_lable')}}" value="{{isset($session['title']) ? $session['title'] : ''}}">
{{--                                    <input type="hidden" {{isset($form_data['htitle']) ? 'name=event_id value='.$form_data["session_id"].'' : ''}}>--}}
                                    <input name="event_type" type="hidden" class="form-control" placeholder="">
                                </div>
                                <div class="col-xs-3 line-height-35">
                                    <input type="radio"  name="session_type" id="session_type" value="2" {{isset($form_data['type']) ? ($form_data['type']==2 ? 'checked' : '') : 'checked'}}/><label for="session_type"> {{trans('tasks.official')}}</label>
                                    <input type="radio" name="session_type" id="session_type1" value="1" {{isset($form_data['type']) ? ($form_data['type']==2 ? 'checked' : '') : ''}}/><label for="session_type1"> {{trans('calendar_events.ce_modal_session_personal')}}</label>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-1 line-height-35">
                                    <label><span>{{trans('calendar_events.ce_agenda_label')}}</span></label>
                                </div>
                                <div class="col-xs-10">
                                    <input type="text" name="agenda" id="agenda" value="" class="form-control" placeholder="{{trans('calendar_events.ce_agenda_label')}}"/>
                                </div>
                                <div class="col-xs-1">
                                    <a class="fa fa-plus pointer line-height-35" id="add_agenda"></a>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-20 {{isset($session->agendas) ? (count($session->agendas)>0 ? '' : 'hidden') : ''}}" id="agenda_list">
                                @if(isset($session->agendas))
                                    @foreach($session->agendas as $agenda)
                                        <div class="col-xs-12 margin-top-10"><div class="col-xs-1"><input type="hidden" class="agendas" name="agendas[]" value="{{$agenda->agenda}}"></div><div class="col-xs-10">{{$agenda->agenda}}</div><div class="col-xs-1"><a class="fa fa-remove remove-agenda pointer"></a></div></div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-1 line-height-35">
                                    <label>{{trans('calendar_events.ce_place')}}</label>
                                </div>
                                <div class="col-xs-7">
                                    <input name="location" class="form-control" placeholder="{{trans('calendar_events.ce_location')}}" value="{{isset($session->location) ? $session->location : ''}}" />
                                </div>
                                <div class="pull-right line-height-35">
                                    <label>{{trans('calendar_events.ce_modal_session_phone')}}</label>
                                </div>
                                <div class="pull-right">
                                    <input type="text" class="form-control" name="location_phone" value="{{isset($session->location_phone) ? $session->location_phone : ''}}" placeholder="{{trans('calendar_events.ce_modal_session_coordination_phone_phone')}}"/>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-1">
                                    <label class="line-height-30 pull-right">{{trans('calendar_events.ce_time_label')}}</label>
                                </div>
                                <div class="col-xs-11">
                                    <div class="pull-right height-30 line-height-30">
                                        <input type="text" class="form-control DatePicker clsDatePicker" name="startdate" value="{{isset($session->date) ? $session->date : ''}}" autocomplete="off" placeholder="{{trans('calendar_events.ce_date_label')}}" aria-describedby="startdate-session">
                                    </div>
                                    <div class="pull-right height-30 line-height-30 margin-right-10">
                                        <label for="determined-time">{{ trans('tasks.duration') }}</label>
                                    </div>
                                    <div class="pull-right height-30 line-height-30 margin-right-10">
                                        <input type="number" class="form-control border-radius" style="display: inline;width: 50px;" id="action_duration_act"  value="{{isset($session->date) ? $session->date : ''}}" name="action_duration_act" placeholder="{{ trans('tasks.duration') }}" aria-describedby="respite_date">
                                    </div>
                                    <div class="pull-right height-30 line-height-30 margin-right-10">
                                        <select class="form-control" id="action_duration_act_type">
                                            <option value="60">ساعت</option>
                                            <option value="1">دقیقه</option>
                                        </select>
                                    </div>
                                    <div class="pull-right height-30 line-height-30 margin-right-10">
                                        <label for="determined-time">{{ trans('tasks.from').' '.trans('tasks.hour') }}</label>
                                        <input type="text" class="form-control border-radius TimePicker" style="display: inline" id="starttime" name="starttime" aria-describedby="respite_time" value="{{isset($session->starttime) ? $session->starttime : ''}}">
                                        <label for="determined-time">{{ trans('tasks.to').' '.trans('tasks.hour') }}</label>
                                        <input type="text" class="form-control border-radius TimePicker" style="display: inline" id="endtime" name="endtime" aria-describedby="respite_time" value="{{isset($session->endtime) ? $session->endtime : ''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-1 line-height-35">
                                    <label>
                                        {{trans('calendar_events.ce_modal_events_cid_field_lable')}}
                                    </label>
                                </div>
                                <div class="col-xs-11">
                                    <select name="cid" class="chosen-rtl" multiple data-placeholder="{{trans('calendar_events.ce_modal_events_cid_field_lable')}}">
                                        @if(!empty($form_data['hcid']))
                                            @if(!empty($form_data['hcid']))
                                                @foreach($form_data['hcid'] as $hcid)
                                                    <option selected="selected" value="{{ $hcid->id }}">{{ $hcid->title }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row col-lg-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-lg-1">
                                    <label class="line-height-35">
                                        {{ trans('app.page') }}
                                    </label>
                                </div>
                                <div class="col-lg-11">
                                    <select id="new_session_pages" class="select2_auto_complete_page " name="new_session_pages[]"
                                            data-placeholder="{{trans('calendar_events.can_select_some_options')}}" multiple="multiple">
                                        @if(isset($session['relations']['pages']))
                                            @foreach($session['relations']['pages'] as $page)
                                                <option selected="selected" value="{{ $page->page->id }}">{{ $page->page->subject->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-1">
                                    <label>{{trans('calendar_events.keyword')}}</label>
                                </div>
                                <div class="col-xs-9">
                                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                                            data-placeholder="{{trans('calendar_events.ce_select_some_keywords')}}"
                                            multiple="multiple">
                                        @if(isset($session->keywords))
                                            @foreach($session->keywords as $key)
                                                <option selected="selected" value="{{ $key->keyword->id }}">{{ $key->keyword->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <input type="text" name="session_color" id="session_color" value="{{isset($session->scolor) ? $session->scolor : 'rgb(255, 235, 205)'}}" style="display: none;" class="form-control">
                                </div>
                            </div>
                            <div class="row col-lg-12 margin-top-20">
                                <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4 noLeftPadding noRightPadding"><label class="line-height-35">{{ trans('tasks.description') }}</label></div>
                                <div class="col-lg-11 noLeftPadding noRightPadding">
                                    <div id="for-desc">
                                        <div class="row col-lg-12 header">
                                            <span class="pointer tab_desc active tab_text" rel="tab_text">{{trans('app.text')}}</span>
                                            <span class="pointer tab_desc tab_view" rel="tab_view">{{trans('app.view')}}</span>
                                        </div>
                                        <div class="row main-desc">
                                            <textarea class="form-control row content_tab_text content_tab" name="descriotion" id="desc" placeholder="{{ trans('tasks.description') }}" cols="30" rows="4">{{isset($form_data['description']) ? $form_data['description'] : ''}}</textarea>
                                            <div class="content_tab_view content_tab hidden">{{isset($form_data['description']) ? $form_data['description'] : ''}}</div>
                                        </div>
                                        <div class="filemanager-buttons-client pull-right bottom-desc">
                                            <label for="fileToUpload" class="pointer">
                                                <input type="file" class="fileToUpload form-control" style="display: none;" id="fileToUpload"/>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                                </svg>
                                                <div class="display-inline">{{trans('app.add_file')}}</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">--}}
                                {{--<div class="col-xs-2">--}}
                                    {{--<label class="form-check-label">{{trans('calendar_events.ce_allday_label')}}</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-10">--}}
                                    {{--<input name="allDay" type="checkbox" class="form-check-input" value="1"></label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>

                <div id="s_form" class="tab-pane fade">
                    <div class="col-md-12">
                        <div class="">
                            <div class="col-xs-12 margin-top-20">
                                <div class="col-xs-1 noLeftPadding noRightPadding line-height-35">
                                    <label>{{trans('calendar_events.ce_moda_session_modal_session_chief')}}</label>
                                </div>
                                <div class="col-xs-11">
                                    <select name="session_chief" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_chief')}}" >
                                        <option value=""></option>
                                        @if(isset($session->members))
                                            @foreach($session->members->where('user_type', '=', 5) as $session_chief)
                                                <option selected="selected" value="{{ $session_chief->user['id'] }}">{{ $session_chief->user['Name'].' '.$session_chief->user['Family'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-20">
                                <div class="col-xs-1 noLeftPadding noRightPadding line-height-35">
                                    <label>{{trans('calendar_events.ce_moda_session_modal_session_secretary')}}</label>
                                </div>
                                <div class="col-xs-11">
                                    <select name="session_secretary" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_secretary')}}" >
                                        <option value=""></option>
                                        @if(isset($session->members))
                                            @foreach($session->members->where('user_type', '=', 4) as $session_chief)
                                                <option selected="selected" value="{{ $session_chief->user['id'] }}">{{ $session_chief->user['Name'].' '.$session_chief->user['Family'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-20">
                                <div class="col-xs-1 noLeftPadding noRightPadding line-height-35">
                                    <label>{{trans('calendar_events.ce_moda_session_modal_facilitator')}}</label>
                                </div>
                                <div class="col-xs-11">
                                    <select name="session_facilitator" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_facilitator')}}">
                                        <option value=""></option>
                                        @if(isset($session->members))
                                            @foreach($session->members->where('user_type', '=', 3) as $session_chief)
                                                <option selected="selected" value="{{ $session_chief->user['id'] }}">{{ $session_chief->user['Name'].' '.$session_chief->user['Family'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-20">
                                <div class="col-xs-1 noLeftPadding noRightPadding line-height-35">
                                    <label>{{trans('calendar_events.users')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <select name="session_voting_users[]" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_voting_users')}}" multiple>
                                        <option value=""></option>
                                        @if(isset($session->members))
                                            @foreach($session->members->where('user_type', '=', 2) as $session_chief)
                                                <option selected="selected" value="{{ $session_chief->user['id'] }}">{{ $session_chief->user['Name'].' '.$session_chief->user['Family'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-xs-1 line-height-35">
                                    <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_users_responsible']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                        <span class="icon icon-afzoodane-fard fonts"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-20">
                                <div class="col-xs-1 noLeftPadding noRightPadding line-height-35">
                                    <label>{{trans('calendar_events.users')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <select name="session_notvoting_users[]" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_notvoting_users')}}" multiple>
                                        <option value=""></option>
                                        @if(isset($session->members))
                                            @foreach($session->members->where('user_type', '=', 1) as $session_chief)
                                                <option selected="selected" value="{{ $session_chief->user['id'] }}">{{ $session_chief->user['Name'].' '.$session_chief->user['Family'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-xs-1 line-height-35">
                                    <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_users_responsible']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                        <span class="icon icon-afzoodane-fard fonts"></span>
                                    </a>
                                </div>
                            </div>
                            {{--<div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">--}}
                                {{--<div id="map_canvas" class="col-md-12"></div>--}}
                            {{--</div>--}}
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-1 noLeftPadding noRightPadding line-height-35"></div>
                                <div class="col-xs-11">
                                    <input name="send_Invitation" type="checkbox" id="send_Invitation" class="form-check-input" value="1" disabled>
                                    <label class="form-check-label" for="send_Invitation">{{trans('calendar_events.ce_send_Invitation')}}</label>
                                    <input name="create_session_page" type="checkbox" id="create_session_page" class="form-check-input" value="1">
                                    <label class="form-check-label" for="create_session_page">{{trans('calendar_events.ce_create_session_page')}}</label>
                                    <input name="allow_inform_invitees" id="allow_inform_invitees" type="checkbox" class="form-check-input" value="1" disabled>
                                    <label class="form-check-label" for="allow_inform_invitees">{{trans('calendar_events.ce_allow_inform_invitees')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="s_detail" class="tab-pane fade">
                    {{--<div class="panel panel-info col-md-12">--}}
                        {{--<div class="panel-body">--}}
                            {{--<table class="table table-bordered table-striped col-md-12">--}}
                                {{--<tr>--}}
                                    {{--<td class="col-md-2">--}}
                                        {{--<label class="line-height-35">{{trans('calendar_events.ce_attachs')}}</label>--}}
                                    {{--</td>--}}
                                    {{--<td class="col-md-10">--}}
                                        {{--<!--<div class="row-fluid">-->--}}
                                        {{--<div class="col-md-12 form-inline line-height-25">--}}
                                            {{--@foreach($HFM_CalendarEvent['Buttons'] as $key => $value)--}}
                                                {{--{!! $value !!}--}}
                                                {{--{!! $HFM_CalendarEvent['ShowResultArea'][$key] !!}--}}
                                            {{--@endforeach--}}
                                        {{--</div>--}}
                                        {{--<!-- </div>-->--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td class="col-md-12" colspan="2">--}}
                                        {{--<table id="sessionFilesGrid"--}}
                                               {{--class="table table-condensed table-hover table-striped">--}}
                                            {{--<thead>--}}
                                            {{--<tr>--}}
                                                {{--<th>{{trans('calendar_events.ce_rowindex_label')}}</th>--}}
                                                {{--<th>{{trans('calendar_events.ce_file_title')}}</th>--}}
                                                {{--<th>{{trans('calendar_events.ce_file_type')}}</th>--}}
                                                {{--<th>{{trans('calendar_events.ce_file_size')}}</th>--}}
                                                {{--<th>--}}
                                                    {{--عملیات دانلود--}}
                                                {{--</th>--}}
                                            {{--</tr>--}}
                                            {{--</thead>--}}


                                        {{--</table>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
            {{--  <div class="btnContent">
                  <button type="button" name="saveSession" id="saveSession"
                          class="btn btn-success pull-left">
                      <i class="glyphicon  glyphicon-save-file bigger-125">
                          <span>{{trans('calendar_events.ce_saved_label')}}</span></i>
                  </button>
              </div>
          </div>--}}
        </div>

    </form>

    {{-- </div>
 </div>
</div>
</div>
</div>--}}
    {!! $HFM_CalendarEvent['UploadForm'] !!}


    <script>
        $("#starttime").on('keyup', function() {
            var starttime = $('#starttime').val().split(':');
            starttime = parseInt(starttime[0])*60 + parseInt(starttime[1]);
            var endtime = $('#endtime').val().split(':');
            endtime = parseInt(endtime[0])*60 + parseInt(endtime[1]);
            if(endtime > starttime)
                $("#action_duration_act").val(Math.floor((endtime-starttime)/(parseInt($('#action_duration_act_type').val()=='ساعت' ? 60 : 1))));
        });

        $("#action_duration_act").on('keyup', function() {
            var pe = new persianDate().subtract('milliseconds', 1000*$('#action_duration_act').val()*($('#action_duration_act_type').val()=='ساعت' ? 3600 : 60));
            $("#starttime").val(parseArabic(pe.format('HH:mm')));
        });
        $("#action_duration_act_type").on('change', function() {
            var pe = new persianDate().subtract('milliseconds', 1000*$('#action_duration_act').val()*($('#action_duration_act_type').val()=='ساعت' ? 3600 : 60));
            $("#starttime").val(parseArabic(pe.format('HH:mm')));
        });
        $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 40px; top: -3px;"><a href="{!! url('/modals/helpview?code=').enCode('350') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
        $(".DatePicker").persianDatepicker({

            autoClose: true,
            format: 'YYYY-MM-DD',

        });

        $('#add_agenda').click(function () {
            $('#agenda_list').append('<div class="col-xs-12 margin-top-10"><div class="col-xs-1"><input type="hidden" class="agendas" name="agendas[]" value="' + $('#agenda').val() + '" /></div><div class="col-xs-10">' + $('#agenda').val() + '</div><div class="col-xs-1"><a class="fa fa-remove remove-agenda pointer"></a></div></div>');
            $('#agenda_list').removeClass('hidden');
        });
        // $(".DatePicker").val('');
        $(".TimePicker").persianDatepicker({
            format: "HH:mm:ss a",
            timePicker: {
                //showSeconds: false,
            },
            onlyTimePicker: true
        });
        // $(".TimePicker").val('');
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
        $.ajax({
            url: '{{ URL::route('auto_complete.get_user_calendar')}}',
            type: 'Post', // Send post dat
            dataType:'json',
            success: function (s) {

                var options = '';
                $('select[name="cid"]').empty();
                for (var i = 0; i < s.length; i++) {
                    if(s[i].is_default ==1)
                    {
                        options += '<option  selected=true value="' + s[i].id + '">' + s[i].title + '</option>';
                    }
                    else{
                        options += '<option value="' + s[i].id + '">' + s[i].title + '</option>';
                    }


                }

                $('select[name="cid"]').append(options);
                $('select[name="cid"]').select2({
                    dir: "rtl",
                    width: '100%',
                });
            }
        });

        $("select[name='session_voting_users[]']").select2({
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


        $("select[name='session_notvoting_users[]']").select2({
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


        $("select[name='session_chief']").select2({
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


        $("select[name='session_secretary']").select2({
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

        $("select[name='session_facilitator']").select2({
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
        $("#session_color").spectrum({
            showPaletteOnly: true,
            togglePaletteOnly: false,
            togglePaletteLessText: 'less',
            color: 'blanchedalmond',
            palette: [
                ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
                ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
                ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
                ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
                ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
                ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
                ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
                ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
            ]
        });
    </script>

{!! $HFM_CalendarEvent['UploadForm'] !!}