<script>
    var data = {!! json_encode($data) !!}

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

    $(document).on("click", ".btn_edit_news_tabs", function () {
        $.ajax({
            type: "POST",
            url: '{{ route('hamafza.update_news_setting')}}',
            dataType: "json",
            data: $('#ad_setting_form').serialize(),
            success: function (result) {
                if (result.success == true) {
                    $('.jsPanel-btn jsPanel-btn-close').click();
                    messageModal('success', 'ویرایش زبانه‌های اخبار', result.message);
                }
                else {
                    messageModal('error', 'خطا در ویرایش زبانه‌های اخبار', result.error);
                }
            }
        });
    });

    $(document).ready(function () {
        for(var k in data){
            $(".tabs_list").select2("trigger", "select", {
                data: {id: data[k].id, text: data[k].text}
            });
        }
    });
</script>