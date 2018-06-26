@if($btn_type=='newCalendar')
    {{--<button type="button" id="add-calendar" value="save" class="btn btn-info add-calendar" type="button">--}}
        {{--<i class=""></i>--}}
        {{--<span>{{trans('app.register')}}سسسسسسس</span>--}}
    {{--</button>--}}
    <a class="btn btn-primary pull-left add-calendar" id="add-calendar" value="save" data-again_save = "2" data-form_id="calendar_info_form">
        <i ></i>
        {{trans('tasks.ok')}}
    </a>
    @elseif($btn_type=='editCalendar')
    <button type="button" name="saveEdit" id="saveEdit"
            class="btn btn-info"
            type="button">
        <i class="bigger-125"></i>
        <span>{{ trans('app.register') }}</span>
    </button>
@endif