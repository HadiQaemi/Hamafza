<div class="" style="padding: 10px;">
    <ol class="progress-track">
        <li class="progress-done">
            <div class="icon-wrap">
                <svg class="icon-state icon-check-mark"><use xlink:href="#icon-check-mark"></use></svg>
                <svg class="icon-state icon-down-arrow"><use xlink:href="#icon-down-arrow"></use></svg>
            </div>
            <span class="progress-text" style="color: #87BA51;"><a href="{!! $url_cart !!}" style="color: #87BA51;">ورود به هم‌افزا</a></span>
        </li>
        <li class="progress-done progress-current">
            <div class="icon-wrap">
                <svg class="icon-state icon-check-mark"><use xlink:href="#icon-check-mark"></use></svg>
                <svg class="icon-state icon-down-arrow"><use xlink:href="#icon-down-arrow"></use></svg>
            </div>
            <span class="progress-text" style="color: #87BA51;">اطلاعات ارسال سفارش</span>
        </li>
        <li class="progress-todo">
            <div class="icon-wrap">
                <svg class="icon-state icon-check-mark"><use xlink:href="#icon-check-mark"></use></svg>
                <svg class="icon-state icon-down-arrow"><use xlink:href="#icon-down-arrow"></use></svg>
            </div>
            <span class="progress-text" style="color: #DDD;">بازبینی سفارش</span>
        </li>
        <li class="progress-todo">
            <div class="icon-wrap">
                <svg class="icon-state icon-check-mark"><use xlink:href="#icon-check-mark"></use></svg>
                <svg class="icon-state icon-down-arrow"><use xlink:href="#icon-down-arrow"></use></svg>
            </div>
            <span class="progress-text" style="color: #DDD;">اطلاعات پرداخت</span>
        </li>
    </ol>

    <table class="table" style="border: none;">
        <tr>
            <td style="vertical-align: middle;">
                <div class="pull-right" style="margin: 3px 0 0 10px;">
                    <i class="fa fa-caret-left" style="color: #2196F3;"></i><span style="color: #666666; font-size: larger;"> انتخاب آدرس</span>
                </div>
                <button modal="modal" href="{!! route('modals.addresses_add_form') !!}" class="btn btn-default pull-right jsPanels" type="button" id="address_add">
                    <span>افزودن آدرس جدید</span>
                </button>
            </td>
        </tr>
    </table>

    <form class="form_shipping form-inline" id="form_shipping" name="form_shipping" method="post" action="{!! route('ugc.desktop.hamahang.bazaar.review', ['Uname' => auth()->user()->Uname]) !!}">
        @foreach ($addresses as $address)
            @php
                $address = (object) $address;
                if ($address->province_id)
                {
                    $province = App\Models\Hamahang\ProvinceCity\Province::find($address->province_id)->name;
                } else
                {
                    $province = 'نا مشخص';
                }
                if ($address->city_id)
                {
                    $city = App\Models\Hamahang\ProvinceCity\City::find($address->city_id)->name;
                } else
                {
                    $city = 'نا مشخص';
                }
            @endphp
            <table class="table table-bordered" style="{!! $address->id == auth()->user()->default_address_id ? 'border: 2px solid #87BA51;' : null !!}">
                <colgroup>
                    <col class="col-xs-1">
                    <col class="col-xs-2">
                    <col class="col-xs-5">
                    <col class="col-xs-3">
                    <col class="col-xs-1">
                </colgroup>
                <tr>
                    <th rowspan="3" class="text-center" style="background-color: #F7FFF7;">
                        <input type="radio" name="address" class="address" value="{!! $address->id !!}" {!! $address->id == $cart_setting['address'] ? 'checked ' : ($address->id == auth()->user()->default_address_id ? 'checked ' : null) !!}/>
                    </th>
                    <th colspan="3" style="font-size: larger;">{!! $address->receiver_name . ' ' . $address->receiver_family !!}</th>
                    <th rowspan="3" style="padding: 0; margin: 0;">
                        <table class="table" style="padding: 0; margin: 0; height: 160px;">
                            <tr>
                                <td class="text-center" style="background-color: #E3F3FC; color: #2196F3; height: 50%; vertical-align: middle;">
                                    <button modal="modal" href="{!! route('modals.addresses_add_form') . '?edit_id=' . $address->id !!}" class="btn btn-default pull-right jsPanels" type="button" id="address_add" style="background-color: transparent; border: none; color: #2196F3;">
                                        <i class="fa fa-pencil"></i> <span>ویرایش</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center" style="background-color: #FFEDEE; color: #F05457; height: 50%; vertical-align: middle;">
                                    <a style="color: #F05457; cursor: pointer;" onclick="if (confirm('آیا مطمئن هستید؟')) { address_delete('{!! $address->id !!}') }">
                                        <i class="fa fa-close" style="font-size: 16px;"></i> <span>حذف</span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th>استان: {!! $province !!}</th>
                    <th rowspan="2">
                        <div>{!! $address->address !!}</div><br />
                        <div>کدپستی: {!! $address->postal_code !!}</div>
                    </th>
                    <th>شماره تماس اضطراری: {!! $address->emergency_phone !!}</th>
                </tr>
                <tr>
                    <th>شهر: {!! $city !!}</th>
                    <th>شماره تماس ثابت: {!! $address->land_phone_number !!}</th>
                </tr>
            </table>
        @endforeach
        <i class="fa fa-caret-left" style="color: #2196F3;"></i><span style="color: #666666; font-size: larger;"> شیوه ارسال</span><br />
        <br />
        @foreach ($postmethods as $postmethod)
            <table class="table table-bordered">
                <colgroup>
                    <col class="col-xs-1">
                    <col class="col-xs-8">
                    <col class="col-xs-3">
                </colgroup>
                <tr>
                    <th class="text-center" style="background-color: #F7FFF7;">
                        <input type="radio" class="postmethod" name="postmethod" value="{!! $postmethod->id !!}" {!! $postmethod->id == $cart_setting['postmethod'] ? 'checked ' : null !!}/>
                    </th>
                    <th>
                        <i class="fa fa-car fa-4x pull-right" style="margin: 10px; color: #42A2E5;{{--{!! 30 == $postmethod->id ? '#42A2E5' : '#FF7272' !!}--}}"></i>
                        <div class="pull-right" style="margin: 10px;">
                            <span>{!! $postmethod->title !!}</span><br />
                            <span style="color: #888A8A;">{!! $postmethod->comment !!}</span>
                        </div>
                    </th>
                    <th>
                        <span>هزینه ارسال</span><br />
                        <span style="color: #52AF50; font-size: larger;">{!! $postmethod->value ? number_format($postmethod->value) . ' ریال': 'پس کرایه' !!}</span>
                    </th>
                </tr>
            </table>
        @endforeach
        {!! csrf_field() !!}
    </form>

    <button class="btn btn-info pull-left" type="button" onclick="proceed_to_review(this);">
        <span>ثبت اطلاعات و ادامه خرید</span>&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-left"></i>
    </button>
    <div class="pull-left" style="color: #FF5252; margin: 7px 0 0 10px;"></div>
    <a href="{!! $url_cart !!}">
        <button class="btn btn-disabled pull-right" type="button">
            <span>بازگشت به سبد خرید</span>
        </button><br />
    </a>
    <br />
    <div class="pull-left">مرحله بعد: بازبینی سفارش</div>
    <div class="clear"></div>
    <br />
</div>

