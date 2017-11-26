
<div class="row">
    <div class="col-xs-12">
        <table id="grid_keyword_subjects" class="table table-striped display" cellspacing="0" width="100%" >
            <thead>
            <tr>
                <th style="display: none;">شناسه</th>
                <th>عنوان</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>

    DataTablesKeywordSubjectsList();

    function DataTablesKeywordSubjects_reload() {
        grid_keyword_subjects.ajax.reload();
    }

    function DataTablesKeywordSubjectsList() {
        grid_keyword_subjects = $('#grid_keyword_subjects').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.keywords.get_keyword_subject_list') !!}',
                data: {'keyword_id':{{$keyword->id}} },
                type: 'POST'
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title',
                    mRender: function (data, type, full, meta) {
                        return '<a target="_blank" href="{{url('/')}}/'+full.pages[0].id+'">'+full.title+'</a>';
                        //return '-';
                    }
                }

            ]
        });
    }

</script>