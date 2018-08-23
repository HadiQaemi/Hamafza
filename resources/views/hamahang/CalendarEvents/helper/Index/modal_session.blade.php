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
<div id="form-content">
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
            <div class="tab-content" style="overflow: auto;height: 50vh;padding-bottom: 10vh;">
                <div id="s_event" class="tab-pane fade in active">
                    <div class="col-md-12">
                        <div class="">
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label>
                                        {{--<span class="required">*</span>--}}
                                        {{trans('calendar_events.ce_modal_events_title_field_lable')}}
                                    </label>
                                </div>
                                <div class="col-xs-5">
                                    <input name="title" class="form-control" placeholder="" value="{{isset($form_data['htitle']) ? $form_data['htitle'] : ''}}">
{{--                                    <input type="hidden" {{isset($form_data['htitle']) ? 'name=event_id value='.$form_data["session_id"].'' : ''}}>--}}
                                    <input name="event_type" type="hidden" class="form-control" placeholder="">
                                </div>
                                <div class="col-xs-5">
                                    <input type="radio"  name="session_type" id="session_type" value="2" {{isset($form_data['type']) ? ($form_data['type']==2 ? 'checked' : '') : 'checked'}}/><label for="session_type"> {{trans('tasks.official')}}</label>
                                    <input type="radio" name="session_type" id="session_type1" value="1" {{isset($form_data['type']) ? ($form_data['type']==2 ? 'checked' : '') : ''}}/><label for="session_type1"> {{trans('calendar_events.ce_modal_session_personal')}}</label>
                                </div>
                            </div>
                            <div class="row col-lg-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-lg-2">
                                    <label class="line-height-35">
                                        {{ trans('app.about') }}
                                    </label>
                                </div>
                                <div class="col-lg-10">
                                    <select id="new_session_pages" class="select2_auto_complete_page " name="new_session_pages[]"
                                            data-placeholder="{{trans('tasks.can_select_some_options')}}" multiple="multiple">
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
                            <div class="row col-lg-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('tasks.description') }}</label></div>
                                <div class="col-lg-10">
                                    <textarea class="form-control row" name="descriotion" id="descriotion" placeholder="{{ trans('tasks.description') }}" cols="30" rows="2">{{isset($form_data['description']) ? $form_data['description'] : ''}}</textarea>
                                </div>
                            </div>
                            <div class="row col-lg-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noRightPadding noLeftPadding line-height-35">
                                        <label class="line-height-35 pull-right">{{ trans('calendar_events.ce_attachment') }}</label>
                                    </div>
                                </div>
                                <div class="col-lg-10 line-height-35 pull-right">
                                    <div class="filemanager-buttons-client pull-right">
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
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label class="line-height-30 pull-right">{{trans('calendar_events.ce_startdate_label')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <div class="col-sm-5 col-xs-5">
                                        <div class="input-group pull-right">
                                            <input type="text" class="form-control DatePicker clsDatePicker col-xs-3" name="startdate" value="2018-7-12" autocomplete="off" placeholder="{{trans('calendar_events.ce_date_label')}}" aria-describedby="startdate-session">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-2"></div>
                                    <div class="col-sm-5 col-xs-5">
                                        <div class=' input-group date'>
                                            <input type="text" class="form-control TimePicker" placeholder="{{trans('calendar_events.ce_hour_label')}}" name="starttime" value="{{isset($form_data['starttime']) ? $form_data['starttime'] : ''}}" autocomplete="off" aria-describedby="starttime">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label class="line-height-30 pull-right">{{trans('calendar_events.ce_enddate_label')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <div class="col-sm-5 col-xs-5">
                                        <div class="input-group pull-right">
                                            <input type="text" class="form-control DatePicker  clsDatePicker col-xs-3" value="{{isset($form_data['henddate']) ? $form_data['henddate'] : ''}}" name="enddate" placeholder="{{trans('calendar_events.ce_date_label')}}" autocomplete="off" aria-describedby="enddate-session">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-2"></div>
                                    <div class="col-sm-5 col-xs-5">
                                        <div class=' input-group date'>
                                            <input type="text" class="form-control TimePicker" placeholder="{{trans('calendar_events.ce_hour_label')}}" value="{{isset($form_data['endtime']) ? $form_data['endtime'] : ''}}" name="endtime" autocomplete="off" aria-describedby="endtime">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label> {{trans('calendar_events.ce_term_of_session')}} </label>
                                </div>
                                <div class="col-xs-10">
                                    <div class='col-md-4 form-horizontal input-group date'>
                                        <input type="text" class="form-control TimePicker" placeholder="" name="term" aria-describedby="term" value="{{isset($form_data['term']) ? $form_data['term'] : ''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label>{{trans('calendar_events.ce_location')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <textarea name="location" class="form-control" >{{isset($form_data['hlocation']) ? $form_data['hlocation'] : ''}}</textarea>
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
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3">
                                    <label>
                                        {{trans('calendar_events.ce_modal_events_cid_field_lable')}}
                                    </label>
                                </div>
                                <div class="col-xs-9">
                                    <select name="cid" class="chosen-rtl">
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
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3">
                                    <label><span>{{trans('calendar_events.ce_agenda_label')}}</span></label>
                                </div>
                                <div class="col-xs-9">
                                    <input type="text" name="agenda" id="agenda" value="{{isset($form_data['hagenda']) ? $form_data['hagenda'] : ''}}" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3">
                                    <label>{{trans('calendar_events.ce_moda_session_modal_session_chief')}}</label>
                                </div>
                                <div class="col-xs-9">
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
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3">
                                    <label>{{trans('calendar_events.ce_moda_session_modal_session_secretary')}}</label>
                                </div>
                                <div class="col-xs-9">
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
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3">
                                    <label>{{trans('calendar_events.ce_moda_session_modal_session_facilitator')}}</label>
                                </div>
                                <div class="col-xs-9">
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
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3">
                                    <label>{{trans('calendar_events.ce_moda_session_modal_session_voting_users')}}</label>
                                </div>
                                <div class="col-xs-9">
                                    <select name="session_voting_users[]" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar_events.ce_selected_users')}}" multiple>
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
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3">
                                    <label>{{trans('calendar_events.ce_moda_session_modal_session_notvoting_users')}}</label>
                                </div>
                                <div class="col-xs-9">
                                    <select name="session_notvoting_users[]" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar_events.ce_selected_users')}}" multiple>
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
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div id="map_canvas" class="col-md-12"></div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3">
                                    <label>{{trans('calendar_events.ce_modal_session_coordination_phone_phone')}}</label>
                                </div>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="location_phone" value="{{isset($form_data['location_phone']) ? $form_data['location_phone'] : ''}}"/>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="form-check">
                                    <input name="send_Invitation" type="checkbox" id="send_Invitation" class="form-check-input" value="1" disabled>
                                    <label class="form-check-label" for="send_Invitation">{{trans('calendar_events.ce_send_Invitation')}}</label>
                                    <input name="create_session_page" type="checkbox" id="create_session_page" class="form-check-input" value="1" disabled>
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