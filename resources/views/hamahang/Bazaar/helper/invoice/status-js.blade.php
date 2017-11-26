<script>
    $(document).ready(function()
    {
        e_target = $('#invoice_status_table').parent().parent();
        get_left = e_target.position().left;
        get_width = e_target.width();
        e_target.animate({left: get_left + 150, width: get_width - 300, }, function()
        {
            $('.table_coupon').fadeIn();
        });

        e_status = $('#status');
        e_tracking_code_client = $('#tracking_code_client');
        e_status.change(function()
        {
            if ('{!! config('bazaar.invoice_status_sent') !!}' == $('option:selected', this).val())
            {
                e_tracking_code_client.show();
            } else
            {
                e_tracking_code_client.hide();
            }
        });
        //e_status.select2();
    });
    function invoice_status_submit()
    {
        data = $('#invoice_status_form').serialize();
        $.ajax
        ({
            url: '{{ route('hamahang.bazaar.invoice_status_submit') }}',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(data)
            {
                if (data.success)
                {
                    $('.jsglyph-close').click();
                    invoices_grid_reload();
                } else
                {
                    messageModal('fail', '{!! trans('bazaar.error') !!}', data.result);
                }
            }
        });
    }
</script>