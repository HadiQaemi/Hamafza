<script>
    var invoices_grid;
    function invoices_grid_load()
    {
        invoices_grid = $('#invoices_grid').DataTable
        ({
            "scrollX": true,
            dom: '<"space-10">' +
            ' <"row form-inline" <"col-xs-4"f> <"col-xs-4"l>  <"col-xs-4 text-left toolbar"> <"clearfixed">>' +
            ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
            ' <"row" <"col-xs-3"i><"col-xs-9 text-left"p> <"clearfixed"> >',
            initComplete: function ()
            {
                $('div.toolbar').html
                (
                    '<button onclick="invoices_grid_reload();" class="btn btn_grid_add_role" type="button">' +
                    '   <i class="fa fa-refresh"></i> به‌روز رسانی' +
                    '</button>'
                );
            },
            processing: true,
            serverSide: true,
            "language": window.LangJson_DataTables,
            ajax:
            {
                @if (isset($mysales))
                    url: '{!! route('hamahang.bazaar.invoice_mysales_get_datatable') !!}',
                @elseif (isset($my))
                    url: '{!! route('hamahang.bazaar.invoice_my_get_datatable') !!}',
                @else
                    url: '{!! route('hamahang.bazaar.invoice_get_datatable') !!}',
                @endif
                type: 'POST',
                dataType: 'json'
            },
            columns:
            [
                {
                    data: 'id',
                    name: 'id',
                },
                @if (!isset($my))
                {
                    data: 'user.Name',
                    name: 'user.Name'
                },
                {
                    data: 'user.Family',
                    name: 'user.Family'
                },
                {
                    data: 'user.melli_code',
                    name: 'user.melli_code'
                },
                @endif
                {
                    data: 'invoice_no',
                    name: 'id',
                },
                {
                    data: 'products_count',
                    name: 'products_count',
                },
                {
                    data: 'date',
                    name: 'id',
                },
                {
                    data: 'amount',
                    name: 'payable_amount',
                },
                {
                    data: 'state',
                    name: 'state',
                    sortable: false,
                    mRender: function (data, type, full)
                    {
                        return full.state;
                    }
                },
                {
                    data: 'has_coupon_label',
                    name: 'has_coupon',
                },
                {
                    sortable: false,
                    mRender: function (data, type, full)
                    {
                        action_details = '<button modal="modal" class="btn btn-default btn-xs jsPanels" type="button" href="{!! route('modals.invoice_details_form') !!}?id=' + full.id + '"><small>{!! trans('bazaar.invoice.operations_details_btn') !!}</small></button>';
                        action_subjects = '<button modal="modal" class="btn btn-default btn-xs jsPanels" type="button" href="{!! route('modals.invoice_subjects_form') !!}?id=' + full.id + '{!! isset($my) ? "&my" : null !!}"><small>{!! trans('bazaar.invoice.operations_subjects_btn') !!}</small></button>';
                        @if (!isset($my))
                            action_status = '<button modal="modal" class="btn btn-default btn-xs jsPanels" type="button" href="{!! route('modals.invoice_status_form') !!}?id=' + full.id + '"><small>{!! trans('bazaar.invoice.operations_status_btn') !!}</small></button>';
                            action_paymentdata = '<button modal="modal" class="btn btn-default btn-xs jsPanels" type="button" href="{!! route('modals.invoice_payment_data_form') !!}?id=' + full.id + '"><small>{!! trans('bazaar.invoice.operations_paymentdata') !!}</small></button>';
                        @else
                            action_status = '';
                            action_paymentdata = '';
                        @endif
                        action_pay = '<button class="btn btn-warning btn-xs" type="button" onclick="pay_prepare(' + full.id + ')"><small>{!! trans('bazaar.invoice.operations_pay_btn') !!}</small></button>';
                        return action_details + ' ' + action_status + ' ' + action_subjects + ' ' + action_paymentdata + (full.paid ? '' : ' ' + action_pay);
                    }
                }
            ]
        });
        invoices_grid.on('draw.dt order.dt search.dt', function()
        {
            invoices_grid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i)
            {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    invoices_grid_load();
    function invoices_grid_reload()
    {
        invoices_grid.ajax.reload();
    }

    function pay_prepare(invoice_id)
    {
        $.ajax
        ({
            url: '{{ route('hamahang.bazaar.pay_prepare') }}',
            type: 'post',
            dataType: 'json',
            data: {'invoice_id': invoice_id},
            success: function(data)
            {
                window.location = '{!! $url_pay !!}';
            }
        });
    }
</script>