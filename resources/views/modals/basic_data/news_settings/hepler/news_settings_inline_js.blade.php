<script>

    $(".tabs_list").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
        ajax: {
            url: "{{ route('auto_complete.keywords_with_subjects') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

    $(document).click(function () {
        $(".btn_add_edit_news").off();
        @if(isset($basic_data_value))
            $(".btn_add_edit_news").click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.update_news_setting')}}',
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
            $(".btn_add_edit_news").off();
            $(".btn_add_edit_news").click(function () {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamafza.add_news_setting')}}',
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

    var keywords = {!! json_encode($keywords) !!}
    $(document).ready(function () {
        for(var k in keywords){
            $(".tabs_list").select2("trigger", "select", {
                data: {id: keywords[k].id, text: keywords[k].text}
            });
        }
    });

</script>