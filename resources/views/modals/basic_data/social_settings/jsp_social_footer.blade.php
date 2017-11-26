<div class="col-xs-12">
    <div class="pull-left">
        {{--  <button type="button" class="btn btn-info btn_add_edit_item_social" data_id=id >@if(!$add_true) {{trans('basic_data.edit_item')}} @else {{trans('basic_data.add_new_item')}} @endif</button>--}}
        @if(!$add_true)
            <button type="button" class="btn btn-info btn_edit_item_social" data_id=id >{{trans('basic_data.edit_item')}}</button>
        @else
            <button type="button" class="btn btn-info btn_add_item_social" data_id=id >{{trans('basic_data.add_new_item')}}</button>
        @endif
    </div>
</div>

@include('modals.basic_data.social_settings.helper.social_settings_inline_js')