<script>
    function pages_list_load_more(SPLIP, show_more_sign, thic)
    {
        pages_list_client = $('#pages-list-client-' + show_more_sign);
        pages_list_paginate_current_page = parseInt(pages_list_client.attr('data-page')) + 1;
        pages_list_client.attr('data-page', pages_list_paginate_current_page);
        more_btn = $(thic); //$('.more_btn-' + show_more_sign);
        more_btn.attr('disabled', 'disabled');
        more_btn.html('<img src="{!! url('/img/ajax-loading.gif') !!}" />');
        $.ajax
        ({
            url: '{{ route('pages_list_load_more') }}?page=' + pages_list_paginate_current_page,
            type: 'post',
            data: {'html': SPLIP},
            dataType: 'json',
            success: function (response)
            {
                if (response.success)
                {
                    response_result = response.result[0];
                    response_remainning_items = response.result[1];
                    $('#pages-list-client-' + show_more_sign).append(response_result);
                    if (response_remainning_items <= 0)
                    {
                        more_btn.html('<span>مورد دیگری موجود نیست.</span>');
                        more_btn.addClass('more_btn_disabled');
                    } else
                    {
                        more_btn.removeAttr('disabled');
                        more_btn.html('<span>بارگذاری موارد بیشتر (' + response_remainning_items + ')...</span>');
                    }
                }
            }
        });
    }
</script>