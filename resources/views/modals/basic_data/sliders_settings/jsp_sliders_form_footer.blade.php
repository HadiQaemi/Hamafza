<div class="col-xs-12">
    <div class="pull-left">
        <button type="button" class="btn btn-info btn_add_edit_slider">{{ (isset($basic_data_value)) ? trans('basic_data.edit_slider') : trans('basic_data.add_new_slider') }}</button>
    </div>
</div>

@include('modals.basic_data.sliders_settings.hepler.sliders_settings_inline_js')