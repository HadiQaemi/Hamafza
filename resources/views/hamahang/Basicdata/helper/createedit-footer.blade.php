<script>
    function do_action()
    {
        var e_title = $('#title');
        var e_inactive = $('[name=inactive]:checked');
        var e_comment = $('#comment');
        var e_attr_title = $('.attr_title');
        var e_attr_title_vals = [];
        for(i = 1; i < e_attr_title.length; i++)
        {
            e_attr_title_vals.push(e_attr_title.eq(i).val());
        }
        $.ajax(
        {
            type: 'post',
            url: '{!! route('modals.basicdata_create_edit') !!}',
            data: {'editid': '{!! $editid !!}', 'title': e_title.val(), 'inactive': e_inactive.val(), 'comment': e_comment.val(), 'attr_title': e_attr_title_vals},
            dataType: 'json',
            success: function(data)
            {
                if (data.success)
                {
                    if ('0' != '{!! $editid !!}')
                    {
                        window.location.reload();
                    } else
                    {
                        $('.jsglyph-close').click();
                        e = '<li role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="' + data.result[0] + '_anchor" id="' + data.result[0] + '" class="jstree-node  jstree-leaf jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#." tabindex="-1" id="' + data.result[0] + '_anchor"><i class="jstree-icon jstree-themeicon" role="presentation"></i><span style="' + (1 == e_inactive.val() ? 'color: lightgray; ' : null) + '">' + e_title.val() + '</span></a></li>';
                        $('.tree').find('ul').append(e);
                        messageModal('success', 'ثبت', data.result[1]);
                    }
                } else
                {
                    messageModal('fail', 'خطا', data.result);
                }
            },
        });
    }
</script>
<div class="row">
    <span class="pull-left" style="padding: 10px">
        <button id="NewTaskPackageSubmitBtn" onclick="do_action()" name="upload_files" value="save" class="btn btn-info" type="button"> <i class="bigger-125"></i> <span>ثبت</span> </button>
    </span>
</div>
