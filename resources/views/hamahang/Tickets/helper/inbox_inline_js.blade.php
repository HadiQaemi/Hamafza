<script>
    Grid_Table = $('#ticketRecieveGrid').DataTable
    ({
        'dom': window.CommonDom_DataTables,
        'order': [[3, 'desc']],
        'processing': true,
        'serverSide': true,
        'language': window.LangJson_DataTables,
        ajax:
        {
            url: '{!! route('hamahang.tickets.get_ticket_receive') !!}',
            type: 'POST'
        },
        columns:
        [
            {
                'data': 'id', orderSequence: ['desc'],
                render: function(data, type, row, meta)
                {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'sender_user',
                render: function(data, type, full)
                {
                    if (full.sender_user)
                        return '<a class="jsPanels" title="پیام دریافتی" href="{{ route('modals.view_message') }}?sid=' + full['id'] + '">' + full['sender_user']['Name'] + ' ' + full['sender_user']['Family'] + '</a>';
                    else
                        return '';
                }
            },
            {
                data: 'title',
                render: function(data, type, full)
                {
                    return '<a class="jsPanels" title="پیام دریافتی" href="{{ route('modals.view_message') }}?sid=' + full['id'] + '">' + full['title'] + '</a>';
                }
            },
            {
                render: function(data, type, full)
                {
                    return '<a class="jsPanels" title="پیام دریافتی" href="{{ route('modals.view_message') }}?sid=' + full['id'] + '">' + full['ticket_answer']['comment'].substr(0, 20) + ' ...' + '</a>';
                }
            },
            {
                render: function (data, type, full)
                {
                    var r = '';
                    if (full['has_attachment'])
                    {
                        r = '<a class="jsPanels" title="این نشان یعنی پیام دارای فایل پیوست است." href="{{ route('modals.view_message') }}?sid=' + full['id'] + '">' + '<div style="text-align: center; color: green;"><i class="fa fa-check fa-2x"></i></div>' + '</a>';
                    } else
                    {
                        r = '<div style="text-align: center; color: lightgray;"><i class="fa fa-close"></i></div>';
                    }
                    return r;
                }
            },
            {
                render: function(data, type, full)
                {
                    return '<a class="jsPanels" title="پیام دریافتی" href="{{ route('modals.view_message') }}?sid=' + full['id'] + '">' + full['JalaliRegDate'] + '</a>';
                }
            }
        ]
    });
</script>
