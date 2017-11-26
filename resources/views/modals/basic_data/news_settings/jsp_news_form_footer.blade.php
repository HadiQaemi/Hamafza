<div class="col-xs-12">
    <div class="pull-left">
        <button type="button" class="btn btn-info btn_add_edit_news">{{ (isset($basic_data_value)) ? trans('basic_data.edit_news_tab') : trans('basic_data.add_new_tab') }}</button>
    </div>
</div>

@include('modals.basic_data.news_settings.hepler.news_settings_inline_js')