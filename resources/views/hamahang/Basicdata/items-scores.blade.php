<div class="panel panel-default" style="margin: 10px;">
    @include('hamahang.Basicdata.items-panel-heading')
    <div class="panel-body">
        <table id="grid" width="100%" class="table table-condensed table-bordered table-striped table-hover td-center-align">
            <thead>
            <th style="text-align: center;">{{ trans('tools.rowIndex') }}</th>
            <th style="text-align: center;">{{ trans('tools.title') }}</th>
            <th style="text-align: center;">امتیاز</th>
            <th style="text-align: center;">حداکثر امتیاز</th>
            <th style="text-align: center;">تعداد برای کسب نشان</th>
            <th style="text-align: center;">نشان</th>
            <th style="text-align: center;">حداکثر نشان</th>
            <th style="text-align: center;">کاربران دارای امتیاز</th>
            <th style="text-align: center;">مجموع امتیاز</th>
            <th style="text-align: center;">مجموع نشان</th>
            <th style="text-align: center;">کاربران دارای نشان</th>
            <th style="text-align: center;">{{ trans('tools.operations') }}</th>
            </thead>
        </table>
    </div>
</div>
<script>
    groupGrid = $('#grid').DataTable
    ({
        language: LangJson_DataTables,
        processing: true,
        serverSide: true,
        //dom: '<"col-xs-5"f><"col-xs-5 floatleft"l><"tools-group-toolbar">t<"toolbar"><"col-xs-14 text-center"p><"clearfixed">',
        dom: '<"space-10">' +
        ' <"row form-inline" <"col-xs-4"f>   <"col-xs-8 text-left toolbar"> <"clearfixed">>' +
        ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
        ' <"row" <"col-xs-3"i><"col-xs-4"l> <"col-xs-5 text-left"p><"clearfixed"> >',
        initComplete: function () {
            $("div.toolbar").html
            (
                '<a href="{!! route('modals.basicdata_value_create_view') !!}?parentid=' + id + '" class="jsPanels createnewvalue1">' +
                '<button style="position: relative; float: left;" data-item_type="role" class="btn btn-info btn_grid_add_item " type="button">' +
                '   <i ></i> ' +
                '   {{ trans('app.add')}}' +
                '</button>' +
                '</a>'
            );
        },
        ajax: {
            url: '{!! route('hamahang.basicdata.load_items') !!}',
            type: 'POST',
            data: {'id': id}
        },
        columns: [
            { //row index
                data: 'id'
            },
            { //عنوان
                data: 'title',
                name: 'title',
                mRender: function (data, type, full) {
                    r = '<div style="direction: ltr;' + (1 == full.inactive ? 'color: lightgray; ' : null) + '">' + full.title + '</div>';
                    return r;
                }
            },
            { //امتیاز
                data: 'value',
                name: 'value',
                mRender: function (data, type, full) {
                    r = '<div style="direction: ltr; color: ' + (full.value < 0 ? 'red' : 'green') + '">' + full.value + '</div>';
                    return r;
                }
            },
            { //حداکثر امتیاز
                data: 'a',
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    r = full.a;
                    return r;
                }
            },
            { //تعداد برای کسب نشان
                data: 'b',
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    r = full.b;
                    return r;
                }
            },
            { //نشان
                data: 'c',
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    r = full.c;
                    return r;
                }
            },
            { //حداکثر نشان
                data: 'max_medal',
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    r = full.max_medal;
                    return r;
                }
            },
            { //کاربران دارای امتیاز
                data: 'd',
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    console.log(full.d);
                    r = full.d;
                    if (r > 0)
                        return '<a title="کاربران دارای امتیاز '+ full.title +'" href="{!! route('modals.basicdata_get_users_scores') !!}?item_id=' + full.id + '&item_title=' + full.title + '" class="jsPanels">' + r + '</a>';
                    else
                        return r;
                }
            },
            { //مجموع امتیاز
                data: 'e',
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    r = full.e;
                    return r;
                }
            },
            { //مجموع نشان
                data: 'total_medals',
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    r = full.total_medals;
                    return r;
                }
            },
            { //کاربران دارای نشان
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    return '';
                }
            },
            { //operations
                sortable: false,
                searchable: false,
                mRender: function (data, type, full) {
                    make_content =
                        '<div style="display: none;">' +
                        '    <span class="jsPanelsLive_content' + full.id + '" data-comment="' + full.comment + '"></span>' +
                        '</div>';
                    make_delete = '<i class="fa fa-times" style="font-size: 17px; cursor: pointer; " onclick="if (confirm(\'آیا مطمئن هستید؟\')) { do_delete_value(' + full.id + ',groupGrid); }"></i>';
                    data_content_function = 'get_content(\'' + full.id + '\', \'' + full.title + '\', \'' + full.value + '\', \'' + full.a + '\', \'' + full.b + '\', \'' + full.c + '\', \'' + full.d + '\', \'' + full.e + '\', \'' + full.parent_id + '\', \'' + full.c_value + '\', \'' + full.max_medal + '\')';
                    make_edit = '<a class="jsPanelsLive" data-id="' + full.id + '" data-header="ویرایش ' + full.title + '" data-content-function="' + data_content_function + ' " data-footer-function="get_footer(' + full.id + ')" data-after-function="get_after(' + full.id + ')" style="font-size: 15px; cursor: pointer;"><i class="fa fa-pencil-square-o"></i></a>';
                    return make_content + make_edit + ' ' + make_delete;
                }
            }
        ]
    });
    groupGrid.on('order.dt search.dt', function () {
        groupGrid.column(0,
            {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
    function edit_value(id) {
        var e_parentid = $('#parentid');
        var e_title = $('#title');
        var e_value = $('#value');
        var e_inactive = $('[name=inactive]:checked');
        var e_comment = $('#comment');
        var e_a = $('#a');
        var e_b = $('#b');
        var e_c = $('#select_c_' + id);
        var e_max_medal = $('#max_medal');
        $.ajax
        ({
            type: 'post',
            url: '{!! route('modals.basicdata_value_create_edit_scores') !!}',
            data: {
                'editid': id,
                'parentid': e_parentid.val(),
                'title': e_title.val(),
                'value': e_value.val(),
                'inactive': e_inactive.val(),
                'comment': e_comment.val(),
                'a': e_a.val(),
                'b': e_b.val(),
                'c': e_c.val(),
                'max_medal': e_max_medal.val(),
            },
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    $('.jsglyph-close').click();
                    $('.tree').find('ul li a#' + e_parentid.val() + '_anchor').click();
                    messageModal('success', 'ثبت', data.result[1]);
                } else {
                    messageModal('fail', 'خطا', data.result);
                }
            },
        });
    }
    function get_content(id, title, value, a, b, c, d, e, parentid, c_value, max_medal) {
        comment = $('.jsPanelsLive_content' + id).attr('data-comment');
        r =
            '<div style="padding: 10px;">' +
            '   <div class="row" style="margin-top: 5px;">' +
            '       <div class="col-sm-9"><label>عنوان:</label> <input type="text" id="title" name="title" class="form-control" value="' + title + '" /></div>' +
            '       <div class="col-sm-3"><label>امتیاز:</label> <input type="text" id="value" name="value" class="form-control" style="direction: ltr;" value="' + value + '" /></div>' +
            '   </div>' +
            '   <div class="row" style="margin-top: 5px;">' +
            '       <div class="col-sm-4"><label>حداکثر امتیاز:</label> <input type="text" id="a" name="a" class="form-control" style="direction: ltr;" value="' + a + '" /></div>' +
            '       <div class="col-sm-5"><label>تعداد برای کسب نشان:</label> <input type="text" id="b" name="b" class="form-control" style="direction: ltr;" value="' + b + '" /></div>' +
            '       <div class="col-sm-3"><label>نشان:</label>' +
            @php
                $values = \App\Models\Hamahang\BasicdataValue::where('parent_id', config('constants.basicdata_groups_id.medals'))->select('id', 'title')->get();
            @endphp
                '           <select id="select_c_' + id + '" name="c" class="form-control" style="direction: ltr;" value="' + c_value + '">' +
            @forelse ($values->toArray() as $value)
                '                   <option value="{!! $value['id'] !!}"{!! 1 ? 'selected="selected"' : null !!}>{!! $value['title'] !!}</option>' +
            @empty
                    @endforelse
                '           </select>' +
            '       </div>' +
            '   </div>' +
            '   <div class="row" style="margin-top: 5px; display: none;">' +
            '       <div class="col-sm-4"><label>حداکثر نشان:</label> <input type="text" id="max_medal" name="max_medal" class="form-control" style="direction: ltr;" value="' + max_medal + '" /></div>' +
            '   </div>' +
            '   <div class="row" style="margin-top: 5px;">' +
            '       <div class="col-sm-12"><label>توضیحات:</label> <textarea id="comment" name="comment" class="form-control">' + comment + '</textarea></div>' +
            '   </div>' +
            '   <div class="row" style="margin-top: 5px;">' +
            '       <label>وضعیت:</label> <input type="radio" id="0" name="inactive" value="0" checked="checked" /><label for="inactive_0">فعال</label> <input type="radio" id="inactive_1" name="inactive" value="1" /><label for="inactive_1">غیر فعال</label>' +
            '   </div>' +
            '</div>' +
            '<input type="hidden" id="parentid" name="parentid" value="' + parentid + '" />';
        $('#inactive_{!! @$data['inactive'] !!}').attr('checked', 'checked');
        return r;
    }
    function get_footer(id) {
        r =
            '<div class="row">' +
            '    <span class="pull-left" style="padding: 10px">' +
            '       <button id="NewTaskPackageSubmitBtn" onclick="edit_value(' + id + ')" name="upload_files" value="save" class="btn btn-info" type="button"> <i class="bigger-125"></i> <span>ثبت</span> </button>' +
            '   </span>' +
            '</div>';
        return r;
    }
    function get_after(id) {
        var e = $('#select_c_' + id);
        e.val(e.attr('value'));
    }
</script>
