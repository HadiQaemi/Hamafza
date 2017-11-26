<div class="col-xs-12">
    <div class="pull-left">
        <button type="button" class="btn btn-primary btn_add_edit_tool">{{ isset($tool) ? 'ویرایش ابزار' : 'افزودن ابزار' }}</button>
    </div>
</div>

@include('hamahang.Tools.helper.Index.modals.scripts.add_edit_tool_inline_js')