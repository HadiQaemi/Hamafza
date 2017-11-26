<script>
$('#btn_change_chart').click(function (){

    $.ajax({
        type: "POST",
        url: '{{ route('hamahang.org_chart.edit_chart')}}',
        dataType: "json",
        data: $('#FormEditChart').serialize(),
        success: function (result) {
            if (result.success == true) {
                var msg='ویرایش شد';
                messageBox('success',msg,'',{ 'id' :'alert_insert'});
                $("#ChartTitle").html($("#NewChartTitle").val());
            }
            else {
                messageBox('error', '',result.error,{'id': 'alert_insert'},'hide_modal');

            }
            setTimeout(function(){$("#alert_insert").html('') }, 4000);
        }
    });

});

</script>