<script>

    $(document).ready(function()
    {
        payment_content(true);
    });

    // load review content directly
    function payment_content(loader)
    {
        if (loader)
        {
            $('.content').html('<div class="loader"></div>');
        }
        $.ajax
        ({
            type: 'post',
            url: '{{ route('hamahang.bazaar.payment_content') }}',
            dataType: 'html',
            success: function(data) { $('.content').html(data); }
        });
    }

    function proceed_to_pay(thic)
    {
        melli_code = $('#melli_code').val();
        $('.content').html('<div class="loader"></div>');
        var success = false;
        $(thic).attr('disabled', 'disabled');
        $.ajax
        ({
            async: false,
            url: '{{ route('hamahang.bazaar.payment_invoice') }}',
            type: 'post',
            dataType: 'json',
            data: {'melli_code': melli_code},
            success: function(data)
            {
                if (data.success)
                {
                    window.location = '{!! $url_pay !!}';
                } else
                {
                    messageModal('fail', 'خطا', data.result);
                    payment_content(false);
                    $(thic).removeAttr('disabled');
                }
            }
        });
    }

    function discountcoupon_check()
    {
        var failed = false;
        var e_coupon = $('#coupon');
        var coupon = e_coupon.val();
        if (coupon)
        {
            $.ajax
            ({
                async: false,
                url: '{{ route('hamahang.bazaar.payment_discountcoupon_check') }}',
                type: 'post',
                dataType: 'json',
                data: {'coupon': coupon},
                success: function(data)
                {
                    failed = !data.success;
                }
            });
        } else
        {

        }
        if (failed)
        {
            alert('Error!');
        } else
        {
            //window.location = '{!! $url_payment !!}';
        }
    }

</script>