<script>

    $(document).ready(function()
    {
        e_subject_id = $('#subject_id');
        e_applicant = $('#applicant');
        e_count = $('#count');
        e_required_document = $('#required_document');

        //var height = 500;
        e_target = $('.form_coupon').parent().parent();
        get_left = e_target.position().left;
        //$('.jsPanel-content').animate({height: /*height -*/ 95});
        e_target.animate({/*height: height, */left: get_left + 300, width: 600, }, function()
        {
            $('.form_coupon').fadeIn();
        });
        e_applicant.change(function()
        {
            e_required_document.html($(this).find('option:selected').attr('data-document'));
            applicant = $(this).val();
            switch (applicant)
            {
                case '1':
                case '2':
                case '3':
                case '5':
                case '4':
                {
                    e_count.val(0);
                    e_count.removeAttr('disabled');
                    break;
                }
                case '6':
                case '7':
                case '8':
                case '9':
                {
                    e_count.val(1);
                    e_count.attr('disabled', 'disabled');
                    break;
                }
            }
        });
        //e_applicant.select2({ 'width': '100%'});
        $('.filemanager-buttons-client-place').html($('.filemanager-buttons-client').html());
    });

    function discountcoupon_request_submit(thic)
    {
        $(thic).attr('disabled', 'disabled');
        subject_id = e_subject_id.val();
        applicant = e_applicant.val();
        count = e_count.val();
        data = $('.form_coupon').serialize();
        $.ajax
        ({
            type: 'post',
            url: '{{ route('modals.discount_coupon_request') }}',
            dataType: 'json',
            data: {'subject_id': subject_id, 'applicant': applicant, 'count': count},
            success: function(data)
            {
                if (data.success)
                {
                    $('.jsglyph-close').click();
                    messageModal('success', 'ثبت', data.result[0]);
                } else
                {
                    messageModal('fail', 'خطا', data.result);
                    $(thic).removeAttr('disabled');
                }
            }
        });
        return (false);
    }

</script>