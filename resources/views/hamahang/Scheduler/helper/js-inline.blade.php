<script>
    $(document).ready(function()
    {
        $('#type_0, #type_1, #type_2, #type_3').click(function()
        {
            $('#type_daily, #type_weekly, #type_weekly2, #type_monthly, #type_monthly2, #type_monthly3, #end_date_node').hide();
            $('#' + $(this).attr('data-target')).show();
            $('#' + $(this).attr('data-target') + '2').show();
            $('#' + $(this).attr('data-target') + '3').show();
            if ('type_0' !== $(this).attr('id'))
            {
                $('#end_date_node').show();
            }

        }).click();
    });
    $(document).ready(function()
    {
        $('#recur_type_1').click(function()
        {
            $("[name=count]").prop('disabled', false);
            $("[name=end_time]").prop('disabled', true);
            $("[name=end_time]").val('');
        });
        $('#recur_type_2').click(function()
        {
            $("[name=count]").prop('disabled', true);
            $("[name=end_time]").prop('disabled', false);
            $("[name=count]").val('');
        });
        $('#monthly_type_1').click(function()
        {
            $("[id^='months_days_']").prop('disabled', false);
            $("[id^='monthly_weeknums_']").prop('disabled', true);
            $("[id^='monthly_weekdays_']").prop('disabled', true);
            $("#type_monthly2_pan2").hide();
            $("#type_monthly2_pan1").show();
        });
        $('#monthly_type_2').click(function()
        {
            $("[id^='months_days_']").prop('disabled', true);
            $("[id^='monthly_weeknums_']").prop('disabled', false);
            $("[id^='monthly_weekdays_']").prop('disabled', false);
            $("#type_monthly2_pan1").hide();
            $("#type_monthly2_pan2").show();
        });
        //$("[id^='months_days_']").prop('disabled', true);
        $("[id^='monthly_weeknums_']").prop('disabled', true);
        $("[id^='monthly_weekdays_']").prop('disabled', true);
        //$("#type_monthly2_pan1").hide();
        $("#type_monthly2_pan2").hide();
        $(".TimePicker").persianDatepicker(
            {
                format: "HH:mm",
                onlyTimePicker: true
            });
        $(".DatePicker").persianDatepicker(
            {
                autoClose: true,
                format: 'YYYY/MM/DD',
                observer: true
            });
        $(".DatePicker, .TimePicker").val('');
        $("#type_0").click();
    });
</script>
