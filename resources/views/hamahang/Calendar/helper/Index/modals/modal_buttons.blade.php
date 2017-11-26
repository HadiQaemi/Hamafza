@if($btn_type=='newCalendar')
    <button type="button" id="add-calendar" value="save" class="btn btn-info add-calendar" type="button">
        <i class=""></i>
        <span>{{trans('app.register')}}</span>
    </button>
    @elseif($btn_type=='editCalendar')
    <button type="button" name="saveEdit" id="saveEdit"
            class="btn btn-info"
            type="button">
        <i class="bigger-125"></i>
        <span>{{ trans('app.register') }}</span>
    </button>
@endif