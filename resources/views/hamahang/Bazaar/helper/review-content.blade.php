@include('hamahang.Bazaar.helper.common')
@if (count($products))
    <div class="" style="padding: 10px;">
        <ol class="progress-track">
            <li class="progress-done">
                <div class="icon-wrap">
                    <svg class="icon-state icon-check-mark"><use xlink:href="#icon-check-mark"></use></svg>
                    <svg class="icon-state icon-down-arrow"><use xlink:href="#icon-down-arrow"></use></svg>
                </div>
                <span class="progress-text" style="color: #87BA51;"><a href="{!! $url_cart !!}" style="color: #87BA51;">ورود به هم‌افزا</a></span>
            </li>
            <li class="progress-done">
                <div class="icon-wrap">
                    <svg class="icon-state icon-check-mark"><use xlink:href="#icon-check-mark"></use></svg>
                    <svg class="icon-state icon-down-arrow"><use xlink:href="#icon-down-arrow"></use></svg>
                </div>
                <span class="progress-text" style="color: #87BA51;"><a href="{!! $url_shipping !!}" style="color: #87BA51;">اطلاعات ارسال سفارش</a></span>
            </li>
            <li class="progress-done progress-current">
                <div class="icon-wrap">
                    <svg class="icon-state icon-check-mark"><use xlink:href="#icon-check-mark"></use></svg>
                    <svg class="icon-state icon-down-arrow"><use xlink:href="#icon-down-arrow"></use></svg>
                </div>
                <span class="progress-text" style="color: #87BA51;">بازبینی سفارش</span>
            </li>
            <li class="progress-todo">
                <div class="icon-wrap">
                    <svg class="icon-state icon-check-mark"><use xlink:href="#icon-check-mark"></use></svg>
                    <svg class="icon-state icon-down-arrow"><use xlink:href="#icon-down-arrow"></use></svg>
                </div>
                <span class="progress-text" style="color: #DDD;">اطلاعات پرداخت</span>
            </li>
        </ol>
        <form class="form_cart form-inline" id="form_cart" name="form_cart" method="get" action="{!! $url_shipping !!}">
            <table class="table table-bordered">
                <thead>
                <tr class="text-center" style="background-color: #F7F9FA; font-size: 13px; height: 48px;">
                    <td class="col-xl-6" colspan="2">شرح محصول</td>
                    <td class="col-xl-1">تعداد</td>
                    <td class="col-xl-1">قیمت واحد</td>
                    <td class="col-xl-2">قیمت کل</td>
                    <td class="col-xl-1"></td>
                </tr>
                </thead>
                @php
                    $total_price = 0;
                    $total_discount = 0;
                    $total_discountcoupon = 0;
                @endphp
                @foreach ($products as $product)
                    @php
                        $id = $product->id;
                        $image = $product->def_image_url;
                        $title = $product->title;
                        $count = $cart[$product->id];
                        $page = App\Models\hamafza\Pages::where('sid', $product['product_info']['subject_id'])->first();
                        $page_id = $page->id;
                        $subject_id = $product['product_info']['subject_id'];
                        $price = $product['product_info']['price'];
                        $discount = $product['product_info']['discount'];
                        $discounted_price = $price - $discount;
                        $sum_price = $price * $count;
                        $sum_discount = $discount * $count;
                        $final_price = $sum_price - $sum_discount;
                        $total_price += $sum_price;
                        $total_discount += $sum_discount;
                    @endphp
                    <tr>
                        <th class="text-center" style="border-left: none;">
                        </th>
                        <th class="text-center" style="border-right: none;">
                            <a href="{!! url($page_id) !!}" target="_blank"><img src="{!! $image !!}" style="border-radius: 15px 0;" width="200" /></a><br />
                            <br />
                            <a href="{!! url($page_id) !!}" target="_blank">{!! $title !!}</a>
                        </th>
                        <th class="text-center">{!! $count !!}</th>
                        <th class="text-center">
                            <span style="font-size: larger;">{!! number_format($price) !!}</span> <small>ریال</small>
                        </th>
                        <th class="text-center h-close-beside" style="border-left: none;">
                            <table class="table table-condensed table_inner" style="border: none;">
                                <tr>
                                    <td class="text-right">قیمت کل:</td>
                                    <td class="text-left">
                                        <span style="font-size: large;">{!! number_format($sum_price) !!}</span> <small>ریال</small>
                                    </td>
                                </tr>
                                @if ($sum_discount)
                                    <tr style="color: #ff5252;">
                                        <td class="text-right">تخفیف:</td>
                                        <td class="text-left">
                                            <span style="font-size: large;">{!! number_format($sum_discount) !!}</span> <small>ریال</small>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="2">
                                        <hr style="border: none; border-top: 1px dashed lightgray;"/>
                                    </td>
                                </tr>
                                <tr style="color: #3EB332;">
                                    <td class="al center" colspan="2">
                                        @if (cart_has_coupon($subject_id))
                                            @php ($cart_calc_discount = cart_calc_discount($subject_id, $price, $discounted_price, $count))
                                            @php ($total_discountcoupon += $cart_calc_discount)
                                            <span style="text-decoration: line-through; color: #ff5252;">{!! number_format($final_price) !!} <small>ریال</small></span><br />
                                            <span style="font-size: x-large;">{!! number_format($final_price - $cart_calc_discount > 0 ? $final_price - $cart_calc_discount : 0) !!} <small>ریال</small></span>
                                        @else
                                            <span style="font-size: x-large;">{!! number_format($final_price) !!}</span> <small>ریال</small>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th class="text-center h-refresh" style="border-right: none;"><i class="fa fa-refresh" onclick="review_content();"></i></th>
                    </tr>
                @endforeach
            </table>
            {!! csrf_field() !!}
        </form>
        <br />
        <br />
        <br />

        <i class="fa fa-caret-left" style="color: #2196F3;"></i><span style="color: #666666; font-size: larger;"> خلاصه صورتحساب شما</span><br />
        <br />
        <table class="table table-bordered">
            <tr>
                <th>جمع کل خرید شما:</th>
                <th class="col-sm-1">{!! number_format($total_price) !!}</th>
                <th class="col-sm-1">ریال</th>
            </tr>
            <tr>
                <th>هزینه ارسال، بیمه و بسته بندی سفارش:</th>
                <th>{!! number_format($postmethod->value) !!}</th>
                <th>ریال</th>
            </tr>
            <tr style="background-color: #FCF5F5;">
                <th style="color: #FF6B7E; ">جمع کل تخفیف:</th>
                <th style="color: #FF6B7E; ">{!! number_format($total_discount + $total_discountcoupon) !!}</th>
                <th style="color: #FF6B7E; ">ریال</th>
            </tr>
            <tr style="background-color: #F7FFF7; font-size: larger;">
                <th style="color: #5DAF50; ">جمع کل قابل پرداخت:</th>
                @php ($payable_amount = $total_price - $total_discount - $total_discountcoupon + $postmethod->value)
                <th style="color: #5DAF50; ">{!! number_format($payable_amount) !!}</th>
                <th style="color: #5DAF50; ">ریال</th>
            </tr>
        </table>
        <br />
        <br />
        <br />

        <i class="fa fa-caret-left" style="color: #2196F3;"></i><span style="color: #666666; font-size: larger;"> اطلاعات ارسال سفارش</span><br />
        <br />
        <table class="table table-bordered">
            <tr>
                <th style="padding: 20px;width: 40px;"><img src="http://imgh.us/location_4.png" /></th>
                <th style="padding: 20px;">
                    <span class="txt">این سفارش به <span class="green">{!! $address->receiver_name !!} {!! $address->receiver_family !!}</span> به آدرس  <span class="green">{!! $address->address !!}</span> و شماره تماس  {!! $address->emergency_phone !!}  تحویل می&zwnj;گردد.</span>
                </th>
            </tr>
            <tr>
                <th style="padding: 20px;"><img src="http://imgh.us/send-mothod.png" /></th>
                <th style="padding: 20px;">
                    <span class="txt">این سفارش از طریق <span class="green">{!! $postmethod->title !!}</span> با هزینه <span class="green">{!! number_format($postmethod->value) !!}</span> ریال به شما تحویل داده خواهد شد.</span>
                </th>
            </tr>
        </table>
        <a href="{!! $url_shipping !!}">
            <button class="btn btn-disabled pull-left" type="button" onclick="window.location='{!! route('ugc.desktop.hamahang.bazaar.shipping', ['Uname' => auth()->user()->Uname]) !!}';">
                <span>ویرایش</span>
            </button><br />
        </a>
        <br />
        <br />
        <br />
        <br />

        <button class="btn btn-info pull-left" type="button" onclick="proceed_to_payment('{!! $payable_amount !!}', this);">
            <span>تایید و انتخاب شیوه پرداخت</span>&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-left"></i>
        </button>
        <div class="pull-left" style="color: #FF5252; margin: 7px 0 0 10px;"></div>
        <a href="{!! $url_shipping !!}">
            <button class="btn btn-disabled pull-right" type="button" onclick="">
                <span>بازگشت</span>
            </button><br />
        </a>
        <br />
        <div class="pull-left">مرحله بعد: تکمیل اطلاعات پرداخت</div>
        <div class="clear"></div>
        <br />
    </div>
@else
    <div class="" style="padding: 10px;">
        <div class="text-center" style="margin: 150px 0; font-size: x-large"> سبد خرید شما خالی است!</div>
    </div>
@endif
