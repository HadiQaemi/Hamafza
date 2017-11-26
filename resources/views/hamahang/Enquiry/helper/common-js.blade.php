<script>
    paginate_current_page = 1;
    keyword_search_time = 0;
    keyword_search = $('#keyword_search');
    keyword_search.val('');
    function show_comment_box()
    {
        $('#CommentPage').click();
        $('#post_type').val(2).change();
        $('#portal_id').val({!! $sid !!}).change();
        $('#commentTitleW').focus();
    }
    function keyword_search_do()
    {
        paginate_current_page = 0;
        keyword_content_tbody.html('');
        keyword_content.scroll();
    }
    $(document).ready(function()
    {
        keyword_content = $('#keyword_content');
        e_keyword_loading = $('#keyword_loading');
        keyword_content_tbody = keyword_content.find('tbody');
        $(document).on('keyup', keyword_search, function()
        {
            clearTimeout(keyword_search_time);
            keyword_search_time = setTimeout(function() { keyword_search_do(); }, 1000);
        });
        keyword_content.scroll(function ()
        {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight)
            {
                paginate_current_page++;
                e_keyword_loading.css('visibility', 'visible');
                $.ajax
                ({
                    url: '{{ route('hamahang.enquiry.get_keywords', ['id' => $sid, 'paginate' => config('constants.enquiry_sidebar_paginate'), ]) }}?page=' + paginate_current_page,
                    type: 'post',
                    data: {'term': keyword_search.val()},
                    dataType: 'json',
                    success: function (response)
                    {
                        e_keyword_loading.css('visibility', 'hidden');
                        if (response.data.length)
                        {
                            $.each(response.data, function (key, value)
                            {
                                tr =
                                '<tr>' +
                                '   <td style="width: 90%;">' +
                                '           <a href="#" class="h-tag" data-tagid="' + value.id + '" data-tagtitle="' + value.title + '" style="margin: 0; padding: 0;">' +
                                '               ' + value.title +
                                '           </a>' +
                                '   </td>' +
                                '   <td style="width: 10%; text-align: center;">' +
                                '       ' + value.questions_count +
                                '   </td>' +
                                '</tr>';
                                keyword_content_tbody.append(tr);
                            });
                        } else if ('' == keyword_content_tbody.html())
                        {
                            keyword_content_tbody.append('<th><td>موردی موجود نیست.</td><td></td></th>');
                        }
                    }
                });
            }
        });
    });
</script>

