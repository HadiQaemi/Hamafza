<script>

    $(document).ready(function()
    {
        shipping_content();
    });

    // load cart content directly
    function shipping_content()
    {
        $('.content').html('<div class="loader"></div>');
        $.ajax
        ({
            type: 'post',
            url: '{{ route('hamahang.bazaar.shipping_content') }}',
            dataType: 'html',
            success: function(data) { $('.content').html(data); }
        });
    }

    function proceed_to_review(thic)
    {
        var failed = false;
        e_address = $('.address:checked');
        e_postmethod = $('.postmethod:checked');
        address = e_address.val();
        postmethod = e_postmethod.val();
        $(thic).attr('disabled', 'disabled');
        if ('undefined' != address && 'undefined' != postmethod)
        {
            $.ajax
            ({
                async: false,
                url: '{{ route('hamahang.bazaar.shipping_prepare') }}',
                type: 'post',
                dataType: 'json',
                data: {'address': address, 'postmethod': postmethod},
                success: function(data)
                {
                    failed = !data.success;
                }
            });
        } else
        {
            failed = true;
        }
        if (failed)
        {
            $(thic).removeAttr('disabled');
            alert('لطفاً یک آدرس و یک شیوه ارسال انتخاب نمائید.');
        } else
        {
            window.location = '{!! $url_review !!}';
        }
    }

    function address_delete(delete_id)
    {
        $.ajax
        ({
            type: 'post',
            url: '{!! route('modals.addresses_delete') !!}',
            data: {'delete_id': delete_id},
            dataType: 'json',
            success: function(data)
            {
                if (data.success)
                {
                    shipping_content();
                }
            },
        });
    }

</script>

