<script>
    $(document).ready(function()
    {
        $(document).on('click', '.clickable-accept', function()
        {
            $.ajax(
            {
                type: 'POST',
                dataType: 'json',
                url: '{{ Route('hamahang.enquiry.accept') }}',
                data: { 'answer_id': $(this).attr('postid') },
                success: function(data)
                {
                    //messageModal('success', 'نتیجه', data.result);
                    if (data.success)
                    {
                        window.location.reload();
                    }
                },
            });
        });
        $(document).on('click', '.delete-post', function()
        {
            rel = $('div.data-delete' + $(this).attr('id')).attr('data-type');
            $('div.data-delete' + $(this).attr('id')).remove();
            window.setTimeout(function()
            {
                if ('post' == rel)
                {
                    window.location = '{!! route('page', [ 'id' => $sid*10 ]) !!}';
                } else
                {
                    window.location.reload();
                }
            }, 1000);
            return false;
        });
        $(document).on('click', '#post_answer', function()
        {
            desc = $('#post_desc').val();
            $('.post-new-answer').remove();
            $.ajax(
            {
                type: 'POST',
                dataType: 'json',
                url: '{{ Route('hamahang.enquiry.answer') }}',
                data: { 'parent_id': '{!! $post->id !!}', 'desc': desc },
                success: function(data)
                {
                    if (data.success)
                    {
                        $('#post_desc').val('');
                        //messageModal('success', '{{ trans('enquiry.submit') }}', [ '{{ trans('enquiry.answersubmited') }}' ], function()
                        //{
                            window.location.reload();
                        //});
                    } else
                    {
                        messageModal('fail', '{{ trans('enquiry.submit') }}', data.result);
                    }
                },
            });
        });
        $(document).on('click', '[class*="vote-up"], [class*="vote-down"]', function()
        {
            target_id = $(this).attr('data-target_id');
            type = $(this).attr('data-type');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{{ route('hamahang.vote.set') }}',
                data: {'target_table': 'App\\Models\\hamafza\\Post', 'target_id': target_id, 'type': type},
                success: function(data)
                {
                    //messageModal('success', 'ثبت', data.result);
                    switch (data.result[0])
                    {
                        case '1':
                        case 1:
                            $('.vote-up' + target_id).css('color', 'orange');
                            $('.vote-down' + target_id).css('color', 'lightgrey');
                            break;
                        case '-1':
                        case -1:
                            $('.vote-up' + target_id).css('color', 'lightgrey');
                            $('.vote-down' + target_id).css('color', 'orange');
                            break;
                        default:
                            $('.vote-up' + target_id + ', .vote-down' + target_id).css('color', 'lightgrey');
                            break;
                    }
                    $('.vote-count' + target_id).html(data.result[1]);
                },
            });
        });
        function add_template(postid)
        {
            t = $('#' + postid).find('.commentShow');
            _id_ = t.find('.Postid').attr('value');
            _comment_ = t.find('.txtContain').html();
            _commentid_ = t.find('.commentid').attr('value');
            _commentdate_ = t.find('.CommentTime').html();
            t.remove();
            r = '\
            <div style="width: 100%; margin: 5px 0; background-color: #f4f4f4; padding: 5px;">\
                <input class="Postid" value="' + _id_ + '" type="hidden">\
                <div style="float: right; margin-right: 5px;">{!! auth()->user()->smallAvatar2 !!}</div>\
                <div style="float: left; width: 93%; margin: auto; padding: 5px; min-height: 30px; text-align: justify;">\
                    ' + _comment_ + '\
                </div>\
                <div class="clear"></div>\
                <div style="float: left; height: 20px;">\
                <div style="margin-right: 10px; float: left;" class="fonts icon-hazv CommentDelicn" page="comment" action="delete" id="' + _commentid_ + '"></div><div style=" float: left;">هم اکنون</div>\
                </div>\
                <div class="clear"></div>\
            </div>\
            ';
            $('#' + postid).find('.h-new-comment').append(r);
        }
        $('.CommentSend2').on('keypress', function(e)
        {
            if (e.which == 13)
            {
                v = $(this).val();
                e = jQuery.Event('keypress');
                e.which = 13;
                $('#CommentSend' + $(this).attr('postid')).val(v).trigger(e);
                if (v)
                {
                    $(this).val('');
                    window.setTimeout(function() { add_template($(this).attr('postid')); }, 1000);
                }
            }
        });
    });
    /*
    groupGrid = $('#Keyword_Grid').DataTable({
        language: LangJson_DataTables,
        processing: true,
        serverSide: true,
        dom: '<"col-xs-3"f><"tools-group-toolbar">t<"col-xs-14 text-center"p><"clearfixed">',
        ajax: {
            url: '{!! route('hamahang.enquiry.index_ajax_sidebar')!!}',
            type: 'POST',
            data:{'sid': '{{$sid}}' }
        },
        columns: [
            {
                data:'title',
                width: '80%',
                mRender: function (data, type, full) {
                    return '<a href="{!! route('page', ['id' => $sid*10, 'tagid' => '']) !!}' + full.id + '" class="h-tag">' + full.title + '</a>';
                }
            },
            {
                data:'questions_count',
                width: '20%',
                mRender: function (data, type, full) {
                    return full.questions_count;
                }
            }

        ]
    });
    */
</script>

