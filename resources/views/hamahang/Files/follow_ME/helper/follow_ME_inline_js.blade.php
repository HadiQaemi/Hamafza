<script>

    Grid_Table = $('#fileCreated_ME_RecieveGrid').DataTable({
        dom: window.CommonDom_DataTables,
        "processing": true,
        "serverSide": true,
        "language": window.LangJson_DataTables,
        ajax: {
            url: '{!! route('hamahang.files.get_file_follow') !!}',
            type: 'POST'
        },
        columns: [

            {
                mRender: function (data, type, full) {
                    return full['id']+'0';
                }
            },
            { data: 'title',

                mRender: function (data, type, full) {
                    return '<a target="_blank" href="{{ url('') }}/'+full['id']+'0'+'">'+full['title']+'</a>';
                }
            },
            {data: 'subject_type.name',
                mRender: function (data, type, full) {
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
                    return full['JalaliRegDate'];
                }
            },
            {
                mRender: function (data, type, full) {
                    return full['EditDate'];
                }
            }
        ]
    });

    Grid_Table.column( '0:visible' )
        .order( 'desc' )
        .draw();


</script>