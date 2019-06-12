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
                                <div class="col-xs-8">
                                    <input name="title" id="session_title" class="form-control" placeholder="{{trans('calendar_events.ce_modal_events_title_field_lable')}}" value="{{isset($form_data['htitle']) ? $form_data['htitle'] : ''}}">
{{--                                    <input type="hidden" {{isset($form_data['htitle']) ? 'name=event_id value='.$form_data["session_id"].'' : ''}}>--}}
                                    <input name="event_type" type="hidden" class="form-control" placeholder="">
                                </div>
                                <div class="col-xs-3 line-height-35">
                                    <input type="radio"  name="session_type" id="session_type" value="2" {{isset($form_data['type']) ? ($form_data['type']==2 ? 'checked' : '') : 'checked'}}/><label for="session_type"> {{trans('tasks.official')}}</label>
                                    <input type="radio" name="session_type" id="session_type1" value="1" {{isset($form_data['type']) ? ($form_data['type']==2 ? 'checked' : '') : ''}}/><label for="session_type1"> {{trans('calendar_events.ce_modal_session_personal')}}</label>
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
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-1">
                                    <label>{{trans('calendar_events.ce_place')}}</label>
                                </div>
                                <div class="col-xs-11">
                                    <input name="location" class="form-control" placeholder="{{trans('calendar_events.ce_location')}}" value="{{isset($form_data['hlocation']) ? $form_data['hlocation'] : ''}}" />
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-1">
                                    <label class="line-height-30 pull-right">{{trans('calendar_events.ce_time_label')}}</label>
                                </div>

                                <div class="col-xs-9 noLeftPadding noRightPadding">
                                    <div class="col-xs-4 noLeftPadding noRightPadding">
                                        <div class="col-xs-3">
                                            <label class="line-height-30 pull-right">{{trans('calendar_events.ce_date_label')}}</label>
                                        </div>
                                        <div class="col-sm-9 col-xs-10 noLeftPadding noRightPadding">
                                            <input type="text" class="form-control DatePicker clsDatePicker" name="startdate" value="2018-7-12" autocomplete="off" placeholder="{{trans('calendar_events.ce_date_label')}}" aria-describedby="startdate-session">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 noLeftPadding noRightPadding">
                                        <div class="col-xs-3">
                                            <label class="line-height-30 pull-right">{{trans('calendar_events.ce_startdate_label')}}</label>
                                        </div>
                                        <div class="col-sm-9 col-xs-10 noLeftPadding noRightPadding">
                                            <input type="text" class="form-control TimePicker" placeholder="{{trans('calendar_events.ce_hour_label')}}" name="starttime" value="{{isset($form_data['starttime']) ? $form_data['starttime'] : ''}}" autocomplete="off" aria-describedby="starttime">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 noLeftPadding noRightPadding">
                                        <div class="col-xs-3 noLeftPadding noRightPadding">
                                            <label class="line-height-30 pull-right">{{trans('calendar_events.ce_enddate_label')}}</label>
                                        </div>
                                        <div class="col-sm-9 col-xs-10 noLeftPadding noRightPadding">
                                            <input type="text" class="form-control TimePicker" placeholder="{{trans('calendar_events.ce_hour_label')}}" value="{{isset($form_data['endtime']) ? $form_data['endtime'] : ''}}" name="endtime" autocomplete="off" aria-describedby="endtime">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="col-xs-4 noLeftPadding noRightPadding">
                                        <label class="line-height-30 pull-right">{{trans('calendar_events.ce_term_of_session')}}</label>
                                    </div>
                                    <div class="col-sm-8 col-xs-10 noLeftPadding noRightPadding">
                                        <input type="text" class="form-control" placeholder="" name="term" aria-describedby="term" value="{{isset($form_data['term']) ? $form_data['term'] : ''}}">

                                    </div>
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
                                        @if(!empty($form_data['session_pages']))
                                            @if(is_array($form_data['session_pages']))
                                                @foreach($form_data['session_pages'] as $page)
                                                    <option selected="selected" value="{{ $page->id }}">{{ $page->title }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-1">
                                    <label>{{trans('calendar_events.keyword')}}</label>
                                </div>
                                <div class="col-xs-11">
                                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                                            data-placeholder="{{trans('calendar_events.ce_select_some_keywords')}}"
                                            multiple="multiple">
                                        @if(!empty($form_data['session_pages']))
                                            @if(is_array($form_data['session_pages']))
                                                @foreach($form_data['session_pages'] as $page)
                                                    <option selected="selected" value="{{ $page->id }}">{{ $page->title }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
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
                            <div class="col-xs-12 margin-top-20">
                                <div class="col-xs-1 noLeftPadding noRightPadding line-height-35">
                                    <label><span>{{trans('calendar_events.ce_agenda_label')}}</span></label>
                                </div>
                                <div class="col-xs-11">
                                    <input type="text" name="agenda" id="agenda" value="{{isset($form_data['hagenda']) ? $form_data['hagenda'] : ''}}" class="form-control" placeholder="{{trans('calendar_events.ce_agenda_label')}}"/>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-20">
                                <div class="col-xs-1 noLeftPadding noRightPadding line-height-35">
                                    <label>{{trans('calendar_events.ce_moda_session_modal_session_chief')}}</label>
                                </div>
                                <div class="col-xs-11">
                                    <select name="session_chief" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_chief')}}" >
                                        <option value=""></option>
                                        @if(!empty($form_data['session_chief']))
                                            @if(is_array($form_data['session_chief']))
                                                @foreach($form_data['session_chief'] as $session_chief)
                                                    <option selected="selected" value="{{ $session_chief['id'] }}">{{ $session_chief['text'] }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                        <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
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
                                        @if(!empty($form_data['session_secretary']))
                                            @if(is_array($form_data['session_secretary']))
                                                @foreach($form_data['session_secretary'] as $session_secretary)
                                                    <option selected="selected" value="{{ $session_secretary['id'] }}">{{ $session_secretary['text'] }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                        <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
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
                                        @if(!empty($form_data['session_facilitator']))
                                            @if(is_array($form_data['session_facilitator']))
                                                @foreach($form_data['session_facilitator'] as $session_facilitator)
                                                    <option selected="selected" value="{{ $session_facilitator['id'] }}">{{ $session_facilitator['text'] }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                        <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 margin-top-20">
                                <div class="col-xs-1 noLeftPadding noRightPadding line-height-35">
                                    <label>{{trans('calendar_events.ce_moda_session_modal_session_voting')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <select name="session_voting_users[]" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_voting_users')}}" multiple>
                                        <option value=""></option>
                                        @if(!empty($form_data['session_voting_users']))
                                            @if(is_array($form_data['session_voting_users']))
                                                @foreach($form_data['session_voting_users'] as $session_voting_user)
                                                    <option selected="selected" value="{{ $session_voting_user['id'] }}">{{ $session_voting_user['text'] }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                        <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
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
                                    <label>{{trans('calendar_events.ce_moda_session_modal_session_notvoting')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <select name="session_notvoting_users[]" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_notvoting_users')}}" multiple>
                                        <option value=""></option>
                                        @if(!empty($form_data['session_notvoting_users']))
                                            @if(is_array($form_data['session_notvoting_users']))
                                                @foreach($form_data['session_notvoting_users'] as $session_notvoting_user)
                                                    <option selected="selected" value="{{ $session_notvoting_user['id'] }}">{{ $session_notvoting_user['text'] }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                        <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
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
                            <div class="col-xs-12 margin-top-20">
                                <div class="col-xs-1 noLeftPadding noRightPadding line-height-35">
                                    <label>{{trans('calendar_events.ce_modal_session_phone')}}</label>
                                </div>
                                <div class="col-xs-11">
                                    <input type="text" class="form-control" name="location_phone" value="{{isset($form_data['location_phone']) ? $form_data['location_phone'] : ''}}" placeholder="{{trans('calendar_events.ce_modal_session_coordination_phone_phone')}}"/>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="form-check">
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
        $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 40px; top: -3px;"><a href="{!! url('/modals/helpview?code=').enCode('350') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
        $(".DatePicker").persianDatepicker({

            autoClose: true,
            format: 'YYYY-MM-DD',

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

    </script>

{!! $HFM_CalendarEvent['UploadForm'] !!}