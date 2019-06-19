@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/OrgChart/dist/css/jquery.orgchart.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop

@section('content')
    <style>
        .hd-body{
            overflow: hidden !important;
        }
        .base_tabs{
            padding: 10px;
        }
    </style>
    <div class="row opacity-7" style="margin-top: -10px;background: #eee">
        <form id="form_filter_priority">
            <div class="row padding-bottom-20 opacity-7">
                <i class="fa fa-user int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="organs_staff_search" name="organs_staff_search[]" class="select2_auto_complete_staff col-xs-12"
                            data-placeholder="{{trans('org_chart.search_some_staff')}}" multiple>
                    </select>
                </div>
                <i class="fa fa-sitemap int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="organs_organs_search" class="select2_auto_complete_organs" name="select_org_lists[]"
                            data-placeholder="{{trans('org_chart.select_org_list')}}" multiple></select>
                </div>
                <i class="fa fa-sitemap int-icon1"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="organs_units_search" name="organs_units_search[]" class="select2_auto_complete_organ_units col-xs-12"
                            data-placeholder="{{trans('org_chart.search_some_unit')}}" multiple>
                    </select>
                </div>
            </div>
            <div class="row padding-bottom-20 opacity-7">
                <i class="fa fa-sitemap int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="organs_jobs_search" name="organs_jobs_search[]" class="select2_auto_complete_onet_jobs_item col-xs-12"
                            data-placeholder="{{trans('org_chart.search_some_job')}}" multiple>
                    </select>
                </div>
                <i class="fa fa-sitemap int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="organs_posts_search" name="organs_posts_search[]" class="select2_auto_complete_organ_posts col-xs-12"
                            data-placeholder="{{trans('org_chart.search_some_post')}}" multiple>
                    </select>
                </div>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">

                </div>
            </div>
        </form>
    </div>
    <div class="container-fluid noLeftPadding noRightPadding task-list-height" id="base_items_div">
        <div class="col-xs-12">
            <fieldset>
                <div id="OrgList">
                    {{--<legend>--}}
                        {{--<h3>--}}
{{--                            <span>{{ trans('org_chart.organizations_list') }}</span>--}}
                            {{--<a href="{!! route('modals.add_new_organ') !!}" class="jsPanels btn btn-default pull-left jspa btn-primary btn fa fa-plus"></a>--}}
                            {{--<div class="clearfix"></div>--}}
                        {{--</h3>--}}
                    {{--</legend>--}}
                    <div class="row-fluid">
                        <div class="col-lg-12">
                            <table id="OrgOrgansGrid" class="table dt-responsive nowrap display text-center" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    {{--<th>{{ trans('app.id') }}</th>--}}
                                    {{--<th>{{ trans('org_chart.creator') }}</th>--}}
                                    {{--<th>{{ trans('org_chart.organ') }}</th>--}}
                                    <th>{{ trans('app.title') }}</th>
                                    {{--<th>{{ trans('app.description') }}</th>--}}
                                    <th>{{ trans('org_chart.amount').' '.trans('org_chart.organizational_unit') }}</th>
                                    <th>{{ trans('org_chart.amount').' '.trans('org_chart.jobs') }}</th>
                                    <th>{{ trans('org_chart.amount').' '.trans('org_chart.position') }}</th>
                                    <th>{{ trans('org_chart.amount').' '.trans('org_chart.staff') }}</th>
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
        $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 40px; top: -3px;"><a href="{!! url('/modals/helpview?code=').enCode('332') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');

        $(".select2_auto_complete_organ_posts").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.org_charts_posts')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term,
                        item_id: $(this).attr('rel')
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
        $(".select2_auto_complete_onet_jobs_item").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.onet_jobs_items')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term,
                        item_id: $(this).attr('rel')
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
        $(".select2_auto_complete_organs").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.organs')}}",
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
        $(".select2_auto_complete_organ_units").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.units')}}",
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
        $(".select2_auto_complete_staff").select2({
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
                // "order": [[ 5, "desc" ]],
                "aaSorting": [],
                "bSortable": true,
                "autoWidth": false,
                "searching": false,
                "pageLength": 25,
                // "scrollY": 400,
                "language": LangJson_DataTables,
                "processing": false,
                columns: [
                    // {"data": "id"},
                    // {
                    //     "data": ["CreatorName"],
                    //     "mRender": function (data, type, full) {
                    //         //console.log(full.CreatorName);
                    //         if(full.CreatorName)
                    //             return full.CreatorName + " " + full.CreatorFamily;
                    //         else
                    //             return '';
                    //     }
                    // },
                    // {"data": "ParentTitle"},
                    {"data": "title"},
                    // {"data": "description"},
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {

                            return full.chartsCount.chartItemCount;
                        }
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {

                            return full.chartsCount.chartItemJobCount;
                        }
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {

                            return full.chartsCount.chartItemJobPostCount;
                        }
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {

                            return full.chartsCount.chartItemJobPostUserCount;
                        }
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            var oid = full.oid;
                            var title = full.title;
                            var description=full.description;
                            var level=full.level;

                            window.RowData[id] = full;
                            return "" +
                                '<a class="jsPanels fa fa-cog edit_btn margin-right-10" href="{!! route('modals.edit_organ')!!}?org_id='+oid+'&org_title='+title+'&org_description='+description+'&level='+level+'" data-toggle="tooltip" data-placement="top" title="{{trans('projects.settings')}}"></a>' +
                                (full.ChartID==null ?
                                    '<a class="jsPanels" href="{!! route('modals.manager_charts', ['org_id' =>'']) !!}'+oid+'"><i class="fa fa-object-group"></i></a>' :
                                    '<a class="fa fa-sitemap margin-right-10 showOrgChart pointer" add="{!! route('ugc.desktop.hamahang.org_chart.show_chart',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}/'+full.ChartID+'" rel="'+full.ChartID+'" data-toggle="tooltip" data-placement="top" title="{{trans('org_chart.chart_view')}}"></a>' +
                                    '<a class="fa fa-table margin-right-10 showOrglist pointer" add="{!! route('ugc.desktop.hamahang.org_chart.show_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}/'+full.ChartID+'" rel="'+full.ChartID+'" data-toggle="tooltip" data-placement="top" title="{{trans('org_chart.table_view')}}"></a>' +
                                    '<a class="fa fa-vcard margin-right-10 showJoblist pointer" add="{!! route('ugc.desktop.hamahang.org_chart.show_job_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}/'+full.ChartID+'" rel="'+full.ChartID+'" data-toggle="tooltip" data-placement="top" title="{{trans('org_chart.job_view')}}"></a>' +
                                    '<a class="fa fa-laptop margin-right-10 showPostlist pointer" add="{!! route('ugc.desktop.hamahang.org_chart.show_post_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}/'+full.ChartID+'" rel="'+full.ChartID+'" data-toggle="tooltip" data-placement="top" title="{{trans('org_chart.position_view')}}"></a>'
                                ) +
                                '<a class="link_pointer fa fa-trash color_red margin-right-10 color_red" style="font-size: 10px"  onclick="RemoveOrg(\'' + oid + '\')" data-toggle="tooltip" data-placement="top" title="{{trans('app.delete')}}"></a>'

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
        $(document).on('click', '.add_job_post', function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.org_chart.add_job_post')}}',
                dataType: "json",
                data: $('#add_job_post_frm').serialize(),
                success: function (result) {
                    if (result.success == true) {
                        $('#list_job_post').append('<tr><td class="col-xs-7">'+$('#select2-job-container').html()+'</td><td class="col-xs-4">'+$('#amount').val()+'</td><td class="col-xs-1">' +
                            '<i class="fa fa-remove margin-left-10 pointer remove_job" rel="'+$('#job').val()+'" ref="'+result.job_item+'" ></i>' +
                            '<i class="fa fa-edit pointer jsPanelsEditJob" href="{!! route('modals.add_new_post') !!}" rel="'+$('#amount').val()+'" ref="'+result.job_item+'" ></i>' +
                            '</td></tr>');
                        $.each(result.semats, function (index, semat) {
                            $('#list_positions').append('<tr><td class="col-xs-4">' + semat.title + '</td><td class="col-xs-3"></td><td class="col-xs-2"></td><td class="col-xs-2"></td><td class="col-xs-1">' +
                                '<i class="fa fa-remove margin-left-10 pointer remove_job" ref="'+semat.id+'" add="{{ route('hamahang.org_chart.delete_item_job') }}" ></i>' +
                                '<i class="fa fa-edit pointer edit_job jsPanelsEditPositions" post="'+semat.jobId+'" ></i>' +
                                '</td></tr>');
                        });
                    }
                    else {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                    }
                }
            });
        });
        $(document).on('click', '.remove_mission', function () {
            $(this).parent().parent().remove();
        });
        $(document).on('click', '#add_mission', function () {
            $('#mission_list').append('<div class="col-xs-12 margin-top-10"><div class="col-xs-2"></div><div class="col-xs-8"><input class="hidden" name="unit_missions[]" value="'+$('#mission').val()+'"/>'+$('#select2-mission-container').attr('title')+'</div><div class="col-xs-2"><i class="fa fa-remove remove_mission pointer"></i></div></div>')
        });
        $(document).on('click', '.showOrglist', function () {
            var url = '{!! route('ugc.desktop.hamahang.org_chart.show_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}' + '/' + $(this).attr('rel');
            $('.relatedOrg').attr('rel',$(this).attr('rel'));
            var rel = $(this).attr('rel');
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
                },
                complete: function (data) {
                    showOrglist(rel);
                }
            });
        });
        function  showOrglist(organ_id) {
            var send_info = {
                organ_id: organ_id
            };
            $('#ShowOrglistGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.org_chart.fetch_org_list') }}",
                    "type": "POST",
                    "data": send_info
                },
                "searching": false,
                "language": LangJson_DataTables,
                "processing": false,
                columns: [
                    {"data": "title"},
                    {"data": "description"},
                    {"data": "created_at"},
                    {
                        "data": "id",
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            return "<i class='fa fa-remove margin-left-10'></i> <i class='fa fa-edit'></i>";
                        }
                    }
                ]
            });
        }
        $(document).on('click', '.showJoblist', function () {
            var url = '{!! route('ugc.desktop.hamahang.org_chart.show_job_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}' + '/' + $(this).attr('rel');
            $('.relatedOrg').attr('rel',$(this).attr('rel'));
            var rel = $(this).attr('rel');
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
                },
                complete: function (data) {
                    ShowJoblist(rel);
                }
            });
        });
        function  ShowJoblist(organ_id) {
            var send_info = {
                organ_id: organ_id
            };
            $('#ShowJoblistGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.org_chart.fetch_job_list') }}",
                    "type": "POST",
                    "data": send_info
                },
                "searching": false,
                "language": LangJson_DataTables,
                "processing": false,
                columns: [
                    {"data": "title"},
                    {"data": "title_item"},
                    {"data": "describ"},
                    {"data": "amount"},
                    {
                        "data": "id",
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            return "<i class='fa fa-remove margin-left-10'></i> <i class='fa fa-edit'></i>";
                        }
                    }
                ]
            });
        }
        $(document).on('click', '.showPostlist', function () {
            var url = '{!! route('ugc.desktop.hamahang.org_chart.show_post_list',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}' + '/' + $(this).attr('rel');
            var rel = $(this).attr('rel');
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
                },
                complete: function (data) {
                    showPostlist(rel);
                }
            });
        });
        function  showPostlist(organ_id) {
            var send_info = {
                organ_id: organ_id
            };
            $('#ShowPostlistGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.org_chart.fetch_post_list') }}",
                    "type": "POST",
                    "data": send_info
                },
                "searching": false,
                "language": LangJson_DataTables,
                "processing": false,
                columns: [
                    {"data": "extra_title"},
                    {"data": "title_item"},
                    {"data": "title_job"},
                    {"data": "location"},
                    {"data": "share_performance"},
                    {"data": "outsourcing"},
                    {
                        "data": "id",
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            return "<i class='fa fa-remove margin-left-10'></i> <i class='fa fa-edit'></i>";
                        }
                    }
                ]
            });
        }
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

        var JS_Panel_1 ;
        $(document).on("click", ".jsPanelsEditPositions", function () {
            link = "{{route('modals.edit_show_post')}}";
            title = $(this).attr('title');
            item = $(this).attr('post');
            var h = $(window).height();
            var w = $(window).width();
            JS_Panel_2 = $.jsPanel({
                contentAjax: {
                    url: link,
                    method: 'POST',
                    dataType: 'json',
                    data: {post: item},
                    done: function (data, textStatus, jqXHR, panel) {
                        panel.headerTitle(data.header);
                        panel.content.html(data.content);
                        panel.toolbarAdd('footer', [{item: data.footer}]);
                    }
                },
                headerControls: {
                    minimize: 'disable',
                    smallify: 'disable'
                },
                headerTitle: title,
                contentOverflow: {horizontal: 'hidden', vertical: 'auto'},
                panelSize: {width: w * 0.7, height: h * 0.7},
                theme: 'default',
            });
            //JS_Panel.resize('1000px','500px');
            JS_Panel_2.content.html('<div class="loader"></div>');
            return false
        });
        var JS_Panel_2 ;
        $(document).on("click", ".jsPanelsPositions", function () {
            link = "{{route('modals.add_new_post')}}";
            title = $(this).attr('title');
            item = $(this).attr('item');
            modal = 'modal' == $(this).attr('modal') ? 'modal' : '';
            //get_height = $(this).attr('height');
            if (link.indexOf('share?sid') > 0)
                title = 'بازنشر';
            if (link.indexOf('print?sid') > 0)
                title = 'چاپ';
            var h = $(window).height();
            var w = $(window).width();
            JS_Panel_2 = $.jsPanel({
                contentAjax: {
                    url: link,
                    method: 'POST',
                    dataType: 'json',
                    data: {item_id: item},
                    done: function (data, textStatus, jqXHR, panel) {
                        //  this.content.append(jqXHR.responseText);
                        //console.log(data.content);
                        panel.headerTitle(data.header);
                        panel.content.html(data.content);
                        panel.toolbarAdd('footer', [{item: data.footer}]);
                        //panel.content.css({"width": "800px", "max-height": "550px", "height": hei, 'overflow-y': 'auto'});  ;
                    }
                },
                headerControls: {
                    minimize: 'disable',
                    smallify: 'disable'
                },
                headerTitle: title,
                contentOverflow: {horizontal: 'hidden', vertical: 'auto'},
                panelSize: {width: w * 0.7, height: h * 0.7},
                // contentSize: {width: "800px", height: hei},
                // position: {top: h, left: w},
                // position: 'center',
                theme: 'default',
                paneltype: modal,
            });
            //JS_Panel.resize('1000px','500px');
            JS_Panel_2.content.html('<div class="loader"></div>');
            return false
        });
        var JS_Panel_3 ;
        $(document).on("click", ".jsPanelsEditJob", function () {
            link = "{{route('modals.edit_job_unit')}}";
            job_id = $(this).attr('ref');
            title = $(this).attr('title');
            item = $(this).attr('item');
            var h = $(window).height();
            var w = $(window).width();
            JS_Panel_2 = $.jsPanel({
                contentAjax: {
                    url: link,
                    method: 'POST',
                    dataType: 'json',
                    data: {job_id: job_id},
                    done: function (data, textStatus, jqXHR, panel) {
                        //  this.content.append(jqXHR.responseText);
                        //console.log(data.content);
                        panel.headerTitle(data.header);
                        panel.content.html(data.content);
                        panel.toolbarAdd('footer', [{item: data.footer}]);
                        //panel.content.css({"width": "800px", "max-height": "550px", "height": hei, 'overflow-y': 'auto'});  ;
                    }
                },
                headerControls: {
                    minimize: 'disable',
                    smallify: 'disable'
                },
                headerTitle: title,
                contentOverflow: {horizontal: 'hidden', vertical: 'auto'},
                panelSize: {width: w * 0.7, height: h * 0.5},
                // contentSize: {width: "800px", height: hei},
                // position: {top: h, left: w},
                // position: 'center',
                theme: 'default',
                paneltype: modal,
            });
            //JS_Panel.resize('1000px','500px');
            JS_Panel_2.content.html('<div class="loader"></div>');
            return false
        });
        $(document).on("click", "#btn_insert_post", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.org_chart.insert_posts')}}',
                dataType: "json",
                data: $('#add_new_post_frm').serialize(),
                success: function (result) {
                    console.log(result);
                    if (result.success == true) {
                        $('#list_positions').append('<tr>'+
                                '<td class="col-xs-3">' + result.post.extra_title + '</td>'+
                                '<td class="col-xs-3">' + result.post.location + '</td>'+
                                '<td class="col-xs-3">' + result.post.share_performance + '</td>'+
                                '<td class="col-xs-2">' + result.post.outsourcing + '</td>' +
                                '<td class="col-xs-1">' +
                                    '<i class="fa fa-remove remove_post margin-left-10" rel="' + result.post.id + '"></i>' +
                                    '<i class="fa fa-edit edit_post margin-left-10" rel="' + result.post.id + '"></i>' +
                                '</td>' +
                            '</tr>');
                        JS_Panel_2.close();
                    } else {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                    }
                    setTimeout(function(){$("#alert_insert").html('') }, 4000);
                }
            });
        });
        $(document).on("click", "#btn_edit_post", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.org_chart.edit_post')}}',
                dataType: "json",
                data: $('#add_new_post_frm').serialize(),
                success: function (result) {
                    console.log(result);
                    if (result.success == true) {
                        JS_Panel_2.close();
                    } else {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                    }
                    setTimeout(function(){$("#alert_insert").html('') }, 4000);
                }
            });
        });
        $(document).on("click", "#btn_edit_job_unit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.org_chart.send_edit_job_unit')}}',
                dataType: "json",
                data: $('#add_new_post_frm').serialize(),
                success: function (result) {
                    console.log(result);
                    if (result.success == true) {
                        $('#list_positions').append('<tr>'+
                                '<td class="col-xs-3">' + result.post.extra_title + '</td>'+
                                '<td class="col-xs-3">' + result.post.location + '</td>'+
                                '<td class="col-xs-3">' + result.post.share_performance + '</td>'+
                                '<td class="col-xs-2">' + result.post.outsourcing + '</td>' +
                                '<td class="col-xs-1">' +
                                    '<i class="fa fa-remove remove_post margin-left-10" rel="' + result.post.id + '"></i>' +
                                    '<i class="fa fa-edit edit_post margin-left-10" rel="' + result.post.id + '"></i>' +
                                '</td>' +
                            '</tr>');
                        JS_Panel_2.close();
                    } else {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                    }
                    setTimeout(function(){$("#alert_insert").html('') }, 4000);
                }
            });
        });
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
