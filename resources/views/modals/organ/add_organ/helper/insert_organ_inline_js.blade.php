<script>
    $(document).ready(function () {
        $("#organ_parent").select2({
            ajax: {

                type: "POST",
                url: '{!! route('hamahang.org_chart.select_list_organs') !!}',
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
        $('#btn_insert_organ').click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.org_chart.insert_organs')}}',
                dataType: "json",
                data: $('#Form_Add_Organ').serialize(),
                success: function (result) {
                    if (result.success == true) {
                        $('.jsPanel-btn-close').click();
                        window.table_organs_grid.ajax.reload();
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