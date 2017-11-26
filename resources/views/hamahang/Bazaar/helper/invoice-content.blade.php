@if (Session::has('payment_error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Session::get('payment_error') }}</div>
@endif
<table id="invoices_grid" class="table table-striped td-center-align" cellspacing="0" style="min-width: 99.5%; width: 120%;">
    <thead>
        <th style="text-align: center;">{{ trans('bazaar.invoice.row') }}</th>
        @if (!isset($my))
            <th style="text-align: center;">{{ trans('bazaar.invoice.customer_name') }}</th>
            <th style="text-align: center;">{{ trans('bazaar.invoice.customer_family') }}</th>
            <th style="text-align: center;">{{ trans('bazaar.invoice.customer_mellicode') }}</th>
        @endif
        <th style="text-align: center;">{{ trans('bazaar.invoice.invoice_no') }}</th>
        <th style="text-align: center;">{{ trans('bazaar.invoice.subject_count') }}</th>
        <th style="text-align: center;">{{ trans('bazaar.invoice.date') }}</th>
        <th style="text-align: center;">{{ trans('bazaar.invoice.amount_rial') }}</th>
        <th style="text-align: center;">{{ trans('bazaar.invoice.state') }}</th>
        <th style="text-align: center;">{{ trans('bazaar.invoice.has_coupon') }}</th>
        <th style="text-align: center;">{{ trans('bazaar.invoice.operations') }}</th>
    </thead>
</table>
