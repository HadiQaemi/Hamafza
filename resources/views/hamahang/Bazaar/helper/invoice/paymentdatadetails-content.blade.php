@php
    $get_pay_ids_response = p(json_decode($item['get_pay_ids_response'], true), true, true, true);
    $params = p(json_decode($item['params'], true), true, true, true);
@endphp
<style>
    #paymentdatadetails tr td
    {
        direction: ltr;
    }
    pre
    {
        background-color: transparent;
        border: none;
        padding: 0;
        margin: 0;
    }
</style>
<table class="table table-bordered table-condensed" id="paymentdatadetails">
    <tr>
        <td>{!! $get_pay_ids_response !!}</td>
        <td>{!! $params !!}</td>
    </tr>
</table>
