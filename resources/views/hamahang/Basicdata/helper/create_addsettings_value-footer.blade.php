<script>
    function do_action()
    {
        var e_parentid = $('#parentid');
        var e_title = $('#title');
        var e_value = $('#value');
        var e_inactive = $('[name=inactive]:checked');
        var e_comment = $('#comment');
        $.ajax(
        {
            type: 'post',
            url: '{!! route('modals.basicdata_ads_setting_add_new_value') !!}',
            data: {'editid': '{!! $editid !!}', 'parentid': e_parentid.val(), 'title': e_title.val(), 'value': e_value.val(), 'inactive': e_inactive.val(), 'comment': e_comment.val(), },
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
                        $('.tree').find('ul li a#' + e_parentid.val() + '_anchor').click();
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
