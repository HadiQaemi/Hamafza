{{--
@forelse ($subjects as $subject)
    <div class="col-sm-4" style="height: 100px; width: 250px; float: right;">
        <img style="float: right; margin-left: 10px; height: 65px;" src="{{ url('img/bazaar/sample-1.png') }}" />
        <span style="text-decoration: line-through; color: red;" class="larg">{!! number_format($subject->product_info->price) !!}</span> {!! number_format($subject->product_info->price - $subject->product_info->discount) !!}<br />
        <strong>{!! $subject->title !!}</strong><br />
        <small>{!! $subject->product_info->CreatedAtName !!}</small><br />
        <small><a href="#" class="add-to-cart">افزودن به سبد خرید</a></small>
        <div class="clear"></div>
    </div>
@empty
    <div style="margin: 10px;">موردی برای نمایش وجود ندارد.</div>
@endforelse
<div style="clear: both;"></div>
<div style="width: 100%; margin: auto; text-align: center;">{{ $subjects->appends(array_except(Request::query(), 'page'))->links() }}</div>
--}}
