<table class="table" id="invoice_status_table">
    <tr>
        <th class="col-sm-1">{!! trans('bazaar.invoice.status.row') !!}</th>
        <th class="col-sm-4">{!! trans('bazaar.invoice.status.title') !!}</th>
        <th class="col-sm-1">{!! trans('bazaar.invoice.status.date') !!}</th>
        <th class="col-sm-4">{!! trans('bazaar.invoice.status.user') !!}</th>
    </tr>
    @foreach($invoice->status as $status_k => $status)
        @php ($invoice_status = App\Models\Hamahang\InvoiceStatus::find($status->pivot->id))
        <tr>
            <td>{!! $status_k + 1 !!}</td>
            <td>{!! $status->title !!}</td>
            <td>{!! $invoice_status->created_at_jalali !!}</td>
            <td>{!! $invoice_status->creator !!}</td>
        </tr>
    @endforeach
</table>



