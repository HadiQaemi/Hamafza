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
                data: 'sender_user.Name',

                mRender: function (data, type, full) {
                    return '<a class="jsPanels" title="پیام دریافتی" href="{{ route('modals.view_message') }}?sid=' + full['id'] + '">' + full['sender_user']['Name'] + ' ' + full['sender_user']['Family'] + '</a>';
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
                mRender: function (data, type, full) {
                    if (full['ticket_files'].length > 0)
                        return '<img src="{{ url('') }}/img/clip.png">';
                    else
                        return '';
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