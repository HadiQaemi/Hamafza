<script type="text/javascript">

   var sid =  '{{ $sid }}';
    function data_subjects2(){

        Grid_Table = $('#subjects_subjectType_Grid').DataTable({
            "dom": window.CommonDom_DataTables,
            "processing": true,
            "serverSide": true,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.subjects.get_subjects_jsPanel') !!}',
                type: 'POST',
                data:{id:sid}
            },
            columns: [
                {
                    mRender: function (data, type, full) {
                        return '';
                    }
                },
                {
                    data: 'title',
                    mRender: function (data, type, full) {
                        var url = '{{ url('') }}'+'/'+full['id']+'/desktop';
                        return '<a href="'+url+'" target="_blank">'+full['title']+'</a> ';
                    }
                },
                {
                    mRender: function (data, type, full) {
                        return full['jdate'];
                    }
                }
            ]
        });
        Grid_Table.on('draw.dt order.dt search.dt', function () {
            Grid_Table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }
    window.data_subjects2();

</script>