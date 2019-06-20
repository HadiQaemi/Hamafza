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
                    <input type="text" class="form-control int-btm-brd" style="padding: 6px 20px;" id="staff_name" name="staff_name" placeholder="{{trans('org_chart.search_some_staff')}}" autocomplete="off">
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
        <fieldset>
            <div id="OrgList">
                <div class="row-fluid">
                    <div class="col-lg-12">
                        <table id="StaffListGrid" class="table dt-responsive nowrap display text-center" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('org_chart.clerk') }}</th>
                                <th>{{ trans('org_chart.organization') }}</th>
                                <th>{{ trans('org_chart.organizational_unit') }}</th>
                                <th>{{ trans('org_chart.job') }}</th>
                                <th>{{ trans('org_chart.post') }}</th>
                                <th>{{ trans('app.action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </fieldset>
    </div>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
@stop
@section('inline_scripts')
    <script>
        (function($){
            $.fn.serializeObject = function(){

                var self = this,
                    json = {},
                    push_counters = {},
                    patterns = {
                        "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                        "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                        "push":     /^$/,
                        "fixed":    /^\d+$/,
                        "named":    /^[a-zA-Z0-9_]+$/
                    };


                this.build = function(base, key, value){
                    base[key] = value;
                    return base;
                };

                this.push_counter = function(key){
                    if(push_counters[key] === undefined){
                        push_counters[key] = 0;
                    }
                    return push_counters[key]++;
                };

                $.each($(this).serializeArray(), function(){

                    // skip invalid keys
                    if(!patterns.validate.test(this.name)){
                        return;
                    }

                    var k,
                        keys = this.name.match(patterns.key),
                        merge = this.value,
                        reverse_key = this.name;

                    while((k = keys.pop()) !== undefined){

                        // adjust reverse_key
                        reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                        // push
                        if(k.match(patterns.push)){
                            merge = self.build([], self.push_counter(reverse_key), merge);
                        }

                        // fixed
                        else if(k.match(patterns.fixed)){
                            merge = self.build([], k, merge);
                        }

                        // named
                        else if(k.match(patterns.named)){
                            merge = self.build({}, k, merge);
                        }
                    }

                    json = $.extend(true, json, merge);
                });

                return json;
            };
        })(jQuery);
        var table_organs_grid = "";
        var table_chart_grid = "";
        var RowData = [];
        var cur_org_id = '';
        $("#staff_name").keyup(function(e){
            var code = e.which; // recommended to use e.which, it's normalized across browsers
            if(code==32||code==13||code==188||code==186){
                window.table_organs_grid.destroy();
                var form_search_staff = $("#form_filter_priority").serializeObject();
                organs_grid(form_search_staff);
            } // missing closing if brace
        });
        function organs_grid(form_search_staff) {
            LangJson_DataTables = window.LangJson_DataTables;
            LangJson_DataTables.searchPlaceholder = '{{trans('tasks.search_in_task_title_placeholder')}}';
            LangJson_DataTables.sLoadingRecords = '<div class="loader preloader"></div>';
            window.table_organs_grid = $('#StaffListGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "serverSide": false,
                "ajax": {
                    "url": "{!! URL::route('hamahang.org_chart.fetch_all_staff_list',['username'=>$UName]) !!}",
                    "data" : form_search_staff,
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
                    {"data": "staff"},
                    {"data": "org"},
                    {"data": "item"},
                    {"data": "job"},
                    {"data": "post"},
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;

                            window.RowData[id] = full;
                            return "" +
                                "" +
                                "<a class='cursor-pointer jsPanels white-space margin-right-10' href='/modals/ViewStaffForm?sid="+full.staffId+"'><i class='fa fa-edit pointer'></i></a>" +
                                // "<a class='cursor-pointer jsPanels white-space margin-right-10' href='/modals/ViewStaffDoc?sid="+full.staffId+"'><i class='fa fa-file-text-o pointer'></i></a>" +
                                "<i class='fa fa-trash pointer remove_staff margin-right-10 color_red' title='حذف کارمند' data-toggle='tooltip' ref=" + full.staffId + " add='{{ route('hamahang.org_chart.delete_staff') }}'></i>" +
                                ""
                        }
                    }
                ]
            });
        }
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
        $(document).ready(function () {
            organs_grid({});
        });
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop