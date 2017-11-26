<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/TagsInput/css/jquery.tagsinput.rtl.css')}}">

<div class="row">
    <div class="space-14"></div>
    <fieldset>
        <legend>{{ trans('modal.process') }} </legend>
        <div class="col-xs-12" style="padding: 5px;">

            <div id="tab" class="container table-bordered" style="width: 95%;margin-bottom: 10px">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="#t1" data-toggle="tab" class="active">{{ trans('modal.define') }}</a>
                    </li>
                    <li>
                        <a href="#t4" data-toggle="tab">{{ trans('modal.process_task') }}</a>
                    </li>
                    <li>
                        <a href="#t2" data-toggle="tab">{{ trans('modal.access') }}</a>
                    </li>
                    <li>
                        <a href="#t3" data-toggle="tab">{{ trans('modal.report') }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" style="padding-top: 8px" id="t1">
                        <form id="process_form">
                            <table class="table table-striped">
                                <tr>
                                    <td>{{ trans('app.title') }}</td>
                                    <td>

                                        <input type="text" class="col-xs-4 form-control" id="p_title"/>
                                        <input type="radio" class="" name="p_type" value="0"/><label>{{ trans('modal.formal') }}</label>
                                        <input type="radio" class="" name="p_type" value="1"/><label>{{ trans('modal.informal') }}</label>

                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('modal.up_goals') }}</td>
                                    <td><input type="text" class="form-control" id="top_goals"/></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('modal.page') }}</td>
                                    <td>
                                        <div class="col-sm-12 row">
                                                    <span id="pages">
                                                        <div class="col-sm-12 row">
                                                <select class="js-data-example-ajax form-control" id="page_id" name="page_id" multiple>

											</select>
                                                <span style="position: absolute; left: 20px; top: 10px;" class="glyphicon glyphicon-file"></span>
                                            </div>
                                                    </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>توضیح</td>
                                    <td><input type="text" class="form-control" id="p_desc"/></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('modal.process_manager') }}</td>
                                    <td>
                                        <div class="col-xs-5">
                                            <div class="col-sm-7 row">
                                                <select id="p_responsible"
                                                        name="p_responsible[]"
                                                        class="chosen-rtl col-xs-12"
                                                        data-placeholder="{{trans('tasks.select_some_options')}}">
                                                    <option value=""></option>
                                                </select>
                                                <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                            </div>
                                        </div>
                                        <div class="col-xs-1">{{ trans('modal.organization_unit') }}</div>
                                        <div class="col-xs-6">
                                            <div class="col-sm-7 row">
                                                <select id="p_org_unit"
                                                        name="p_org_unit[]"
                                                        class="chosen-rtl col-xs-12"
                                                        data-placeholder="{{trans('tasks.select_some_options')}}">
                                                    <option value=""></option>
                                                </select>
                                                <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="width-120">
                                        <label class="line-height-35">{{ trans('modal.keywords') }}</label>
                                    </td>
                                    <td>
                                        <div class="col-sm-12 row">
                                                    <span id="users">
                                                        <div class="col-sm-12 row">
                                                <input type="text" class="col-xs-12" id="p_keyword" name="p_keyword[]" multiple/>
                                                <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                            </div>
                                                    </span>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-25">
                                                <div class="form-inline">

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </form>
                    </div>
                    <div class="tab-pane" style="padding-top: 8px" id="t4">
                        <table class="table col-xs-12">
                            <tr>
                                <td class="pull-left">
                                    <a class="cursor-pointer"><span class="fa fa-check-circle"></span>{{ trans('modal.select_task') }}</a> |
                                    <a class="cursor-pointer" onclick="CreateNewTask()"><span ></span>{{ trans('modal.create_new_task') }}</a>
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="tab-pane" id="t2" style="padding-top: 8px">
                        <table class="table table-default">
                            <tr>
                                <td class="col-xs-2">
                                    <h6>{{ trans('modal.edit_access') }}</h6>
                                </td>
                                <td class="col-xs-3">
                                    <input type="radio" value="all" id="PermissionType1" name="PermissionType" onclick="CheckType()"/><label>{{ trans('modal.all_users') }}</label>
                                    <input type="radio" value="some" id="PermissionType2" name="PermissionType" onclick="CheckType()"/><label>{{ trans('modal.permitted_users') }}</label>
                                </td>
                                <td class="col-xs-7">
                                    <div class="col-sm-7 row">
                                        <select id="ModifyPermissionUsers"
                                                name="ModifyPermissionUsers[]"
                                                class="chosen-rtl col-xs-12 "
                                                data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                            <option value=""></option>
                                        </select>

                                        <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                    </div>
                                </td>

                            </tr>
                        </table>
                        <table class="table table-default">
                            <tr>
                                <td class="col-xs-2">
                                    <h6>{{ trans('modal.read_access') }}</h6>
                                </td>
                                <td class="col-xs-3">
                                    <input type="radio" value="all" id="PermissionType1" name="PermissionType" onclick="CheckType()"/><label>ه{{ trans('modal.all_users') }}</label>
                                    <input type="radio" value="some" id="PermissionType2" name="PermissionType" onclick="CheckType()"/><label>{{ trans('modal.permitted_users') }}</label>
                                </td>
                                <td class="col-xs-7">
                                    <div class="col-sm-7 row">
                                        <select id="ObservePermissionUsers"
                                                name="ObservePermissionUsers[]"
                                                class="chosen-rtl col-xs-12 "
                                                data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                            <option value=""></option>
                                        </select>

                                        <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane" id="t3" style="padding-top: 8px">
                        <table class="table table-stripped">
                            <tr>
                                <td>{{ trans('modal.report') }}</td>
                                <td>

                                    <table class="table" dir="">
                                        <tr>
                                            <td><span class="">{{ trans('modal.from_date') }}</span><input class="form-control"/></td>
                                            <td>
                                                <span class="">{{ trans('modal.hour') }}</span>
                                                <div class="input-group">
                                                    <input type="text" class="DatePicker form-control " dir="rtl" id="DatePicker" name='respite_date_start'/>
                                                    <span class="input-group-addon">
                                                 <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                </div>
                                            </td>
                                            <td>
                                        <span>
                                           <span class="">{{ trans('modal.till_date') }}</span><input class="form-control"/>
                                        </span>
                                            </td>
                                            <td>
                                                <span class="">{{ trans('modal.hour') }}</span>
                                                <div class="input-group">
                                                    <input type="text" class="DatePicker form-control " dir="rtl" id="DatePicker" name='respite_date_end'/>
                                                    <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                </div>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>{{ trans('modal.total_development') }}<input type="text" id="progress_amount" class="form-control"/></div>
                                            </td>
                                            <td>
                                                <div>{{ trans('modal.duration') }}<input type="text" id="duration" class="form-control"/></div>
                                            </td>
                                            <td>
                                                <div>{{ trans('modal.variance') }}<input type="text" id="variance" class="form-control"/></div>
                                            </td>
                                            <td>
                                                <div>{{ trans('modal.inputs') }}<input type="text" id="" class="form-control"/></div>
                                            </td>
                                            <td>
                                                <div>{{ trans('modal.outputs') }}<input type="text" class="form-control"/></div>
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="row-fluid">

<span>

    </span>
                                    </div>
                                    <div class="row-fluid">

                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                    <span class="pull-left">

                        <input type="radio" name="save_type" value="0"/>
                        <label>{{ trans('modal.draft') }}</label>
                        <input type="radio" name="save_type" value="1"/>
                        <label>{{ trans('modal.final') }}</label>
                        <a class="btn btn-info" onclick="SaveNewProcess(2)">{{ trans('modal.confirm_and_register_new_process') }}</a>
                        <a class="btn btn-info" onclick="SaveNewProcess(1)">{{ trans('app.confirm') }}</a>
                    </span>
            </div>
        </div>
    </fieldset>
</div>
<div class="modal fade" id="task_details" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title" style="color: #bbb">{{ trans('modal.show_process_draft_info') }}<span style="color: #222" id="taskTitle"></span></h5>
            </div>
            <div class="modal-body">
                <!---------------->
                <div id="tab" class="container table-bordered" style="width: 95%">
                    <ul class="nav nav-tabs">
                        <li>
                            <a href="#tab1" data-toggle="tab" class="active">{{ trans('modal.information') }}</a>
                        </li>
                        <li><a href="#tab3" data-toggle="tab">{{ trans('modal.attaches') }}</a>
                        </li>


                        <li style="float: left">
                            <h5 id="task_type" style="color: blue"></h5>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" style="padding-top: 8px" id="tab1">
                            <form action="{{ route('hamahang.tasks.save_drafts') }}" class="" name="task_public" id="task_public" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="draft" id="draft" value="0"/>
                                <input type="hidden" name="first_m" id="first_m" value="0"/>
                                <input type="hidden" name="first_u" id="first_u" value="0"/>
                                <input type="hidden" name="assigner_id" value="125"/>
                                <input type="hidden" name="current_task_id" id="current_task_id" value=""/>
                                <table class="table table-striped col-xs-12">
                                    <tr>
                                        <td class="width-120">
                                            <label class="line-height-35">{{ trans('app.title') }}</label>
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
                                                            <label for="r1">{{ trans('modal.formal') }}</label>
                                                            <input type="radio" name="type" value="1"/>
                                                            <label for="r2">{{ trans('modal.informal') }}</label>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="width-120">
                                            <label class="line-height-35">{{ trans('modal.description') }}</label>
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
                                            <label class="line-height-35">{{ trans('modal.due_date') }}</label>
                                        </td>
                                        <td>
                                            <div class="row-fluid">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                                                    <div class=" row">
                                                        <div class="col-sm-6 col-xs-12">
                                                            <label class="line-height-30 pull-right">{{ trans('modal.date') }}</label>
                                                            <div class="input-group pull-right">
                                <span class="input-group-addon" id="respite_date">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                                                <input type="text" class="form-control DatePicker" id="rpDate" name="respite_date"
                                                                       aria-describedby="respite_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-xs-12">
                                                            <label class="line-height-30">{{ trans('modal.hour') }}</label>
                                                            <div class="input-group">
                                <span class="input-group-addon" id="respite_time">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                                                <input type="text" class="form-control TimePicker" name="respite_time"
                                                                       aria-describedby="respite_time">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="width-120">
                                            <label class="line-height-35">{{ trans('modal.importance_urgency') }}</label>
                                        </td>
                                        <td>
                                            <div class="row-fluid">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <label>{{ trans('modal.importance') }}</label>
                                                            <span class="input-group" style="background-color: #eeeeee;">
                                <input type="radio" name="importance" value="1" checked/>
                                <label>{{ trans('modal.important') }}</label>
                                <input type="radio" name="importance" value="0"/>
                                <label>{{ trans('modal.unimportant') }}</label>
                            </span>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <label>{{ trans('modal.urgency') }}</label>
                                                            <span class="input-group" style="background-color: #eeeeee">
                                <input type="radio" name="immediate" value="1"/>
                                <label>{{ trans('modal.urgent') }}</label>
                                <input type="radio" name="immediate" value="0"/>
                                <label>{{ trans('modal.non_urgent') }}</label>
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
                                            <label class="line-height-35">{{ trans('modal.responsible') }}</label>
                                        </td>
                                        <td>
                                            <div class="row-fluid">
                                                <div class="col-sm-7 row">
                                                    <span id="users">
                                                        <div class="col-sm-7 row">
                                                <select id="p_task_users"
                                                        name="p_task_users[]"
                                                        class="chosen-rtl col-xs-12"
                                                        data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                    <option value=""></option>
                                                </select>
                                                <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                            </div>
                                                    </span>
                                                </div>
                                                <div class="col-sm-5 line-height-35">
                                                    <input type="radio" name="assign_type" id="use_type1" value="1" checked/>
                                                    <label for="use_type1">{{ trans('modal.plural') }}</label>
                                                    <input type="radio" name="assign_type" id="use_type2" value="2"/>
                                                    <label for="use_type2">{{ trans('modal.individual') }}</label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="width-120">
                                            <label class="line-height-35">{{ trans('modal.transcript_to') }}</label>
                                        </td>
                                        <td>
                                            <div class="row-fluid">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row">
                                                   <span id="transcripts">

                                                    <span id="">
                                                        <div class="col-sm-7 row">
                                                <select id="p_task_transcripts"
                                                        name="p_task_transcripts[]"
                                                        class="chosen-rtl col-xs-12"
                                                        data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                    <option value=""></option>
                                                </select>
                                                <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                            </div>
                                                    </span>

                                                   </span>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 smaller-90 line-height-35">
                                                    <input type="checkbox" name="report_on_cr" id="report-type1"/>
                                                    <label for="">{{ trans('modal.at_task_creation') }}</label>

                                                    <input type="checkbox" name="report_on_co" id="report-type2"/>
                                                    <label for="">{{ trans('modal.end_task_report') }}</label>
                                                    {{--<input type="checkbox" name="report_to_manager" id="report-type3"/>--}}
                                                    {{--<label for="">اطلاع به مسئولان</label>--}}
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="width-120">
                                            <label class="line-height-35">{{ trans('modal.keywords') }}</label>
                                        </td>
                                        <td>
                                            <div class="row-fluid">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-25">
                                                    <div class="form-inline">
                                                        <input type="text" class="col-xs-12" id="p_task_keywords" name="p_task_keywords[]" multiple/>
                                                    </div>
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
                                                        <input type="checkbox" class="form-control" name="end_on_assigner_accept" id="end_on_assigner_accept"/>
                                                        <label for="date">{{ trans('modal.finnish_with_assignor_confirm') }}</label>

                                                        <input type="checkbox" class="form-control" name="transferable" id="transferable"/>
                                                        <label for="date">{{ trans('modal.assign_possibility') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <span class="pull-left">
                                            <a class="btn btn-default" onclick="CancelModify()">{{ trans('app.cancel') }}</a>
                                            <a class="btn btn-info" onclick="save_new_ptask()">{{ trans('app.register') }}</a>
                                            </span>
                                        </td>
                                    </tr>
                                </table>

                                <input type="hidden" id="save_type" name="save_type" value="0"/>

                            </form>
                        </div>

                        <div class="tab-pane" id="tab3">
                            <div class="row-fluid">
                                <h5>
                                    <div class="hr dotted"></div>
                                </h5>
                                <div class="row-fluid">
                                    {{--{!!  $HFM_TaskDrafts['Buttons']['TaskDrafts'] !!}--}}
                                    {{--{!!  $HFM_TaskDrafts['ShowResultArea']['TaskDrafts'] !!}--}}
                                    <div class="col-xs-2">
                                        <a id="" class="btn btn-info pull-left" onclick="SaveNewFiles()">
                                            <i ></i>
                                            <span>{{ trans('modal.add_attaches') }}</span>
                                        </a>
                                    </div>
                                    <div class="clearfixed"></div>
                                </div>
                                <h1>
                                    <div class="hr hr-double dotted"></div>
                                </h1>
                            </div>
                            <div class="hr"></div>
                            <div class="row-fluid">
                                <table id="draft_files_grid" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">{{ trans('modal.index') }}</th>
                                        <th class="text-center">{{ trans('app.title') }}</th>
                                        <th class="text-center">{{ trans('modal.file_type') }}</th>
                                        <th class="text-center">{{ trans('modal.file_size') }}</th>
                                        <th class="text-center">{{ trans('app.action') }}</th>
                                        {{--<th>دانلود</th>--}}
                                        {{--<th>عملیات</th>--}}
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <span class="pull-left">
                                            <a class="btn btn-default" onclick="CancelModify()">{{ trans('app.cancel') }}</a>
                                            </span>

                        </div>

                    </div>
                </div>

                <!---------------->
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/TagsInput/js/jquery.tagsinput.js')}}"></script>
<script>
    function CreateNewTask() {
        $('#task_details').modal({show: true});
    }

    function save_new_ptask() {

        $('#task_public').attr('action', '{{ route('hamahang.process.save_new_process_task') }}');
        $('#task_public').submit();
    }

    $(".js-data-example-ajax").select2({
        minimumInputLength: 1,
        tags: false,
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

    ///////////
    function SaveNewProcess(type) {
        var sendInfo = {
            p_title: $('#p_title').val(),
            p_type: $('input[name=p_type]:checked').val(),
            p_desc: $('#p_desc').val(),
            p_responsible: $('#p_responsible').val(),
            p_keyword: $('#p_keyword').val(),
            p_page: $('#page_id').val(),
            p_org_unit: $('#p_org_unit').val()

        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.process.save_new_process') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                if (type == 1) {
                    window.location = '{{ route('ugc.desktop.hamahang.process.list',['username'=>$uname]) }}';
                }
                else {

                    $('#process_form').trigger("reset");
                    $('#p_keyword').removeTag();
                    $('#p_org_unit').destroy();
                    $('#p_org_unit').ajaxChosen({
                        dataType: 'json',
                        type: 'POST',
                        url: "{{ route('hamahang.project.user_orgs') }}"
                    });

                }
            }
        });

    }
    function CheckType() {

        if ($('input[name=PermissionType]:checked').val() == 'some') {

            //$("#UserPermission" ).prop( "disabled", false );
            $("#UserPermission").removeAttr('disabled');
        }
        else {
            $("#UserPermission").attr('disabled', 'disabled');
            s
        }
    }
    (function ($) {
        $('#p_task_keywords').tagsInput
        ({
            'width': 'auto',
            'height': 'auto',
            'minChars': 0,
            'maxChars': 0, // if not provided there is no limit
            'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
            'interactive': true,
            'defaultText': '{{trans('tasks.enter_keywords')}}',
            'placeholderColor': '#777777',
            'removeWithBackspace': true,
        });
        $('#p_keyword').tagsInput
        ({
            'width': 'auto',
            'height': 'auto',
            'minChars': 0,
            'maxChars': 0, // if not provided there is no limit
            'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
            'interactive': true,
            'defaultText': '{{trans('tasks.enter_keywords')}}',
            'placeholderColor': '#777777',
            'removeWithBackspace': true,
        });
        $('#p_responsible').ajaxChosen({
            dataType: 'json',
            type: 'POST',
            url: "{{ route('autocomplete',['username'=>$uname]) }}"
        });

        $('#p_task_users').ajaxChosen({
            dataType: 'json',
            type: 'POST',
            url: "{{ route('autocomplete',['username'=>$uname]) }}"
        });

        $('#p_task_transcripts').ajaxChosen({
            dataType: 'json',
            type: 'POST',
            url: "{{ route('autocomplete',['username'=>$uname]) }}"
        });

        $('#p_org_unit').ajaxChosen({
            dataType: 'json',
            type: 'POST',
            url: "{{ route('hamahang.project.user_orgs') }}"
        });
        $('#ModifyPermissionUsers').ajaxChosen({
            dataType: 'json',
            type: 'POST',
            url: "{{ route('autocomplete',['username'=>$uname]) }}"
        });
        $('#ObservePermissionUsers').ajaxChosen({
            dataType: 'json',
            type: 'POST',
            url: "{{ route('autocomplete',['username'=>$uname]) }}"
        });
    })(jQuery);
</script>

