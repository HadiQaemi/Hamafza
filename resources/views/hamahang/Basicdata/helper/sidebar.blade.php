<style type="text/css">
    .jstree li > a > .jstree-icon
    {
        display: none !important;
    }
</style>

<div class="panel-body searching-cntnt">
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
        <div class="txtsearch" style="border-bottom: 1px solid lightgray; margin-bottom: 5px;">
            <input type="text" placeholder="{{ trans('menus.filter') }}" id="list-search" style="float: right; width: 80%; border-bottom: none;" />
            <a href="{!! route('modals.basicdata_create_view') !!}" style="float: left;" class="jsPanels"><i class="" aria-hidden="true"></i> افزودن</a>
            <div class="clear"></div>
        </div>
        <div accordion="" class="panel-group accordion" id="accordion">
            <div id="tree" class="v tree"></div>
        </div>
    </div>
</div>


