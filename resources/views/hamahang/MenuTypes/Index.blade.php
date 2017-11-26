@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('content')
    <div id="menTypeMsg"></div>
    <div>
        <form id="menyTypeForm" class="col-xs-12 tab-pane fade in active default-options">
            <table class="table table-bordered col-xs-12">
                <tr>
                    <td class="col-xs-2">{{ trans('menu_types.title') }}</td>
                    <td class="col-xs-10"><input type="text" class="form-controll" name="title"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="button" id="add-menu-type" value="save" class="btn btn-info pull-left" type="button">
                            <i class="glyphicon  glyphicon-save-file bigger-125 pull-left"></i>
                            <span>{{ trans('menu_types.register') }}</span>
                        </button>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="edit_id" value="0"/>
        </form>
    </div>
    <div>
        <table id="menuTypesGrid" class="table table-striped table-bordered dt-responsive nowrap display">
            <thead>
            <tr>
                <th>{{ trans('menu_types.row') }}</th>
                <th>{{ trans('menu_types.title') }}</th>
                <th>{{ trans('menu_types.action') }}</th>
            </tr>

            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::asset('assets/Packages/DataTables/datatables.js')}}"></script>
@stop
@section('inline_scripts')
    <script>
        $(document).ready(function () {
            var menuTypesGrid = '';
            menuTypesGrid = $('#menuTypesGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "language": LangJson,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('MenuTypes.list')!!}',
                    type: 'POST'
                },
                columns: [
                    {
                        data: 'index',
                        name: 'index',
                        width: '1%'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        width: '79%'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        mRender: function (data, type, full) {
                            var actions = '' +
                                '<a class="cls3"   style="margin: 2px" onclick="editMenu(' + full.id + ',this)" href="#"><i class="fa fa-edit"></i></a>' +
                                '<a class="cls3"  style="margin: 2px" onclick="deleteMenu(' + full.id + ')" href="#"><i class="fa fa-close"></i></a>';
                            return actions;
                        }
                    },
                ]
            });
            menuTypesGrid.on('order.dt search.dt', function () {
                menuTypesGrid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
            $('#add-menu-type').click(function () {
                var title = $('#menyTypeForm input[name="title"]').val();
                var edit_id = $('#menyTypeForm input[name="edit_id"]').val();
                var obj = {};
                if (edit_id > 0)
                    obj.id = edit_id;
                obj.title = title;
                $.ajax({
                    url: '{{ URL::route('MenuTypes.save')}}',
                    type: 'POST', // Send post dat
                    data: obj,
                    async: false,
                    success: function (s) {
                        res = JSON.parse(s);
                        console.log(res);
                        if (res.success == true) {
                            var html = '' +
                                '<div class="alert alert-success">' +
                                '   <div class=" close-box-btn" onclick="closeMsgBox(this);">' +
                                '       <i class=" pull-left fa fa-window-close"></i>' +
                                '   </div>' +
                                '   <strong> {{ trans('menu_types.successfully_added') }}</strong>' +
                                '</div>';
                            $('#menTypeMsg').html(html);
                            menuTypesGrid.ajax.reload();
                            $('#menyTypeForm')[0].reset();
                        }
                    }
                });
            });
        });
        function closeMsgBox(el) {
            $(el).parent().parent().html('');
        }
        function showMsgModal(title, msg) {

            $('#modal_msgBox .modal-title').html('');
            $('#modal_msgBox #modal_massage').html('');
            if (title != '') {
                $('#modal_msgBox .modal-title').html(title);
            }
            $('#modal_msgBox #modal_massage').html(msg);
            $('#modal_msgBox').modal({show: true});

        }
        function editMenu(id, el) {
            var tr = $(el).parent().parent();
            $('#menyTypeForm input[name="title"]').val($(tr).find('td:nth-child(2)').text());
            $('#menyTypeForm input[name="edit_id"]').val(id);
        }
        function deleteMenu(id) {
            $('#remove_confirm_modal #modal_massage').html('{{ trans('menu_types.sure_to_delete') }}');
            $('#remove_confirm_modal').modal({backdrop: 'static', keyboard: false});
            var obj = {};
            obj.id = id;
            $('.yes_no_btn').click(function () {
                if ($(this).val() == 'yes') {
                    $.ajax({
                        url: '{{ URL::route('MenuTypes.delete')}}',
                        type: 'POST', // Send post dat
                        data: obj,
                        async: false,
                        success: function (s) {
                            if (res.success == true) {
                                $('#remove_confirm_modal').modal('hide');
                                showMsgModal('{{ trans("menu_types.delete") }}', '{{ trans("menu_types.menu_deleted") }}');
                                menuTypesGrid.ajax.reload();
                            }
                        }
                    });
                }
            });
        }
        function modalopen() {
            $('#remove_confirm_modal').modal('show');
        }
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
