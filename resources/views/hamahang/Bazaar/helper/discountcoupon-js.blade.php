<script>
    var coupons_grid;
    function coupons_grid_load()
    {
        coupons_grid = $('#coupons_grid').DataTable
        ({
            dom: '<"space-10">' +
            ' <"row form-inline" <"col-xs-4"f> <"col-xs-4"l>  <"col-xs-4 text-left toolbar"> <"clearfixed">>' +
            ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
            ' <"row" <"col-xs-3"i><"col-xs-9 text-left"p> <"clearfixed"> >',
            initComplete: function ()
            {
                $('div.toolbar').html
                (
                    '<button onclick="coupons_grid_reload();" class="btn btn_grid_add_role" type="button">' +
                    '   <i class="fa fa-refresh"></i> به‌روز رسانی' +
                    '</button>&nbsp;' +
                    '<button href="{!! route('modals.discount_coupon_add_edit_form') !!}" class="btn btn-info btn_grid_add_role jsPanels" type="button">' +
                    '   <i ></i>  {{ trans('app.add') }}' +
                    '</button>'
                );
            },
            "processing": true,
            "serverSide": true,
            "language": window.LangJson_DataTables,
            ajax:
            {
                url: '{!! route('hamahang.bazaar.discountcoupon_get_datatable') !!}',
                type: 'POST',
                dataType: 'json'
            },
            columns:
            [
                {
                    data: 'id',
                    name: 'id',
                    sortable: false,
                },
                {
                    data: 'coupon',
                    mRender: function (data, type, full)
                    {
                        return '<strong style="font-family: \'Courier New\'; ' + (full.disposable && 0 != full.used_count ? 'text-decoration: line-through' : '') + '">' + full.coupon + '</strong>';
                    }
                },
                {
                    data: 'type',
                    mRender: function (data, type, full)
                    {
                        return full.type ? '{!! trans('bazaar.discountcoupon.type_amount') !!}' : '{!! trans('bazaar.discountcoupon.type_percentage') !!}';
                    }
                },
                {
                    data: 'value',
                    mRender: function (data, type, full)
                    {
                        if (full.type)
                        {
                            r = full.value + ' ' + '{!! trans('bazaar.discountcoupon.type_of_value_1') !!}';
                        } else
                        {
                            r = '%' + full.value;
                        }
                        return r;
                    }
                },
                { data: 'start_date' },
                { data: 'expire_date' },
                {
                    data: 'disposable',
                    mRender: function (data, type, full)
                    {
                        return full.disposable ? '{!! trans('bazaar.discountcoupon.disposable_yes') !!}' : '<span style="color: #3eb332;">{!! trans('bazaar.discountcoupon.disposable_no') !!}</span>';
                    }
                },
                {
                    data: 'usage_quota',
                    mRender: function (data, type, full)
                    {
                        return full.disposable ? '-' : 0 == full.usage_quota ? '<span style="color: #3eb332;">{!! trans('bazaar.discountcoupon.usage_quota_unlimited') !!}</span>' : full.usage_quota;
                    }
                },
                { data: 'used_count' },
                {
                    data: 'inactive',
                    mRender: function (data, type, full)
                    {
                        return full.inactive ? '{!! trans('bazaar.discountcoupon.status_inactive') !!}' : '{!! trans('bazaar.discountcoupon.status_active') !!}';
                    }
                },
                {
                    sortable: false,
                    mRender: function (data, type, full)
                    {
                        action_edit = '<i href="{!! route('modals.discount_coupon_add_edit_form') !!}?edit_id=' + full.id + '" class="fa fa-pencil operation-edit jsPanels"></i>';
                        action_delete = '<i class="fa fa-close operation-delete" onclick="do_delete(' + full.id + ')"></i>';
                        r = full.used_count ? '<span style="color: lightgray;">{!! trans('bazaar.discountcoupon.operations_used') !!}</span>' : action_edit + ' ' + action_delete;
                        return r;
                    }
                }
            ]
        });
        coupons_grid.on('draw.dt order.dt search.dt', function()
        {
            coupons_grid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i)
            {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }
    coupons_grid_load();
    function coupons_grid_reload()
    {
        coupons_grid.ajax.reload();
    }
    function do_submit()
    {
        coupon = e_coupon.val();
        type = e_type.val();
        value = e_value.val();
        start_date = e_start_date.val();
        expire_date = e_expire_date.val();
        disposable = e_disposable.val();
        usage_quota = e_usage_quota.val();
        inactive = e_inactive.val();
        coupon_old = e_coupon_old.val();
        edit_id = e_edit_id.val();
        $.ajax
        ({
            type: 'POST',
            dataType: 'json',
            url: '{!! route('modals.discount_coupon_add_edit') !!}',
            data:
            {
                'coupon': coupon,
                'type': type,
                'value': value,
                'start_date': start_date,
                'expire_date': expire_date,
                'disposable': disposable,
                'usage_quota': usage_quota,
                'inactive': inactive,
                'coupon_old': coupon_old,
                'edit_id': edit_id
            },
            success: function(data)
            {
                if (data.success)
                {
                    $('.jsglyph-close').parent().parent().parent().parent().parent().fadeOut(function()
                    {
                        $('.jsglyph-close').click();
                    });
                } else
                {
                    messageModal('fail', 'خطا', data.result);
                }
                coupons_grid_reload();
            },
        });
    }
    function do_delete(id)
    {
        if (confirm('آیا از حذف این مورد اطمینان دارید؟'))
        {
            $.ajax
            ({
                type: 'POST',
                url: '{!! route('modals.discount_coupon_delete') !!}',
                data: {'delete_id': id},
                success: function(data)
                {
                    if (data.success)
                    {

                    } else
                    {
                        messageModal('fail', 'خطا', ['{!! trans('bazaar.discountcoupon.operations_used_msg') !!}']);
                    }
                    coupons_grid_reload();
                }
            });
        }
    }
</script>