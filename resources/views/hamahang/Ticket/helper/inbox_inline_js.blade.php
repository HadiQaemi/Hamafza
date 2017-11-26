<script>

    Grid_Table = $('#ticketRecieveGrid').DataTable({
        dom: '<"space-10">' +
        ' <"row form-inline" <"col-xs-4"f> <"col-xs-4"l>  <"col-xs-4 text-left toolbar"> <"clearfixed">>' +
        ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
        ' <"row" <"col-xs-3"i><"col-xs-9 text-left"p> <"clearfixed"> >',
        "processing": true,
        "serverSide": true,
        "language": window.LangJson_DataTables,
        ajax: {
            url: '{!! route('hamahang.tickets.get_ticket_receive') !!}',
            type: 'POST'
        },
        columns: [
            {
                mRender: function (data, type, full) {
                    return '';
                }
            },
            {
                data: 'name',class:'name',
                mRender: function (data, type, full) {
                    return '';
                }
            },
            {
                data: 'comment',
                mRender: function (data, type, full) {
                    return '';
                }
            },
            {
                mRender: function (data, type, full) {
                    return '';
                }
            }
        ]
    });
    Grid_Table.on('draw.dt order.dt search.dt', function () {
        Grid_Table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


</script>