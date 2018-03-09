<div class="panel panel-default" style="margin: 10px;">
    @include('hamahang.Basicdata.items-panel-heading')
    <div class="panel-body">
        <table id="grid" width="100%" class="table table-condensed table-bordered table-striped table-hover td-center-align">
            <thead>
            <th style="text-align: center;">{{ trans('tools.rowIndex') }}</th>
            <th style="text-align: center;">{{ trans('tools.title') }}</th>
            <th style="text-align: center;">{{ trans('tools.value') }}</th>
            <th style="text-align: center;">{{ trans('tools.operations') }}</th>
            </thead>
        </table>
    </div>
</div>
<script>
    function edit_value(id)
    {
        var e_parentid = $('#parentid');
        var e_title = $('#title');
        var e_value = $('#value');
        var e_inactive = $('[name=inactive]:checked');
        var e_comment = $('#comment');
        $.ajax
        ({
            type: 'post',
            url: '{!! route('modals.basicdata_value_create_edit') !!}',
            data: {'editid': id, 'parentid': e_parentid.val(), 'title': e_title.val(), 'value': e_value.val(), 'inactive': e_inactive.val(), 'comment': e_comment.val(), },
            dataType: 'json',
            success: function(data)
            {
                if (data.success)
                {
                    $('.jsglyph-close').click();
                    $('.tree').find('ul li a#' + e_parentid.val() + '_anchor').click();
                    messageModal('success', 'ثبت', data.result[1]);
                } else
                {
                    messageModal('fail', 'خطا', data.result);
                }
            },
        });
    }
    function get_content(id, title, value, parentid, is_link)
    {
        comment = $('.jsPanelsLive_content' + id).attr('data-comment');
        r  =
        '<div style="padding: 10px;">' +
        '   <div class="row" style="margin-top: 5px;">' +
        '       <div class="col-sm-9"><label>عنوان:</label> <input type="text" id="title" name="title" class="form-control" value="' + title + '" /></div>' +
        '       <div class="col-sm-3"><label>مقدار:</label> <input type="text" id="value" name="value" class="form-control" style="direction: ltr;" value="' + (is_link ? atob(value) : value) + '" /></div>' +
        '   </div>' +
        '   <div class="row" style="margin-top: 5px;">' +
        '       <div class="col-sm-12"><label>توضیحات:</label> <textarea id="comment" name="comment" class="form-control">' + comment + '</textarea></div>' +
        '   </div>' +
        '   <div class="row" style="margin-top: 5px;">' +
        '           <label>وضعیت:</label> <input type="radio" id="0" name="inactive" value="0" checked="checked" /><label for="inactive_0">فعال</label> <input type="radio" id="inactive_1" name="inactive" value="1" /><label for="inactive_1">غیر فعال</label>' +
        '   </div>' +
        '</div>' +
        '<input type="hidden" id="parentid" name="parentid" value="' + parentid + '" />';
        $('#inactive_{!! @$data['inactive'] !!}').attr('checked', 'checked');
        return r;
    }
    function get_footer(id)
    {
        r  =
        '<div class="row">' +
        '    <span class="pull-left" style="padding: 10px">' +
        '       <button id="NewTaskPackageSubmitBtn" onclick="edit_value(' + id + ')" name="upload_files" value="save" class="btn btn-info" type="button"> <i class="bigger-125"></i> <span>ثبت</span> </button>' +
        '   </span>' +
        '</div>';
        return r;
    }
    groupGrid = $('#grid').DataTable
    ({
        language: LangJson_DataTables,
        processing: true,
        serverSide: true,
        //dom: '<"col-xs-5"f><"col-xs-5 floatleft"l><"tools-group-toolbar">t<"toolbar"><"col-xs-14 text-center"p><"clearfixed">',
        dom: '<"space-10">' +
        ' <"row form-inline" <"col-xs-4"f> <"col-xs-4"l>  <"col-xs-4 text-left toolbar"> <"clearfixed">>' +
        ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
        ' <"row" <"col-xs-3"i><"col-xs-9 text-left"p> <"clearfixed"> >',
        initComplete: function ()
        {
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
        ajax:
        {
            url: '{!! route('hamahang.basicdata.load_items') !!}',
            type: 'POST',
            data: {'id' : id}
        },
        columns:
        [
            {
                data: 'id'
            },
            {
                data: 'title',
                name: 'title',
                mRender: function (data, type, full)
                {
                    r = '<div style="direction: ltr;' + (1 == full.inactive ? 'color: lightgray; ' : null) + '">' + full.title + '</div>';
                    return r;
                }
            },
            {
                data: 'value',
                name: 'value',
                mRender: function (data, type, full)
                {
                    if (full.is_link)
                    {
                        r = '<a href="' + full.value + '" target="_blank">' + full.value + '</a>';
                    } else
                    {
                        r = '<div style="direction: ltr; color: ' + (full.value < 0 ? 'red' : 'green') + '">' + full.value + '</div>';
                    }
                    return r;
                }
            },
            {
                sortable: false,
                searchable: false,
                mRender: function (data, type, full)
                {
                    make_content =
                    '<div style="display: none;">' +
                    '    <span class="jsPanelsLive_content' + full.id + '" data-comment="' + full.comment + '"></span>' +
                    '</div>';
                    make_delete = '<i class="fa fa-times" style="font-size: 17px; cursor: pointer; " onclick="if (confirm(\'آیا مطمئن هستید؟\')) { do_delete_value(' + full.id + ',groupGrid); }"></i>';
                    data_content_function = 'get_content(\'' + full.id + '\', \'' + full.title + '\', \'' + (full.is_link ? btoa(full.value) : full.value) + '\', \'' + full.parent_id + '\', ' + full.is_link + ')';
                    make_edit = '<a class="jsPanelsLive" data-id="' + full.id + '" data-header="ویرایش ' + full.title + '" data-content-function="' + data_content_function + ' " data-footer-function="get_footer(' + full.id + ')" style="font-size: 15px; cursor: pointer;"><i class="fa fa-pencil-square-o"></i></a>';
                    return make_content + make_edit + ' ' + make_delete;
                }
            }
        ]
    });
    groupGrid.on('order.dt search.dt', function ()
    {
        groupGrid.column(0,
            {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i)
        {
            cell.innerHTML = i + 1;
        });
    }).draw();
</script>
