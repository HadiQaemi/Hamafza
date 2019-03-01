<form id="Form_Update_Item" method="post" action="#" id="">
    <div class="margin-top-20">
        <div class="form-group col-xs-12">
            <div class="col-xs-1 line-height-30">{{trans('app.title')}}</div>
            <div class="col-xs-11"><input type="text" name="item_title" id="item_title" class="form-control"/></div>
        </div>
        <div class="form-group col-xs-12">
            <div class="col-xs-1 line-height-30">{{trans('org_chart.up')}}</div>
            <div class="col-xs-11">
                <select id="item_parent_id" name="item_parent_id" class="col-xs-12 js-states form-control">
                </select>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="col-xs-1 line-height-30">{{trans('org_chart.missions')}}</div>
            <div class="col-xs-11">
                <select id="item_parent_id" name="item_parent_id" class="col-xs-12 js-states form-control">
                </select>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="col-xs-1 line-height-30">
                {{trans('app.description')}}
            </div>
            <div class="col-xs-11 line-height-30">
                <textarea type="text" name="item_description" id="item_description" class="form-control"></textarea>
            </div>
        </div>
    </div>
</form>