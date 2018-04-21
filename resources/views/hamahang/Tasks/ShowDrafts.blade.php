@extends('layouts.master')
@section('csrf_token')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@stop


@section('specific_plugin_style')
	<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
	<link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
@stop

@section('content')

	<div class="container-fluid">
		@include('hamahang.Tasks.MyAssignedTask.helper.task_related_pages')
		<fieldset>
			<legend>{{trans('tasks.show_drafts_draft_lists')}}</legend>
			<div class="row">
				<div class="col-md-12 ">
					<table id="ChildsGrid" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th class="text-center">{{trans('tasks.id')}}</th>
							<th class="text-center"> {{trans('tasks.title')}}</th>
							<th class="text-center">{{trans('tasks.create_date')}}</th>
							<th class="text-center">{{trans('tasks.changes')}}</th>
							{{--<th>عملیات</th>--}}
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="modal fade" id="task_details" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title" style="color: #bbb"> {{trans('tasks.modal_task_details_header_title')}} <span style="color: #222" id="taskTitle"></span></h5>
				</div>
				<div class="modal-body">
					<!---------------->
					<div id="tab" class="container table-bordered" style="width: 95%">
						<ul class="nav nav-tabs">
							<li>
								<a href="#t1" data-toggle="tab" class="active">{{trans('tasks.modal_task_details_tabs_information')}}</a>
							</li>
							<li><a href="#t3" data-toggle="tab">{{trans('tasks.modal_task_details_tabs_enclosures')}}</a>
							</li>


							<li style="float: left">
								<h5 id="task_type" style="color: blue"></h5>
							</li>
						</ul>

						<div class="tab-content">
							<div class="tab-pane active" style="padding-top: 8px" id="t1">
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
												<label class="line-height-35"> {{trans('tasks.title')}}</label>
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
																<label for="r1">{{trans('tasks.modal_task_details_official')}}</label>
																<input type="radio" name="type" value="1"/>
																<label for="r2">{{trans('tasks.modal_task_details_unofficial')}}</label>
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
												<label class="line-height-35">{{trans('tasks.description')}}</label>
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
												<label class="line-height-35">{{trans('tasks.deadline')}}</label>
											</td>
											<td>
												<div class="row-fluid">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
														<div class=" row">
															<div class="col-sm-6 col-xs-12">
																<label class="line-height-30 pull-right">{{trans('taks.date')}}</label>
																<div class="input-group pull-right">
                                <span class="input-group-addon" id="respite_date">
                                    <i class="fa fa-calendar"></i>
                                </span>
																	<input type="text" class="form-control DatePicker" id="rpDate" name="respite_date"
																			aria-describedby="respite_date">
																</div>
															</div>
															<div class="col-sm-6 col-xs-12">
																<label class="line-height-30">{{trans('tasks.hour')}}</label>
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
												<label class="line-height-35">{{trans('tasks.modal_task_details_modal_task_details_importance')}}</label>
											</td>
											<td>
												<div class="row-fluid">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-35">
														<div class="row">
															<div class="col-xs-6">
																<label>{{trans('tasks.importance')}}</label>
                            <span class="input-group" style="background-color: #eeeeee;">
                                <input type="radio" name="importance" value="1" checked/>
                                <label>{{trans('tasks.important')}}</label>
                                <input type="radio" name="importance" value="0"/>
                                <label>{{trans('tasks.unimportant')}}</label>
                            </span>
															</div>
															<div class="col-xs-6">
																<label>{{trans('tasks.immediacy')}}</label>
                            <span class="input-group" style="background-color: #eeeeee">
                                <input type="radio" name="immediate" value="1"/>
                                <label>{{trans('tasks.immediate')}}</label>
                                <input type="radio" name="immediate" value="0"/>
                                <label>{{trans('tasks.urgent')}}</label>
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
												<label class="line-height-35">{{trans('tasks.responsible')}}</label>
											</td>
											<td>
												<div class="row-fluid">
													<div class="col-sm-7 row">
                                                    <span id="users">

                                                    </span>
														<span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
													</div>
													<div class="col-sm-5 line-height-35">
														<input type="radio" name="assign_type" id="use_type1" value="1" checked/>
														<label for="use_type1">{{trans('tasks.collective')}}</label>
														<input type="radio" name="assign_type" id="use_type2" value="2"/>
														<label for="use_type2">{{trans('tasks.individual')}}</label>
													</div>
													<div class="clearfix"></div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="width-120">
												<label class="line-height-35">{{trans('tasks.modal_task_details_modal_task_details_transcript')}}</label>
											</td>
											<td>
												<div class="row-fluid">
													<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 row">
                                                   <span id="transcripts">

                                                   </span>
														<span class=" Chosen-LeftIcon"></span>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 smaller-90 line-height-35">
														<input type="checkbox" name="report_on_cr" id="report-type1"/>
														<label for="">{{trans('tasks.modal_task_details_in_create_task')}}</label>

														<input type="checkbox" name="report_on_co" id="report-type2"/>
														<label for="">{{trans('tasks.modal_task_details_task_end_report')}}</label>
														{{--<input type="checkbox" name="report_to_manager" id="report-type3"/>--}}
														{{--<label for="">اطلاع به مسئولان</label>--}}
													</div>
													<div class="clearfix"></div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="width-120">
												<label class="line-height-35">{{trans('tasks.keywords')}}</label>
											</td>
											<td>
												<div class="row-fluid">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-25">
														<div class="form-inline">
															<input type="text" class="col-xs-12" id="tags" name="keyword[]" multiple/>
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
															<label for="date">{{trans('tasks.modal_task_details_assignor_accept_or_ended')}}</label>

															<input type="checkbox" class="form-control" name="transferable" id="transferable"/>
															<label for="date">{{trans('task.modal_task_details_assignor_to_another')}}</label>
														</div>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td></td>
											<td>
                                            <span class="pull-left">
                                            <a class="btn btn-default" onclick="CancelModify()">{{trans('tasks.dissuasion')}}</a>
                                            <a class="btn btn-info" onclick="save_as_draft()">{{trans('tasks.save_as_draft')}}</a>
                                            <a class="btn btn-info" onclick="publish_draft()">{{trans('tasks.publish')}}</a>
                                            </span>
											</td>
										</tr>
									</table>

									<input type="hidden" id="save_type" name="save_type" value="0"/>

								</form>
							</div>

							<div class="tab-pane" id="t3">
								<div class="row-fluid">
									<h5>
										<div class="hr dotted"></div>
									</h5>
									<div class="row-fluid">
										{!!  $HFM_TaskDrafts['Buttons']['TaskDrafts'] !!}
										{!!  $HFM_TaskDrafts['ShowResultArea']['TaskDrafts'] !!}
										<div class="col-xs-2">
											<a id="" class="btn btn-info pull-left" onclick="SaveNewFiles()">
												<i ></i>
												<span>{{trans('tasks.modal_task_details_add_attachs')}}</span>
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
											<th class="text-center">{{trans('tasks.id')}}</th>
											<th class="text-center">{{trans('tasks.title')}}</th>
											<th class="text-center">{{trans('filemanager.file_type')}}</th>
											<th class="text-center">{{trans('filemanager.file_size')}}</th>
											<th class="text-center">{{trans('filemanager.action')}}</th>
											{{--<th>دانلود</th>--}}
											{{--<th>عملیات</th>--}}
										</tr>
										</thead>
									</table>
								</div>

                                            <span class="pull-left">
                                            <a class="btn btn-default" onclick="CancelModify()">{{trans('filemanager.action')}}</a>
                                            </span>

							</div>

						</div>
					</div>

					<!---------------->
				</div>

			</div>
		</div>
	</div>
	<div class="modal fade" id="remove_confirm_modal" role="dialog">
		<div class="modal-dialog modal-xs">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" style="color:red;">{{trans('tasks.warning')}}</h4>
				</div>
				<div class="modal-body">
					<span id="modal_massage">{{trans('tasks.modal_t6ask_detail_delete_task_msg')}}</span>
				</div>
				<div class="modal-footer">
                    <span id="confirm_results">
                        <a class="btn btn-danger pull-left" onclick="RemoveDraft(1)">{{trans('tasks.delete_it')}} </a>
                        <a class="btn btn-default pull-left" style="margin-left: 3px" onclick="RemoveDraft('no')">{{trans('tasks.dissuasion')}}</a>
                    </span>
				</div>
			</div>
		</div>
	</div>
	{!! $HFM_TaskDrafts['UploadForm']!!}
@stop




@section('specific_plugin_scripts')

	<script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
	<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
	<script type="text/javascript" src="{{URL::to('assets/Packages/Grid/js/moderniz.2.8.1.js')}}"></script>
	<script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}"
			type="text/javascript"></script>
	<script>
		function CancelModify() {
			$('#task_details').modal('hide');
		}
		function SaveTask(SaveType) {

		}
		function SaveNewFiles() {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			var sendInfo = {
				tid: current_task
			};
			$.ajax({
				type: "POST",
				url: '{{ URL::route('hamahang.tasks.my_assigned_tasks.save_new_files') }}',
				dataType: "json",
				data: sendInfo,
				success: function (data) {

					HFM_LoadUploadedFiles('{!! enCode('TaskDrafts') !!}');
					refreshDraftFiles();
				}
			});

		}
		(function ($) {
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
            $(".select2_users").select2({
                minimumInputLength: 1,
                tags: false,
                dir: "rtl",
                width: '100%',
                ajax: {
                    url: "{{ route('auto_complete.users') }}",
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

            $("#tags").select2({
                minimumInputLength: 1,
                dir: "rtl",
                width: "100%",
                tags: true
            });

		})(jQuery);
		var table_chart_grid = "";
		var editor; // use a global for the submit and return data rendering in the examples
		var url = "{{ route('hamahang.tasks.my_assigned_tasks.fetch_drafts_list') }}";

		$(document).ready(function () {
			window.table_chart_grid = $('#ChildsGrid').DataTable();
			window.table_chart_grid2 = $('#draft_files_grid').DataTable();
			//editor = new $.fn.dataTables.Editor({});
			refreshDraftsDatatable();
		});
		$(document).on('click', '.update_task', function () {
			var save_type = $("input[name='new_task_save_type']:checked").val();
			$('#task_of_action').val('fffffffffffffff');
			var $this = $(this);
			var form_id = $this.data('form_id');
			var save_again = $this.data('again_save');
			if (save_type == 1) {
				UpdateTask(form_id, save_again,1);
			}
			else if (save_type == 0) {
				UpdateTask(form_id, save_again,0);
				//save_as_draft(form_id, save_again);
			}
			else
			{
				alert('{{ trans('tasks.the_save_type_is_not_selected') }}');
			}
		});
		var t2_default;
		var current_tab = '';
		var current_id = '';
		var current_task = '';

		function RemoveTaskDraftFile(id) {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			var sendInfo = {
				tid: current_task,
				fid: id
			};
			$.ajax({
				type: "POST",
				url: '{{ URL::route('hamahang.tasks.my_assigned_tasks.remove_task_draft_file') }}',
				dataType: "json",
				data: sendInfo,
				success: function (data) {
					refreshDraftFiles();
				}
			});

		}
		function RemoveDraft(id) {
			if (id == 'no') {
				$('#remove_confirm_modal').modal('hide');
			}
			else if (id == 1) {
				$('#remove_confirm_modal').modal('hide');
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				var sendInfo = {
					tid: current_task
				};
				$.ajax({
					type: "POST",
					url: '{{ URL::route('hamahang.tasks.my_assigned_tasks.remove_draft') }}',
					dataType: "json",
					data: sendInfo,
					success: function (data) {

						setTimeout(function () {
							location.reload();
						}, 400)


					}
				});
			}
		}
		function refreshDraftsDatatable() {


			var url = "{{ route('hamahang.tasks.my_assigned_tasks.fetch_drafts_list') }}";

			window.table_chart_grid.destroy();
			setTimeout(function () {
				{{--editor = new $.fn.dataTable.Editor( {--}}
						{{--ajax: "{{ route('hamahang.tasks.my_assigned_tasks.fetch_task_childs_list',['username'=> $uname ,'id'=>'/' ]) }}",--}}
						{{--table: "#ChildsGrid",--}}
						{{--fields: [ {--}}
						{{--label: "شناسه",--}}
						{{--name: "id"--}}
						{{--}--}}
						{{--]--}}
						{{--} );--}}

						window.table_chart_grid = $('#ChildsGrid').DataTable({

					"ajax": {
						"url": url,
						"type": "POST"
					},
					"autoWidth": false,
					"language": LangJson_DataTables,
					"processing": true,
					"serverside": true,
					columns: [
						{"data": "id"},
						{"data": "title"},
						{"data": "cr"},
						{
							"data": "id",
							"bSearchable": false,
							"bSortable": false,
							"mRender": function (data, type, full) {
								var id = full.id;
								//return '<span class="cursor-pointer" style="color: dodgerblue" onclick="modify_task(' + full.id + ')"><i class="fa fa-edit" ></i> ویرایش و انتشار</span>\n' +
								return '<span class="cursor-pointer" style="color: dodgerblue" ><a style="float: right;" class="jsPanels" href="/modals/ShowTaskForm?tid='+id+'" title="{{trans('tasks.show_task')}}">{{trans('tasks.show_task')}}</a></span>'+
                                '<span class="cursor-pointer" style="color: red" onclick="remove_task(' + full.id + ')"><i class="fa fa-remove" ></i>حذف</span>';
							}
						}
					]
				});
			}, 100);
		}
		function refreshDraftFiles() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var url = "{{ route('hamahang.tasks.my_assigned_tasks.fetch_draft_files',['id'=>'/' ]) }}" + "/" + current_task;

			window.table_chart_grid2.destroy();
			setTimeout(function () {

				window.table_chart_grid2 = $('#draft_files_grid').DataTable({

					"ajax": {
						"url": url,
						"type": "POST"
					},
					"autoWidth": false,
					"language": LangJson_DataTables,
					"processing": true,
					"serverside": true,
					columns: [
						{"data": "id"},
						{"data": "title"},
						{"data": "extension"},
						{"data": "size"},
//                        {"data": "cr", "width": "20%"},
						{
							"data": "ID_N",
							"mRender": function (data, type, full) {
								//console.log(data);
								//console.log(type);
								//console.log('f=>'+full);
								var id = full.id;
								if (data == null)
									data = 0;


								return "<a class='cls3' target='_self' style='margin: 2px'  href='{{ route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']) }}/" + full.ID_N + "'><i class=''></i></a>" + '<span class="cursor-pointer" style="color: red" onclick="RemoveTaskDraftFile(' + full.id + ')"><i class="fa fa-remove" ></i></span>';


//                                return '<div class="input-group pull-right">\
//                                <input type="text" class="form-control col-xs-8" id="weight' + full.id + '" onkeyup="enableChange(' + full.id + ')" value="' + data + '"/>\
//                                <span id="refreshBtn' + full.id + '" class="input-group-addon cursor-pointer" onclick="ChangeWeight(' + full.id + ')">\
//                                        <i class="fa fa-save"></i>\
//                                        </span>\
//                                        </div>';

//                                return "<div class='input-group pull-right' ><input type='text' class='form-control col-xs-8' id='weight"+full.id+"' value='"+data+"'/> \
//                                <span class='btn btn-default col-xs-3' onclick='ChangeWeight("+full.id+")'></span></div> ";
							}


						}
//                        {
//                            "data": "id", "width": "20%",
//                            "bSearchable": false,
//                            "bSortable": false,
//                            "mRender": function (data, type, full) {
//                                var id = full.id;
//                                return '<span class="cursor-pointer" style="color: dodgerblue" onclick="modify_task(' + full.id + ')"><i class="fa fa-edit" ></i> تغییر و بروزرسانی</span>';
//                            }
//                        },
//                        ,{
//                            "data": "id", "width": "20%",
//                            "bSearchable": false,
//                            "bSortable": false,
//                            "mRender": function (data, type, full) {
//                                var id = full.id;
//                                return '';
//                            }
//                        }
					]
				});
			}, 100);
		}

		function save_as_draft() {

			//$('#save_type').val(1);
			$('#task_public').attr('action', '{{ route('hamahang.tasks.resave_drafts') }}');
			$('#task_public').submit();
		}

		function modify_task(id) {

			current_task = id;
			//refreshDraftFiles();
			$('#current_task_id').val(current_task);
			$('#t2').html(t2_default);
			current_id = id;
			var sendInfo = {
				id: id
			};
			var imm = 'فوری';
			var imp = 'مهم';
			$.ajax({
				type: "POST",
				url: '{{ URL::route('hamahang.tasks.draft_info') }}',
				dataType: "json",
				data: sendInfo,
				success: function (data) {

					$('#title').val(data['title']);
					$('#taskTitle').html(data['title']);
					$('#desc').val(data['desc']);
					//$('.DatePicker').persianDatepicker('setDate',[1395,10,3]);
					$("input[name=importance][value=" + data['importance'] + "]").prop('checked', true);
					$("input[name=immediate][value=" + data['immediate'] + "]").prop('checked', true);
					$("input[name=type][value=" + data['type'] + "]").prop('checked', true);
					var employee = '';
					for (var i = 0; i < data['employee'].length; i++) {
						employee += '<option selected="selected" value="' + data['employee'][i]['id'] + '">' + data['employee'][i]['name'] + '</option>';
					}
					if (data['employee'].length < 1)
						employee = '';
					var users = '<select id="states-multi-select-users"\
                                name="users[]"\
                                class="select2_users col-xs-12"\
                                data-placeholder="{{trans('tasks.select_some_options')}}"\
                                multiple>' + employee + '</select>';
					$('#users').html(users);


					var transcript = '';
					for (var i = 0; i < data['transcript'].length; i++) {
						transcript += '<option selected="selected" value="' + data['transcript'][i]['id'] + '">' + data['transcript'][i]['name'] + '</option>';
					}
					var transcripts = '<select id="states-multi-select-transcripts"\
                                name="transcripts[]"\
                                class="select2_users col-xs-12"\
                                data-placeholder="{{trans('tasks.select_some_options')}}"\
                                multiple>' + transcript + '</select>';
					$('#transcripts').html(transcripts);
                    $("#states-multi-select-transcripts").select2({
                        minimumInputLength: 1,
                        tags: false,
                        dir: "rtl",
                        width: '100%',
                        ajax: {
                            url: "{{ route('auto_complete.users',['username'=>$uname]) }}",
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
					if (data['report_on_completion_point'])
						$('#report-type2').prop('checked', true);
					if (data['report_on_create_point'])
						$('#report-type1').prop('checked', true);

					if (data['end_on_assigner_accept'])
						$('#end_on_assigner_accept').prop('checked', true);
					if (data['transferable'])
						$('#transferable').prop('checked', true);
					$('#tags').importTags('');
                    $("#tags").select2({
                        minimumInputLength: 1,
                        dir: "rtl",
                        width: "100%",
                        tags: true
                    });
					for (var i = 0; i < data['kw'].length; i++)
						$('#tags').addTag(data['kw'][i]);
				}

			});
			var x = 0;
			{{--var url = "{{URL::route('hamahang.tasks.my_assigned_tasks.ShowDraftTaskFiles',['username'=>$uname])}}";--}}
			{{--$("#grid3").bootgrid("destroy");--}}
			{{--$("#grid3").bootgrid({--}}
			{{--ajax: true,--}}
			{{--url: url,--}}
			{{--selection: true,--}}
			{{--multiSelect: true,--}}
			{{--post: {id: id},--}}
			{{--formatters: {--}}
			{{--"link": function (column, row) {--}}
			{{--return "<a class='cls3' target='_self' style='margin: 2px'  href='{{ route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']) }}/" + row.ID_N + "'><i class='fa \--}}
			{{--fa-save'></i></a><a \--}}
			{{--+ style='margin:2px;' \--}}
			{{--+class='cls3'  onclick='RemoveChartItem(" + row.id + "," + id + ")' href=\"#\"><i class='fa fa-trash'></i></a>";--}}
			{{--},--}}
			{{--"row_no": function () {--}}
			{{--x++;--}}
			{{--return x;--}}
			{{--}--}}
			{{--}--}}
			{{--});--}}
			////////////////////////////////// childs grid

			//////////// DataTables
			refreshDraftFiles();
			$('#task_details').modal({show: true});
		}
		function publish_draft() {
			$('#task_public').attr('action', '{{ route('hamahang.tasks.publish_draft') }}');
			$('#task_public').submit();
		}
		function remove_task(id) {
			current_task = id;
			$('#remove_confirm_modal').modal({show: true});
		}

	</script>

	{!! $HFM_TaskDrafts['JavaScripts'] !!}
@stop


@include('sections.tabs')

@section('position_right_col_3')
	@include('sections.desktop_menu')
@stop