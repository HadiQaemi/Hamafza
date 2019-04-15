<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/OrgChart/dist/css/jquery.orgchart.css')}}">
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}"/>
<style>
    .onclick-menu-content {
        position: absolute;
        z-index: 999999;
        display: none;
    }
    .span_title{
        font-size: 17px;
    }
    .p_body_scrool{
        overflow-y: auto;
        overflow-x:hidden;
        height: 80vh;
        max-height: 100vh;
        height: auto;
        direction: ltr;
    }
</style>
<div class="row-fluid">
    <div class="row" style="height:25px;"></div>
    <div class="col-xs-12">
    <div>
{{--        <span class="span_title">{{ trans('org_chart.edit_organization_chart') }} </span>--}}
        {{--<span  class="span_title" id="ChartTitle">{{$Chart->title}}</span>--}}
        {{--<a href="{!! route('modals.edit_chart',['chart_title'=>$Chart->title,'chart_id'=>$Chart->id])!!}" class="jsPanels pull-left btn btn-default"  >--}}
            {{--<span>{{ trans('org_chart.edit_chart_main_info') }}</span>--}}
        {{--</a>--}}
        {{--<button class="pull-left btn btn-default" type="button" id="add_root_item">--}}
            {{--<i ></i>--}}
            {{--<span>{{ trans('org_chart.register_main_unit') }}</span>--}}
        {{--</button>--}}
    </div>
        <hr>
        <div class="panel panel-info" style="border:0px;">
            <div class="panel-body p_body_scrool">

                <div id="chart-container" style="direction: ltr; text-align: center;"></div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div tabindex="0" class="onclick-menu">
    <div id="onclick-menu-content" class="onclick-menu-content">
        <div class=""
             style="border-radius: 8px;padding: 10px;width: 300px;border: solid blue medium; background-color: #bbdefb;text-align: center;font-size: 12px">
            <h5>{{ trans('org_chart.set_employee') }}</h5>
            <select onchange="" id="select-user"
                    name="users"
                    class="chosen-rtl col-xs-12"
                    data-placeholder="{{trans('tasks.select_some_options')}}">
                <option value=""></option>
            </select>

            <a onclick="hide_menu()" class="btn btn-default" style="margin-top: 10px;">{{ trans('org_chart.cancel') }}</a>
            <a onclick="add_post_user()" class="btn btn-info" style="margin-top: 10px;">{{ trans('org_chart.confirm') }}</a>
        </div>
    </div>
</div>
@include('hamahang.OrgChart.helper.OrgChartShow.modals')

<script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/OrgChart/dist/js/jquery.orgchart.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/Grid/js/moderniz.2.8.1.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.fa.js')}}"></script>
<script>
    window.ItemChildrenGrid = $('#ItemChildrenGrid').DataTable();
    $(document).ready(function () {
    });

    var datatable_list_item_chart;
    var chart_datatable;

    $(document).ready(function () {
        $("#tab_charts").click(function(){
            $(".footer_base_div_btn").html('' +
                '<button class="btn btn-info pull-left" onclick="update_chart_item(\'close\')" id="btn_update_chart_item">ذخیره وبستن</button>'+
                '<button class="btn btn-info pull-left" onclick="update_chart_item(\'notclose\')" id="btn_update_chart_item">ذخیره </button>'
            );
        });
        $("#tab_insert_post").click(function(){
            $(".footer_base_div_btn").html('' +
                '<button class="btn btn-info pull-left" onclick="insert_post(\'close\')" >ثبت وبستن</button>'+
                '<button class="btn btn-info pull-left" onclick="insert_post(\'notclose\')" >ثبت سمت</button>'
            );
        });
        $("#tab_insert_items").click(function(){
            $(".footer_base_div_btn").html('' +
                '<button class="btn btn-info pull-left" onclick="insert_chart_item(\'close\')">ثبت وبستن</button>'+
                '<button class="btn btn-info pull-left" onclick="insert_chart_item(\'notclose\')">ثبت</button>'
            );
        });
        $("#tab_post").click(function(){
            $(".footer_base_div_btn").html('');
        });
        $("#tab_item").click(function(){
            $(".footer_base_div_btn").html('');
        });
        chart_datatable = $('#list_post').DataTable({
            "dom": window.CommonDom_DataTables,
            processing: true,
            language: LangJson_DataTables,
            serverSide: true,
            ajax: {
                url: '{!! route('Hamahang.charts.ListPost',['chart_item_id'=>'']) !!}' + $("#input_add_item_id").val() + '',
                type: 'post'
            },
            columns: [
                {data: 'title', name: 'title'},
                {
                    data: 'employee.Family', name: 'employee', "orderable": "false", searchable: false,
                    "mRender": function (data, type, full) {
                        if (data) {
                            return data;
                        }
                        else return '';
                        //return data;
                    }
                },
                {
                    data: 'user_id', name: '', "orderable": "false", searchable: false, width: '280px',

                    "mRender": function (data, type, full) {
                        if (data == 0) {
                            return '<span id="span_add_employee' + full.id + '" class="cursor-pointer color_red" onclick="show_add_form(' + full.id + ')">انتخاب</span>' +

                                '<div id="div_base_' + full.id + '"></div>';
                        }
                        else {
                            return '<span id="span_edit_employee' + full.id + '" class="cursor-pointer color_red" onclick="show_add_form(' + full.id + ')">ویرایش/حذف</span>' +
                                '<div id="div_base_' + full.id + '"></div>';

                        }
                    }
                }
            ]
        });
        datatable_list_item_chart = $("#datatable_ItemChildrenGrid").DataTable({
            "dom": window.CommonDom_DataTables,
            language: LangJson_DataTables,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('Hamahang.charts.ListOrganChartItem',['chart_item_id'=>'']) !!}' + $("#input_add_item_id").val() + '',
                type: 'post'
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
            ]
        });
    });
    function update_chart_item(stata1){
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.org_chart.update_one_chart_item')}}',
            dataType: "json",
            data: $('#Form_Update_Item').serialize(),
            success: function (result) {
                if (result.success == true) {
                    var msg = 'انجام شد';
                    messageBox('success', msg, '', {'id': 'alert_edit'});
                    chart_datatable.ajax.reload();
                    $("#insert_new_post_title").val('');
                    $("#insert_new_post_description").val('');
                    if(stata1=='close'){
                        $('.jsglyph-close').click();
                    }
                    load_orgchart();
                }
                else {
                    messageBox('error', '', result.error, {'id': 'alert_insert_post'}, 'hide_modal');

                }
                setTimeout(function () {
                    $("#alert_insert_post").html('')
                }, 4000);
            }
        });
    }
</script>
@include('hamahang.OrgChart.helper.OrgChartShow.InlineJS')


