<div class="col-xs-12 col-md-12">
    <form action="{{ route('hamahang.tasks.save_task') }}" class="" name="create_new_task" id="create_new_task" method="post"
          enctype="multipart/form-data">
        <table class="table col-xs-12">
            <tr>
                <td class="width-120">
                    <label class="line-height-35">{{ trans('tasks.title') }}</label>
                </td>
                <td>
                    <div class="row-fluid">
                        <div class="row">
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="title" id="title"/>
                            </div>
                            <div class="clearfixed"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 line-height-35">
                                <div class="pull-right" style="margin: 0 0 0 10px;">
                                    <input type="radio" name="type" value="0" checked/>
                                    <label for="r1">{{ trans('app.official') }}</label>
                                    <input type="radio" name="type" value="1"/>
                                    <label for="r2">{{ trans('app.unofficial') }}</label>
                                </div>
                                <div class="pull-right" style="margin: 0 10px;">
                                    <input type="radio" name="importance" value="1"/>
                                    <label>{{ trans('tasks.important') }}</label>
                                    <input type="radio" name="importance" value="0" checked/>
                                    <label>{{ trans('tasks.unimportant')}}</label>
                                </div>

                                <div class="pull-right" style="margin: 0 10px;">
                                    <input type="radio" name="immediate" value="1"/>
                                    <label>{{ trans('tasks.immediate') }}</label>
                                    <input type="radio" name="immediate" value="0" checked/>
                                    <label>{{ trans('tasks.Non-urgent') }}</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </td>
            </tr>
            {{--<tr>
                <td class="width-120">
                    <label class="line-height-35">{{ trans('tasks.importance') }}
                        {{ trans('tasks.immediacy') }}
                    </label>
                </td>
                <td>
                    <div class="row-fluid">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>{{ trans('tasks.importance') }} :</label>
                                    <span class="input-group">
                                        <input type="radio" name="importance" value="1"/>
                                        <label>{{ trans('tasks.important') }}</label>
                                        <input type="radio" name="importance" value="0" checked/>
                                        <label>{{ trans('tasks.unimportant')}}</label>
                                    </span>
                                </div>
                                <div class="col-xs-6">
                                    <label>{{ trans('tasks.immediacy') }} :</label>
                                    <span class="input-group">
                                        <input type="radio" name="immediate" value="1"/>
                                        <label>{{ trans('tasks.immediate') }}</label>
                                        <input type="radio" name="immediate" value="0" checked/>
                                        <label>{{ trans('tasks.Non-urgent') }}</label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </td>
            </tr>--}}
            <tr>
                <td>{{ trans('tasks.task_type') }}</td>
                <td>
                    <div class="row">
                        <table class="table no-margin no-padding">
                            <tr>
                                <td style="border-top: none;">
                                    <input type="radio" id="use_type0" name="use_type" value="0" onclick="change_respite_type(0)" checked/>  <!-------- normal task  ---->
                                    <label for="r1">{{ trans('tasks.ordinary_task') }}</label>
                                    <input type="radio" id="use_type1" name="use_type" value="1" onclick="change_respite_type(1)"/>          <!-------- project task  ---->
                                    <label for="r2">{{ trans('tasks.project_task') }}</label>
                                    <input type="radio" id="use_type2" name="use_type" value="2" onclick="change_respite_type(2)"/>          <!-------- process task  ---->
                                    <label for="r2">{{ trans('tasks.process_task') }}</label>
                                </td>
                                <td style="border-top: none;">
                                    <div id="project_span" class="pull-right"></div>
                                </td>
                            </tr>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="width-120">
                    <label class="line-height-35">{{ trans('tasks.do_respite') }}</label>
                </td>
                <td>
                    <div id="respite_span">
                        <table class="table col-xs-12 no-padding no-margin">
                            <tr>
                                <td style="border-top: none;">
                                    <input type="radio" name="respite_timing_type" onclick="change_normal_task_timing_type(0)" value="0" checked/>
                                    <label for="r2">{{ trans('tasks.determination_doing_duration') }}</label>
                                    <input type="radio" name="respite_timing_type" onclick="change_normal_task_timing_type(1)" value="1"/>
                                    <label for="r1">{{ trans('tasks.determination_end_date') }}</label>
                                </td>
                                <td style="border-top: none;">
                                    <div id="normal_task_timing">
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
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="width-120">
                    <label class="line-height-35">{{ trans('tasks.responsible') }}</label>
                </td>
                <td>
                    <div class="row-fluid">
                        <div class="col-sm-7 row" style="padding-left: 0px;">
                            <select id="new_task_users" name="users[]" class="select2_auto_complete_user col-xs-12"
                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                <option value=""></option>
                            </select>
                            <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>


                        </div>
                        <div class="col-sm-5 line-height-35" style="padding-right: 5px;">

                            <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_users']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                            <input type="radio" name="assign_type" id="use_type1" class="person_option" value="1" checked/>
                            <label class="person_option" for="use_type1">{{ trans('tasks.collective') }}</label>
                            <input type="radio" name="assign_type" id="use_type2" class="person_option" value="2"/>
                            <label class="person_option" for="use_type2">{{ trans('tasks.individual') }}</label>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="width-120">
                    <label class="line-height-35">{{ trans('app.transcript') }}</label>
                </td>
                <td>
                    <div class="row-fluid">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row" style="padding-left: 0px;">
                            <select id="new_task_transcripts" name="transcripts[]" class="select2_auto_complete_transcripts"
                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple></select>
                            <span class=" Chosen-LeftIcon"></span>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 smaller-90 line-height-35" style="padding-right: 5px;">
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'new_task_transcripts']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                            <input type="checkbox" name="report_on_cr" id="report-type1"/>
                            <label for="">{{ trans('tasks.report_on_task_creation') }}</label>
                            <input type="checkbox" name="report_on_co" id="report-type2"/>
                            <label for="">{{ trans('tasks.report_on_task_completion') }}</label>
                            {{--<input type="checkbox" name="report_to_manager" id="report-type3"/>--}}
                            {{--<label for="">اطلاع به مسئولان</label>--}}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="width-120">
                    <label class="line-height-35">{{ trans('app.about') }}</label>
                </td>
                <td>
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
                <td></td>
                <td>
                    <div class="row-fluid">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                            <div class="form-inline">
                                <input type="checkbox" class="form-control" name="end_on_assigner_accept" id="manager"/>
                                <label for="date">{{ trans('tasks.modal_task_details_assignor_accept_or_ended') }}</label>
                                <input type="checkbox" class="form-control" name="transferable" id="manager"/>
                                <label for="date">{{ trans('tasks.modal_task_details_assignor_to_another') }}</label>
                            </div>
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
            <tr>
                <td class="width-120">
                    <label class="line-height-35">{{ trans('app.description') }}</label>
                </td>
                <td>
                    <div class="row-fluid">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 line-height-35">
                            <input type="text" class="form-control row" name="task_desc" id="desc" value="{{@$sel}}"/>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="draft" id="draft" value="0"/>
        <input type="hidden" name="first_m" id="first_m" value="0"/>
        <input type="hidden" name="first_u" id="first_u" value="0"/>
        <input type="hidden" name="assigner_id" value="125"/>
        <input type="hidden" id="save_type" name="save_type" value="0"/>
    </form>
    {!! $HFM_CN_Task['UploadForm'] !!}
</div>

<script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>

@include('hamahang.Tasks.helper.CreateNewTask.inline_js')
{!! $HFM_CN_Task['JavaScripts'] !!}