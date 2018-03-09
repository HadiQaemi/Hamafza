<div class="col-xs-12">
    <div class="pull-left">
        {{--<button type="button" class="btn btn-primary btn_add_edit_tool">{{ isset($tool) ? 'ویرایش ابزار' : 'افزودن ابزار' }}</button>--}}
        <button type="button" id="add_new_tools_roles" value="save" name="roles_list" class="btn btn-primary" type="button">
            {{--<i class="fa fa-save bigger-125 "></i>--}}
            <span>{{trans('app.save')}}</span>
        </button>
    </div>
</div>
<script>
    $(document).ready(function () {

        $("#add_new_tools_roles").click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.tools.add_tools_role')}}',
                dataType: "json",
                data: $('#tools_new_roles_form').serialize(),
                success: function (result) {
                    if (result.success == true) {
                        jQuery.noticeAdd({
                            text: 'افزودن به نقش با موفقیت انجام شد!',
                            stay: false,
                            type: 'success'
                        });
                        tools_grid_table.ajax.reload();
                        tools_roles_table.ajax.reload();
                    }
                    else {
                        var errors = '';
                        for(var k in result.error) {
                            errors += '' +
                                    '<li>' + result.error[k] +'</li>'
                        }
                        jQuery.noticeAdd({
                            text: errors,
                            stay: false,
                            type: 'error'
                        });
                    }
                }
            });
        });
    });
</script>
{{--@include('hamahang.Tools.helper.Index.modals.scripts.add_edit_tool_inline_js.blade')--}}