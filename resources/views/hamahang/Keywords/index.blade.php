@extends('layouts.master')
@section('content')
    <style>
        .sorting_1
        {
            display: none;
        }
    </style>
    <div class="container-fluid">
        <div class="space-14"></div>
        <fieldset>
            <div class="row">
                <div class="col-xs-12">
                    <table id="KeywordsListTableID" class="table table-striped display" cellspacing="0" width="100%" style="text-align: center;">
                        <thead>
                        <tr>
                            <th style="display: none;">شناسه</th>
                            <th>عنوان</th>
                            <th>اصطلاح نامه</th>
                            <th>کاربرد</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </fieldset>
    </div>
@stop

@section('inline_scripts')
    <script>

        DataTables_KeywordsList();

        function keyword_delete(id) {
            if (!confirm('{!! trans('app.are_you_sure') !!}')) return false;
            $.ajax
            ({
                type: 'POST',
                dataType: 'json',
                url: '{!! route('modals.keyword_delete', ['sid' => '']) !!}' + id,
                success: function(data)
                {
                    if (data.success)
                    {
                        jQuery.noticeAdd
                        ({
                            text: 'انجام شد.',
                            stay: false,
                            type: 'success'
                        });
                        window.location.href = '';
                    } else
                    {
                        messageModal('fail', 'خطا', data.result);
                    }
                }
            });
        }

        function DataTables_KeywordsList_reload() {
            KeywordsList_Grid.ajax.reload();
        }

        function DataTables_KeywordsList() {
            KeywordsList_Grid = $('#KeywordsListTableID').DataTable({
                "dom": window.CommonDom_DataTables,
                initComplete: function () {
                    $("div.toolbar")
                        .html('' +
                            '<button style="display: none;" class="btn btn-info btn_grid_add_role jsPanels" type="button" href="{!! route('modals.keyword_add_edit_form', [/*'uid' => auth()->id(), */'sid' => 0]) !!}">' +
                            '   <i class=""></i> ' +
                            '   {{ trans('app.add')}}' +
                            '</button>'
                        );
                },
                "processing": true,
                "serverSide": true,
                "language": window.LangJson_DataTables,
                ajax: {
                    url: '{!! route('hamafza.get_keywords_list') !!}',
                    type: 'POST'
                },
                columns:
                    [
                        { data: 'id', name: 'id' },
                        { data: 'title', name: 'title' },
                        {
                            data: 'thesa',
                            name: 'thesa',
                            orderable: false,
                            searchable: false,
                            mRender: function (data, type, full, meta)
                            {
                                return full.thesa;
                                //return '-';
                            }

                        },
                        {
                            data: 'subjects_count',
                            name: 'subjects_count',
                            searchable: false ,
                            mRender: function (data, type, full, meta)
                            {
                                return '<a class="jsPanels" href="{{ route('modals.get_keywords_list_subject_usages', ['keyword_id' => '']) }}' + full.id + '">'+full.subjects_count+'</a>';
                            }
                        },
                        {
                            data: 'edit',
                            name: 'edit',
                            orderable: false,
                            searchable: false,
                            mRender: function (data, type, full, meta)
                            {
                                return '<a class="jsPanels fa fa-edit" href="{{ route('modals.keyword_add_edit_form', ['sid' => '']) }}' + full.id + '"></a>';
                            }
                        },
                        {
                            data: 'delete',
                            name: 'delete',
                            orderable: false,
                            searchable: false,
                            mRender: function (data, type, full, meta)
                            {
                                return '<a class="fa fa-close" href="#" onclick="keyword_delete(' + full.id + ')"></a>';
                            }
                        }
                    ]
            });
        }

    </script>
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
