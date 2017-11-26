<script>
    current_tagid = 0;
    current_tab = 20;
    prev_tab = current_tab;
    current_order = 'desc';
    $(document).ready(function()
    {
        $(document).on('click', '#th10, #th20, #th30, #th40, #th50', function()
        {
            current_tab = $(this).attr('data-id');
        });
        $(document).on('click', 'a.h-tag', function()
        {
            current_tagid = $(this).attr('data-tagid');
            if ('current-keyword-area-close' != $(this).attr('id'))
            {
                $('#current-keyword-area-title').html($(this).attr('data-tagtitle'));
                $('#current-keyword-area').show();
            }
        });
        $(document).on('click', '#th10, #th20, #th30, #th40, #th50, a.h-tag', function()
        {
            $('#t' + current_tab).html('<div class="loader"></div>');
            if (current_tab == prev_tab)
            {
                if ($(this).find('i').hasClass('fa-sort-amount-asc'))
                {
                    $(this).find('i').removeClass('fa-sort-amount-asc');
                    $(this).find('i').addClass('fa-sort-amount-desc');
                    current_order = 'desc';
                } else if ($(this).find('i').hasClass('fa-sort-amount-desc'))
                {
                    $(this).find('i').removeClass('fa-sort-amount-desc');
                    $(this).find('i').addClass('fa-sort-amount-asc');
                    current_order = 'asc';
                }
                $(this).find('i').attr('data-ord', current_order);
            } else
            {
                prev_tab = current_tab;
            }
            $.ajax
            ({
                url: '{{ route('hamahang.news.index_ajax') }}',
                type: 'post',
                data: { 'tab': current_tab, 'tagid': current_tagid, 'order': $('#th' + current_tab).find('i').attr('data-ord'),'sid':'{{$sid}}' },
                dataType: 'json',
                success: function(data)
                {
                    if (data.success)
                    {
                        $('#t' + current_tab).html(data.result);
                    }
                }
            });
        });
        $('div#Keyword_Grid_paginate').css({ 'text-align': 'center' });
        $('div#Keyword_Grid_filter').html('<input class="" placeholder="{{ trans('enquiry.gharbal') }}" aria-controls="Keyword_Grid" style="width: 100%; height: 30px; margin-bottom: 10px; borer-radius: 0 !important; border:none; border-bottom: lightgray 1px solid;" type="search">');
        @if (isset($keyword))
            current_tagid = '{!! $keyword->id !!}';
            if ('current-keyword-area-close' != $(this).attr('id'))
            {
                $('#current-keyword-area-title').html('{!! $keyword->title !!}');
                $('#current-keyword-area').show();
            }
        @endif
        $('#th20').click();
    });
</script>

