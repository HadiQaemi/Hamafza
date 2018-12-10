<script>

    Grid_Table = $('#fileCreated_ME_RecieveGrid').DataTable({
        dom: window.CommonDom_DataTables,
        "processing": true,
        "serverSide": true,
        "language": window.LangJson_DataTables,
        ajax: {
            url: '{!! route('hamahang.files.get_file_all_other') !!}',
            type: 'POST'
        },
        columns: [

            {
                mRender: function (data, type, full) {
                    return full['id'] + '0';
                }
            },
            {
                data: 'title',

                mRender: function (data, type, full) {
                    return '<a target="_blank" href="{{ url('') }}/' + full['id'] + '0' + '">' + full['title'] + '</a>';
                }
            },
            {
                data: 'subject_type.name',
                mRender: function (data, type, full) {
                    if(full['subject_type'] == null )
                        return '';
                    else
                        return full['subject_type']['name'];
                }
            },
            {
                mRender: function (data, type, full) {
                    return full['visit'];
                }
            },
            {
                mRender: function (data, type, full) {

                    return full['like'];
                }
            },
            {
                mRender: function (data, type, full) {
                    return full['follow'];
                }
            },
            {
                mRender: function (data, type, full) {
                    if (full.owner)
                        return full.owner.Uname + ' (' + full.owner.Name + ' ' + full.owner.Family + ')';
                    else
                        return '';
                }
            },
            {
                mRender: function (data, type, full) {
                    return full['EditDate'];
                }
            },
            {
                width: "3%",
                searchable: false,
                sortable: false,
                mRender: function (data, type, full) {
                    var result = '';
                    result += '' +
                        '<button style="margin-right: 3px;" title="تنظیمات صفحه" type="button" class="jsPanels btn btn-xs bg-warning-400 fa fa-edit" href="/modals/setting?sid=' + full.id + '&type=subject&pid=' + full['id'] + '0' + '" ' +
                        '   data-grid_item_id="' + full.id + '" ' +
                        '   data-grid_item_type="edit" ' +
                        '   data-grid_item_name="' + full.name + '">' +
                        '</button>';
                    return result;
                }
            },
        ]
    });

    Grid_Table.column('0:visible')
        .order('desc')
        .draw();

    $(document).click(function () {

        $("#add_subjects_roles_view").off();
        $("#delete_subjects_roles_view").off();
        $("#add_subjects_roles_edit").off();
        $("#delete_subjects_roles_edit").off();

        $("#add_subjects_roles_view").click(function () {
            $("#add_subjects_roles_view").prop("disabled", true);
            $("#add_subjects_roles_edit").prop("disabled", true);
            $('#subject_role_loader_modal').modal('show');
            $('.attach_loader').addClass('loader');
            var role_id = $("#roles_list option:selected").val();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.files.add_subjects_role_show')}}',
                dataType: "json",
                data: {
                    role_id: role_id

                },
                success: function (result) {
                    $('#subject_role_loader_modal').modal('hide');
                    $('.attach_loader').removeClass('loader');
                    $("#add_subjects_roles_view").prop("disabled", false);
                    $("#add_subjects_roles_edit").prop("disabled", false);
                    if (result.success == true) {
                        jQuery.noticeAdd({
                            text: result.message,
                            stay: false,
                            type: 'success'
                        });
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
        });

        $("#delete_subjects_roles_view").click(function () {
            $("#delete_subjects_roles_view").prop("disabled", true);
            $("#delete_subjects_roles_edit").prop("disabled", true);
            $('#subject_role_loader_modal').modal('show');
            $('.detach_loader').addClass('loader');
            var role_id = $("#detach_roles_list option:selected").val();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.files.delete_subjects_role_show')}}',
                dataType: "json",
                data: {
                    role_id: role_id

                },
                success: function (result) {
                    $('#subject_role_loader_modal').modal('hide');
                    $('.detach_loader').removeClass('loader');
                    $("#delete_subjects_roles_view").prop("disabled", false);
                    $("#delete_subjects_roles_edit").prop("disabled", false);
                    if (result.success == true) {
                        jQuery.noticeAdd({
                            text: result.message,
                            stay: false,
                            type: 'success'
                        });
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
        });

        $("#add_subjects_roles_edit").click(function () {
            $("#add_subjects_roles_view").prop("disabled", true);
            $("#add_subjects_roles_edit").prop("disabled", true);
            $('#subject_role_loader_modal').modal('show');
            $('.attach_loader').addClass('loader');
            var role_id = $("#roles_list option:selected").val();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.files.add_subjects_role_edit')}}',
                dataType: "json",
                data: {
                    role_id: role_id

                },
                success: function (result) {
                    $('#subject_role_loader_modal').modal('hide');
                    $('.attach_loader').removeClass('loader');
                    $("#add_subjects_roles_view").prop("disabled", false);
                    $("#add_subjects_roles_edit").prop("disabled", false);
                    if (result.success == true) {
                        jQuery.noticeAdd({
                            text: result.message,
                            stay: false,
                            type: 'success'
                        });
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
        });

        $("#delete_subjects_roles_edit").click(function () {
            $("#delete_subjects_roles_view").prop("disabled", true);
            $("#delete_subjects_roles_edit").prop("disabled", true);
            $('#subject_role_loader_modal').modal('show');
            $('.detach_loader').addClass('loader');
            var role_id = $("#detach_roles_list option:selected").val();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.files.delete_subjects_role_edit')}}',
                dataType: "json",
                data: {
                    role_id: role_id

                },
                success: function (result) {
                    $('#subject_role_loader_modal').modal('hide');
                    $('.detach_loader').removeClass('loader');
                    $("#delete_subjects_roles_view").prop("disabled", false);
                    $("#delete_subjects_roles_edit").prop("disabled", false);
                    if (result.success == true) {
                        jQuery.noticeAdd({
                            text: result.message,
                            stay: false,
                            type: 'success'
                        });
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
        });

    });

    $(document).ready(function () {

        $('#roles_list').select2({
            dir: "rtl",
            width: '100%',
            placeholder: "{{ trans('tools.choose') }}",
            allowClear: true,
            data: {!! $roles !!}
        });

        $('#detach_roles_list').select2({
            dir: "rtl",
            width: '100%',
            placeholder: "{{ trans('tools.choose') }}",
            allowClear: true,
            data: {!! $roles !!}
        });

    });


</script>