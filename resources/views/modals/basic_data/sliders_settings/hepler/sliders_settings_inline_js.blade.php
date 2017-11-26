<script>
    $(document).click(function () {
        $(".btn_add_edit_slider").off();
        @if(isset($basic_data_value))
$(".btn_add_edit_slider").click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.update_slider_setting')}}',
                dataType: "json",
                data: $('#ad_setting_form').serialize(),
                success: function (result) {
                    if (result.success == true) {
                        $('.jsglyph-close').click();
                        groupGrid.ajax.reload();
                        messageModal('success', 'ویرایش اسلایدر', result.message);
                    }
                    else {
                        messageModal('error', 'خطا در ویرایش اسلایدر', result.error);

                    }
                }
            });
        });
        @else
        $(".btn_add_edit_slider").off();
        $(".btn_add_edit_slider").click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.add_slider_setting')}}',
                dataType: "json",
                data: $('#ad_setting_form').serialize() + '&parent_id={{ $parent_id }}',
                success: function (result) {
                    if (result.success == true) {
                        $('.jsglyph-close').click();
                        groupGrid.ajax.reload();
                        messageModal('success', 'افزودن اسلایدر جدید', result.message);
                    }
                    else {
                        messageModal('error', 'خطا در افزودن اسلایدر جدید', result.error);

                    }
                }
            });
        });
        @endif
    });
</script>