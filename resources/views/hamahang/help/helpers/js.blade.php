<script>
    var help_grid_table = '';

    $(document).ready(function ()
    {
        help_data_table('help_grid');
    });

    function help_data_table(target_id)
    {
        help_grid_table = $('#' + target_id).DataTable
        ({
            "dom":CommonDom_DataTables ,
            "language": window.LangJson_DataTables,
            ajax:
            {
                url: '{!! route('hamahang.help.help_content') !!}',
                type: 'POST'
            },
            columns:
            [
                {
                    'data': 'id',
                    render: function(data, type, full, meta)
                    {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'title',
                    render: function(data, type, full, meta)
                    {
                        return '<a class="jsPanels" href="{!! route('modals.help.view') !!}?id=' + full.id + '">' + full.title + ' <small>(' + full.blocks_count + ' {!! trans('help.title_blocks') !!})</small></a>';
                    }
                },
                {
                    data: 'usages',
                    name: 'usages'
                },
                {
                    data: 'see_also',
                    name: 'see_also'
                },
            ]
        });
    }

    function seealso_add(help_1_id)
    {
        $.ajax
        ({
            url: '{{ route('modals.help.seealso_add') }}',
            type: 'post',
            data: {'help_1_id': help_1_id, 'help_2_ids': $('.help_add').val()},
            dataType: 'html',
            success: function(response)
            {
                seealso_content(help_1_id);
            }
        });
    }

    function seealso_content(id)
    {
        $('.jsPanel-content').html('<div class="loader"></div>');
        $.ajax
        ({
            url: '{{ route('modals.help.seealso_content') }}',
            type: 'post',
            data: {'id': id},
            dataType: 'html',
            success: function(response)
            {
                $('.jsPanel-content').html(response);
            }
        });
    }

    function seealso_delete(help_1_id, help_2_id)
    {
        if (_confirm_delete())
        {
            $.ajax
            ({
                url: '{{ route('modals.help.seealso.delete') }}',
                type: 'post',
                data: {'help_1_id': help_1_id, 'help_2_id': help_2_id},
                dataType: 'json',
                success: function(response)
                {
                    $('#seealso_' + help_1_id + '_' + help_2_id).remove();
                    jQuery.noticeAdd({type: response[0], text: response[1], stay: false});
                    seealso_content(help_1_id);
                }
            });
        }
    }
</script>