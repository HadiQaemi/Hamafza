<table class="table">
    <tr>
        <td>{!! trans('bazaar.invoice.paymentdata.row') !!}</td>
        <td>{!! trans('bazaar.invoice.paymentdata.buyer') !!}</td>
        <td>{!! trans('bazaar.invoice.paymentdata.due') !!}</td>
        <td>{!! trans('bazaar.invoice.paymentdata.id') !!}</td>
        <td>{!! trans('bazaar.invoice.paymentdata.pay_request_trace_no') !!}</td>
        <td>{!! trans('bazaar.invoice.paymentdata.invoice_serial') !!}</td>
        <td>{!! trans('bazaar.invoice.paymentdata.date') !!}</td>
        <td>{!! trans('bazaar.invoice.paymentdata.details') !!}</td>
    </tr>
    @forelse ($items as $item_k => $item)
        @php
            $params = json_decode($item['params']);
            $get_pay_ids_response = json_decode($item['get_pay_ids_response']);
            $pay_id = @$get_pay_ids_response->GetPayIDsResult->PayDueIDs->PayID->ID;
            $pay_request_trace_no = @$get_pay_ids_response->GetPayIDsResult->PayRequestTraceNo
        @endphp
        <tr>
            <td>{!! $item_k + 1 !!}</td>
            <td>{!! $params->PayRequestIn->Buyer !!}</td>
            <td>{!! $params->PayRequestIn->PayDues->PayDue->Due !!}</td>
            <td>{!! $pay_id ? : '-' !!}</td>
            <td>{!! $pay_request_trace_no ? : '-' !!}</td>
            <td>{!! $params->PayRequestIn->InvoiceSerial !!}</td>
            <td>{!! $item['created_at_jalali'] !!}</td>
            <td><a href="{!! route('modals.invoice_payment_data_details_form') . '?id=' . $item['id'] !!}" class="jsPanels" modal="modal">{!! trans('bazaar.invoice.paymentdata.details') !!}</a></td>
        </tr>
    @empty
        خطا
    @endforelse
</table>
