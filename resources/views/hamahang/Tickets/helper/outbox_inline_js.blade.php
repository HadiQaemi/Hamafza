<script>

    Grid_Table = $('#ticketSendGrid').DataTable({
        "dom": window.CommonDom_DataTables,
        "processing": true,
        "serverSide": true,
        "language": window.LangJson_DataTables,
        ajax: {
            url: '{!! route('hamahang.tickets.get_ticket_send') !!}',
            type: 'POST'
        },
        columns: [
            {
                data: 'id',
                mRender: function (data, type, full) {
                    return '';
                }
            },
            {
                data: 'receiver_users',
                render: function (data, type, full)
                {
                    var out = [];
                    items = full.receiver_users;
                    for (var item in items)
                    {
                        item = items[item];
                        out.push('<a class="jsPanels" title="پیام دریافتی" href="{{ route('modals.view_message') }}?sid=' + full.id + '">' + item.Name + ' ' + item.Family + '</a>');
                    }
                    return out.join('، ');
                }
            },
            {
                data: 'title',
                mRender: function (data, type, full) {
                    return '<a class="jsPanels" title="پیام دریافتی" href="{{ route('modals.view_message') }}?sid=' + full['id'] + '">' + full['title'] + '</a>';
                }
            },
            {
                mRender: function (data, type, full) {
                    if (full.ticket_answer)
                        return '<a class="jsPanels" title="پیام دریافتی" href="{{ route('modals.view_message') }}?sid=' + full['id'] + '">' + full['ticket_answer']['comment'].substr(0, 20) + ' ...' + '</a>';
                    else
                        return '';
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
                mRender: function (data, type, full) {
                    return '<a class="jsPanels" title="پیام دریافتی" href="{{ route('modals.view_message') }}?sid=' + full['id'] + '">' + full['JalaliRegDate'] + '</a>';
                }
            }
        ]
    });
    Grid_Table.on('draw.dt order.dt search.dt', function () {
        Grid_Table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
    Grid_Table.column('0:visible')
        .order('desc')
        .draw();


</script>