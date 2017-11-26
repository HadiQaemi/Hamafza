<div class="pull-right" style="width: 100%; margin: auto; padding-right: 10px;">
    <form class="form-inline" id="invoice_status_form">
        <label for="status">{!! trans('bazaar.invoice.operations_status') !!}:</label>
        <select class="form-control" id="status" name="status" style="width: 200px;">
            <option>-</option>
            @foreach($statuses as $status)
                <option value="{!! $status->id !!}" data-value="{!! $status->value !!}">{!! $status->title !!}</option>
            @endforeach
        </select>
        <span id="tracking_code_client" style="display: none; width: 100px;">
            <label for="tracking_code" style=" padding-right: 50px;">{!! trans('bazaar.invoice.tracking_code') !!}:</label>
            <input type="text" id="tracking_code" name="tracking_code" class="form-control" value="{!! $invoice->tracking_code !!}" />
        </span>
        <input type="hidden" id="id" name="id" value="{!! $invoice->id !!}" />
    </form>
</div>
<div class="row pull-left">
    <span>
        <button type="button" class="btn btn-info" id="submit" onclick="invoice_status_submit();">
            <i class="fa fa-check"></i>&nbsp;{!! trans('bazaar.invoice.operations_status') !!}
        </button>
    </span>
</div>
