@php

    //check whether subject has a coupon added
    function cart_has_coupon($id)
    {
        $r = \App\Http\Controllers\Hamahang\BazaarController::cart_has_coupon($id);
        return $r;
    }

    //check whether subject has a coupon added
    function cart_calc_discount($id, $price, $discounted_price, $count)
    {
        $r = \App\Http\Controllers\Hamahang\BazaarController::cart_calc_discount($id, $price, $discounted_price, $count);
        return $r;
    }

@endphp
