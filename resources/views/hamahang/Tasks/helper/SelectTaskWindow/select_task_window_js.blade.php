<script>
    var rows_selected = [];
    var selected_statuses = [];
    var selected_immediate = [];
    var selected_importance = [];
    var timeoutHandle = window.setTimeout(function () {},1);
    /*------------------------------------------------------*/
    $(document).ready(function () {
        $(document).on('click', '#select_task_window_table tbody input[type="checkbox"]', function (e) {
            var $row = $(this).closest('tr');

            // Get row data
            var data = window.select_task_window.row($row).data();
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
            //updateDataTableSelectAllCtrl(table);
            // Prevent click event from propagating to parent
            e.stopPropagation();
            $('#selected_items_count').html(rows_selected.length);
            console.log(rows_selected);
        });

        $('#jstree_div').on("select_node.jstree", function (e, data) {;
            do_filter();
        });
        $('#jstree_div').bind("deselect_node.jstree", function (evt, data) {
            do_filter();
        });

        window.select_task_window = $('#select_task_window_table').DataTable({
            "dom": window.CommonDom_DataTables,
            'language': window.LangJson_DataTables
        });

        jstree_select_task();

        if(window_use_type == 200)
        {
            refresh_window_tasks();
        }
    });

    function do_filter() {
        window.clearTimeout(timeoutHandle);
        timeoutHandle = window.setTimeout(function () {
            refresh_window_tasks(1);
        },1500);
    }
    function add_selected_tasks() {
        var sendInfo = {
            type: window_use_type,
            tasks: rows_selected,
            item_id: current_use_type_item
        };
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.tasks.use_selected_tasks') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                location.reload();
            }
        });

    }
    function jstree_select_task() {
        switch (window_use_type)
        {
            case 0:
            {
                var tree_nodes = [
                    {
                        'checkbox': true,
                        'text': 'همه',
                        'state': {
                            'opened': true
                        },
                        'id': 999,
                        'children': [
                            {
                                'text': 'وظایف عادی',
                                'id': 100
                            },
                            {
                                'text': 'وظایف پروژه ای',
                                'id': 200
                            },
                            {
                                'text': 'وظایف فرآیندی',
                                'id': 300
                            }
                        ]
                    }
                ];
                break;
            }
            case 1:
            {
                var tree_nodes = [
                    {
                        'checkbox': true,
                        'text': 'همه',
                        'state': {
                            'opened': true
                        },
                        'id': 999,
                        'children': [

                            {
                                'text': 'وظایف پروژه ای',
                                'id': 200
                            }
                        ]
                    }
                ];
                break;
            }
            case 2:
            {
                var tree_nodes = [
                    {
                        'checkbox': true,
                        'text': 'همه',
                        'state': {
                            'opened': true,
                            'disabled': true,
                        },
                        'id': 999,
                        'children': [
                            {
                                'text': 'وظایف عادی',
                                'id': 100,
                                'state': {
                                    'selected': true,
                                },
                            },
                            {
                                'text': 'وظایف پروژه ای',
                                'id': 200,
                                'state': {
                                    'disabled': true,
                                }
                            },
                            {
                                'text': 'وظایف فرآیندی',
                                'id': 300,
                                'state': {
                                    'disabled': true,
                                }
                            }
                        ]
                    }
                ];
                break;
            }
        }
        $('#jstree_div').jstree({
            'core': {
                'data': tree_nodes,
                "themes": {
                    "icons": true
                }
            },
            "checkbox": {
                "three_state": true,
                "whole_node": true,
                "keep_selected_style": true,
                "tie_selection": true,
                "hide_checkboxes": true
            },
            "plugins": ["checkbox", "real_checkboxes"]
        });
    }
    function refresh_window_tasks(id) {
        var selected_types = $('#jstree_div').jstree('get_selected');
        if(selected_types.length > 0 || window_use_type == 200) {
            $('#selected_items_count').html(0);
            if (window.select_task_window)
                window.select_task_window.destroy();
            var sendInfo = {
                window_use_type: window_use_type,
                task_types: selected_types,
                selected_task_states: selected_statuses,
                selected_task_importance: selected_importance,
                selected_task_immediate: selected_immediate,
                title: $('#title').val(),
                tasks_assign_type: $('input[name="tasks_assign_type"]:checked').val()
            }
            window.select_task_window = $('#select_task_window_table').DataTable({
                "dom": window.CommonDom_DataTables,
                'language': window.LangJson_DataTables,
                "bFilter": false,
                "bLengthChange": false,
                //'processing': true,
                //'serverSide': true,
                'ajax': {
                    'url': "{!!  route('hamahang.tasks.fetch_tasks_for_select_task_window') !!}",
                    'type': "POST",
                    'data': sendInfo
                },
                'columnDefs': [{
                    'targets': 0,
                    'searchable': true,
                    'orderable': false,
                    'width': '1%',
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta) {
                        return '<input type="checkbox" />';
                    }
                }],
                'columns': [
                    {data: 'id'},
                    {data: 'title'}
                ],
                'order': [[1, 'asc']],
                "pageLength": 5//,
                //"lengthChange": false
            });
        }
        else
        {
            alert('هیچ موردی انتخاب نشده است');
        }

    }
    function selected_task_status(id){
        var index = selected_statuses.indexOf(id);
        if(index == -1)
        {
            selected_statuses.push(id);
        }
        else
        {

            if (index > -1)
            {
                selected_statuses.splice(index, 1);
            }
        }
        do_filter();
    }
    function selected_task_immediate(id) {
        var index = selected_immediate.indexOf(id);
        if(index == -1)
        {
            selected_immediate.push(id);
        }
        else
        {
            if (index > -1) {
                selected_immediate.splice(index, 1);
            }
        }
        do_filter();

    }
    function selected_task_importance(id) {
        var index = selected_importance.indexOf(id);
        if(index == -1)
        {
            selected_importance.push(id);
        }
        else
        {
            if (index > -1) {
                selected_importance.splice(index, 1);
            }
        }
        do_filter();
    }
</script>