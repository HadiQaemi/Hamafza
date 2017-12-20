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
                render: function(data, type, full)
                {
                    console.log(full.files);
                    if (full.files.length > 0)
                        return '<img src="{{ url('') }}/img/clip.png">';
                    else
                        return '';
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
