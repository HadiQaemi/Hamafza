<script>
    $(document).ready(function () {

        $(".btn_add_edit_item_social").off();
        $(".btn_edit_item_social").click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.update_item_tab')}}',
                dataType: "json",
                data: $('#ad_social_form').serialize(),
                success: function (result_edit) {
                    if (result_edit.success == true) {
                        $('.jsglyph-close').click();
                        Item_Scial_Grid.ajax.reload();
                        messageModal('success', 'ویرایش آیتم', result_edit.message);
                    }
                    else {
                        messageModal('error', 'خطا در ویرایش آیتم', result_edit.error);

                    }
                }
            });
        });
        $(".btn_add_item_social").click(function () {

                 $.ajax({
                   type: "POST",
                   url: '{{ route('hamafza.add_item_social')}}',
                   dataType: "json",
                   data: $('#ad_social_form').serialize() + '&parent_id={{ $parent_id }}',
                   success: function (result) {
                   if (result.success == true) {
                   $('.jsglyph-close').click();
                   Item_Scial_Grid.ajax.reload();
                   messageModal('success', 'افزودن آیتم  جدید', result.message);
                   }
                   else {
                   messageModal('error', 'خطا در افزودن آیتم جدید', result.error);

                   }
                   }
                   });
               });

    });
</script>