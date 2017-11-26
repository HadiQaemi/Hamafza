@include('hamahang.Bazaar.helper.common')
@if (count($products))
    <div class="" style="padding: 10px;">
        <table class="table" style="border: none;">
            <tr>
                <td style="vertical-align: middle;">
                    <i class="fa fa-caret-left" style="color: #2196F3;"></i><span style="color: #666666; font-size: larger;"> سبد خرید شما در {!! config('constants.SiteTitle') !!}</span><br />
                    <span style="color: #666666;">افزودن کالاها به سبد خرید به معنی رزرو کالا برای شما نیست. برای ثبت سفارش باید مراحل بعدی خرید را تکمیل نمایید.</span><br />
                </td>
                <td style="vertical-align: middle;">
                    <a href="{!! $url_shipping !!}">
                        <button class="btn btn-info pull-left to_shipping" type="button" onclick="$('.to_shipping').attr('disabled', 'disabled');">
                            <span>ادامه ثبت سفارش</span>&nbsp;<i class="fa fa-arrow-left"></i>
                        </button>
                    </a>
                </td>
            </tr>
        </table>
        <form class="form_cart form-inline" id="form_cart" name="form_cart" method="get" action="{!! $url_shipping !!}">
            <table class="table table-bordered">
                <thead>
                <tr class="text-center" style="background-color: #F7F9FA; font-size: 13px; height: 48px;">
                    <td class="col-xl-6" colspan="2">شرح محصول</td>
                    <td class="col-xl-1">تعداد</td>
                    <td class="col-xl-1">قیمت واحد</td>
                    <td class="col-xl-2">قیمت کل</td>
                    <td class="col-xl-1 h-close" style="background-color: #ffcfcc;"><i class="fa fa-close h-close" style="background-color: #ffcfcc;" onclick="cart_empty();"></i></td>
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
                        <th class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown" style="width: 45px;">
                                    <div class="selected-count" style="display: inline-block; width: 15px">{!! $count !!}</div> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @for ($i = 1; $i < 11; $i++)
                                        <li><a class="select-count" onclick="cart_update('{!! $id !!}', '{!! $i !!}');">{!! $i !!}</a></li>
                                    @endfor
                                    {{--
                                    <li><a class="select-count" onclick="cart_update('{!! $id !!}', '20');">20</a></li>
                                    <li><a class="select-count" onclick="cart_update('{!! $id !!}', '30');">30</a></li>
                                    <li><a class="select-count" onclick="cart_update('{!! $id !!}', '40');">40</a></li>
                                    <li><a class="select-count" onclick="cart_update('{!! $id !!}', '50');">50</a></li>
                                    --}}
                                </ul>
                            </div>
                        </th>
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
                                <tr style="color: #ff5252;">
                                    <td class="text-right">کد تخفیف:</td>
                                    <td class="text-left">
                                        @if (cart_has_coupon($subject_id))
                                            <button class="btn btn-warning pull-left" type="button" style="width: 75px;" onclick="cart_discountcoupon_remove('{!! $subject_id !!}', this)">حذف</button>
                                        @else
                                            <input type="text" class="form-control" id="discountcoupon_{!! $subject_id !!}" />&nbsp;
                                            <button class="btn btn-info pull-left" type="button" style="width: 75px;" onclick="cart_discountcoupon_check('{!! $subject_id !!}', this)">ثبت</button>
                                        @endif
                                    </td>
                                </tr>
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
                        <th class="text-center h-close" style="border-right: none;"><i class="fa fa-close" onclick="cart_delete('{!! $id !!}')"></i></th>
                    </tr>
                @endforeach
            </table>
            {!! csrf_field() !!}
        </form>
        <div class="row">
            <table class="table pull-left" style="width: 65%; border-color: #D8F6D9;">
                <tr>
                    <td class="text-center" style="vertical-align: middle; width: 40%;">
                        @if ($total_discount + $total_discountcoupon > 0)
                            <div style="width: 100%; margin: auto; color: white; font-size: smaller;">
                                <div class="pull-right" style="background-color: #FF7272; width: 50%; margin: auto; height: 22px; padding-top: 5px; border-radius: 0 3px 3px 0;">مجموع تخفیف:</div>
                                <div class="pull-left" style="background-color: #FF5252; width: 50%; margin: auto; height: 22px; padding-top: 5px; border-radius: 3px 0 0 3px ;">{!! number_format($total_discount + $total_discountcoupon) !!} ریال</div>
                            </div>
                        @endif
                    </td>
                    <td class="text-left" style="vertical-align: middle; width: 20%;"><small>جمع کل خرید شما:</small></td>
                    <td class="text-left" style="padding-left: 100px; width: 50%;">
                        <span style="font-size: large;">{!! number_format($total_price) !!}</span> <small>ریال</small>
                    </td>
                </tr>
                <tr style="background-color: #F7FFF7; color: #5FAF50;">
                    <td class="text-left" style="vertical-align: middle;" colspan="2"><small>مبلغ قابل پرداخت:</small></td>
                    <td class="text-left" style="padding-left: 100px;">
                        <span style="font-size: x-large;">{!! number_format($total_price - $total_discount - $total_discountcoupon) !!}</span> <small>ریال</small>
                    </td>
                </tr>
            </table>
        </div>
        <a href="{!! $url_shipping !!}">
            <button class="btn btn-info pull-left to_shipping" type="button" onclick="$('.to_shipping').attr('disabled', 'disabled');">
                <span>ادامه ثبت سفارش</span>&nbsp;<i class="fa fa-arrow-left"></i>
            </button>
        </a>
        <div class="pull-left" style="color: #FF5252; margin: 9px 0 0 10px;">کالاهای موجود در سبد شما ثبت و رزرو نشده اند، برای ثبت سفارش مراحل بعدی را تکمیل کنید <i class="fa fa-chevron-left"></i></div>
        <a href="{!! url('/') !!}">
            <button class="btn btn-disabled pull-right" type="button">
                <span>بازگشت به صفحه اصلی</span>
            </button>
        </a>
        <div class="clear"></div>
    </div>
@else
    <div class="" style="padding: 10px;">
        <div class="text-center" style="margin: 150px 0; font-size: x-large"> سبد خرید شما خالی است!</div>
    </div>
@endif
