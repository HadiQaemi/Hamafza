<script>

    $(document).ready(function()
    {
        review_content();
    });

    // load review content directly
    function review_content()
    {
        $('.content').html('<div class="loader"></div>');
        $.ajax
        ({
            type: 'post',
            url: '{{ route('hamahang.bazaar.review_content') }}',
            dataType: 'html',
            success: function(data) { $('.content').html(data); cart_update_basket(); }
        });
    }

    function proceed_to_payment(payable_amount, thic)
    {
        var failed = false;
        $(thic).attr('disabled', 'disabled');
        $.ajax
        ({
            async: false,
            url: '{{ route('hamahang.bazaar.review_prepare') }}',
            type: 'post',
            dataType: 'json',
            data: {'payable_amount': payable_amount},
            success: function(data)
            {
                failed = !data.success;
            }
        });
        if (failed)
        {
            alert('Error!');
            $(thic).removeAttr('disabled');
        } else
        {
            window.location = '{!! $url_payment !!}';
        }
    }

</script>