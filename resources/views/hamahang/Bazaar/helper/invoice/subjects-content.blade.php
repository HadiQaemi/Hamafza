<table class="table" id="invoice_status_table">
    <tr>
        <th>{!! trans('bazaar.invoice.subjects.row') !!}</th>
        <th>{!! trans('bazaar.invoice.subjects.subject_title') !!}</th>
        <th>{!! trans('bazaar.responsible_for_sales_id') !!}</th>
        <th>{!! trans('bazaar.invoice.subjects.subject_price') !!}</th>
        <th>{!! trans('bazaar.invoice.subjects.subject_count') !!}</th>
        <th>{!! trans('bazaar.invoice.subjects.total_price') !!}</th>
        <th>{!! trans('bazaar.invoice.has_coupon') !!}</th>
        <th>{!! trans('bazaar.invoice.subjects.final_price') !!}</th>
    </tr>
    @php ($total = 0)
    @foreach($items as $item_k => $item)
        <tr>
            <td>{!! $item_k + 1 !!}</td>
            <td>
                <a href="{!! url(App\Models\hamafza\Pages::where('sid', $item->subject_id)->first()->id) !!}" target="_blank">
                    <img src="{!! App\Models\hamafza\Subject::find($item->subject_id)->def_image_url !!}" width="40" />&nbsp;
                    {!! $item->subject_title !!}
                </a>
            </td>
            <td>{!! $item->responsible_for_sales !!}</td>
            <td>{!! number_format($item->subject_price) !!}</td>
            <td>{!! number_format($item->subject_count) !!}</td>
            <td>{!! number_format($item->total_price) !!}</td>
            <td>
                {!!
                    $item->coupon_id
                    ? $my
                        ? trans('bazaar.invoice.has_coupon_yes')
                        : '<a modal="modal" class="jsPanels" href="' . route('modals.invoice_coupon_form') . '?id=' . $item->coupon_id . '">' . trans('bazaar.invoice.subjects.check') . '</a>'
                    : trans('bazaar.invoice.has_coupon_no')
                !!}
            </td>
            <td style="color: #6EC565;">{!! number_format($item->final_price) !!}</td>
        </tr>
        @php ($total += $item->final_price)
    @endforeach
    <tr style="border-top: 5px lightgray solid; color: #6EC565;">
        <th colspan="6"></th>
        <th>{!! trans('bazaar.invoice.subjects.total') !!}</th>
        <th>{!! number_format($total) !!}</th>
    </tr>
</table>



