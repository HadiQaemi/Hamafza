<!-- Java_Script______ File Manager ______Java_Script -->
<script type="text/javascript">
    var rows_selected = [];
    var HFM_table_error_uploaded_file = $('#failed_upload_files').DataTable();
    var HFM_table_success_uploaded_file = $('#success_upload_files').DataTable();
    Object.size = function (obj) {
        var size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
        return size;
    };

    function HFM_UploadFiles(FormData, Section) {
        $.ajax({
            type: 'post',
            url: "{{URL::route('FileManager.UploadWithAddToSession',array('section'=>""))}}/" + Section,
            data: FormData,
            dataType: "json",
            success: function (data) {
                $('#HFM_UploadForm').show();
                $('#HFM_UploadProgress').hide();
                $("#HFM_UploadForm :file").filestyle('clear');
                $("#HFM_progress_text").text('0%');
                $("#HFM_progress_bar").css("width", "0%");
                $('#HFM_Modal').modal('hide');
                $('#HFM_ResultUploadFiles').modal({show: true});
                HFM_ShowUploadResults(data.failed, data.succeeded);
                HFM_LoadUploadedFiles(Section, data.attachment_files);
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        $("#HFM_progress_text").text(Math.round(percentComplete * 100) + '%');
                        $("#HFM_progress_bar").css("width", percentComplete * 100 + '%')
                    }
                }, false);
                return xhr;
            },
            error: function (e) {
                alert("ERROR: " + e);
            },
            processData: false,
            contentType: false
        });
    }

    function HFM_AddSelectedFiles(Section) {
        var selected = rows_selected;
        //console.log(selected);
        var Attachments = Object.keys(selected).map(function (key) {
            return selected[key];
        });
        $.ajax({
            type: 'post',
            url: '{{URL::route("FileManager.AddSelectedFileToSession",array("section"=>""))}}/' + Section,
            data: {Attachments: Attachments},
            success: function (data) {
                $('#HFM_Modal').modal('hide');
                HFM_ShowUploadResults(data.failed, data.succeeded);
                HFM_LoadUploadedFiles(Section, data.attachment_files);
            },
            dataType: "json"
        });
    }

    function HFM_ShowUploadResults(dataSetError, dataSetSuccess) {
        $('#HFM_ResultUploadFiles').modal({show: true});
        if (dataSetError.length > 0) {
            $('#HFM_ResultUploadFiles .nav-tabs a[href="#error_upload_content"]').tab('show');
        }
        else {
            $('#HFM_ResultUploadFiles .nav-tabs a[href="#success_upload_content"]').tab('show');
        }
        HFM_table_error_uploaded_file.destroy();
        HFM_table_error_uploaded_file =
            $('#failed_upload_files').DataTable({
                "dom": window.CommonDom_DataTables,
                data: dataSetError,
                autoWidth: false,
                language: window.LangJson_DataTabels,
                processing: true,
                searching: false,
                "scrollX": true,
                info: false,
                paging: false,
                columns: [
                    /*{"data": "OrginalFileName"},
                    {"data": "Size", "width": "30px"},*/
                    {
                        "data": "error",
                        "mRender": function (data, type, full) {
                            var out =
                            '<div style="margin:0; padding:0;">';
                            for (var x in data) { out += '<span style="color: red;">' + data[x] + '</span>'; }
                            out += ' » ' + full.OrginalFileName + '</div>';
                            return out;
                        }
                    },
                ]
            });
        HFM_table_success_uploaded_file.destroy();
        HFM_table_success_uploaded_file =
            $('#success_upload_files').DataTable({
                "dom": window.CommonDom_DataTables,
                data: dataSetSuccess,
                autoWidth: false,
                language: window.LangJson_DataTabels,
                processing: true,
                searching: false,
                "scrollX": true,
                info: false,
                paging: false,
                columns: [
                    {"data": "OrginalFileName"},
                    {"data": "MimeType"},
                    {"data": "Size"},
                    {
                        "data": "ID",
                        "mRender": function (data, type, full) {
                            var out = '<a href="{{route('FileManager.DownloadFile',['ID',''])}}/' + data + '" ' +
                                'class="' + full.Icon + '"></a>';
                            return out;
                        }
                    }
                ]
            });
    }

    function HFM_LoadUploadedFiles(Section, Files) {
        Files = Files || false;
        var out = '';
        if (Files != false) {
            $.each(Files, function (key, value) {
                var URL = '{{URL::route("FileManager.RemoveFileFromSession",array("section"=> "","record"=>""))}}';
                out += '' +
                    '<div class="well well-sm tooltip_area" style="margin: 2px 5px; float: right; position: relative;">\n' +
                    '   <div style="position: absolute; left: -8px; bottom: -8px; cursor: pointer;"' +
                    '        onclick="HFM_RemoveFFS(' + "'" + Section + "','" + value.ID + "')" + '"' +
                    '        class="text-danger RemoveFFS-Btn" ' +
                    '        id="ID_' + Section + '_' + value.ID + '">\n' +
                    '       <i class="glyphicon glyphicon-remove"></i> \n' +
                    '   </div>\n' +
                    '   <div class="tooltip_text">\n';
                if ((typeof value.Icon != "undefined" || value.Icon != null) && value.Icon == "glyphicon glyphicon-picture") {
                    out += '<div> <img style="height:120px; width:170px;" src="{{URL::route("FileManager.DownloadFile", array("type"=>"ID","id"=>""))}}/' + value.ID + '"></div>\n';
                }
                else {
                    out += '<div style="height:45px; width:170px; direction:ltr;"><h5> <span>' + value.Size + '</span></h5><h5>' + value.MimeType + '</h5></div>\n';
                }
                out += '</div>\n';
                out += '<i style="cursor: default;" class="';
                if (typeof value.Icon != "undefined" || value.Icon != null) {
                    out += value.Icon;
                }
                else {
                    out += 'glyphicon glyphicon-file ';
                }
                out += '"></i>\n';
                out += '<span>' + value.OrginalFileName + '</span>\n';
                out += '</div>';
            });
        }
        else {
            out = '<div style="color: #888a85;">{{trans("filemanager.attachment_not_found")}}</div>';
        }
        //console.log(Section);
        $('#HFM_ResultsArea_' + Section).empty();
        $('#HFM_ResultsArea_' + Section).append(out);
    }

    function HFM_RemoveFFS(Section, FileID) {
        var confirm_result = confirm("{{trans('filemanager.are_you_sure')}}");
        if (confirm_result == true) {
            var link = '{{URL::route('FileManager.RemoveFileFromSession',array('section'=> "",'record'=>''))}}/' + Section + "/" + FileID;
            $.ajax({
                type: 'post',
                url: link,
                data: {section: Section, record: FileID},
                success: function (data) {
                    if (data.success == true) {
                        HFM_LoadUploadedFiles(Section, data.All_Attachments);
                    }
                },
                dataType: "json"
            });
        }
    }

    function HFM_RemoveAllFFS(Section) {
        var confirm_result = confirm("{{trans('filemanager.are_you_sure')}}");
        if (confirm_result == true) {
            var link = '{{URL::route('FileManager.RemoveFileFromSession',array('section'=> "",'record'=>''))}}/' + Section + "/AllFile";
            $.ajax({
                type: 'post',
                url: link,
                data: {
                    AllRemove: Section,
                    success: function () {
                        HFM_LoadUploadedFiles(Section);
                    }
                }
            });
        }
    }

    $(document).ready(function () {
        $('.mousemove').off();
        $('.HFM_ModalOpenBtn').off();
        $('.HFM_UploadFormSubmitBtn').off();
        $('.HFM_AddSelectedFilesSubmitBtn').off();
        $('.HFM_RemoveAllFileFSS_SubmitBtn').off();

        $(document).on('click', '.HFM_ModalOpenBtn', function () {
            var $this = $(this);
            if ($("input[name='select_all']:indeterminate").length > 0 || $("input[name='select_all']:checked").length > 0) {
                $("input[name='select_all']").click();
            }
            rows_selected = [];
            $('#HFM_Modal').modal({show: true});
            $('#HFM_Modal #HFM_InputSectionName').val($this.data('section'));
            if ($this.data('multi_file') == 'Single') {
                $('#id_input_files').attr('multiple', false);
            }
            else {
                $('#id_input_files').attr('multiple', true);
            }
        });

        $(document).on('click', '.HFM_RemoveAllFileFSS_SubmitBtn', function () {
            var $this = $(this);
            HFM_RemoveAllFFS($this.data('section'));
        });

        $(document).on('click', '#HFM_AddSelectedFilesSubmitBtn', function () {
            var Section = $('#HFM_Modal #HFM_InputSectionName').val();
            HFM_AddSelectedFiles(Section);
        });

        $(document).on('click', '#HFM_UploadFormSubmitBtn', function () {
            var formElement = document.querySelector('#HFM_UploadForm');
            var formData = new FormData(formElement);
            var Section = $('#HFM_Modal #HFM_InputSectionName').val();
            $('#HFM_UploadForm').hide();
            $('#HFM_UploadProgress').show();
            HFM_UploadFiles(formData, Section);
        });

        $('[data-toggle="tooltip"]').tooltip({html: true, show: true});

        $(document).on('mousemove', '[data-toggle="tooltip"]', function () {
            $('[data-toggle="tooltip"]').tooltip({html: true});
        });
    });


    /*-------------------- GridMyFile - DataTables -----------------*/
    function updateDataTableSelectAllCtrl(table) {
        var $table = table.table().node();
        var $chkbox_all = $('tbody input[type="checkbox"]', $table);
        var $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
        var chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);

        // If none of the checkboxes are checked
        if ($chkbox_checked.length === 0) {
            chkbox_select_all.checked = false;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
            }
            // If all of the checkboxes are checked
        } else if ($chkbox_checked.length === $chkbox_all.length) {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
            }
            // If some of the checkboxes are checked
        } else {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = true;
            }
        }
    }
    $(document).ready(function () {
        var table = $('#HFM_GridMyFile').DataTable({
            'language': window.LangJson_DataTables,
            'processing': true,
            'serverSide': true,
            "scrollX": true,
            'ajax': {
                'url': "{!! route('FileManager.GridMyFiles') !!}",
                'type': "POST"
            },
            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'width': '1%',
                'className': 'dt-body-center',
                'render': function (data, type, full, meta) {
                    return '<input type="checkbox">';
                }
            }],
            'columns': [
                {data: 'id'},
                {data: 'originalName'},
                {data: 'extension'},
                {data: 'mimeType'},
                {data: 'size'},
                {data: 'created_at'}
            ],
            'order': [[1, 'asc']],
            "pageLength": 5,
            "lengthChange": false,
            'rowCallback': function (row, data, dataIndex) {
                // Get row ID
                var rowId = data['id'];
                // If row ID is in the list of selected row IDs
                if ($.inArray(rowId, rows_selected) !== -1) {
                    $(row).find('input[type="checkbox"]').prop('checked', true);
                    $(row).addClass('selected');
                }
            },
            "dom": '<"col-xs-7"f><"col-xs-5 text-left"i>t<"col-xs-12 text-center"p><"clearfixed">'
        });
        // Handle click on checkbox
        $('#HFM_GridMyFile tbody').on('click', 'input[type="checkbox"]', function (e) {
            var $row = $(this).closest('tr');
            // Get row data
            var data = table.row($row).data();
            //console.log(data);
            // Get row ID
            var rowId = data['id'];
            // Determine whether row ID is in the list of selected row IDs
            var index = $.inArray(rowId, rows_selected);
            // If checkbox is checked and row ID is not in list of selected row IDs
            if (this.checked && index === -1) {
                rows_selected.push(rowId);
                // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
            } else if (!this.checked && index !== -1) {
                rows_selected.splice(index, 1);
            }
            if (this.checked) {
                $row.addClass('selected');
            } else {
                $row.removeClass('selected');
            }
            // Update state of "Select all" control
            updateDataTableSelectAllCtrl(table);
            // Prevent click event from propagating to parent
            e.stopPropagation();
        });

        // Handle click on table cells with checkboxes
        $('#HFM_GridMyFile').on('click', 'tbody td, thead th:first-child', function (e) {
            $(this).parent().find('input[type="checkbox"]').trigger('click');
        });

        // Handle click on "Select all" control
        $('thead input[name="select_all"]', table.table().container()).on('click', function (e) {
            if (this.checked) {
                $('#HFM_GridMyFile tbody input[type="checkbox"]:not(:checked)').trigger('click');
            } else {
                $('#HFM_GridMyFile tbody input[type="checkbox"]:checked').trigger('click');
            }

            // Prevent click event from propagating to parent
            e.stopPropagation();
        });

        // Handle table draw event
        table.on('draw', function () {
            // Update state of "Select all" control
            updateDataTableSelectAllCtrl(table);
        });

    });
</script>