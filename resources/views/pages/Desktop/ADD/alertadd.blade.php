@extends('pages.Desktop.DesktopFunctions')
@section('content')
<script type="text/javascript" src="{{App::make('url')->to('/')}}/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    mode: "textareas",
    editor_selector: "mceEditor",
    directionality: 'rtl',
    language: 'fa',
    menubar: "tools table format view insert edit",
    height: 500,
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
    toolbar: 'formatselect  | styleselect | bold italic | alignleft aligncenter alignright alignjustify ltr rtl | bullist numlist outdent indent | link  |     fullscreen'
});
</script>
<div class="panel-body text-decoration">
    <div class='text-content'>
        <form action="{{ route('hamafza.alert_save') }}" method="post" name="form" id="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <td>
                            عنوان
                        </td>
                        <td>
                            <input type="hidden" name="alertid" value="{{$id}}">
                            <input type="text" size="100" dir="rtl" id="alert_title" class="form-control required" value="{{$name}}" name="alert_name"> 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea class="mceEditor" name="descr"> {{$Comment}} </textarea>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <button name="addasubject" class="btn btn-primary FloatLeft" type="submit">تایید</button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>

    </div>
</div>

@stop