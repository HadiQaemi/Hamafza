<div class="panel-heading" style="border-bottom: 1px solid lightgray; ">
    <div id="grid_operations" style="float: left; margin: 0 0 0 34px;" data-id="0">
        <a href="{!! route('modals.basicdata_edit_view') . '?id=' . $data->id !!}" class="jsPanels edit"><i class="fa fa-pencil-square-o" style="font-size: 15px; cursor: pointer;"></i></a>
        <i class="fa fa-times" style="font-size: 17px; cursor: pointer; " onclick="if (confirm('آیا مطمئن هستید؟')) { do_delete({!! $data->id !!}); }"></i>
    </div>
    {{--<div id="grid_title" style="float: right;">{!! $data->title !!}</div>--}}
    <div class="clear"></div>
</div>
