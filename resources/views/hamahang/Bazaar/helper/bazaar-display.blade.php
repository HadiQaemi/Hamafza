<!--
Path: \app\HamafzaViewClasses\
File: PageClass.php
Function: CreatPageView
Line: Approximately Line 357
-->
@if ($image_exist || $fields || $PageDescription)
    <link type="text/css" rel="stylesheet" href="{{ url('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css') }}">
    <script type="text/javascript" src="{{ url('assets/Packages/PersianDateOrTimePicker/js/persian-date.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js') }}"></script>
    @include('hamahang.Bazaar.helper.bazaar-css')
    @include('hamahang.Bazaar.helper.bazaar-js')
    @php
        $price_after_discount = $spi['price'] - $spi['discount'];
        $tax = $price_after_discount * $spi['tax'] / 100;
        $payment_methods = explode(',', $spi['payment_methods']);
        foreach($payment_methods as $payment_method)
        {
            $payment_methods_final_array[] = trans("bazaar.payment_methods_$payment_method");
        }
        $payment_methods_final = implode(', ', $payment_methods_final_array);
        $final_pay = $price_after_discount + $tax + $spi['shipping_cost'];
        $user = App\User::find($spi['responsible_for_sales_id']);
    @endphp
    <style>
        .ui-effects-transfer
        {
            border: 1px dotted #286090;
        }
    </style>
    <form class="form_bazaar form-inline" id="form_bazaar" name="form_bazaar">
        <div class="row">
            @if($image_exist)
                <div class="col-md-4">
                    <img src="{!! $image !!}" style="border-radius: 15px 0; height: 200px; width: 100%;"/>
                </div>
            @endif
            @if($fields || $spi)
                <div class="@if($image_exist)col-md-8 @else col-md-12 @endif">
                    @if ($fields)
                        <div class="pull-right" style="width: 49%;">
                            <style>
                                .table_fields,
                                .table_fields > thead > tr > th,
                                .table_fields > tbody > tr > th,
                                .table_fields > tfoot > tr > th,
                                .table_fields > thead > tr > td,
                                .table_fields > tbody > tr > td,
                                .table_fields > tfoot > tr > td
                                {
                                    border: none;
                                    vertical-align: middle;
                                }
                            </style>
                            <table class="table table-striped table_fields">
                                @if(isset($fields[0]))
                                    @foreach($fields[0] as $field)
                                        @if ('قیمت (ریال)' !== $field['name'])
                                            <tr>
                                                <td>{!! $field['name'] !!}:</td>
                                                <td>{!! $field['pivot']['field_value'] !!}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </table>
                        </div>
                        <div class="pull-left" style="width: 49%; margin-right: 5px;">
                            <table class="table table-striped table_fields">
                                @if(isset($fields[1]))
                                    @foreach($fields[1] as $field)
                                        <tr>
                                            <td>{!! $field['name'] !!}:</td>
                                            <td>{!! $field['pivot']['field_value'] !!}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                        <div class="clear"></div>
                    @endif
                    @if ($spi)
                        @if ($spi['ready_to_supply'])
                            {!! trans('bazaar.price') !!}:
                            @if ($spi['discount'])
                                <span style="text-decoration: line-through; color: red;" class="larg">{!! number_format($spi['price']) !!}</span>
                                <span class="larg">{!! number_format($price_after_discount) !!}</span>
                            @else
                                <span class="larg">{!! number_format($spi['price']) !!}</span>
                            @endif
                            {!! trans('bazaar.$') !!}
                            @if (Auth::check())
                                <input type="button" class="btn btn-primary pull-left add_to_cart" onclick="add_to_cart(this)" value="افزودن به سبد خرید"/>
                                <input modal="modal" type="button" class="btn btn-info pull-left jsPanels" href="{!! route('modals.discount_coupon_request_form') !!}" value="درخواست کد تخفیف" style="margin-left: 5px;"/>
                            @else
                                <input type="button" class="btn btn-primary pull-left login" value="افزودن به سبد خرید" data-toggle="modal" data-target="#loginWmessage"/>
                                <input type="button" class="btn btn-info pull-left login" value="درخواست کد تخفیف" data-toggle="modal" data-target="#loginWmessage" style="margin-left: 5px;"/>
                            @endif
                            @if ($spi['description'])
                                <div style="border: #eeeeee 1px solid; padding: 10px; margin-top: 10px;">
                                    {!! $spi['description'] !!}
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            @endif
        </div>
        <input type="hidden" id="subject_id" name="subject_id" value="{!! $spi['subject_id'] !!}"/>
        <input type="hidden" id="subject_count" name="subject_count" value="1"/>
    </form>
    <hr style="border: 1px solid #7dca75;"/>
    @if($PageDescription)
        <div class="row">
            {!! $PageDescription !!}
        </div>
    @endif
@endif