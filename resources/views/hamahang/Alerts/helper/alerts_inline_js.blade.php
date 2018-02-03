<script>
    function initmce() {
        tinymce.init({
            mode: "textareas",
            editor_selector: "mceEditor",
            directionality: 'rtl',
            language: 'fa',
            menubar: "tools table format view insert edit",
            height: 250,
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
    }

    var alerts_grid_table = "";

    function alertsDataTable(target_id) {
        alerts_grid_table = $('#' + target_id).DataTable({
            "dom": CommonDom_DataTables,
            "columnDefs": [
                {"className": "align-center", "targets": "_all"}
            ],
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.alerts.get_alerts') !!}',
                type: 'POST'
            },
            columns: [
                {
                    "data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    width: '25%',
                    data: 'name',
                    name: 'name'
                },
                {
                    width: '60%',
                    className: "dt-center",
                    data: 'comment',
                    name: 'comment',
//                    mRender: function (data, type, full) {
//                        return full.comment.substr(0,75) + '...';
//                    }
                },
                {
                    width: '10%',
                    searchable: false,
                    sortable: false,
                    mRender: function (data, type, full) {
                        var result = '';
                        result += '' +
                            '<button style="margin-right: 3px;" title="ویرایش گروه" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_item_edit" ' +
                            '   data-grid_item_id="' + full.id + '">' +
                            '</button>';
                        result += '' +
                            '<button style="margin-right: 3px;" title="حذف گروه" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_item" data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.title + '"></button>';
                        return result;
                    }
                },
            ]
        });
    }

    function create_new_alert() {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.alerts.add_new_alert')}}',
            dataType: "json",
            data: {
                name: $('#alert_title').val(),
                comment: tinyMCE.get('comment').getContent()
            },
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    alerts_grid_table.ajax.reload();
                    $('a[href="#alerts_list"]').click();
                    document.getElementById('create_new_alert').reset();
                }
                else {
                    var errors = '';
                    for (var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] + '</li>'
                    }
                    jQuery.noticeAdd({
                        text: errors,
                        stay: false,
                        type: 'error'
                    });
                }
            }
        });
    }

    function generate_edit_form(item_id) {
        tinymce.EditorManager.execCommand('mceRemoveEditor',true, 'edit_form_comment');
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.alerts.edit_alert_view')}}',
            dataType: "json",
            data: {item_id: item_id},
            success: function (result) {
                if (result.success == true) {
                    $('#edit_form_alert_id').val(item_id);
                    $('#alert_edit_form').html(result.content);
                    tinymce.EditorManager.execCommand('mceAddEditor',true, 'edit_form_comment');
                    var li_tab = '<li class=""><a href="#edit_alert" data-toggle="tab" class="legitRipple edit_tab" aria-expanded="false"><span class=""></span> ویرایش اطلاعیه</a></li>';
                    $('.edit_tab').remove();
                    $('#manage_tab_pane').append(li_tab);
                    $('#manage_tab_pane a[href="#edit_alert"]').tab('show');
                }
                else {
                    var errors = '';
                    for (var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] + '</li>'
                    }
                    jQuery.noticeAdd({
                        text: errors,
                        stay: false,
                        type: 'error'
                    });
                }
            }
        });
    }

    function edit_alert() {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.alerts.edit_alert')}}',
            dataType: "json",
            data: {
                item_id: $('#edit_form_alert_id').val(),
                name: $('#edit_form_alert_title').val(),
                comment: tinyMCE.get('edit_form_comment').getContent()
            },
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    alerts_grid_table.ajax.reload();
                    $('a[href="#alerts_list"]').click();
                    document.getElementById('create_new_alert').reset();
                }
                else {
                    var errors = '';
                    for (var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] + '</li>'
                    }
                    jQuery.noticeAdd({
                        text: errors,
                        stay: false,
                        type: 'error'
                    });
                }
            }
        });
    }

    function destroy_alert(item_id) {
        confirmModal({
            title: '{{trans('alerts.delete_alert')}}',
            message: '{{trans('alerts.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.alerts.delete_alert')}}',
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    success: function (result) {
                        $('#delete-modal').modal('hide');
                        if (result.success == true) {
                            jQuery.noticeAdd({
                                text: result.message,
                                stay: false,
                                type: 'success'
                            });
                            alerts_grid_table.ajax.reload();
                        }
                        else {
                            var errors = '';
                            for (var k in result.error) {
                                errors += '' +
                                    '<li>' + result.error[k] + '</li>'
                            }
                            jQuery.noticeAdd({
                                text: errors,
                                stay: false,
                                type: 'error'
                            });
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    $(document).click(function () {

        $("#btn_add_new_alert").off();
        $("#btn_add_new_alert").click(function () {
            create_new_alert();
        });


        $("#btn_edit_alert").off();
        $("#btn_edit_alert").click(function () {
            edit_alert();
        });

        $(".btn_grid_destroy_item").click(function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            destroy_alert(item_id);
        });
    });

    $(document).on("click", ".btn_grid_item_edit", function () {
        var $this = $(this);
        var item_id = $this.data('grid_item_id');
        generate_edit_form(item_id);


    });

    $(document).on("click", "#btn_cancel_add_new_alert", function () {
        $('a[href="#alerts_list"]').click();
        document.getElementById('create_new_alert').reset();


    });

    $("#btn_cancel_new_relation").click(function () {
        $('a[href="#relations_list"]').click();
        document.getElementById('create_new_relation').reset();
    });

    $("#btn_cancel_edit_relation").click(function () {
        $('a[href="#relations_list"]').click();
        document.getElementById('edit_form_relation').reset();
    });

    $(document).ready(function () {
        alertsDataTable('AlertsGrid');
        initmce();
    });
</script>