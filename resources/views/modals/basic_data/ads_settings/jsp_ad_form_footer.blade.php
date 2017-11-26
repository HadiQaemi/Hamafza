{{--{{ dd($parent_id) }}--}}
<div class="col-xs-12">
    <div class="pull-left">
        <button type="button" class="btn btn-info btn_add_edit_ad">{{ (isset($basic_data_value)) ? trans('basic_data.edit_ad') : trans('basic_data.add_new_ad') }}</button>
    </div>
</div>

@include('modals.basic_data.ads_settings.hepler.ads_settings_inline_js')