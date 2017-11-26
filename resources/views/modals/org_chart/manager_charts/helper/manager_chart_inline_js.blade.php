<script>
    /*$(document).click(function () {  });*/
        $("#btn_insert_chart").hide();
        $("#tab_insert_charts").click(function () {

           $("#btn_insert_chart").show();
        });
        $("#tab_charts").click(function () {

            $("#btn_insert_chart").hide();
        });
        var username=$("#input_Uname").val();
    $("#btn_insert_chart").click(function () {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.charts.insert_chart')}}',
            dataType: "json",
            data: $('#FormInsertChart').serialize(),
            success: function (result) {

                if (result.success == true) {
                    var msg='چارت جدید ایجاد گردید';
                    chart_datatable.ajax.reload();
                    messageBox('success',msg,'',{'id':'alert_insert'});
                    $("#New_ChartTitle").val('');
                    $("#New_ChartDesc").val('');
                }
                else {
                    messageBox('error', '',result.error,{'id': 'alert_insert'},'hide_modal');

                }
                setTimeout(function(){$("#alert_insert").html('') }, 4000);
            }
        });
    });
    function charts_location_href(id) {

        {{--  var href = "{{URL::route('ugc.desktop.Hamahang.OrgChart.test')}}" ;--}}
       // window.location = href;
        {{-- var href="{!! route('ugc.desktop.Hamahang.OrgChart.test') !!}";
        var href = "{{URL::route('ugc.desktop.hamahang.org_chart.show_chart',['username'=>$UName,'ChartID'=>''])}}/" + id;
        window.location = href;--}}
    }
    //$("#Chart_Datatable").dataTable()
    var org_id=$("#organ_id").val();


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
    $(".btn_delete_chart").off();
    $(document).on('click', '.btn_delete_chart', function(){
        $.post('{{ route('hamahang.org_chart.modals.delete_chart')}}',{username:$(this).attr('data_username'),chart_id:$(this).attr('data_chart_id')},function(data) {
        var msg=window.JSON.parse(data);

            if (msg.success == true)
                chart_datatable.ajax.reload();
            else if(msg.success == false)
            {
                messageModal('error','خطادر عملیات ',msg.error);
            }
        });
        {{--  $.ajax({
            type: "POST",
            url: '{{ route('hamahang.org_chart.modals.delete_chart')}}',
            dataType: "json",
            data: $('#FormInsertChart').serialize(),
            success: function (result) {

                if (result.success == true) {
                    var msg='چارت جدید ایجاد گردید';
                    chart_datatable.ajax.reload();
                    messageBox('success',msg,'',{'id':'alert_insert'});
                    $("#New_ChartTitle").val('');
                    $("#New_ChartDesc").val('');
                }
                else {
                    messageBox('error', '',result.error,{'id': 'alert_insert'},'hide_modal');

                }
                setTimeout(function(){$("#alert_insert").html('') }, 4000);
            }
        });--}}
});

</script>