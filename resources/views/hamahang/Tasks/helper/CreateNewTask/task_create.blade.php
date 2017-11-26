<table class="table table-default col-xs-12">
    <tr>

        <td class="width-120">
            <label class="line-height-35">{{ trans('tasks.title') }}</label>
        </td>
        <td>
            <div class="row-fluid">
                <div class="col-sm-7 row">

                    <input type="text" class="form-control" name="title" id="title"/>
                </div>
                <div class="col-sm-5 line-height-35">
                    <div class="row">
                        <div class="col-xs-12">
                            <input type="radio" name="type" value="0" checked/>
                            <label for="r1">{{ trans('app.official') }}</label>
                            <input type="radio" name="type" value="1"/>
                            <label for="r2">{{ trans('app.unofficial') }}</label>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </td>
    </tr>
    <tr>
        <td>{{ trans('tasks.task_type') }}</td>
        <td>
            <div class="row">
                <div class="col-xs-12">
                    <input type="radio" id="use_type0" name="use_type" value="0" onclick="change_respite_type(0)" checked/>  <!-------- normal task  ---->
                    <label for="r1">{{ trans('tasks.ordinary_task') }}</label>
                    <input type="radio" id="use_type1" name="use_type" value="1" onclick="change_respite_type(1)"/>          <!-------- project task  ---->
                    <label for="r2">{{ trans('tasks.project_task') }}</label>
                    <input type="radio" id="use_type2" name="use_type" value="2" onclick="change_respite_type(2)"/>          <!-------- process task  ---->
                    <label for="r2">{{ trans('tasks.process_task') }}</label>
                    <div id="project_span" class="pull-right"></div>
                </div>
                <div class="clearfix"></div>
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
                    <input type="text" class="form-control row" name="task_desc" id="desc"/>
                    <div class="clearfix"></div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="width-120">
            <label class="line-height-35">{{ trans('tasks.do_respite') }}</label>
        </td>
        <td>
            <div id="respite_span">
				<table class="table col-xs-12">
					<tr>
						<td>
                            <input type="radio" name="respite_timing_type" onclick="change_normal_task_timing_type(0)" value="0" checked/>
                            <label for="r2">{{ trans('tasks.determination_doing_duration') }}</label>
							<input type="radio" name="respite_timing_type" onclick="change_normal_task_timing_type(1)" value="1" />
							<label for="r1">{{ trans('tasks.determination_end_date') }}</label>
						</td>

                        <td>
							<div id="normal_task_timing">
                                <div class="row-fluid">
                                       <div class=" col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                                               <div class="row-fluid">
                                                       <div class="col-sm-12 col-xs-12 form-inline">
                                                               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_day" id="duration_day" value="1" />
                                                               <label class="pull-right">روز</label>
                                                               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_hour" id="duration_hour" value="0" />
                                                               <label class="pull-right">ساعت</label>
                                                               <input class="form-control col-xs-1 pull-right" style="width: 55px" name="duration_min" id="duration_min" value="0" />
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
            <label class="line-height-35">{{ trans('tasks.importance') }} / {{ trans('tasks.immediacy') }}</label>
        </td>
        <td>
            <div class="row-fluid">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                    <div class="row">
                        <div class="col-xs-6">
                            <label>{{ trans('tasks.importance') }} :</label>
                            <span class="input-group" style="background-color: #eeeeee;">
                                <input type="radio" name="importance" value="1"/>
                                <label>{{ trans('tasks.important') }}</label>
                                <input type="radio" name="importance" value="0" checked/>
                                <label>{{ trans('tasks.unimportant')}}</label>
                            </span>
                        </div>
                        <div class="col-xs-6">
                            <label>{{ trans('tasks.immediacy') }} :</label>
                            <span class="input-group" style="background-color: #eeeeee">
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
    </tr>
    <tr>
        <td class="width-120">
            <label class="line-height-35">{{ trans('tasks.responsible') }}</label>
        </td>
        <td>
            <div class="row-fluid">
                <div class="col-sm-7 row">
                    <select name="users[]" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                        <option value=""></option>
                    </select>
                    <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                </div>
                <div class="col-sm-5 line-height-35">
                    <input type="radio" name="assign_type" id="use_type1" value="1" checked/>
                    <label for="use_type1">{{ trans('tasks.collective') }}</label>
                    <input type="radio" name="assign_type" id="use_type2" value="2"/>
                    <label for="use_type2">{{ trans('tasks.individual') }}</label>
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
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row">
                    <select name="transcripts[]" class="select2_auto_complete_transcripts" data-placeholder="{{trans('tasks.select_some_options')}}" multiple></select>
                    <span class=" Chosen-LeftIcon"></span>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 smaller-90 line-height-35">
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
            <label class="line-height-35">{{ trans('app.page') }}</label>
        </td>
        <td>
            <div class="row-fluid">
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row">
                    <select class="select2_auto_complete_page " name="pages[]" data-placeholder="{{trans('tasks.can_select_some_options')}}" multiple="multiple"></select>
                    <span class="fa fa-sticky-note Chosen-LeftIcon"></span>
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
                <div class="col-xs-12 row">
                    <select class="select2_auto_complete_keywords " name="keywords[]" data-placeholder="{{trans('tasks.can_select_some_options')}}" multiple="multiple"></select>
                    <span class=""></span>
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
        </td>
        <td>
            <div class="row-fluid">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-25">
                    {!! $HFM_CNT['Buttons']['CreateNewTask'] !!}
                    {!! $HFM_CNT['ShowResultArea']['CreateNewTask'] !!}
                </div>
            </div>
        </td>
    </tr>
</table>