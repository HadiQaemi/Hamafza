<script>

    $("#item_parent_id").select2({
        ajax: {
            type: "POST",
            url: '{!! route('auto_complete.chart_items') !!}',
            dataType: 'json',
            data: function (params) {
                return params
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item, i) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            },
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
    });
    var datatable_list_item_chart;
    var chart_datatable;

    $(document).ready(function () {
        // $("#tab_charts").click(function(){
        //     $(".footer_base_div_btn").html('' +
        //         '<button class="btn btn-info pull-left" onclick="update_chart_item(\'close\')" id="btn_update_chart_item">ذخیره وبستن</button>'+
        //          '<button class="btn btn-info pull-left" onclick="update_chart_item(\'notclose\')" id="btn_update_chart_item">ذخیره </button>'
        //     );
        // });
        // $("#tab_insert_post").click(function(){
        //     $(".footer_base_div_btn").html('' +
        //         '<button class="btn btn-info pull-left" onclick="insert_post(\'close\')" >ثبت وبستن</button>'+
        //         '<button class="btn btn-info pull-left" onclick="insert_post(\'notclose\')" >ثبت سمت</button>'
        //     );
        // });
        // $("#tab_insert_items").click(function(){
        //     $(".footer_base_div_btn").html('' +
        //         '<button class="btn btn-info pull-left" onclick="insert_chart_item(\'close\')">ثبت وبستن</button>'+
        //         '<button class="btn btn-info pull-left" onclick="insert_chart_item(\'notclose\')">ثبت</button>'
        //         );
        // });
        // $("#tab_post").click(function(){
        //     $(".footer_base_div_btn").html('');
        // });
        // $("#tab_item").click(function(){
        //     $(".footer_base_div_btn").html('');
        // });
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

    function show_add_form(id) {

        var form = '<form  class="form_add_employee" id="form_add_employee' + id + '">' +
            '<div class="col-sm-9" style="padding-right: 0px;">' +
            '<input type="hidden" name="post_id" value="' + id + '">' +
            '<select id="select_employee' + id + '" name="employ_id" class="js-states form-control pull-left" style="width: 100%;"></select></div>' +
            '<div class="col-sm-3" style="padding: 0px;">' +
            '<button type="button" class="btn btn-info btn-xs" onclick="add_employ(' + id + ')">ثبت</button>' +
            '<button class="btn btn-sm-default btn-xs" onclick="cancel_add_employ(' + id + ')">لغو</button >' +
            '</div>' +
            '</form>';
        $('#div_base_' + id).html(form);
        $("#span_add_employee" + id).hide();
        $("#span_edit_employee" + id).hide();

        $("#select_employee" + id).select2({
            ajax: {
                type: "POST",
                url: '{!! route('hamahang.org_chart.select_list_employ') !!}',
                dataType: 'json',
                data: function (params) {
                    return params
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item, i) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                },

            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
        });
    }
    function add_employ(id) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.charts.insert_chart')}}',
            dataType: "json",
            data: $('#form_add_employee' + id).serialize(),
            success: function (result) {
                if (result.success == true) {
                    chart_datatable.ajax.reload();
                }
                else {
                    messageBox('error', '', result.error, {'id': 'alert_insert'}, 'hide_modal');

                }
                setTimeout(function () {
                    $("#alert_insert").html('')
                }, 4000);
            }
        });
    }
    function cancel_add_employ(id) {

        var chart_datatable= $('#Chart_Datatable').DataTable({
            "dom": window.CommonDom_DataTables,
            language:LangJson_DataTables,
            processing: true,
            serverSide: true,
            //dom: 'Bfrtip',
            ajax:
                {
                    url:'{!! route('hamahang.charts.list_charts',['org_id'=>'']) !!}'+org_id+'',
                    type:'post'
                },
            columns: [
                { data: 'id', name: 'id' },
                {  data: 'creator.Family', name: 'creator.Family',
                    "mRender": function ( data, type, full ) {
                        if(full.hasOwnProperty('Family'))
                        {
                            return full.Family;
                        }
                        if(full.hasOwnProperty('creator') ){
                            return full.creator.Family
                        }
                    }
                },
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description'
                },
                { data: 'description', name: 'description',

                    "mRender": function ( data, type, full ) {
                        // return '<button onclick="charts_location_href('+full.id+')" class="btn btn-info" ><span>مشاهده / ویرایش</span></button>';
                        return '<a href="{!! route('ugc.desktop.hamahang.org_chart.show_chart',['username'=> auth()->user()->Uname,'ChartID'=>''])!!}/'+full.id+'"   ><span>مشاهده / ویرایش</span></a>'+
                            '<span style="color:#337ab7; cursor:pointer;" class="mr-10 btn_delete_chart" data_username="<?php echo auth()->user()->Uname?>" data_chart_id="'+full.id+'" >حذف  </span>';


                    }
                }


            ]
        });
    {{--var chart_datatable= $('#Chart_Datatable').DataTable({--}}
        {{--//scrollY:200,--}}
        {{--processing: true,--}}
        {{--serverSide: true,--}}
        {{--//dom: 'Bfrtip',--}}
        {{--ajax:--}}
            {{--{--}}
                {{--url:'{!! route('hamahang.charts.list_charts') !!}',--}}
                {{--type:'post'--}}
            {{--},--}}
        {{--columns: [--}}
            {{--{ data: 'id', name: 'id' },--}}
            {{--{  data: 'creator.Family', name: 'creator.Family',--}}
                {{--"mRender": function ( data, type, full ) {--}}
                    {{--if(full.hasOwnProperty('Family'))--}}
                    {{--{--}}
                        {{--return full.Family;--}}
                    {{--}--}}

                {{--}else {--}}
                    {{--messageBox('error', '', result.error, {'id': 'alert_insert_organ'}, 'hide_modal');--}}
                {{--}--}}
                {{--setTimeout(function () {--}}
                    {{--$("#alert_insert_organ").html('')--}}
                {{--}, 4000);--}}
            {{--}--}}
            {{--}--}}
        {{--});--}}
    }
    function insert_post(state){

        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.org_chart.add_chart_item_post')}}',
            dataType: "json",
            data: $('#form_add_new_chart_item_post').serialize(),
            success: function (result) {
                if (result.success == true) {
                    var msg = 'انجام شد';
                    messageBox('success', msg, '', {'id': 'alert_insert_post'});
                    chart_datatable.ajax.reload();
                    $("#insert_new_post_title").val('');
                    $("#insert_new_post_description").val('');
                    if(state=='close'){
                        $('.jsglyph-close').click();
                    }

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
    $(".select2_auto_complete_onet_jobs").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: false,
        ajax: {
            url: "{{route('auto_complete.onet_jobs')}}",
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