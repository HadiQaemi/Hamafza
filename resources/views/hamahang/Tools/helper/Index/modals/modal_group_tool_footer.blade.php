<div class="col-xs-12">
    <div class="pull-left">
        {{--<button type="button" class="btn btn-primary btn_add_edit_tool">{{ isset($tool) ? 'ویرایش ابزار' : 'افزودن ابزار' }}</button>--}}
        <button type="button" id="btn_grid_add_new_tools_group" value="save" name="btn_grid_add_new_tools_group" class="btn btn-primary" type="button">
            {{--<i class="fa fa-save bigger-125 "></i>--}}
            <span>{{trans('app.save')}}</span>
        </button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#btn_grid_add_new_tools_group").click(function () {
                add_new_tools_group();
        });
        function add_new_tools_group() {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.tools_group.add_new_tools_group')}}',
                dataType: "json",
                data: {
                    name: $('#new_tools_group_name').val()
                },
                success: function (result) {
                    if (result.success == true) {
                        jQuery.noticeAdd({
                            text: result.message,
                            stay: false,
                            type: 'success'
                        });
                        $('#new_tools_group_name').val('');
                        tools_group_grid_table.ajax.reload();
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
        }
    });
</script>
{{--@include('hamahang.Tools.helper.Index.modals.scripts.add_edit_tool_inline_js.blade')--}}