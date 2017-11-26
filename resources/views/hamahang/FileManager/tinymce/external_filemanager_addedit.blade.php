@extends('layouts.master_tinymce')

@section('content')
    <script type="text/javascript" language="javascript">
        function tinymce_submit(url)
        {
            var p = top.tinymce.activeEditor.windowManager.getParams();
            p.window.document.getElementById(p.input).value = url;
            top.tinymce.activeEditor.windowManager.close();
        }
        $(document).ready(function()
        {
            $(document).on('click', '#form_tinymce_upload .form-submit', function()
            {
                var formElement = document.querySelector('#form_tinymce_upload');
                var data = new FormData(formElement);
                $.ajax
                ({
                    url: '{{ route('FileManager.tinymce_external_filemanager') }}',
                    type: 'post',
                    dataType: 'json',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data)
                    {
                        if (data.success)
                        {
                            tinymce_submit(data.result);
                        } else
                        {
                            messageModal('fail', 'خطا', data.result);
                        }
                    }
                });
            });
        });
    </script>
    <form id="form_tinymce_upload" enctype="multipart/form-data" style="padding: 10px;">
        <input type="hidden" id="pid" name="pid" value="{!! Request::input('pid') !!}" />
        <input type="file" id="image" name="image" /><br />
        <br />
        <br />
        <br />
        <button class="btn btn-primary pull-left form-submit" style="float: left;" onclick="return false;">ذخیره</button>
    </form>
@stop
