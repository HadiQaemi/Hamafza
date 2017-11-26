<?php
$ope = $_GET['opener'];
$title = $_GET['title'];
?>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    $("#content_body").val( $("#{{$ope}}").val());
tinymce.init({
    mode: "textareas",
    editor_selector: "mceEditor",
    directionality: 'rtl',
    language: 'fa',
    menubar: "tools table format view insert edit",
    height: 450,
    menu: {// this is the complete default configuration
        edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
        insert: {title: 'Insert', items: 'hamafza_form hamafza_index Hamafza_graph Hamafza_subject Hamafza_data OtherHamafza Hamafza_news Hamafza_thesarus   Hamafza_keyword  | anchor charmap | heading'},
        view: {title: 'View', items: 'visualaid'},
        format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats   | removeformat | '},
        table: {title: 'Table', items: 'inserttable deletetable | cell row column'},
        tools: {title: 'Tools', items: 'spellchecker code'}
    },
    style_formats: [
        {title: 'مثال', block: 'p', classes: 'code1'},
        {title: 'ارجاع به جدول،نمودار،تصویر', inline: 'span', attributes: {'class': 'number'}},
        {title: 'عنوان جدول', block: 'p', attributes: {'class': 'number1'}},
        {title: 'عنوان نمودار', block: 'p', attributes: {'class': 'number2'}},
        {title: 'عنوان تصویر', block: 'p', attributes: {'class': 'number3'}},
        {title: 'مأخذ', block: 'p', attributes: {'class': 'resource'}},
        {title: 'زیرنویس', inline: 'span', classes: 'subtitle'},
        {title: 'عمودی', block: 'span', attributes: {'class': 'rotate'}},
        {title: 'تصویر در ابتدای سطر', selector: 'img', attributes: {classes: 'floatright'}}


    ],
    content_css: "{{App::make('url')->to('/')}}/theme/Content/css/content.css", // resolved to http://domain.mine/myLayout.css
    plugins: [
        'directionality hamafza advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code responsivefilemanager '
    ],
    toolbar: 'formatselect  | styleselect | bold italic | alignleft aligncenter alignright alignjustify ltr rtl | bullist numlist outdent indent |    fullscreen'

});
</script>
<div style="height: 650px;">


    <table class="table">
        <tr>
            <td>
                <textarea id="content_body" name="content_body"  class="mceEditor" style="width:100%">
                </textarea>
            </td>
        </tr>
        <tr>
            <td>
                <button id="InsertBut" name="addasubject" class="btn btn-primary floatLeft" type="submit">درج</button>
                </textarea>
            </td>
        </tr>
    </table>
</div>
<script>


    function gup(name, url) {
        if (!url)
            url = location.href;
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(url);
        return results == null ? null : results[1];
    }
    //gup('q', 'hxxp://example.com/?q=abc')



    $(document).ready(function() {
        $("#InsertBut").click(function() {
            var localRels = tinymce.get('content_body').getContent();
            $("#{{$ope}}").val(localRels);
            $("#{{$title}}").html('قالب درج شده');
            parid = $(this).parent().parent().parent().parent().parent().parent().parent().attr('id');
            $("#" + parid + " .jsPanel-hdr .jsPanel-hdr-r .jsPanel-btn-close").trigger("click");
//            console.log($("#" + parid + " .jsPanel-hdr .jsPanel-hdr-r .jsPanel-btn-close").attr('class'));
        });
    });
</script>
