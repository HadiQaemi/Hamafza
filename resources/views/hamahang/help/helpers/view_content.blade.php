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
            @foreach($items->HelpBlocks as $block)
                {!! $block->content !!}
            @endforeach
        </div>
        <div class="tab-pane tab-view padding-10" id="tab_t2">
            <div class="col-xs-12">
                <div class="col-xs-11">
                    <select id="see_also_id" class="select2_auto_complete_see_also " name="see_also_id[]"
                            data-placeholder="{{trans('help.add_see_also')}}"></select>
                    <input type="hidden" id="help_id" value="{{$id}}">
                </div>
                <div class="col-xs-1 line-height-35">
                    <a class="fa fa-plus pointer" id="add_see_also_help"></a>
                </div>
            </div>
            <div class="col-xs-12 margin-top-20">
                <div class="row">
                    <div class="col-xs-1">ردیف</div>
                    <div class="col-xs-10">عنوان</div>
                    <div class="col-xs-1">عملیات</div>
                </div>
                <div id="see_also_list">
                    @foreach($items->SeeAlsos() as $k=>$also)
                        <div class="row margin-top-10">
                            <div class="col-xs-1">{{$k+1}}</div>
                            <div class="col-xs-10">{{enCode($also->Help2->id) == $id ? $also->Help->title : $also->Help2->title}}</div>
                            <div class="col-xs-1">
                                <i class="fa fa-remove pointer remove_see_also" also="{{enCode($also->id)}}"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane tab-view padding-10" id="tab_t3">
            {!! $id !!}
        </div>
        <div class="tab-pane tab-view padding-10" id="tab_t4">
            <div class="col-xs-12">
                <div class="col-xs-11">
                    <select id="permission_id" class="select2_auto_complete_permission " name="permission[]"
                            data-placeholder="{{trans('help.select')}}"></select>
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
