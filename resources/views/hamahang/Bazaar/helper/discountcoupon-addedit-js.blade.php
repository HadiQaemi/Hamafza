<script>
    $(document).ready(function()
    {
        e_coupon = $('#coupon');
        e_type = $('#type');
        e_value = $('#value');
        e_coupon = $('#coupon');
        e_start_date = $('#start_date');
        e_expire_date = $('#expire_date');
        e_disposable = $('#disposable');
        e_usage_quota = $('#usage_quota');
        e_inactive = $('#inactive');
        e_coupon_old = $('#coupon_old');
        e_edit_id = $('#edit_id');
        e_type_of_value = $('#type_of_value');

        var height = 295;
        e_target = $('.form_coupon').parent().parent();
        get_left = e_target.position().left;
        $('.jsPanel-content').animate({height: height - 95});
        e_target.animate({height: height, left: get_left + 200, width: 800, }, function()
        {
            $('.form_coupon').fadeIn();
        });
        e_type.change(function ()
        {
            html = 1 == e_type.val() ? '{!! trans('bazaar.discountcoupon.type_of_value_1') !!}' : '{!! trans('bazaar.discountcoupon.type_of_value_0') !!}';
            placeholder = 1 == e_type.val() ? '15000' : '80';
            e_type_of_value.html(html);
            e_value.attr('placeholder', placeholder);
        });
        e_type.change();
    });
</script>