@php
    $receiver_name = $invoice->receiver->receiver_name;
    $receiver_family = $invoice->receiver->receiver_family;
    $address = $invoice->receiver->address;
    $emergency_phone = $invoice->receiver->emergency_phone;
@endphp
<table class="table">
    <tr>
        <td>{!! trans('bazaar.invoice.customer_name') !!}:</td>
        <td>{!! $invoice->user->Name !!}</td>
        <td></td>
        <td>{!! trans('bazaar.invoice.customer_family') !!}:</td>
        <td>{!! $invoice->user->Family !!}</td>
    </tr>
    <tr>
        <td>{!! trans('bazaar.invoice.customer_mellicode') !!}:</td>
        <td>{!! $invoice->user->melli_code !!}</td>
        <td></td>
        <td>{!! trans('bazaar.invoice.invoice_no') !!}:</td>
        <td>{!! $invoice->invoice_no !!}</td>
    </tr>
    <tr>
        <td>{!! trans('bazaar.invoice.subject_count') !!}:</td>
        <td>{!! $invoice->subject_count !!}</td>
        <td></td>
        <td>{!! trans('bazaar.invoice.date') !!}:</td>
        <td>{!! $invoice->created_at_jalali !!}</td>
    </tr>
    <tr>
        <td>{!! trans('bazaar.invoice.amount') !!}:</td>
        <td>{!! number_format($invoice->payable_amount) . ' ' . trans('bazaar.$') !!}</td>
        <td></td>
        <td>{!! trans('bazaar.invoice.has_coupon') !!}:</td>
        <td>{!! trans('bazaar.invoice.has_coupon_' . ($invoice->has_coupon ? 'yes' : 'no')) !!}</td>
    </tr>
    <tr>
        <td>{!! trans('bazaar.invoice.postmethod') !!}:</td>
        <td>{!! $invoice->postmethod_title !!}</td>
        <td></td>
        <td>{!! trans('bazaar.invoice.tracking_code') !!}:</td>
        <td>{!! $invoice->tracking_code !!}</td>
    </tr>
    <tr>
        <td>{!! trans('bazaar.invoice.receiver') !!}:</td>
        <td colspan="4">{!! sprintf(trans('bazaar.invoice.receiver_template_'), $receiver_name, $receiver_family, $address, $emergency_phone) !!}</td>
    </tr>
    <tr>
        <td>{!! trans('bazaar.invoice.state') !!}:</td>
        <td>{!! $invoice->last_status !!}</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
