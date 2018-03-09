<div class="col-xs-12">
    <div class="pull-left">
        {{--<button type="button" class="btn btn-primary btn_add_edit_tool">{{ isset($tool) ? 'ویرایش ابزار' : 'افزودن ابزار' }}</button>--}}
        <button type="button" class="btn btn-primary menu_item_submit_form_btn">
            <i></i> تایید
        </button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.jsPanel').css('heght','200px');
        $('.jsPanel-content').css('heght','150px');
        $(".menu_item_submit_form_btn").click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.menus.store_menu')}}',
                dataType: "json",
                data: $('#add_edit_menu_form').serialize(),
                success: function (result) {
                    if (result.success == true) {
                        jQuery.noticeAdd({
                            text: result.message,
                            stay: false,
                            type: 'success'
                        });
                        menus_grid_data.ajax.reload();
                        $('a[href="#menus_tab"]').click();
                        document.getElementById('form_created_new_menu').reset();
                    }
                    else {
                        var errors = '';
                        for (var k in result.error) {
                            errors += '' +
                                    '<li>' + result.error[k] + '</li>'
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