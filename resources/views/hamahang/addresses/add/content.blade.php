<style>
    .form_addresses label
    {
        margin-top: 10px;
    }
</style>
<form class="form-horizontal form_addresses" style="padding: 10px; display: none;">
    <label for="receiver_name">نام تحویل گیرنده:</label>
    <input type="text" class="form-control" id="receiver_name" value="{!! $data ? $data->receiver_name : null !!}" placeholder="" autofocus />

    <label for="receiver_family">نام‌خانوادگی تحویل گیرنده:</label>
    <input type="text" class="form-control" id="receiver_family" value="{!! $data ? $data->receiver_family : null !!}" placeholder="" />

    <label for="emergency_phone">شماره تماس ضروری (تلفن همراه):</label>
    <input type="text" class="form-control text-left" id="emergency_phone" value="{!! $data ? $data->emergency_phone : null !!}" placeholder="" />

    <label for="land_phone_precode">شماره تلفن ثابت تحویل گیرنده:</label><br />
    <input type="text" class="form-control pull-left text-left" id="land_phone_precode" value="{!! $data ? $data->land_phone_precode : null !!}" placeholder="" style="width: 19%; display: inline-block" />
    <input type="text" class="form-control pull-right text-left" id="land_phone_number" value="{!! $data ? $data->land_phone_number : null !!}" placeholder="" style="width: 79%; display: inline-block" /><br />

    <label for="city_id">استان/شهر تحویل گیرنده:</label><br />
    <select class="form-control" id="province_id" style="width: 49%; display: inline-block;">
        @php ($province_id = null !== $data ? $data->province_id : 0)
        @foreach ($provinces as $province)
            <option value="{!! $province->id !!}"{!! $province_id == $province->id ? ' selected="selected"' : null !!}>{!! $province->name !!}</option>
        @endforeach
    </select>
    <select class="form-control pull-left" id="city_id" style="width: 49%; display: inline-block;">
        {{--<option value="0">ابتدا استان را انتخاب نمائید.</option>--}}
    </select><br />

    <label for="address">آدرس پستی:</label>
    <textarea type="text" class="form-control" id="address" placeholder="">{!! $data ? $data->address : null !!}</textarea>

    <label for="postal_code">کد پستی:</label>
    <input type="text" class="form-control text-left" id="postal_code" value="{!! $data ? $data->postal_code : null !!}" placeholder="" />

    <input type="checkbox" id="default_address" name="default_address" />
    <label for="default_address">انتخاب به عنوان آدرس پیشفرض</label>

    <input type="hidden" class="form-control" id="edit_id" value="{!! $data ? $data->id : 0 !!}" />
</form>