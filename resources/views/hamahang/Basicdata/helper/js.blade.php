<script>
    function do_delete(deleteid)
    {
        $.ajax(
            {
                type: 'post',
                url: '{!! route('modals.basicdata_delete') !!}',
                data: {'deleteid': deleteid},
                dataType: 'json',
                success: function(data)
                {
                    if (data.success)
                    {
                        window.location.reload();
                    }
                },
            });

    }
    function do_delete_value(deleteid,datatabel_variable)
    {
        $.ajax
        ({
            type: 'post',
            url: '{!! route('modals.basicdata_value_delete') !!}',
            data: {'deleteid': deleteid},
            dataType: 'json',
            success: function(data)
            {
                if (data.success)
                {
                    //window.location.reload();
                    datatabel_variable.ajax.reload();
                }
            },
        });
    }
    $(document).ready(function()
    {
        $.ajax
        ({
            type: 'post',
            url: '{!! route("hamahang.basicdata.get_groups") !!}',
            data: { },
            dataType: 'json',
            success: function(data)
            {
                if (data.success)
                {
                    json_data = JSON.parse('[' + data.result[0] + ']');
                    $('.tree').jstree({ 'core': { 'data': json_data } });
                    window.setTimeout(function(){ $('.tree > ul > li > a').first().click(); }, 1000);
                }
            }
        });
        $(document).on('click', '.tree > ul > li', function()
        {
            current_node = $(this).attr('id');
            window.location = '{{ route('ugc.desktop.hamahang.basicdata.items', ['uname' => auth()->user()->Uname, 'id' => '' ]) }}/' + current_node ;
        });
        $(document).on('click', '.tree > ul > li > a', function()
        {
            $('.basicdata_content').html('<div class="loader"></div>');
            e_a = $(this);
            e_span = e_a.find('span');
            custom = e_span.attr('data-custom');
            dev_title = e_span.attr('data-dev-title');
            id = e_span.attr('data-id');
            $.ajax
            ({
                type: 'post',
                url: '{!! route('hamahang.basicdata.get_items') !!}',
                data: {'target': custom ? dev_title : id, 'custom': custom, 'dev_title': dev_title, 'id': id, },
                dataType: 'json',
                success: function(data)
                {
                    $('.basicdata_content').html(data.result[0]);
                },
            });
            return false;
            /*
            thic = $(this);
            id =  $(thic.parent()).attr('id');
            title = thic.find('span').clone();
            $('#grid_title').html(title);
            $('#grid_operations').attr('data-id', id);
            $('#grid_operations a.edit').attr('href', '{!! route('modals.basicdata_edit_view') !!}?id=' + id);
            fill_dt(id);
            return false;
            */
        });
    });
</script>
