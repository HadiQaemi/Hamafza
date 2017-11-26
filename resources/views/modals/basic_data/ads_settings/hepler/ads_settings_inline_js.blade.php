<script>
    $(document).click(function () {
        $(".btn_add_edit_ad").off();
        @if(isset($basic_data_value))
            $(".btn_add_edit_ad").click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.update_ad_setting')}}',
                dataType: "json",
                data: $('#ad_setting_form').serialize(),
                success: function (result) {
                    if (result.success == true) {
                        $('.jsglyph-close').click();
                        groupGrid.ajax.reload();
                        messageModal('success', 'ویرایش تبلیغ', result.message);
                    }
                    else {
                        messageModal('error', 'خطا در ویرایش تبلیغ', result.error);

                    }
                }
                });
            });
        @else
            $(".btn_add_edit_ad").off();
            $(".btn_add_edit_ad").click(function () {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamafza.add_ad_setting')}}',
                    dataType: "json",
                    data: $('#ad_setting_form').serialize() + '&parent_id={{ $parent_id }}',
                    success: function (result) {
                        if (result.success == true) {
                            $('.jsglyph-close').click();
                            groupGrid.ajax.reload();
                            messageModal('success', 'افزودن تبلیغ جدید', result.message);
                        }
                        else {
                            messageModal('error', 'خطا در افزودن تبلیغ جدید', result.error);
                        }
                    }
                });
            });
        @endif
    });
</script>