<style>
    .form_coupon .form-group
    {
        margin-bottom: 10px;
    }
</style>
<form class="form_coupon" style="padding: 10px; display: none;">
    <table class="table table_coupon table-condensed">
        <tr>
            <td><label for="coupon">{!! trans('bazaar.discountcoupon.coupon') !!}:</label></td>
            <td><input type="text" class="form-control" id="coupon" value="{!! $data ? $data->coupon : null !!}" placeholder="13630306" autofocus /></td>
            <td></td>
            <td><label for="inactive">{!! trans('bazaar.discountcoupon.status') !!}:</label></td>
            <td>
                <select class="form-control" id="inactive">
                    <option value="0" {!! $data ? (0 == $data->inactive ? 'selected' : null) : null !!}>{!! trans('bazaar.discountcoupon.status_active') !!}</option>
                    <option value="1" {!! $data ? (1 == $data->inactive ? 'selected' : null) : null !!}>{!! trans('bazaar.discountcoupon.status_inactive') !!}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="type">{!! trans('bazaar.discountcoupon.type') !!}:</label></td>
            <td>
                <select class="form-control" id="type">
                    <option value="0" {!! $data ? (0 == $data->type ? 'selected' : null) : null !!}>{!! trans('bazaar.discountcoupon.type_percentage') !!}</option>
                    <option value="1" {!! $data ? (1 == $data->type ? 'selected' : null) : null !!}>{!! trans('bazaar.discountcoupon.type_amount') !!}</option>
                </select>
            </td>
            <td></td>
            <td><label for="value">{!! trans('bazaar.discountcoupon.value') !!} (<span id="type_of_value">{!! trans('bazaar.discountcoupon.type_of_value_0') !!}</span>):</label></td>
            <td><input type="text" class="form-control" id="value" value="{!! $data ? str_replace(',', null, $data->value) : null !!}" placeholder="80" /></td>
        </tr>
        <tr>
            <td><label for="disposable">{!! trans('bazaar.discountcoupon.disposable') !!}:</label></td>
            <td>
                <select class="form-control" id="disposable" onchange="'1' == $(this).val() ? $('#usage_quota').attr('disabled', 'disabled') : $('#usage_quota').removeAttr('disabled')">
                    <option value="0" {!! $data ? (0 == $data->disposable ? 'selected' : null) : null !!}>{!! trans('bazaar.discountcoupon.disposable_no') !!}</option>
                    <option value="1" {!! $data ? (1 == $data->disposable ? 'selected' : null) : null !!}>{!! trans('bazaar.discountcoupon.disposable_yes') !!}</option>
                </select>
            </td>
            <td></td>
            <td><label for="usage_quota">{!! trans('bazaar.discountcoupon.usage_quota') !!}:</label></td>
            <td><input type="text" class="form-control" id="usage_quota" value="{!! $data ? $data->usage_quota : null !!}" placeholder="66" {!! $data ? (1 == $data->disposable ? 'disabled' : null) : null !!} /></td>
        </tr>
        <tr>
            <td><label for="start_date">{!! trans('bazaar.discountcoupon.start_date') !!}:</label></td>
            <td><input type="text" class="form-control" id="start_date" value="{!! $data ? $data->start_date : null !!}" placeholder="1396/03/06" /></td>
            <td></td>
            <td><label for="expire_date">{!! trans('bazaar.discountcoupon.expire_date') !!}:</label></td>
            <td><input type="text" class="form-control" id="expire_date" value="{!! $data ? $data->expire_date : null !!}" placeholder="1400/03/06" /></td>
        </tr>
    </table>
    <input type="hidden" class="form-control" id="coupon_old" value="{!! $data ? $data->coupon : 0 !!}" />
    <input type="hidden" class="form-control" id="edit_id" value="{!! $data ? $data->id : 0 !!}" />
</form>