<script>
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute;left: 116px;top: -3px;"><a href="{{App::make('url')->to('/')}}/modals/helpview?code=zzis_N_JMsI" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
/*var fileSelectEle = document.getElementById('input_file_avatar');
fileSelectEle.onchange = function ()
{
    if(fileSelectEle.value.length == 0) {
        $(".btn_save_avatar").hide();
    } else {
        $(".btn_save_avatar").show();
    }
}*/

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.img_avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#input_file_avatar").change(function () {
        readURL(this);
    });


    $("#imgInp").change(function () {
        readURL(this);
    });
    $(document).ready(function () {
        $('.upload_form').hide();
        $('.btn_save_avatar').hide();
    });
    $(".btn_save_avatar").off();
    $(document).on("click", ".btn_save_avatar", function () {

        var formElement = document.querySelector('#avatar_form');
        var formData = new FormData(formElement);
        save_avatar_image(formData);
    });
    $(".edit_avatar_image_originalName").off();
    $(document).on("click", ".edit_avatar_image_originalName", function () {
        var avatar_name = $('.avatar_image_originalName').val();
        var avatar_id = $('.avatar_image_id').val();
        $.ajax({
            url: '{{ route('hamahang.users.rename_avatar') }}',
            type: 'post',
            data: {
                avatar_name: avatar_name,
                image_file_id: avatar_id
            },
            dataType: "json",
            async: false,
            success: function (s) {
                if (s.success == true) {
                    messageModal('success', 'تغییر نام تصویر آواتار', s.result);
                }
                else {
                    messageModal('error', 'خطا در تغییر نام', s.result);
                }
            }
        });
    });
//    $(".remove_avatar_image").off();
    $(document).on("click", ".remove_avatar_image", function () {
        confirmModal({
            title: 'حذف تصویر',
            message: 'آیا از حذف تصویر مطمئن هستید؟',
            onConfirm: function () {
                $.ajax({
                    url: '{{ route('hamahang.users.remove_avatar') }}',
                    type: 'post',
//                    data: form_data,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    async: false,
                    success: function (s) {
                        if (s.success == true) {
                            // $('.show_avatar_image').hide();
                            // $('.btn_save_avatar').show();
                            //$('.upload_form').show();
                            location.reload();
                            $(':file').filestyle({
                                buttonName: 'انتخاب فایل'
                            });

                        }
                        else {
                            messageModal('error', 'خطای آپلود فایل', s.result);
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    });

    function save_avatar_image(form_data) {
        $.ajax({
            url: '{{ route('hamahang.users.save_avatar') }}',
            type: 'post',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            async: false,
            success: function (s) {
                if (s.success == true) {

                    $('.show_avatar_image img').attr('src', '{{route('FileManager.DownloadFile',['ID', '' ])}}/' + s.img_id);
                    $('.upload_form').hide();
                    $('.show_avatar_image').show();
                    $(":file").filestyle('clear');
                    $('.btn_save_avatar').hide();
                    location.reload();
                }
                else {
                    messageModal('error', 'خطای آپلود فایل', s.result);
                }
            }
        });
    }
    $('.img_avatar').click(function () {
        $("#avatar_form").find("input[type='file']").click();
//        $(".btn_save_avatar").show();
    });
    $(document).on("click", "#footer_selec_avatar", function () {
        $("#avatar_form").find("input[type='file']").click();
        $(".btn_save_avatar").show();
    });
</script>