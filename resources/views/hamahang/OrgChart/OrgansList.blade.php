@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/OrgChart/dist/css/jquery.orgchart.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop

@section('content')
    <style>
        .base_tabs{
            padding: 10px;
        }
    </style>
    <div class="row-fluid">
        <div class="space-10"></div>
        <div class="col-xs-12">
            <fieldset>
                <div id="OrgList">
                    <legend>
                        <h3>
                            <span>{{ trans('org_chart.organizations_list') }}</span>
                            <a href="{!! route('modals.add_new_organ') !!}" class="jsPanels btn btn-default pull-left jspa btn-primary btn fa fa-plus"></a>
                            <div class="clearfix"></div>
                        </h3>
                    </legend>
                    <div class="row-fluid">
                        <div class="col-lg-12">
                            <table id="OrgOrgansGrid" class="table dt-responsive nowrap display text-center" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ trans('app.id') }}</th>
                                    <th>{{ trans('org_chart.creator') }}</th>
                                    <th>{{ trans('org_chart.organ') }}</th>
                                    <th>{{ trans('app.title') }}</th>
                                    <th>{{ trans('app.description') }}</th>
                                    <th>{{ trans('org_chart.create') }}</th>
                                    <th>{{ trans('app.action') }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="hidden">
                    <div class="col-xs-12 noLeftPadding noRightPadding">
                        <div class="col-xs-1"><i class="fa fa-arrow-left pointer" id="BackToOrgans" style="margin-top: 10px;"></i></div>
                        <div class="col-xs-9"></div>
                        <div class="col-xs-2 text-left">
                            <span class="fa fa-sitemap pointer showOrgChart relatedOrg" style="margin-right: 10px;font-size: 20px" data-toggle="tooltip" title="{{trans('org_chart.chart_view')}}"></span>
                            <span class="fa fa-table pointer showOrglist relatedOrg" style="margin-right: 10px;font-size: 20px" data-toggle="tooltip" title="{{trans('org_chart.table_view')}}"></span>
                            <span class="fa fa-vcard pointer showJoblist relatedOrg" style="margin-right: 10px;font-size: 20px" data-toggle="tooltip" title="{{trans('org_chart.job_view')}}"></span>
                            <span class="fa fa-laptop pointer showPostlist relatedOrg" style="margin-right: 10px;font-size: 20px" data-toggle="tooltip" title="{{trans('org_chart.position_view')}}"></span>
                        </div>
                    </div>
                    <div class="col-xs-12 noLeftPadding noRightPadding" id="OtherView"></div>
                </div>
            </fieldset>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="modal fade" id="ModalAddOrgan" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('org_chart.add_new_organization') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row-fluid" id="ModalContent">
                        <div id="add_organ_form_error"></div>
                        <form id="add_organ_form" action="#">
                            <div class="row-fluid">
                                <div class="form-group col-md-12">
                                    <label>
                                        <span class="required">*</span>
                                        <span>{{ trans('app.title') }}</span>
                                    </label>
                                    <input name="organ_title" id="root_item_title" class="form-control" required placeholder="">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>
                                        <span class="required">*</span>
                                        <span>{{ trans('org_chart.parent') }}</span>
                                    </label>
                                    <select id="organ_parent_id"
                                            name="organ_parent_id"
                                            class="chosen-rtl col-xs-11"
                                            data-placeholder="{{trans('tasks.select_some_options')}}"
                                    >
                                        <option id="default_parent_item" value="0">{{ trans('org_chart.main_parent') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label> <span>{{ trans('app.description') }}</span></label>
                                    <textarea name="organ_description" id="organ_description" class="form-control" placeholder=""></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('org_chart.cancel') }}</button>
                    <button onclick="create_new_organ()" class="btn btn-info" type="button">
                        <i ></i>
                        <span>{{ trans('app.register_and_save') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalEditOrgan" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('org_chart.edit_organization') }}<span>ss</span></h4>
                </div>
                <div class="modal-body">
                    <div class="row-fluid" id="ModalContent">
                        <div id="edit_organ_form_error"></div>
                        <form id="edit_organ_form" action="#">
                            <div class="row-fluid">
                                <div class="form-group col-md-12">
                                    <label>
                                        <span class="required">*</span>
                                        <span>{{ trans('app.title') }}</span>
                                    </label>
                                    <input name="organ_title" id="edit_organ_title" class="form-control" required placeholder="">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>
                                        <span class="required">*</span>
                                        <span>{{ trans('org_chart.parent') }}</span>
                                    </label>
                                    <select id="edit_organ_parent_id"
                                            name="organ_parent_id"
                                            class="chosen-rtl col-xs-11"
                                            data-placeholder="{{trans('tasks.select_some_options')}}">
                                        <option id="edit_default_parent_item" value="0">{{ trans('org_chart.main_parent') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label><span>{{ trans('app.description') }}</span></label>
                                    <textarea name="organ_description" id="edit_organ_description" class="form-control" placeholder=""></textarea>
                                </div>
                            </div>
                            <input id="EditOrganID" type="hidden" name="organ_id" value="">
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                    <button onclick="update_organ()" class="btn btn-warning" type="button">
                        <i class="fa  fa-edit"></i>
                        <span>{{ trans('app.register_and_edit') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ShowOrganCharts" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('org_chart.organizations_chart_list') }}<span id="ModalOrgTitle"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row-fluid" id="ModalContent">
                        <table id="OrgOrgansChartGrid" class="table table-striped table-bordered dt-responsive nowrap display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('app.id') }}</th>
                                <th>{{ trans('org_chart.creator') }}</th>
                                <th>{{ trans('app.title') }}</th>
                                <th>{{ trans('app.description') }}</th>
                                <th>{{ trans('org_chart.create') }}</th>
                                <th>{{ trans('app.action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-default pull-right" onclick="AddNewChart2()">{{ trans('org_chart.add_new_chart') }}</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('filemanager.cancel')}}</button>
                    <button id="NewTaskPackageSubmitBtn" name="upload_files" value="save" class="btn btn-info" type="button">
                        <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                        <span>{{ trans('app.register') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="AddNewChart" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('org_chart.add_new_chart') }}</h4>
                </div>
                <div class="modal-body">

                    <div class="panel panel-info">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <tr>
                                    <td>{{ trans('org_chart.chart_name') }}</td>
                                    <td><input type="text" class="form-control" id="NewChartTitle"/></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('app.description') }}</td>
                                    <td><input type="text" class="form-control" id="NewChartDesc"/></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row left">
                        <button id="NewChartSubmitBtn" onclick="SaveNewChart()" value="save" class="btn btn-info" type="button">
                            <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                            <span>{{ trans('app.register') }}</span>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('filemanager.cancel')}}</button>
                    <button id="NewChartSubmitBtn" onclick="SaveNewChart()" value="save" class="btn btn-info" type="button">
                        <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                        <span>{{ trans('app.register') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
@stop
@section('inline_scripts')
    <script>
        var table_organs_grid = "";
        var table_chart_grid = "";
        var RowData = [];
        var cur_org_id = '';

        function AddNewChart2() {
            $('#ShowOrganCharts').modal('hide');

            $('#AddNewChart').modal({show: true});

        }
        function organs_grid() {
            LangJson_DataTables = window.LangJson_DataTables;
            LangJson_DataTables.searchPlaceholder = '{{trans('tasks.search_in_task_title_placeholder')}}';
            LangJson_DataTables.sLoadingRecords = '<div class="loader preloader"></div>';
            window.table_organs_grid = $('#OrgOrgansGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "serverSide": false,
                "ajax": {
                    "url": "{!! URL::route('hamahang.org_chart.org_organs.ajax_org_organs',['username'=>$UName]) !!}",
                    "type": "POST"
                },
                "bSort": true,
                "order": [[ 5, "desc" ]],
                "aaSorting": [],
                "bSortable": true,
                "autoWidth": false,
                "searching": false,
                "pageLength": 25,
                // "scrollY": 400,
                "language": LangJson_DataTables,
                "processing": false,
                columns: [
                    {"data": "id"},
                    {
                        "data": ["CreatorName"],
                        "mRender": function (data, type, full) {
                            //console.log(full.CreatorName);
                            if(full.CreatorName)
                                return full.CreatorName + " " + full.CreatorFamily;
                            else
                                return '';
                        }
                    },
                    {"data": "ParentTitle"},
                    {"data": "title"},
                    {"data": "description"},
                    {"data": "created_at"},
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            var oid = full.oid;
                            var title = full.title;
                            var description=full.description;

                            window.RowData[id] = full;
                            return "" +
                                '<a class="link_pointer fa fa-trash color_red margin-right-10" style="font-size: 10px"  onclick="RemoveOrg(' + oid + ')" data-toggle="tooltip" data-placement="top" title="{{trans('app.delete')}}"></a>' +
                                '<a class="jsPanels fa fa-edit gray_light_color edit_btn margin-right-10" href="{!! route('modals.edit_organ')!!}?org_id='+oid+'&org_title='+title+'&org_description='+description+'" data-toggle="tooltip" data-placement="top" title="{{trans('app.edit')}}"></a>' +
                                (full.ChartID==null ?
                                    '<a class="jsPanels" href="{!! route('modals.manager_charts', ['org_id' =>'']) !!}'+oid+'"><i class="fa fa-object-group"></i></a>' :
                                    '<a class="fa fa-sitemap margin-right-10 showOrgChart pointer" add="{!! route('ugc.desktop.hamahang.org_chart.show_chart',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}/'+full.ChartID+'" rel="'+full.ChartID+'" data-toggle="tooltip" data-placement="top" title="{{trans('org_chart.chart_view')}}"></a>' +
                                    '<a class="fa fa-table margin-right-10 showOrglist pointer" add="{!! route('ugc.desktop.hamahang.org_chart.show_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}/'+full.ChartID+'" rel="'+full.ChartID+'" data-toggle="tooltip" data-placement="top" title="{{trans('org_chart.table_view')}}"></a>' +
                                    '<a class="fa fa-vcard margin-right-10 showJoblist pointer" add="{!! route('ugc.desktop.hamahang.org_chart.show_job_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}/'+full.ChartID+'" rel="'+full.ChartID+'" data-toggle="tooltip" data-placement="top" title="{{trans('org_chart.job_view')}}"></a>' +
                                    '<a class="fa fa-laptop margin-right-10 showPostlist pointer" add="{!! route('ugc.desktop.hamahang.org_chart.show_post_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}/'+full.ChartID+'" rel="'+full.ChartID+'" data-toggle="tooltip" data-placement="top" title="{{trans('org_chart.position_view')}}"></a>'
                                )

                                /*'<a style="font-size: 10px" onClick="OpenModalListOrganCharts(' + id + ',' + '"' + title + '"' + ')">' +
                                '   <i class="fa fa-object-group"></i>' +
                                '  {{--  {{ trans('org_chart.charts') }}--}}' +
                                '</a>' +
                                '<span> | </span>' +
                                '<a style="font-size: 10px"  onclick="OpenModalAddChart(' + id + ')">' +
                                '   <i ></i>' +

                                '   <span>{{--{{ trans('org_chart.create_chart') }}--}}</span>' +
                                '</a>'*/
                                ;
                        }
                    }
                ]
            });
        }
        function SaveNewChart() {
            var sendInfo = {

                oid: cur_org_id,
                title: $('#NewChartTitle').val(),
                desc: $('#NewChartDesc').val()

            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.org_chart.add_new_chart') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
                    alert('{{ trans('org_chart.new_chart_added') }}');
                    $('#AddNewChart').modal('hide');
                    organs_grid();
                    OpenModalListOrganCharts(cur_org_id, 'salam');
                    $('#ShowOrganCharts').modal({show: true});
                }
            });

        }
        $(document).on('click', '.showOrgChart', function () {
            var url = '{!! route('ugc.desktop.hamahang.org_chart.show_chart',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}' + '/' + $(this).attr('rel');
            $('.relatedOrg').attr('rel',$(this).attr('rel'));
            $.ajax({
                type: "GET",
                url: url,
                dataType: "html",
                data: {},
                success: function (data) {
                    $('#OtherView').html(data);
                    $('#OtherView').parent().removeClass('hidden');
                    $('#OrgList').addClass('hidden');
                    $('.relatedOrg.showOrgChart').attr('add',$(this).attr('add'));
                    $('.relatedOrg').attr('rel',$(this).attr('rel'));
                    $('.relatedOrg').removeClass('current_page');
                    $('.relatedOrg.showOrgChart').addClass('current_page');
                }
            });
        });
        $(document).on('click', '.showOrglist', function () {
            var url = '{!! route('ugc.desktop.hamahang.org_chart.show_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}' + '/' + $(this).attr('rel');
            $('.relatedOrg').attr('rel',$(this).attr('rel'));
            $.ajax({
                type: "GET",
                url: url,
                dataType: "html",
                data: {},
                success: function (data) {
                    $('#OtherView').html(data);
                    $('#OtherView').parent().removeClass('hidden');
                    $('#OrgList').addClass('hidden');
                    $('.relatedOrg.showOrglist').attr('add',$(this).attr('add'));
                    $('.relatedOrg').attr('rel',$(this).attr('rel'));
                    $('.relatedOrg').removeClass('current_page');
                    $('.relatedOrg.showOrglist').addClass('current_page');
                }
            });
        });
        $(document).on('click', '.showJoblist', function () {
            var url = '{!! route('ugc.desktop.hamahang.org_chart.show_job_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}' + '/' + $(this).attr('rel');
            $('.relatedOrg').attr('rel',$(this).attr('rel'));
            $.ajax({
                type: "GET",
                url: url,
                dataType: "html",
                data: {},
                success: function (data) {
                    $('#OtherView').html(data);
                    $('#OtherView').parent().removeClass('hidden');
                    $('#OrgList').addClass('hidden');
                    $('.relatedOrg.showJoblist').attr('add',$(this).attr('add'));
                    $('.relatedOrg').attr('rel',$(this).attr('rel'));
                    $('.relatedOrg').removeClass('current_page');
                    $('.relatedOrg.showJoblist').addClass('current_page');
                }
            });
        });
        $(document).on('click', '.showPostlist', function () {
            var url = '{!! route('ugc.desktop.hamahang.org_chart.show_post_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}' + '/' + $(this).attr('rel');
            $('.relatedOrg').attr('rel',$(this).attr('rel'));
            $.ajax({
                type: "GET",
                url: url,
                dataType: "html",
                data: {},
                success: function (data) {
                    $('#OtherView').html(data);
                    $('#OtherView').parent().removeClass('hidden');
                    $('#OrgList').addClass('hidden');
                    $('.relatedOrg.showPostlist').attr('add',$(this).attr('add'));
                    $('.relatedOrg').attr('rel',$(this).attr('rel'));
                    $('.relatedOrg').removeClass('current_page');
                    $('.relatedOrg.showPostlist').addClass('current_page');
                }
            });
        });
        $(document).on('click', '#BackToOrgans', function () {
            $('#OtherView').parent().addClass('hidden');
            $('#OrgList').removeClass('hidden');
        });
        function OpenModalAddChart(id) {

            cur_org_id = id;
            $('#AddNewChart').modal({show: true});
            $('#btn_insert_chart').css('display','inline');

        }
        function RemoveOrg(id) {
            confirmModal({
                title: '{{ trans('org_chart.delete_organ') }}',
                message: '{{ trans('app.are_you_sure') }}',
                onConfirm: function () {
                    var sendInfo = {
                        id: id
                    };
                    $.ajax({
                        type: "POST",
                        url: '{{ URL::route('hamahang.org_chart.Remove_organ') }}',
                        dataType: "json",
                        data: sendInfo,
                        success: function (data) {

                            window.table_organs_grid.destroy();
                            organs_grid();

                        }
                    });
                },
                afterConfirm: 'close'
            });
        }

        function OpenModalEditOrgan(id) {
            var DataInfo = window.RowData[id];
            $("#edit_organ_title").val(DataInfo.title);
            $("#edit_organ_description").val(DataInfo.description);
            $("#EditOrganID").val(id);
            $('#edit_organ_parent_id').chosen('destroy');
            $("#edit_organ_parent_id #edit_default_parent_item").val(DataInfo.parent_id);
            $("#edit_organ_parent_id #edit_default_parent_item").text(DataInfo.ParentTitle);
            $('#edit_organ_parent_id').ajaxChosen({
                dataType: 'json',
                type: 'POST',
                url: "{{ route('auto_complete.organs') }}"
            });
            $('#ModalEditOrgan').modal({show: true});
        }




        function OpenModalListOrganCharts(id, title) {
            alert('ggg');
            cur_org_id = id;
            $('#ModalOrgTitle').text(title);
            window.table_chart_grid.destroy();
            setTimeout(function () {
                window.table_chart_grid = $('#OrgOrgansChartGrid').DataTable({
                    "dom": window.CommonDom_DataTables,
                    "ajax": {
                        "url": "{!! URL::route('hamahang.org_chart.ajax_org_charts',['OrgID'=>'']) !!}/" + id,
                        "type": "POST"
                    },
                    "language": LangJson_DataTables,
                    "processing": true,
                    columns: [
                        {"data": "id"},
                        {
                            "data": "CreatorName",
                            "mRender": function (data, type, full) {
                                return full.CreatorName + " " + full.CreatorFamily;
                            }
                        },

                        {"data": "title"},
                        {"data": "description"},
                        {"data": "created_at"},
                        {
                            "data": "id",
                            "bSearchable": false,
                            "bSortable": false,
                            "mRender": function (data, type, full) {
                                var id = full.id;
                                return "<button class='btn btn-info btn-block' onClick='charts_location_href(" + id + ")'>" +
                                    "<i class='fa fa-edit'></i>" +
                                    "<span> " +
                                    "{{ trans('app.see_edit') }}" +
                                    "</span>" +
                                    "</button>";
                            }
                        }
                    ]
                });
            }, 100);
            $('#ShowOrganCharts').modal({show: true});
        }
        function charts_location_href(id) {
            var href = "{{URL::route('ugc.desktop.hamahang.org_chart.show_chart',['username'=>$UName,'ChartID'=>''])}}/" + id;
            window.location = href;
        }
        function create_new_organ() {
            $.ajax({
                type: "POST",
                url: '{{URL::route('hamahang.org_chart.create_organ')}}',
                data: $("#add_organ_form").serialize(),
                dataType: "json",
                success: function (result) {
                    $('#add_organ_form_error').empty();
                    if (result.success == true) {
                        $('#add_organ_form').trigger("reset");
                        $('#ModalAddOrgan').modal('hide');
                        setTimeout(function () {
                            window.table_organs_grid.destroy();
                            organs_grid();
                        }, 200);
                        organs_grid();
                    }
                    else {
                        var ul = document.createElement('ul');

                        var target = result.error;
                        for (var k in target) {
                            if (target.hasOwnProperty(k)) {
                                var li = document.createElement('li');
                                li.append(target[k]);
                                ul.appendChild(li);
                                console.log(li);
                            }
                        }

                        $('#add_organ_form_error').append(ul);
                    }
                }
            });
        }
        function update_organ() {
            $.ajax({
                type: "POST",
                url: '{{URL::route('hamahang.org_chart.update_organ')}}',
                data: $("#edit_organ_form").serialize(),
                dataType: "json",
                success: function (result) {
                    $('#edit_organ_form_error').empty();
                    if (result.success == true) {
                        $('#edit_organ_form').trigger("reset");
                        $('#ModalEditOrgan').modal('hide');
                        setTimeout(function () {
                            window.table_organs_grid.destroy();
                            organs_grid();
                        }, 200);
                    }
                    else {
                        var ul = document.createElement('ul');

                        var target = result.error;
                        for (var k in target) {
                            if (target.hasOwnProperty(k)) {
                                var li = document.createElement('li');
                                li.append(target[k]);
                                ul.appendChild(li);
                                console.log(li);
                            }
                        }

                        $('#edit_organ_form_error').append(ul);
                    }
                }
            });
        }
        /* $(document).on('click', '.edit_btn', function(){
             var title=$(this).attr('data_title');
             var description=$(this).attr('data_description');

             setTimeout(function(){
                 $("#root_item_title").val(title);
                 $("#organ_description").val(description);
                 }, 1000);

         });*/
        $(document).ready(function () {
            organs_grid();
            $(document).on('click', '#btn_add_Organs', function () {
                //$('#ModalAddOrgan').modal({show: true});
            });
            $('#organ_parent_id').ajaxChosen({
                dataType: 'json',
                type: 'POST',
                url: "{{ route('auto_complete.organs') }}"
            });
            $('#edit_organ_parent_id').ajaxChosen({
                dataType: 'json',
                type: 'POST',
                url: "{{ route('auto_complete.organs') }}"
            });
            window.table_chart_grid = $('#OrgOrgansChartGrid').DataTable();
        });
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
