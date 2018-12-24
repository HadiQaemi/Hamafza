{{--{{ dd($item_id) }}--}}
<div class="show_image" style="width:250px; margin: 10px auto">
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('app.image') }}</div>
        <div class="panel-body">
            <img style="width: 100%; height: 100%; position: relative;" title="" src="{{route('FileManager.DownloadFile',['ID', isset($image) ? enCode((int)$image->id) : -1])}}">
        </div>
        <a class="btn btn-danger fa fa-remove remove_image" title="{{ trans('app.remove_image') }}" style="margin-right: 10px;"></a>
        <input type="hidden" class="image_id" value="{{ $image ? enCode($image->id) : '' }}">
        <input type="text" class="image_originalName" value="{{ $image ? $image->originalName : 'تصویر پیش‌فرض' }}">
        <a class="btn btn-info fa fa-edit edit_image_originalName" title=""></a>
    </div>
</div>
<div class="show_image" style="width:250px; margin: 10px auto">
    <input type="checkbox" class="form-check-input" name="show_pic" id="show_pic" {{$showDefimg==0 ? '' : 'checked'}}>
    <label class="pointer" for="show_pic">نمایش در صفحه</label>
</div>
<div class="upload_form" style="width:250px; margin: 10px auto">
    {{--<div class="panel panel-default ">--}}
        <div class="panel-body" style="padding-right: 25%;">
{{--            <span style="padding-bottom: 10px">{{ trans('app.select_new_file') }}</span>--}}
            <form method="Post" enctype="multipart/form-data" id="image_form" action="#">
                <input data-buttonText="انتخاب تصویر" data-input="false" data-iconName="" class="form-control filestyle" type="file" id="page_file_image" name="image" style="display: none;">
                <input type="hidden" id="item_id" name="item_id" value="{{ $item_id }}">
            </form>
        </div>
    {{--</div>--}}
</div>
<div class="col-xs-12">
    <div class="pull-left">
        <button type="button" class="btn btn-primary btn_save_image">بارگذاری</button>
    </div>
</div>

<script>

            @if(isset($image))
    var image_exists = true;
            @else
    var image_exists = false;
    @endif

    $(document).ready(function () {
        $('.upload_form').hide();
        $('.btn_save_image').hide();

        if (!image_exists) {
            $('.show_image').hide();
            $('.upload_form').show();
            $('.btn_save_image').show();
        }

    });

    $(document).click(function () {
        $(".btn_save_image").off();
        $(".btn_save_image").click(function () {
            var formElement = document.querySelector('#image_form');
            var formData = new FormData(formElement);
            save_image(formData);
        });

        $(".edit_image_originalName").off();
        $(".edit_image_originalName").click(function () {
            var image_name = $('.image_originalName').val();
            var image_id = $('.image_id').val();
            $.ajax({
                url: '{{ route($rename_route, $params['rename_route']) }}',
                type: 'post',
                data: {
                    image_name: image_name,
                    image_file_id: image_id
                },
                dataType: "json",
                async: false,
                success: function (s) {
                    if (s.success == true) {
                        messageModal('success', 'تغییر نام تصویر', s.result);

                    }
                    else {
                        messageModal('error', 'خطا در تغییر نام', s.result);
                    }
                }
            });
        });

        $(".remove_image").off();
        $(".remove_image").click(function () {
            confirmModal({
                title: 'حذف تصویر',
                message: 'آیا از حذف تصویر مطمئن هستید؟',
                onConfirm: function () {
                    $.ajax({
                        url: '{{ route($remove_route, $params['remove_route']) }}',
                        type: 'post',
                        data: {
                            item_id: $('#item_id').val()
                        },
                        dataType: "json",
                        success: function (s) {
                            console.log(s);
                            if (s.success == true) {
                                $('.show_image').hide();
                                $('.btn_save_image').show();
                                $('.upload_form').show();
                                $(':file').filestyle({
                                    buttonName: 'انتخاب فایل'
                                });
                                messageModal('success', 'حذف تصویر', s.result);

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
    });

    function save_image(form_data) {
        $.ajax({
            url: '{{ route($save_route, $params['save_route']) }}',
            type: 'post',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            async: false,
            success: function (s) {
                console.log(s.image_name);
                if (s.success == true) {
                    messageModal('success', 'آپلود فایل', s.result);
                    $('.show_image img').attr('src', '{{route('FileManager.DownloadFile',['ID', '' ])}}/' + s.img_id);
                    $('.image_originalName').val(s.image_name);
                    $('.image_id').val(s.img_id);
                    $('.upload_form').hide();
                    $('.show_image').show();
                    $(":file").filestyle('clear');
                    $('.btn_save_image').hide();
                }
                else {
                    messageModal('error', 'خطای آپلود فایل', s.result);
                }
            }
        });
    }
</script>