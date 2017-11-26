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
        <li class="progress-done">
            <div class="icon-wrap">
                <svg class="icon-state icon-check-mark"><use xlink:href="#icon-check-mark"></use></svg>
                <svg class="icon-state icon-down-arrow"><use xlink:href="#icon-down-arrow"></use></svg>
            </div>
            <span class="progress-text" style="color: #87BA51;"><a href="{!! $url_review !!}" style="color: #87BA51;">بازبینی سفارش</a></span>
        </li>
        <li class="progress-done progress-current">
            <div class="icon-wrap">
                <svg class="icon-state icon-check-mark"><use xlink:href="#icon-check-mark"></use></svg>
                <svg class="icon-state icon-down-arrow"><use xlink:href="#icon-down-arrow"></use></svg>
            </div>
            <span class="progress-text" style="color: #87BA51;">اطلاعات پرداخت</span>
        </li>
    </ol>

    {{--
    <div>
        <input type="checkbox" id="has_discount_code" name="has_discount_code" onclick="$('.discount_code_area').slideToggle();" /> <label for="has_discount_code" style="font-size: larger; color: #666666;">کد تخفیف هم‌افزا دارم</label><br />
        <br />
        <div class="discount_code_area" style="display: none;">
            <table class="table">
                <colgroup>
                    <col class="col-xs-8">
                    <col class="col-xs-3">
                    <col class="col-xs-1">
                </colgroup>
                <tr>
                    <th>

                    </th>
                    <th>
                        <input type="text" id="coupon" name="coupon" class="form-control text-left" style="margin: 15px;" />
                    </th>
                    <th>
                        <button class="btn btn-primary pull-left" type="button" style="margin: 15px;" onclick="discountcoupon_check();">
                            <span>ثبت کد تخفیف</span>
                        </button>
                    </th>
                </tr>
            </table>
        </div>
    </div>
    <br />
    <br />

    <div>
        <input type="checkbox" id="has_giftcard_code" name="has_giftcard_code" onclick="$('.giftcard_code_area').slideToggle();" /> <label for="has_giftcard_code" style="font-size: larger; color: #666666;">کارت هدیه هم‌افزا دارم</label><br />
        <br />
        <div class="giftcard_code_area" style="display: none;">
            <table class="table">
                <colgroup>
                    <col class="col-xs-8">
                    <col class="col-xs-3">
                    <col class="col-xs-1">
                </colgroup>
                <tr>
                    <th>

                    </th>
                    <th>
                        <input type="text" id="giftcard_code" name="giftcard_code" class="form-control text-left" style="margin: 15px;" />
                    </th>
                    <th>
                        <button class="btn btn-info pull-left" type="button" style="margin: 15px;">
                            <span>ثبت کارت هدیه</span>
                        </button>
                    </th>
                </tr>
            </table>
        </div>
    </div>
    <br />
    <br />
    --}}

    <div style="padding: 25px; background-color: #F7FFF7; border: 1px solid #F0F1F2;">
        <span class="pull-right">مبلغ قابل پرداخت:</span>
        <span class="pull-left"><span style="font-size: large;">{!! number_format($cart_setting['payable_amount']) !!}</span> ریال</span>
        <div class="clear"></div>
    </div>
    <br />
    <br />

    <i class="fa fa-caret-left" style="color: #2196F3;"></i><span style="font-size: larger;"> شیوه پرداخت</span><br />
    <br />

    <table class="table table-bordered">
        <colgroup>
            <col class="col-xs-1">
            <col class="col-xs-11">
        </colgroup>
        <tr>
            <th style="vertical-align: middle;" class="text-center">
                <input type="radio" name="method" checked="checked">
            </th>
            <th>
                <span style="font-size: large;">پرداخت اینترنتی (با تمامی کارت‌های عضو شتاب)</span><br />
                <span>
                    <input id="d" name="d" type="radio" checked="checked" /> <label for="d">درگاه پرداخت دریانوردی</label>
                    <!--
                    <input id="a" name="a" type="radio" disabled="disabled" /> <label for="a"> درگاه پرداخت اینترنتی بانک سامان</label>
                    <input id="b" name="a" type="radio" disabled="disabled" /> <label for="b"> درگاه پرداخت اینترنتی بانک ملت</label>
                    <input id="c" name="a" type="radio" disabled="disabled" /> <label for="c"> درگاه پرداخت اینترنتی بانک پارسیان</label>
                    -->
                </span>
            </th>
        </tr>
    </table>

    <!--
    <table class="table table-bordered">
        <colgroup>
            <col class="col-xs-1">
            <col class="col-xs-11">
        </colgroup>
        <tr>
            <th style="vertical-align: middle;" class="text-center">
                <input type="radio" name="method" disabled="disabled">
            </th>
            <th>
                <span style="font-size: large;">پرداخت در محل</span><br />
                <span style="color: #888;">برای سفارشهایی که از طریق باربری ارسال میشوند یا مبلغ آنها بیشتر از سی میلیون ریال است، لازم است یکی از روشهای پرداخت اینترنتی یا کارت به کارت، انتخاب و پیش از ارسال، مبلغ آنها تسویه شود</span>
            </th>
        </tr>
    </table>

    <table class="table table-bordered">
        <colgroup>
            <col class="col-xs-1">
            <col class="col-xs-11">
        </colgroup>
        <tr>
            <th style="vertical-align: middle;" class="text-center">
                <input type="radio" name="method" disabled="disabled">
            </th>
            <th>
                <span style="font-size: large;">واریز به حساب</span><br />
                <span style="color: #888;">شما می توانید وجه سفارش خود را از طریق مراجعه به شعب بانک به حساب شرکت فن آوازه واریز کرده و تا حداکثر 24 ساعت پس از سفارش اطلاعات آن را ثبت نمایید.</span>
            </th>
        </tr>
    </table>

    <table class="table table-bordered">
        <colgroup>
            <col class="col-xs-1">
            <col class="col-xs-11">
        </colgroup>
        <tr>
            <th style="vertical-align: middle;" class="text-center">
                <input type="radio" name="method" disabled="disabled">
            </th>
            <th>
                <span style="font-size: large;">کارت به کارت</span><br />
                <span style="color: #888;">شما می توانید وجه سفارش خود را بصورت انتقال وجه کارت به کارت پرداخت نموده و حداکثر تا 24 ساعت پس از سفارش اطلاعات آن را ثبت نمایید.</span>
            </th>
        </tr>
    </table>
    -->

    @if (empty(auth()->user()->melli_code))
        <div class="alert alert-info" role="alert" style="text-align: left;">
            <span>لطفاً کد ملی خود را درج نمائید:</span>
            <input type="text" class="form-control" id="melli_code" style="display: inline; width: 200px;" />
        </div>
    @endif

    <button class="btn btn-info pull-left" type="button" onclick="proceed_to_pay(this);">
        <span>پرداخت و ثبت سفارش</span>&nbsp;<i class="fa fa-arrow-left"></i>
    </button>
    <div class="pull-left" style="color: #FF5252; margin: 7px 0 0 10px;"></div>
    <a href="{!! $url_review !!}">
        <button class="btn btn-disabled pull-right" type="button">
            <span>بازگشت</span>
        </button>
    </a>
    <div class="pull-left" style="margin-left: 10px;"> با انتخاب دکمه (پرداخت و تکمیل خرید) موافقت خود را با <a href="#">شرایط و قوانین</a> مربوط<br />به ثبت و رویه‌های پردازش سفارشات هم‌افزا اعلام نموده‌اید.</div>
    <div class="clear"></div>
    <br />
</div>

