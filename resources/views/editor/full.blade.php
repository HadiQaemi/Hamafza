<script type="text/javascript" src="{{url('tinymce/js/tinymce/tinymce.min.js')}}"></script>
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
            insert: {title: 'پودمان', items: 'OtherHamafza hamafza_dashboard Hamafza_subject Hamafza_keyword hamafza_form Hamafza_news hamafza_index  Hamafza_graph      Hamafza_thesarus     | anchor charmap| hr '},
            view: {title: 'View', items: 'visualaid'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats   | removeformat | '},
            table: {title: 'Table', items: 'inserttable deletetable | cell row column'},
            tools: {title: 'Tools', items: 'spellchecker code'}
        },
        style_formats: [
            {title: 'مثال', block: 'p', classes: 'code1'},
            {title: 'ارجاع به جدول،نمودار،تصویر', inline: 'span', attributes: {'class': 'number'}},
            {title: 'عنوان جدول  (در بالای جدول)', block: 'p', attributes: {'class': 'number1'}},
            {title: 'عنوان نمودار (در زیر نمودار)', block: 'p', attributes: {'class': 'number2'}},
            {title: 'عنوان تصویر (در زیر تصویر)', block: 'p', attributes: {'class': 'number3'}},
            {title: 'ماخذ (در زیر)', block: 'p', attributes: {'class': 'resource'}},
            {title: 'زیرنویس', inline: 'span', classes: 'subtitle'},
            {title: 'عمودی', block: 'span', attributes: {'class': 'rotate'}},
            {title: 'تصویر در ابتدای سطر', selector: 'img', attributes: {classes: 'floatright'}}
        ],
        table_default_attributes: {
            border: '1'
        },
        content_css: "{{App::make('url')->to('/')}}/theme/Content/css/content.css", // resolved to http://domain.mine/myLayout.css
        plugins: [
            'directionality hamafza advlist autolink lists link image charmap print preview anchor hr ',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code responsivefilemanager colorpicker'
        ],
        force_br_newlines: true,
        force_p_newlines: true,

        toolbar: 'formatselect | styleselect | bold italic | alignleft aligncenter alignright alignjustify ltr rtl | bullist numlist outdent indent | link image | media | fullscreen',
        external_filemanager_path: "{{App::make('url')->to('/')}}/filemanager/",
        //external_plugins: {"filemanager": "{{App::make('url')->to('/')}}/filemanager/plugin.min.js"}, filemanager_title: "مدیریت فایل ها",
        filemanager_access_key: "{{$UploadURL}}&upurl={{$Upurl}}",
        codemirror: {
            indentOnInit: true, // Whether or not to indent code on init.
            path: 'CodeMirror'
        },
        file_browser_callback: function(field_name, url, type, win)
        {
            var filebrowser = '{!! route('FileManager.tinymce_external_filemanager_form') . "?pid=$pid" !!}';
            filebrowser += (filebrowser.indexOf('?') < 0 ? '?' : '&') + 'type=' + type;
            tinymce.activeEditor.windowManager.open
            ({
                url: filebrowser,
                title: 'مدیریت فایل',
                width: 500,
                height: 300
            },
            {
                window: win,
                input: field_name
            });
            return false;
        }
    });
</script>