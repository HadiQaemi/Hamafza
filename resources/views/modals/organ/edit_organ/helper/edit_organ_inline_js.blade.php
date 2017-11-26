<script>
    $(document).ready(function () {
        $("#organ_parent").select2({
            ajax: {
                type: "POST",
                url: '{!! route('hamahang.org_chart.select_list_edit_organs') !!}',
                dataType: 'json',
                data: function (params) {
                    return params
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item, i) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                },

            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        });
        $('#btn_edit_organ').click(function () {

            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.org_chart.edit_organs')}}',
                dataType: "json",
                data: $('#Form_edit_Organ').serialize(),
                success: function (result) {
                    if (result.success == true) {
                        var msg='ویرایش شد';
                        messageBox('success',msg,'',{ 'id' :'alert_insert'});
                        window.table_organs_grid.destroy();
                        organs_grid();

                    }
                    else {
                        messageBox('error', '',result.error,{'id': 'alert_insert'},'hide_modal');

                    }
                    setTimeout(function(){$("#alert_insert").html('') }, 4000);
                }
            });
        });
    });


</script>