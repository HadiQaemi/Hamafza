<form id="add_new_post_frm" method="post" action="#" id="">
    <div class="padding-top-20" style="height: 60vh;overflow: scroll;padding-bottom: 40px">
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                <label for="extra_title">{{trans('org_chart.extra_title')}}</label>
            </div>
            <div class="col-xs-10">
                <input type="hidden" name="post_id" id="post_id" value="{{enCode($post->id)}}"/>
                <input type="text" name="extra_title" id="extra_title" value="{{$post->extra_title}}" class="form-control" placeholder="{{trans('org_chart.extra_title')}}"/>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                <label for="need_successor_users">{{trans('org_chart.add_users')}}</label>
            </div>
            <div class="col-xs-10">
                <select name="add_users[]" id="add_users" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('org_chart.add_users')}}" multiple>
                @if(!empty($post->users))
                        @foreach($post->users as $user)
                            <option selected="selected" value="{{ $user->user->id }}">{{ $user->user->Name.' '.$user->user->Family }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        {{--<div class="col-xs-12 form-group">--}}
            {{--<div class="col-xs-2 line-height-35">--}}
                {{--<input type="checkbox" class="noRightMargin" name="need_successor" id="need_successor" />--}}
                {{--<label for="need_successor">{{trans('org_chart.need_successor')}}</label>--}}
            {{--</div>--}}
            {{--<div class="col-xs-10">--}}
                {{--<div class="col-xs-2 noRightPadding noLeftPadding line-height-35">--}}
                    {{--<label for="need_successor_users">{{trans('org_chart.need_successor_users')}}</label>--}}
                {{--</div>--}}
                {{--<div class="col-xs-10 noRightPadding noLeftPadding">--}}
                    {{--<select name="need_successor_users[]" id="need_successor_users" class="select2_auto_complete_user col-xs-12" data-placeholder="{{trans('org_chart.need_successor_users')}}" multiple></select>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-xs-12 form-group">--}}
            {{--<div class="col-xs-2 line-height-35">--}}
                {{--<input type="checkbox" class="noRightMargin" name="outsourced" id="outsourced" />--}}
                {{--<label for="outsourced">{{trans('org_chart.outsourced')}}</label>--}}
            {{--</div>--}}
            {{--<div class="col-xs-10">--}}
                {{--<div class="col-xs-2 noRightPadding noLeftPadding line-height-35">--}}
                    {{--<label for="outsourced">{{trans('org_chart.outsourced_num')}}</label>--}}
                {{--</div>--}}
                {{--<div class="col-xs-10 noRightPadding noLeftPadding">--}}
                    {{--<input type="text" name="outsourced_num" id="outsourced_num" class="form-control" placeholder="{{trans('org_chart.outsourced_num')}}"/>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                <label for="work_place">{{trans('org_chart.work_place')}}</label>
            </div>
            <div class="col-xs-10">
                <input type="text" name="work_place" id="work_place" class="form-control" placeholder="{{trans('org_chart.work_place')}}" value="{{$post->location}}"/>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                <label for="share_payment">{{trans('org_chart.share_payment')}}</label>
            </div>
            <div class="col-xs-10">
                <input type="text" name="share_payment" id="share_payment" class="form-control" placeholder="{{trans('org_chart.share_payment')}}" value="{{$post->share_performance}}"/>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                <label>{{trans('org_chart.working_hours')}}</label>
            </div>
            <div class="col-xs-10 line-height-35">
                <input type="checkbox" name="working_hours[]" value="full_time" id="working_full_time"
                        {{$post->worktime->map(function($object) {
                            return ($object->type == 'full_time') ? $object : null;
                        })->filter()->count()==1 ? 'checked' : ''}}
                /><label for="working_full_time">{{trans('org_chart.full_time')}}</label>
                <input type="checkbox" class="margin-right-20" name="working_hours[]" id="working_part_time" value="working_part_time"
                        {{$post->worktime->map(function($object) {
                            return ($object->type == 'working_part_time') ? $object : null;
                        })->filter()->count()==1 ? 'checked' : ''}}
                /><label for="working_part_time">{{trans('org_chart.part_time')}}</label>
                <input type="checkbox" class="margin-right-20" name="working_hours[]" id="working_shift" value="working_shift"
                        {{$post->worktime->map(function($object) {
                                    return ($object->type == 'working_shift') ? $object : null;
                                })->filter()->count()==1 ? 'checked' : ''}}
                /><label for="working_shift">{{trans('org_chart.shift')}}</label>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                <label>{{trans('org_chart.access')}}</label>
            </div>
            <div class="col-xs-10 line-height-35">
                <input type="checkbox" name="access[]" id="financial_auth" value="financial_auth"
                        {{$post->accesses->map(function($object) {
                            return ($object->type == 'financial_auth') ? $object : null;
                        })->filter()->count()==1 ? 'checked' : ''}}
                /><label for="financial_auth">دسترسی به اکانت مالی</label>
                <input type="checkbox" class="margin-right-20" name="access[]" id="financial_server" value="financial_server"
                        {{$post->accesses->map(function($object) {
                            return ($object->type == 'financial_server') ? $object : null;
                        })->filter()->count()==1 ? 'checked' : ''}}/><label for="financial_server">دسترسی به سرورها</label>
                <input type="checkbox" class="margin-right-20" name="access[]" id="accounting" value="accounting"
                        {{$post->accesses->map(function($object) {
                            return ($object->type == 'accounting') ? $object : null;
                        })->filter()->count()==1 ? 'checked' : ''}}/><label for="accounting">دسترسی به سیستم پرداخت</label>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <div class="col-xs-2 line-height-35">
                <label>{{trans('org_chart.advantages')}}</label>
            </div>
            <div class="col-xs-10 line-height-35">
                <input type="checkbox" name="advantages[]" id="advantages0" value="private_room"
                    {{$post->adventages->map(function($object) {
                        return ($object->type == 'private_room') ? $object : null;
                    })->filter()->count()==1 ? 'checked' : ''}}
                /><label for="advantages0">اتاق اختصاص مشترک</label>
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="advantages1" value="shared_room"
                    {{$post->adventages->map(function($object) {
                        return ($object->type == 'shared_room') ? $object : null;
                    })->filter()->count()==1 ? 'checked' : ''}}/><label for="advantages1">اتاق اشتراکی</label>
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="advantages2" value="driver"
                    {{$post->adventages->map(function($object) {
                        return ($object->type == 'driver') ? $object : null;
                    })->filter()->count()==1 ? 'checked' : ''}}/><label for="advantages2">راننده</label>
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="advantages3" value="car"
                    {{$post->adventages->map(function($object) {
                        return ($object->type == 'car') ? $object : null;
                    })->filter()->count()==1 ? 'checked' : ''}}
                /><label for="advantages3">خودرو</label>
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="advantages4" value="labtop"
                    {{$post->adventages->map(function($object) {
                        return ($object->type == 'labtop') ? $object : null;
                    })->filter()->count()==1 ? 'checked' : ''}}/><label for="advantages4">لب تاپ</label>
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="advantages5" value="launch"
                    {{$post->adventages->map(function($object) {
                        return ($object->type == 'launch') ? $object : null;
                    })->filter()->count()==1 ? 'checked' : ''}}/><label for="advantages5">ناهار</label>
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="advantages6" value="dinner"
                    {{$post->adventages->map(function($object) {
                        return ($object->type == 'dinner') ? $object : null;
                    })->filter()->count()==1 ? 'checked' : ''}}/><label for="advantages6">شام</label>
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="advantages7" value="insurance"
                    {{$post->adventages->map(function($object) {
                        return ($object->type == 'insurance') ? $object : null;
                    })->filter()->count()==1 ? 'checked' : ''}}/><label for="advantages7">بیمه تکمیلی</label>
                <input type="checkbox" class="margin-right-20" name="advantages[]" id="advantages8" value="swim"
                    {{$post->adventages->map(function($object) {
                        return ($object->type == 'swim') ? $object : null;
                    })->filter()->count()==1 ? 'checked' : ''}}/><label for="advantages8">استخر</label>
            </div>
        </div>
    </div>
</form>
<script>
    $(".select2_auto_complete_onet_jobs_item").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: false,
        ajax: {
            url: "{{route('auto_complete.onet_jobs_items')}}",
            dataType: "json",
            type: "POST",
            quietMillis: 150,
            data: function (term) {
                return {
                    term: term,
                    item_id: $(this).attr('rel')
                };
            },
            results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            }
        }
    });
</script>