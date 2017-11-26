<script type="text/javascript">
    $('#province').select2();
    $('#city').select2();
    $(document).on("change", '#province', function () {
        var province_id = $(this).val();
        // var form_data = $('#user_detail_edit_form').serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.users.cities')}}',
            dataType: "json",
            data: {province_id:province_id},
            success: function (results) {
                $('#city').html('');
                $.each(results,function (key,value) {
                    $('#city').append('<option value="'+value['id']+'">'+value['text']+'</option>');
                });

            }
        });
    });

    $("#birthday").persianDatepicker({
        autoClose: true,
        format: 'YYYY/MM/DD'
    });

    $(document).on("click", '.btn_edit_user_detail .form-submit', function () {
        var formElement = document.querySelector('#user_detail_edit_form');
        var data = new FormData(formElement);
       // var form_data = $('#user_detail_edit_form').serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.users.update_user_detail')}}',
            dataType: "json",
            data: data,
            success: function (result) {
                if (result.success == true) {
                    window.location = result.user_profile_url;
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
    $(document).on("click", "#tab_pass", function () {
        $("#div_bas_footer").html('<input type="button" value="تایید" class="btn btn-primary btn_change_pass">');

    });
    $(document).on("click", "#tab_edit", function () {
        $("#div_bas_footer").html('<input type="button" value="تایید" class="btn btn-primary btn_edit_user_detail">');

    });
    $(document).on("click", ".btn_change_pass", function () {
        var form_data = $('#user_password_edit_form').serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.users.updateUserPassword')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    messageModal('success', 'ویرایش اطلاعات کاربری', result.message);
//                        $('#user_detail_edit').addClass('hide');
//                        $('#modal_edit_cat_item').modal('hide');
                }
                else {
                    messageModal('error', 'خطا در ویرایش اطلاعات کاربری', result.error);
                }
            }
        });
    });
    var h = $(window).height()
    $('.user_edit_jspanel_content').css('height',(h* 0.7)-200+'px');
    $('.user_edit_jspanel_content').css('overflow-y','scroll');
    $('.user_edit_jspanel_content').css('direction','ltr');
    $('.user_edit_jspanel_content .tab-content').css('direction','rtl');


</script>