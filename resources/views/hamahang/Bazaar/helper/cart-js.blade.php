<script>

    $(document).ready(function()
    {
        a = $('.select-count');
        select = $('.selected-count');
        a.click(function()
        {
            select.html($(this).html());
        });
        cart_content();
    });

    /**
     *
     * some of scripts may placed in:
     *      \resources\views\sections\main_scripts.blade.php
     *      \resources\views\hamahang\Bazaar\helper\bazaar-js.blade.php
     *
     */

    // load cart content directly
    function cart_content()
    {
        $('.content').html('<div class="loader"></div>');
        $.ajax
        ({
            type: 'post',
            url: '{{ route('hamahang.bazaar.cart_content') }}',
            dataType: 'html',
            success: function(data) { $('.content').html(data); cart_update_basket(); }
        });
    }

    // update cart
    function cart_update(id, count)
    {
        $.ajax
        ({
            type: 'POST',
            url: '{{ route('hamahang.bazaar.cart_update') }}',
            data: {'id': id, 'count': count},
            success: function(data) { cart_content(); }
        });
        return false;
    }

    // delete an item from cart
    function cart_delete(id)
    {
        if (confirm('آیا از حذف این مورد اطمینان دارید؟'))
        {
            $.ajax
            ({
                type: 'POST',
                url: '{{ route('hamahang.bazaar.cart_delete') }}',
                data: {'id': id},
                success: function(data) { cart_content(); }
            });
        }
    }

    // make cart empty
    function cart_empty()
    {
        if (confirm('آیا از خالی کردن سبد خرید خود اطمینان دارید؟'))
        {
            $.ajax
            ({
                type: 'post',
                url: '{{ route('hamahang.bazaar.cart_empty') }}',
                success: function(data) { cart_content(); }
            });
        }
    }

    // add coupon from cart
    function cart_discountcoupon_command(id, coupon, command, thic)
    {
        $(thic).attr('disabled', 'disabled');
        $.ajax
        ({
            type: 'POST',
            url: '{{ route('hamahang.bazaar.cart_update') }}',
            data: {'id': id, 'coupon': coupon, 'command': command},
            success: function(data) { cart_content(); }
        });
        return false;
    }

    // add coupon from cart
    /*
    function cart_discountcoupon_add(id, coupon, thic)
    {
        cart_discountcoupon_command(id, coupon, '+', thic)
    }
    */

    // remove coupon from cart
    function cart_discountcoupon_remove(id, thic)
    {
        cart_discountcoupon_command(id, 0, '-', thic)
    }

    // make cart empty
    function cart_discountcoupon_check(id, thic)
    {
        var coupon = $('#discountcoupon_' + id).val();
        $(thic).attr('disabled', 'disabled');
        $.ajax
        ({
            url: '{{ route('hamahang.bazaar.cart_discountcoupon_check') }}',
            type: 'post',
            dataType: 'json',
            data: {'id': id, 'coupon': coupon},
            success: function(data)
            {
                if (data.success)
                {
                    cart_content();
                } else
                {
                    messageModal('fail', 'خطا', ['کد تخفیف معتبر نیست.']);
                    $(thic).removeAttr('disabled');
                }
            }
        });
    }

</script>