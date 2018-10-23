<script>
    var success_msg_area_id = '';
    var error_msg_area_id = '';

    var Grid_Table = {};
    $.ajax({
        type: 'post',
        url: '{{ route('hamahang.users.countUser') }}',
        dataType: 'json',
        success: function (count) {
            setDataTables('.GridDataUser', 'Grid_Table', '', '',count);
        },
    })
var num =0;
    function reloadDatatable(varibleDataTable) {
        window[varibleDataTable].ajax.reload();
    }
    var num = 0;
    function setDataTables(element, varibleDataTable, extra2, data,count) {
        //DataTable grid in Inbox

        window[varibleDataTable] = $(element).DataTable({
                "processing": true,
                "serverSide": true,
                "autoWidth": false,
                "bSort": false,
                "language": window.LangJson_DataTables,
                ajax: {
                    url: '{!! route('hamahang.users.get_users') !!}',
                    data: function (d) {
                        d.view_mode = 0, d.extra = extra2;
                    },
                    type: 'POST'
                },
                "createdRow": function (row, data, index) {
                   // console.log(data);
                    // Add identity if it specified
                    if (data.hasOwnProperty("id_code")) {
                        row.id = "row-" + data.id_code;
                    }
                    $(row).addClass('row_records');

                },
                "dom": window.CommonDom_DataTables,
                initComplete: function () {
//                    if(data.length != 0){
//                        toolbar();
//                        $.each(data,function (key,value){
//                            $(".roles_filter").append('<option selected="selected" value="'+value.id+'">'+value.text+'</option>');
//                        });
//                    }

                },
                columns: [
                    {
                        mRender: function (data, type, full) {
                            /*var varibleCount = count - num;
                            num++;
                            return varibleCount;*/
                            return '';
                        }
                    },
                    {
                        className: "Name", data: "Name",
                        searchable: true,
                        mRender: function (data, type, full) {
                            return '<a target="_blank" href="{{ url('') }}/'+full['Uname']+'">'+full['Name'] + ' ' + full['Family']+'</a>';
                        }
                    },
                    {
                        className: "Uname", data: "Uname",
                        mRender: function (data, type, full) {
                            return full['Uname'];
                        }
                    },
                    {
                        className: " text-center",
                        mRender: function (data, type, full) {
                            var res = ''
                            $.each(full['_roles'], function (key, value) {
                                color = '';
                                if (key % 2 == 0) {
                                    color = 'background-color: aliceblue';
                                }

                                res = res + '<div  style="padding:10px; " >' + value.display_name + ' ' + value.name + '</div>';
                            });
                            var length_group = '';
                            var length = '-';
                            var tooltip_text = '';
                            tooltip_text = ''

                            if (full['_roles'].length == 1) {
                                length = res;
                                tooltip_text = '';

                            } else if (full['_roles'].length > 1) {
                                length = full['_roles'].length;
                                tooltip_text = '<div class="tooltip_text" style="width: 169px;">' + res + '</div>';
                            }
//                            return  '<button  type="button" class="btn btn-default btn-sm '+length_group+'"  data-placement="bottom" > '+length+'</button> ' +
//                                '<div style="display:none" class="title_group_for_modal"> گروه های اختصاص داده شده به صفت '+full['attribute_name']+'</div><div style="display: none;position: absolute;box-shadow: 5px 5px 5px #dcd7d7;background-color: #fff;padding: 10px;" class="length_group_toggle">'+res+'</div>';
                            return '<div class=" tooltip_area" style="margin: 2px 5px; float: right; position: relative;width: 100%;">' +
                                tooltip_text +
                                '   <span>' + length + '</span>' +
                                '</div>';

                        }

                    },
                    {
                        className: "date",
                        mRender: function (data, type, full) {
                            if (full['date'])
                                return full['date'];
                            else
                                return '';
                        }
                    },
                    {
                        className: "reward",
                        mRender: function (data, type, full) {
                            return full.total_scores;
                        }
                    },
                    {
                        className: "Active",
                        mRender: function (data, type, full) {
                            if (full['Active'] == '1')
                                return 'فعال';
                            else
                                return 'غیر فعال';
                        }
                    },
                    {
                        className: "operations",
                        mRender: function (data, type, full) {
                            return '<button style="margin-right: 3px;" title="ویرایش" type="button" class="btn btn-xs bg-warning fa fa-edit btn_grid_item_edit" data-toggle="modal" data-target="#modal_attribute" ></button>' +
                                '<button style="margin-right: 3px;"  title="حذف" type="button" class="btn btn-xs bg-danger fa fa-remove btn_grid_destroy_item" data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.title + '"></button>';
                        }
                    }
                ]

            }
        )
        ;
        window[varibleDataTable].on('draw.dt order.dt search.dt', function () {
            window[varibleDataTable].column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    }
    toolbar();
    function toolbar() {
        $(".roles_filter").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '100%',
            placeholder: "فیلتر نقش",
            ajax: {
                url: "{{ route('auto_complete.roles') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    //console.log(data);
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });
    }

    $(".roles_list").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
        ajax: {
            url: "{{ route('auto_complete.roles') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                //console.log(data);
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

    $(".roles_list_edit").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
        ajax: {
            url: "{{ route('auto_complete.roles') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                //console.log(data);
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });


    //$(".roles_list").select2('destroy');
    $(".roles_list").select2("trigger", "select", {
        data: {id: "2", text: 'registerd کاربر عادی'}
    });
    $(document).on('click', '#form_created_new_btn', function () {
        $.ajax({
            type: 'post',
            url: '{{ route('hamahang.users.add_user') }}',
            data: $('#form_created_new').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.success == true) {
                    success_msg_area_id = 'error_msg_add_user';
                    messageBox('success', '', data.message, {'id': 'success_msg_area_id'});
                    ajax_success_msg(data.message);
                    reloadDatatable('Grid_Table');
                } else if (data.success == false) {
                    error_msg_area_id = 'success_msg_add_user';
                    messageBox('error', '', data.error, {'id': 'success_msg_area_id'});
                    ajax_error(data.error);
                    reloadDatatable('Grid_Table');
                }
            },
        })
    });

    $(document).on('click', '#form_edit_btn', function () {
        $.ajax({
            type: 'post',
            url: '{{ route('hamahang.users.edit_user') }}',
            data: $('#form_edit_item').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.success == true) {
                    success_msg_area_id = 'error_msg_edit_user';
                    ajax_success_msg(data.message);
                    reloadDatatable('Grid_Table');
                } else if (data.success == false) {
                    error_msg_area_id = 'success_msg_edit_user';
                    ajax_error(data.error);
                    reloadDatatable('Grid_Table');
                }
            },
        })
    });

    $(document).on('click', '.manage_tab_click', function () {
        $('.edit_tab_click').hide();
    });
    $(document).on('click', '.add_tab_click', function () {
        $('.edit_tab_click').hide();
    });

    $('.edit_tab_click').hide();
    $(document).on('click', '.btn_grid_item_edit', function () {
        var res = $(this).parent().parent().attr('id');
        var id = res.substring(4);
        $.ajax({
            type: 'post',
            url: '{{ route('hamahang.users.edit_show_users') }}',
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#Name_edit').val(data.Name);
                $('#Family_edit').val(data.Family);
                $('#Email_edit').val(data.Email);
                $('#Uname_edit').val(data.Uname);
                $('#password_edit').val(data.password);
                if(data.profile != null)
                {
                    $('#modal_mobile_input_edit').val(data.profile.Mobile);
                    $('#modal_phone_input_edit').val(data.profile.Tel_number);
                    $('#province_edit').val(data.profile.Province);
                    $('#modal_relevant_organization_input_edit').val(data.profile.relevant_organization);
                    $("#modal_province_input_edit").val(data.profile.Province).change();
                    $("#modal_city_input_edit").val(data.profile.City).change();
                }
                if(data.educations.length>=1)
                    $("#modal_education_input_edit").val(data.educations[data.educations.length - 1].grade).change();
                $('#item_id').val(data.id);
                var arr = [];
                if (data.role_policy != '') {
                    $(".roles_list_edit").val('-').change();
                    $.each(data._roles, function (key, value) {
                        $(".roles_list_edit").append('<option selected="selected" value="' + value.id + '">' + value.display_name + ' ' + value.name + '</option>');
                    });
                } else {
                    $(".roles_list_edit").val('-').change();
                }
            },
        })
        $('.edit_tab_click').show();
        $('.edit_tab_click').click();

    });

    $(document).on('click', '.btn_grid_destroy_item', function () {
        var res = $(this).parent().parent().attr('id');
        var id = res.substring(4);
        confirmModal({
            title: 'حذف کاربر',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    type: 'post',
                    url: '{{ route('hamahang.users.destroy_user') }}',
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == true) {
                            success_msg_area_id = 'error_msg_destroy_user';
                            ajax_success_msg(data.message);

                            reloadDatatable('Grid_Table');
                            $('#destroy-mmodal').modal('hide')
                        } else if (data.success == false) {
                            error_msg_area_id = 'success_msg_destroy_user';
                            ajax_error(data.error);
                            reloadDatatable('Grid_Table');
                        }
                    },
                })
            },
            afterConfirm: 'close'
        });
    });


    $(document).on('click', '.select_filter', function () {
        var roles_filter = $('.roles_filter').val();
        var data = $(".roles_filter").select2('data')
        window['Grid_Table'].destroy();
        $.ajax({
            type: 'post',
            url: '{{ route('hamahang.users.countFilterUser') }}',
            dataType: 'json',
            data:{extra:roles_filter},
            success: function (count) {
                setDataTables('.GridDataUser', 'Grid_Table', roles_filter, data,count);
            },
        })


    });

    //////////////////////////////////message
    function ajax_error(errors) {
        empty_all_msg_area();
        var row = document.createElement('div');
        row.setAttribute('class', 'row');
        var target = errors;
        for (var k in target) {
            if (target.hasOwnProperty(k)) {
                var div = document.createElement('div');
                div.setAttribute("class", "alert alert-danger alert-styled-left");
                div.setAttribute("style", "height: 24px;padding-top: 3px;margin-bottom: 5px;");
                var button = document.createElement('button');
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'close');
                button.setAttribute('data-dismiss', 'alert');
                var in_b_span_x = document.createElement('span');
                in_b_span_x.setAttribute("style", "font-size: 15px;position: absolute;");
                in_b_span_x.append('x');
                var in_b_span = document.createElement('span');
                in_b_span.setAttribute('class', 'sr-only');
                in_b_span.append('Close');
                button.append(in_b_span_x);
                button.append(in_b_span);
                var span_text = document.createElement('span');
                span_text.append(target[k]);
                div.append(button);
                div.append(span_text);
                row.append(div);
            }
        }
        $('#' + error_msg_area_id).append(row);
        $('#' + error_msg_area_id).show();
        setTimeout(function () {
            $('#' + error_msg_area_id).toggle();
        }, 5000);
    }

    function ajax_success_msg(messages) {
        empty_all_msg_area();
        var row = document.createElement('div');
        row.setAttribute('class', 'row');
        var target = messages;
        for (var k in target) {
            if (target.hasOwnProperty(k)) {
                var div = document.createElement('div');
                div.setAttribute("class", "alert alert-success alert-styled-left");
                div.setAttribute("style", "height: 24px;padding-top: 3px;margin-bottom: 5px;");
                var button = document.createElement('button');
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'close');
                button.setAttribute('data-dismiss', 'alert');
                var in_b_span_x = document.createElement('span');
                in_b_span_x.setAttribute("style", "font-size: 15px;position: absolute;");
                in_b_span_x.append('x');
                var in_b_span = document.createElement('span');
                in_b_span.setAttribute('class', 'sr-only');
                in_b_span.append('Close');
                button.append(in_b_span_x);
                button.append(in_b_span);
                var span_text = document.createElement('span');
                span_text.append(target[k]);
                div.append(button);
                div.append(span_text);
                row.append(div);
            }
        }
        $('#' + success_msg_area_id).append(row);
        $('#' + success_msg_area_id).show();
        setTimeout(function () {
            $('#' + success_msg_area_id).toggle();
        }, 5000);

    }

    function empty_all_msg_area() {
        $('#' + error_msg_area_id).empty();
        $('#' + success_msg_area_id).empty();
    }


</script>