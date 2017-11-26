<script>
    var current_tab = 1;
    var page = 1;
    var search = '';

    function do_submit(apply)
    {
        var $this = $(this);
        var is_apply = $this.data('apply');
        data = $('.form_bazaar').serialize();
        $.ajax({
            type: 'post',
            url: '{{ route('hamahang.bazaar.bazaar_update') }}',
            dataType: 'json',
            data: data,
            success: function(data)
            {
                 if (data.success)
                 {
                     if (apply)
                         jQuery.noticeAdd({
                             text: 'تغییرات با موفقیت انجام شد',
                             stay: false,
                             type: 'success'
                         });
                     else
                         location.reload();
//                     $('.jsglyph-close').click();
//                     messageModal('success', 'ثبت', ['ذخیره با موفقیت انجام شد.']);
                 } else
                 {
                     messageModal('fail', 'خطا', data.result);
                 }
            }
        });
        return (false);
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin cart functions
     *
     * some of scripts may placed in:
     *      \resources\views\sections\main_scripts.blade.php
     *      \resources\views\hamahang\Bazaar\helper\cart-js.blade.php
     *
     */



    /**
     *
     *
     * end cart functions
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     */
    $(document).ready(function()
    {
        $('.responsible_for_sales_id').select2(
        {
            minimumInputLength: 3,
            dir: 'rtl',
            width: '100%',
            tags: false,
            ajax:
            {
                url: '{{ route('auto_complete.users') }}',
                dataType: 'json',
                type: 'post',
                quietMillis: 150,
                data: function (term)
                {
                    return {
                        term: term
                    };
                },
                results: function (data)
                {
                    return {
                        results: $.map(data, function (item)
                        {
                            return { text: item.text, id: item.id }
                        })
                    };
                }
            }
        });
        $('.h-dropdown-h').click(function()
        {
            $('#' + $(this).attr('id') + '-list').slideToggle();
        });
        $('.h-tabs .h-tab').click(function()
        {
            $('.h-tab-selected').addClass('h-tab');
            $('.h-tab-selected').removeClass('h-tab-selected');
            $(this).addClass('h-tab-selected');
        });
        /*
        $(document).on('click', '#th1, #th2', function()
        {
            current_tab = $(this).attr('data-id');
            //part2(current_tab);
        });
        function part2(current_tab, page)
        {
            $.ajax(
            {
                type: 'POST',
                dataType: 'json',
                url: '{ { route('bazaar.part2') } }?page=' + page,
                data: { 'tab': current_tab, 'search': search },
                success: function(data)
                {
                    if (data.success)
                    {
                        $('#t' + current_tab).html(data.result);
                    }
                }
            });
        }
        */
        $('#th1').click();
        $('body').on('click', '#search_btn', function(e)
        {
            search = $('#search_term').val();
            part2(current_tab, page, search);
        });
        $('body').on('click', '.pagination a', function(e)
        {
            e.preventDefault();
            $('#load a').css('color', '#dfecf6');
            $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');
            get_page = $(this).html();
            switch (get_page)
            {
                case '»':
                    page = parseInt(page) + 1
                    break;
                case '«':
                    page = parseInt(page) - 1
                    break;
                default:
                    page = parseInt(get_page);
                    break;
            }
            part2(current_tab, page, search);
        });
    });
</script>

