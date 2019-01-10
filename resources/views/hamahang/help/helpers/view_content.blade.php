<div id="tab" class="row table-bordered" style="border-bottom: none">
    <ul class="nav nav-tabs">
        <li class="active" id="define">
            <a href="#tab_t1" data-toggle="tab">{{trans('help.context')}}</a>
        </li>
        <li>
            <a href="#tab_t2" data-toggle="tab">{{trans('help.see_also')}}</a>
        </li>
        <li>
            <a href="#tab_t3" data-toggle="tab">{{trans('help.votes')}}</a>
        </li>
        <li>
            <a href="#tab_t4" class="tab_t4" data-toggle="tab">{{trans('help.pages')}}</a>
        </li>
    </ul>
    <div class="tab-content help-view">
        <div class="tab-pane active tab-view padding-10" id="tab_t1">
            {!! $items->content !!}
        </div>
        <div class="tab-pane tab-view padding-10" id="tab_t2">
            tab_t2
        </div>
        <div class="tab-pane tab-view padding-10" id="tab_t3">
            {!! $id !!}
        </div>
        <div class="tab-pane tab-view padding-10" id="tab_t4">
            <div class="col-xs-12">
                <div class="col-xs-11">
                    <select id="permission_id" class="select2_auto_complete_permission " name="permission[]" data-placeholder="{{trans('help.select')}}"></select>
                    <input type="hidden" id="help_id" value="{{$id}}">
                </div>
                <div class="col-xs-1 line-height-35">
                   <a class="fa fa-plus pointer" id="add_help_permission"></a>
                </div>
            </div>

            <table id="permissions_help_grid" width="100%" class="table dt-responsive nowrap display text-center">
                <thead>
                <tr>
                    <th>{{trans('help.row')}}</th>
                    <th>{{trans('help.permission')}}</th>
                    <th>{{trans('help.operations')}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('hamahang.help.helpers.inline_js')
