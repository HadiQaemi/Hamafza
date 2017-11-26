<!--
Reference: \resources\views\modals\page_setting.blade.php
Line: Approximately Line 254
-->
<link type="text/css" rel="stylesheet" href="{{ url('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css') }}">
<script type="text/javascript" src="{{ url('assets/Packages/PersianDateOrTimePicker/js/persian-date.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js') }}"></script>
@include('hamahang.Bazaar.helper.bazaar-css')
@include('hamahang.Bazaar.helper.bazaar-js')
<style>
    table tr,
    table tr td,
    input[type=checkbox],
    input[type=radio]
    {
        margin-right: 0;
        padding-right: 0;
    }
    table tr td
    {
        vertical-align: middle !important;
    }
</style>
<form class="form_bazaar" id="form_bazaar" name="form_bazaar">
    @php ($user = App\User::find($spi['responsible_for_sales_id']))
    <table class="table">
        <tr>
            <td style="width: 10%;">{!! trans('bazaar.price') !!} ({!! trans('bazaar.$') !!}):</td>
            <td style="width: 20%;"><input type="text" class="form-control" id="price" name="price" value="{!! $spi['price'] !!}"></td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;">{!! trans('bazaar.discount') !!} ({!! trans('bazaar.$') !!}):</td>
            <td style="width: 20%;"><input type="text" class="form-control" id="discount" name="discount" value="{!! $spi['discount'] !!}"></td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;">{!! trans('bazaar.tax') !!} ({!! trans('bazaar.%') !!}):</td>
            <td style="width: 20%;"><input type="text" class="form-control" id="tax" name="tax" value="{!! $spi['tax'] !!}"></td>
        </tr>
        <tr>
            <td>{!! trans('bazaar.weight') !!} ({!! trans('bazaar.weight_unit') !!}):</td>
            <td><input type="text" class="form-control" id="weight" name="weight" value="{!! $spi['weight'] !!}"></td>
            <td></td>
            <td>{!! trans('bazaar.size') !!} ({!! trans('bazaar.size_unit') !!}):</td>
            <td><input type="text" class="form-control" id="size" name="size" value="{!! $spi['size'] !!}"></td>
            <td></td>
            <td>{!! trans('bazaar.count') !!}:</td>
            <td><input type="text" class="form-control" id="count" name="count" value="{!! $spi['count'] !!}"></td>
        </tr>
        <tr>
            <td>{!! trans('bazaar.shipping_cost') !!} ({!! trans('bazaar.$') !!}):</td>
            <td><input type="text" class="form-control" id="shipping_cost" name="shipping_cost" value="{!! $spi['shipping_cost'] !!}"></td>
            <td></td>
            <td>{!! trans('bazaar.maximum_delivery_time') !!}:</td>
            <td><input type="text" class="form-control maximum_delivery_time" id="maximum_delivery_time" name="maximum_delivery_time" value="{!! $spi['maximum_delivery_time'] !!}"></td>
            <td></td>
            <td>{!! trans('bazaar.responsible_for_sales_id') !!}:</td>
            <td>
                <select id="responsible_for_sales_id" name="responsible_for_sales_id[]" class="responsible_for_sales_id" {{--multiple--}}>
                    <option value=""></option>
                </select>
                {{--<input type="text" class="form-control" id="responsible_for_sales_id" name="responsible_for_sales_id" value="{!! $spi['responsible_for_sales_id'] !!}">--}}
            </td>
        </tr>
        <tr>
            <td colspan="8">
                <label>{!! trans('bazaar.description') !!}:</label>
                <textarea class="form-control" id="description" name="description">{!! $spi['description'] !!}</textarea>
            </td>
        </tr>
        <tr>
            <td>{!! trans('bazaar.how_to_send') !!}:</td>
            <td colspan="4">
                <input type="radio" class="" id="how_to_send_1" name="how_to_send" value="1" {!! 1 == $spi['how_to_send'] ? 'checked="checked"' : null !!}><label for="how_to_send_1">{!! trans('bazaar.how_to_send_1') !!}</label><br />
                <input type="radio" class="" id="how_to_send_2" name="how_to_send" value="2" {!! 2 == $spi['how_to_send'] ? 'checked="checked"' : null !!}><label for="how_to_send_2">{!! trans('bazaar.how_to_send_2') !!}</label>
            </td>
            <td></td>
            <td>{!! trans('bazaar.payment_methods') !!}:</td>
            <td>
                <input type="checkbox" class="" id="payment_methods_1" name="payment_methods[]" value="1" {!! 1 == $spi['how_to_send'] ? 'checked="checked"' : null !!}><label for="payment_methods_1">{!! trans('bazaar.payment_methods_1') !!}</label><br />
                <input type="checkbox" class="" id="payment_methods_2" name="payment_methods[]" value="2" {!! 2 == $spi['how_to_send'] ? 'checked="checked"' : null !!}><label for="payment_methods_2">{!! trans('bazaar.payment_methods_2') !!}</label>
            </td>
        </tr>
        <tr>
            <td colspan="8">
                <input type="checkbox" class="" id="ready_to_supply" name="ready_to_supply" value="1" {!! 1 == $spi['ready_to_supply'] ? 'checked="checked"' : null !!}>
                <label>{!! trans('bazaar.ready_to_supply') !!}</label>
            </td>
        </tr>
        <tr>
            <td colspan="7">
            <td><input type="button" class="btn btn-primary submit_bazzar" id="submit_bazzar" name="submit_bazzar" value="{!! trans('bazaar.submit') !!}" onclick="return do_submit();" style="float: left; width: 200px;"></td>
        </tr>
    </table>
    <input type="hidden" id="id" name="id" value="{!! $spi['id'] ? $spi['id'] : -1 !!}">
    <input type="hidden" id="subject_id" name="subject_id" value="{!! $spi['subject_id'] ? $spi['subject_id'] : $sid !!}">
</form>
@if ($user)
    <script>
        $(document).ready(function()
        {
            $('.responsible_for_sales_id').select2('trigger', 'select',
            {
                data: {'id': '{!! $spi['responsible_for_sales_id'] !!}', 'text': '{!! $user->Name !!} {!! $user->Family !!}'}
            });
        });
    </script>
@endif